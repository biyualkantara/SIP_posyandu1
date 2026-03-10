<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  bayi: Object // grouped by id_posyandu
})

const emptyRow = () => ({
  id_bayi: null,
  tgl_pnb: '',
  berat: '',
  tb: '',
  hasil: '',
  ket: ''
})

const form = useForm({
  kecamatan_id: null,
  kelurahan_id: null,
  posyandu_id: null,
  rows: [emptyRow()]
})

// State untuk notifikasi
const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')
const modalTitle = ref('')
const validationErrors = ref([])

// Notifikasi toast
const toast = ref({
  show: false,
  type: 'success',
  message: '',
  timeout: null
})

function showToast(type, message, duration = 3000) {
  // Clear existing timeout
  if (toast.value.timeout) {
    clearTimeout(toast.value.timeout)
  }
  
  toast.value.show = true
  toast.value.type = type
  toast.value.message = message
  
  // Auto hide after duration
  toast.value.timeout = setTimeout(() => {
    toast.value.show = false
    toast.value.timeout = null
  }, duration)
}

function hideToast() {
  toast.value.show = false
  if (toast.value.timeout) {
    clearTimeout(toast.value.timeout)
    toast.value.timeout = null
  }
}

function openError(msg, errors = []) {
  modalType.value = 'error'
  modalTitle.value = 'Gagal!'
  modalMessage.value = msg
  validationErrors.value = errors
  showModal.value = true
  
  // Juga tampilkan toast error
  showToast('error', msg, 4000)
}

function openSuccess(msg) {
  modalType.value = 'success'
  modalTitle.value = 'Berhasil!'
  modalMessage.value = msg
  validationErrors.value = []
  showModal.value = true
  
  // Juga tampilkan toast success
  showToast('success', msg, 3000)
}

function addRow() {
  // Cek apakah masih ada bayi yang tersedia
  const availableBayiCount = bayiOptions.value.length - selectedBayiIds.value.length
  
  if (availableBayiCount <= 0) {
    openError('Tidak ada lagi bayi yang tersedia untuk posyandu ini')
    return
  }
  
  form.rows.push(emptyRow())
  showToast('info', `Baris data ke-${form.rows.length} ditambahkan`, 2000)
}

function deleteRow(i) {
  if (form.rows.length > 1) {
    const deletedRow = i + 1
    form.rows.splice(i, 1)
    showToast('warning', `Baris data ke-${deletedRow} dihapus`, 2000)
  }
}

const kelurahanOptions = computed(() => {
  if (!form.kecamatan_id) return []
  return props.kelurahan?.[form.kecamatan_id] ?? []
})

const posyanduOptions = computed(() => {
  if (!form.kelurahan_id) return []
  return props.posyandu?.[form.kelurahan_id] ?? []
})

const bayiOptions = computed(() => {
  if (!form.posyandu_id) return []
  
  const options = props.bayi?.[form.posyandu_id] ?? []
  
  // Map ke format yang dibutuhkan VueSelect
  return options.map(b => ({
    label: `${b.nama_bayi} - ${b.tgl_lhr}`,
    value: b.id_bayi
  }))
})

// ID bayi yang sudah dipilih
const selectedBayiIds = computed(() => {
  return form.rows
    .map(row => row.id_bayi)
    .filter(id => id !== null)
})

// Filter opsi bayi untuk row tertentu (tidak menampilkan bayi yang sudah dipilih di row lain)
const getBayiOptionsForRow = (currentRowIndex) => {
  if (!form.posyandu_id) return []
  
  const allOptions = bayiOptions.value
  
  // Filter out bayi yang sudah dipilih di row lain
  return allOptions.filter(option => {
    // Cek apakah bayi ini sudah dipilih di row lain
    const isSelectedElsewhere = form.rows.some((row, index) => 
      index !== currentRowIndex && row.id_bayi === option.value
    )
    
    // Tampilkan jika belum dipilih di row lain
    return !isSelectedElsewhere
  })
}

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.posyandu_id = null
  form.rows = [emptyRow()]
})

watch(() => form.kelurahan_id, () => {
  form.posyandu_id = null
  form.rows = [emptyRow()]
})

watch(() => form.posyandu_id, () => {
  form.rows = [emptyRow()]
})

function validateRow(row, index) {
  const errors = []
  
  if (!row.id_bayi) errors.push('Bayi harus dipilih')
  if (!row.tgl_pnb) errors.push('Tanggal penimbangan harus diisi')
  
  return errors
}

function submit() {
  if (!form.kelurahan_id) {
    openError('Kelurahan wajib dipilih')
    return
  }

  if (!form.posyandu_id) {
    openError('Posyandu wajib dipilih')
    return
  }

  // Validasi semua baris
  const allErrors = []
  let hasError = false

  form.rows.forEach((row, index) => {
    const rowErrors = validateRow(row, index)
    if (rowErrors.length > 0) {
      hasError = true
      allErrors.push({
        row: index + 1,
        errors: rowErrors
      })
    }
  })

  // Validasi duplikasi bayi
  const bayiIds = form.rows.map(row => row.id_bayi).filter(id => id)
  const uniqueBayiIds = [...new Set(bayiIds)]
  
  if (bayiIds.length !== uniqueBayiIds.length) {
    hasError = true
    allErrors.push({
      row: 'Semua',
      errors: ['Tidak boleh memilih bayi yang sama untuk data yang berbeda']
    })
  }

  if (hasError) {
    openError('Data tidak lengkap', allErrors)
    return
  }

  // Tampilkan loading toast
  showToast('info', 'Menyimpan data...', 0)

  form.post('/posyandu/bayi-pnb/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      hideToast()
      openSuccess(`${form.rows.length} data penimbangan bayi berhasil disimpan`)
      
      // Kirim event ke index untuk toast
      window.dispatchEvent(new CustomEvent('toast', {
        detail: { type: 'success', message: 'Data penimbangan bayi berhasil disimpan!' }
      }));

      setTimeout(() => {
        router.visit('/posyandu/bayi-pnb')
      }, 1500)
    },
    onError: (errors) => {
      hideToast()
      console.error('Error:', errors)
      
      let errorMsg = 'Gagal menyimpan data'
      if (errors.message) {
        errorMsg = errors.message
      } else if (typeof errors === 'object') {
        errorMsg = Object.values(errors).join(', ')
      }
      
      openError(errorMsg)
    }
  })
}
</script>

<template>
  <div class="data-container">
    <!-- Toast Notification -->
    <Transition name="slide-fade">
      <div v-if="toast.show" class="toast-notification" :class="toast.type">
        <div class="toast-content">
          <span v-if="toast.type === 'success'" class="toast-icon">✅</span>
          <span v-else-if="toast.type === 'error'" class="toast-icon">❌</span>
          <span v-else-if="toast.type === 'info'" class="toast-icon">ℹ️</span>
          <span v-else-if="toast.type === 'warning'" class="toast-icon">⚠️</span>
          <span class="toast-message">{{ toast.message }}</span>
          <button class="toast-close" @click="hideToast">×</button>
        </div>
      </div>
    </Transition>

    <!-- Header Section -->
    <div class="header-section">
      <div class="header-left">
        <h1 class="page-title">Tambah Penimbangan Bayi</h1>
        <p class="page-subtitle">Input multi data penimbangan bayi</p>
      </div>
      <div class="header-right">
        <Link href="/posyandu/bayi-pnb" class="btn-back">
          <span>←</span>
          <span>Kembali</span>
        </Link>
      </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
      <div class="card-body">
        <!-- FILTER SECTION -->
        <div class="filter-section">
          <h6 class="filter-section-title">Pilih Lokasi</h6>
          <div class="filter-grid-3">
            <div class="filter-item">
              <label class="filter-label">Kecamatan <span class="text-danger">*</span></label>
              <div class="select-wrapper">
                <VueSelect
                  v-model="form.kecamatan_id"
                  :options="(kecamatan||[]).map(k => ({ label: k.nama_kec, value: k.id_kec }))"
                  placeholder="Pilih Kecamatan"
                  class="vue-select-custom"
                />
              </div>
            </div>

            <div class="filter-item">
              <label class="filter-label">Kelurahan <span class="text-danger">*</span></label>
              <div class="select-wrapper">
                <VueSelect
                  v-model="form.kelurahan_id"
                  :options="kelurahanOptions.map(k => ({ label: k.nama_kel, value: k.id_kel }))"
                  :isDisabled="!form.kecamatan_id"
                  placeholder="Pilih Kelurahan"
                  class="vue-select-custom"
                />
              </div>
            </div>

            <div class="filter-item">
              <label class="filter-label">Posyandu <span class="text-danger">*</span></label>
              <div class="select-wrapper">
                <VueSelect
                  v-model="form.posyandu_id"
                  :options="posyanduOptions.map(p => ({ label: p.nama_posyandu, value: p.id_posyandu }))"
                  :isDisabled="!form.kelurahan_id"
                  placeholder="Pilih Posyandu"
                  class="vue-select-custom"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Info Alert -->
        <div v-if="form.posyandu_id" class="info-alert">
          <span>ℹ️</span>
          <span>
            Total bayi tersedia: <strong>{{ bayiOptions.length }}</strong> | 
            Terpilih: <strong>{{ selectedBayiIds.length }}</strong> | 
            Sisa: <strong>{{ bayiOptions.length - selectedBayiIds.length }}</strong>
          </span>
        </div>

        <form @submit.prevent="submit">
          <!-- Data Penimbangan Rows -->
          <div v-if="form.posyandu_id" class="data-rows-section">
            <div class="section-header">
              <h6 class="section-title">Data Penimbangan Bayi</h6>
              <div class="section-badge">
                <span class="badge-total">Total: {{ form.rows.length }} data</span>
                <span class="badge-available">Bayi tersedia: {{ bayiOptions.length - selectedBayiIds.length }}</span>
              </div>
            </div>

            <div v-for="(row, i) in form.rows" :key="i" class="data-card">
              <div class="data-card-header">
                <div class="card-title">
                  <span class="card-number">{{ i+1 }}</span>
                  <strong>Data Penimbangan</strong>
                </div>
                <button 
                  type="button" 
                  class="btn-delete-row" 
                  @click="deleteRow(i)"
                  v-if="form.rows.length > 1"
                >
                  <span>×</span>
                  <span>Hapus</span>
                </button>
              </div>

              <!-- Grid 2 kolom untuk data wajib -->
              <div class="form-grid-2">
                <div class="form-field">
                  <label>Pilih Bayi <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="row.id_bayi"
                    :options="getBayiOptionsForRow(i)"
                    :isDisabled="!form.posyandu_id"
                    placeholder="Pilih Bayi"
                    :key="`${form.posyandu_id}-${i}`"
                    class="vue-select-custom"
                  />
                  <small v-if="getBayiOptionsForRow(i).length === 0" class="text-warning">
                    ⚠️ Tidak ada bayi tersedia untuk baris ini
                  </small>
                </div>

                <div class="form-field">
                  <label>Tanggal Penimbangan <span class="text-danger">*</span></label>
                  <input 
                    type="date" 
                    class="form-input" 
                    v-model="row.tgl_pnb"
                  />
                </div>
              </div>

              <!-- Grid 3 kolom -->
              <div class="form-grid-3 mt-3">
                <div class="form-field">
                  <label>Berat (kg)</label>
                  <input 
                    type="number" 
                    step="0.01"
                    class="form-input" 
                    v-model="row.berat"
                    placeholder="Contoh: 5.5"
                  />
                </div>

                <div class="form-field">
                  <label>Tinggi (cm)</label>
                  <input 
                    type="number" 
                    step="0.1"
                    class="form-input" 
                    v-model="row.tb"
                    placeholder="Contoh: 60.5"
                  />
                </div>

                <div class="form-field">
                  <label>Hasil</label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.hasil"
                    placeholder="Masukkan hasil"
                  />
                </div>
              </div>

              <!-- Keterangan -->
              <div class="form-field mt-3">
                <label>Keterangan</label>
                <textarea 
                  class="form-textarea" 
                  rows="2" 
                  v-model="row.ket"
                  placeholder="Masukkan keterangan tambahan (opsional)"
                ></textarea>
              </div>
            </div>

            <div class="form-actions">
              <button 
                type="button" 
                class="btn-add-row" 
                @click="addRow"
                :disabled="bayiOptions.length - selectedBayiIds.length <= 0"
              >
                <span>+</span>
                <span>Tambah Data</span>
              </button>
              <button type="submit" class="btn-save" :disabled="form.processing">
                <span>✓</span>
                <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Semua Data' }}</span>
              </button>
            </div>
          </div>

          <div v-else class="alert-empty">
            <span>ℹ️</span>
            <span>Silakan pilih kecamatan, kelurahan, dan posyandu terlebih dahulu</span>
          </div>
        </form>

      </div>
    </div>

    <!-- Modal Notifikasi -->
    <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
      <div class="modal-card">
        <div class="text-center">
          <span v-if="modalType === 'success'" class="modal-icon">✅</span>
          <span v-else-if="modalType === 'error'" class="modal-icon">❌</span>
          <h4 class="modal-title-text">{{ modalTitle }}</h4>
          <p class="modal-message">{{ modalMessage }}</p>
          
          <!-- Tampilkan detail error jika ada -->
          <div v-if="validationErrors.length > 0" class="error-details">
            <div v-for="(error, idx) in validationErrors" :key="idx" class="error-item">
              <strong v-if="error.row !== 'Semua'">Baris {{ error.row }}:</strong>
              <strong v-else>Perhatian:</strong>
              <ul>
                <li v-for="(err, errIdx) in error.errors" :key="errIdx">{{ err }}</li>
              </ul>
            </div>
          </div>
          
          <button class="btn-modal-close" @click="showModal = false">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Container Utama */
.data-container {
  padding: 24px;
  background: #f8fafc;
  min-height: 100vh;
}

/* Header Section */
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  background: white;
  padding: 20px 24px;
  border-radius: 16px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.header-left {
  flex: 1;
}

.page-title {
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 4px 0;
  line-height: 1.2;
}

.page-subtitle {
  font-size: 14px;
  color: #64748b;
  margin: 0;
}

.header-right {
  display: flex;
  gap: 12px;
}

/* Button Back */
.btn-back {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background: #f1f5f9;
  color: #475569;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}

.btn-back:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
}

.btn-back:active {
  background: #cbd5e1;
  transform: translateY(0);
}

/* Main Card */
.main-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
  overflow: hidden;
}

.card-body {
  padding: 28px;
}

/* Filter Section */
.filter-section {
  background: #f8fafc;
  padding: 24px;
  border-radius: 16px;
  margin-bottom: 20px;
  border: 1px solid #e2e8f0;
}

.filter-section-title {
  font-size: 16px;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 16px 0;
}

.filter-grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.filter-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.filter-label {
  font-weight: 600;
  font-size: 13px;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.select-wrapper {
  width: 100%;
}

/* Info Alert */
.info-alert {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 16px 20px;
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  border-radius: 12px;
  color: #1e40af;
  font-size: 14px;
  margin-bottom: 24px;
}

.info-alert strong {
  font-weight: 700;
}

/* Vue Select Custom */
.vue-select-custom :deep(.vs__dropdown-toggle) {
  height: 42px;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  background: #f8fafc;
  padding: 0 12px;
  transition: all 0.2s;
}

.vue-select-custom :deep(.vs__dropdown-toggle:hover) {
  border-color: #94a3b8;
  background: white;
}

.vue-select-custom :deep(.vs__dropdown-toggle:focus-within) {
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
}

.vue-select-custom :deep(.vs__selected) {
  color: #1e293b;
  font-size: 14px;
}

.vue-select-custom :deep(.vs__search) {
  color: #1e293b;
  font-size: 14px;
}

.vue-select-custom :deep(.vs__search::placeholder) {
  color: #94a3b8;
}

.vue-select-custom :deep(.vs__open-indicator) {
  fill: #64748b;
}

/* Data Rows Section */
.data-rows-section {
  margin-top: 24px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
  color: #1e293b;
  margin: 0;
}

.section-badge {
  display: flex;
  gap: 10px;
}

.badge-total {
  display: inline-block;
  padding: 6px 12px;
  background: #e2e8f0;
  color: #1e293b;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
}

.badge-available {
  display: inline-block;
  padding: 6px 12px;
  background: #dcfce7;
  color: #166534;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
}

/* Data Card */
.data-card {
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 24px;
  margin-bottom: 20px;
  background: white;
  transition: all 0.2s;
}

.data-card:hover {
  border-color: #94a3b8;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.data-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 2px solid #f1f5f9;
}

.card-title {
  display: flex;
  align-items: center;
  gap: 12px;
}

.card-number {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  background: #1e293b;
  color: white;
  border-radius: 8px;
  font-size: 14px;
  font-weight: 600;
}

/* Delete Row Button */
.btn-delete-row {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  background: #fee2e2;
  color: #991b1b;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-delete-row:hover {
  background: #fecaca;
  transform: translateY(-1px);
}

.btn-delete-row:active {
  background: #fca5a5;
  transform: translateY(0);
}

/* Form Grid */
.form-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 16px;
}

.form-grid-3 {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 20px;
  margin-bottom: 16px;
}

.form-field {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-field label {
  font-weight: 500;
  font-size: 13px;
  color: #475569;
}

/* Form Input */
.form-input {
  height: 42px;
  border-radius: 10px;
  border: 2px solid #e2e8f0;
  padding: 0 12px;
  font-size: 14px;
  transition: all 0.2s;
  background: #f8fafc;
  width: 100%;
}

.form-input:hover {
  border-color: #94a3b8;
  background: white;
}

.form-input:focus {
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
  outline: none;
}

.form-input::placeholder {
  color: #94a3b8;
}

/* Form Textarea */
.form-textarea {
  border-radius: 10px;
  border: 2px solid #e2e8f0;
  padding: 10px 12px;
  font-size: 14px;
  transition: all 0.2s;
  background: #f8fafc;
  width: 100%;
  resize: vertical;
  font-family: inherit;
}

.form-textarea:hover {
  border-color: #94a3b8;
  background: white;
}

.form-textarea:focus {
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
  outline: none;
}

.form-textarea::placeholder {
  color: #94a3b8;
}

/* Text Warning */
.text-warning {
  color: #b45309;
  font-size: 12px;
  margin-top: 4px;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 28px;
  padding-top: 24px;
  border-top: 2px solid #f1f5f9;
}

.btn-add-row {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 24px;
  background: #f1f5f9;
  color: #475569;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-add-row:hover:not(:disabled) {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
}

.btn-add-row:active:not(:disabled) {
  background: #cbd5e1;
  transform: translateY(0);
}

.btn-add-row:disabled {
  background: #e2e8f0;
  color: #94a3b8;
  cursor: not-allowed;
}

.btn-save {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 28px;
  background: #1e293b;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 2px 4px rgba(30, 41, 59, 0.1);
}

.btn-save:hover:not(:disabled) {
  background: #0f172a;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(30, 41, 59, 0.2);
}

.btn-save:active:not(:disabled) {
  background: #1e293b;
  transform: translateY(0);
}

.btn-save:disabled {
  background: #94a3b8;
  cursor: not-allowed;
}

/* Alert Empty */
.alert-empty {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 20px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  color: #475569;
  font-size: 14px;
  margin-top: 24px;
}

/* Text Danger */
.text-danger {
  color: #ef4444;
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(6px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  animation: fadeIn 0.2s ease;
}

.modal-card {
  width: 420px;
  background: white;
  border-radius: 20px;
  padding: 32px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  animation: slideUp 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.modal-icon {
  font-size: 48px;
  line-height: 1;
}

.modal-title-text {
  font-size: 20px;
  font-weight: 700;
  color: #1e293b;
  margin: 16px 0 8px 0;
}

.modal-message {
  color: #64748b;
  margin: 0 0 16px 0;
}

.btn-modal-close {
  padding: 10px 28px;
  background: #1e293b;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  margin-top: 16px;
}

.btn-modal-close:hover {
  background: #0f172a;
  transform: translateY(-2px);
}

/* Error Details */
.error-details {
  text-align: left;
  background: #fef2f2;
  border-radius: 12px;
  padding: 16px;
  max-height: 300px;
  overflow-y: auto;
  margin-top: 16px;
}

.error-item {
  margin-bottom: 12px;
  padding-bottom: 8px;
  border-bottom: 1px solid #fecaca;
}

.error-item:last-child {
  border-bottom: none;
}

.error-item strong {
  color: #991b1b;
  font-size: 14px;
}

.error-item ul {
  margin: 8px 0 0 0;
  padding-left: 20px;
}

.error-item li {
  color: #b91c1c;
  font-size: 13px;
  margin: 4px 0;
}

/* Toast Notification */
.toast-notification {
  position: fixed;
  top: 24px;
  right: 24px;
  z-index: 10000;
  min-width: 320px;
  max-width: 400px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
  overflow: hidden;
  animation: slideInRight 0.3s ease;
  border-left: 4px solid;
}

.toast-notification.success {
  border-left-color: #10b981;
}

.toast-notification.error {
  border-left-color: #ef4444;
}

.toast-notification.info {
  border-left-color: #3b82f6;
}

.toast-notification.warning {
  border-left-color: #f59e0b;
}

.toast-content {
  padding: 16px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.toast-icon {
  font-size: 20px;
}

.toast-message {
  flex: 1;
  font-size: 14px;
  color: #1e293b;
  font-weight: 500;
}

.toast-close {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #94a3b8;
  padding: 0 4px;
  line-height: 1;
}

.toast-close:hover {
  color: #475569;
}

/* Animations */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(30px);
  opacity: 0;
}

@keyframes slideInRight {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

/* Responsive */
@media (max-width: 1024px) {
  .filter-grid-3 {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .data-container {
    padding: 16px;
  }
  
  .header-section {
    flex-direction: column;
    gap: 16px;
    align-items: start;
    padding: 16px;
  }
  
  .header-right {
    width: 100%;
  }
  
  .btn-back {
    width: 100%;
    justify-content: center;
  }
  
  .form-grid-2,
  .form-grid-3 {
    grid-template-columns: 1fr;
  }
  
  .section-badge {
    flex-direction: column;
    gap: 5px;
  }
  
  .badge-total,
  .badge-available {
    text-align: center;
  }
  
  .form-actions {
    flex-direction: column;
    gap: 12px;
  }
  
  .btn-add-row,
  .btn-save {
    width: 100%;
    justify-content: center;
  }
  
  .toast-notification {
    top: 16px;
    right: 16px;
    left: 16px;
    max-width: none;
  }
  
  .modal-card {
    width: 90%;
    margin: 0 16px;
    padding: 24px;
  }
}
</style>