<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object
})

const STRATA_OPTIONS = [
  { label: 'Pratama', value: 'Pratama' },
  { label: 'Madya', value: 'Madya' },
  { label: 'Purnama', value: 'Purnama' },
  { label: 'Mandiri', value: 'Mandiri' },
]

const YESNO_OPTIONS = [
  { label: 'Ya', value: 1 },
  { label: 'Tidak', value: 0 },
]

const emptyRow = () => ({
  id_kel: null,
  nama_posyandu: "",
  strata_psy: "",
  alamat_posyandu: "",
  pj_umum: "",
  pj_operasional: "",
  ketuplak: "",
  sekretaris: "",
  int_paud: null,
  int_bkd: null,
  int_terpadu: null,
  kader_aktif: "",
  kader_taktif: "",
  ptgs_kb: "",
  ptgs_medis: "",
  ptgs_bidan: ""
})

const form = useForm({
  kecamatan_id: null,
  kelurahan_id: null,
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

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.rows = [emptyRow()]
})

watch(() => form.kelurahan_id, () => {
  form.rows = [emptyRow()]
})

function validateRow(row, index) {
  const errors = []
  
  if (!row.nama_posyandu) errors.push('Nama Posyandu harus diisi')
  if (!row.strata_psy) errors.push('Strata harus dipilih')
  if (!row.alamat_posyandu) errors.push('Alamat harus diisi')
  if (!row.pj_umum) errors.push('PJ Umum harus diisi')
  if (!row.pj_operasional) errors.push('PJ Operasional harus diisi')
  if (!row.ketuplak) errors.push('Ketua Pelaksana harus diisi')
  if (!row.sekretaris) errors.push('Sekretaris harus diisi')
  if (row.int_paud === null || row.int_paud === '') errors.push('Integrasi PAUD harus dipilih')
  if (row.int_bkd === null || row.int_bkd === '') errors.push('Integrasi BKD harus dipilih')
  if (row.int_terpadu === null || row.int_terpadu === '') errors.push('Integrasi Terpadu harus dipilih')
  if (row.kader_aktif === "" || row.kader_aktif === null) errors.push('Kader Aktif harus diisi')
  if (row.kader_taktif === "" || row.kader_taktif === null) errors.push('Kader Tidak Aktif harus diisi')
  if (!row.ptgs_kb) errors.push('Petugas KB harus diisi')
  if (!row.ptgs_medis) errors.push('Petugas Medis harus diisi')
  if (!row.ptgs_bidan) errors.push('Petugas Bidan harus diisi')
  
  return errors
}

function submit() {
  if (!form.kelurahan_id) {
    openError('Kelurahan wajib dipilih')
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

  if (hasError) {
    // Format pesan error untuk ditampilkan
    let errorMessage = 'Data masih ada yang kosong:\n'
    allErrors.forEach(item => {
      errorMessage += `\nBaris ${item.row}:\n`
      item.errors.forEach(err => {
        errorMessage += `  • ${err}\n`
      })
    })
    
    openError('Data tidak lengkap', allErrors)
    return
  }

  // Set id_kel untuk setiap row
  form.rows = form.rows.map(row => ({
    ...row,
    id_kel: form.kelurahan_id
  }))

  // Tampilkan loading toast
  showToast('info', 'Menyimpan data...', 0) // 0 = tidak auto hide

  form.post('/posyandu/data-umum/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      // Hide loading toast
      hideToast()
      openSuccess(`${form.rows.length} data posyandu berhasil disimpan`)
      setTimeout(() => {
        router.visit('/posyandu/data-umum')
      }, 1500)
    },
    onError: (errors) => {
      // Hide loading toast
      hideToast()
      console.error('Error:', errors)
      
      // Format error dari server
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
          <i 
            class="icon" 
            :class="{
              'icon-check-circle': toast.type === 'success',
              'icon-exclamation-circle': toast.type === 'error',
              'icon-info-circle': toast.type === 'info',
              'icon-exclamation-triangle': toast.type === 'warning'
            }"
          ></i>
          <span class="toast-message">{{ toast.message }}</span>
          <button class="toast-close" @click="hideToast">×</button>
        </div>
      </div>
    </Transition>

    <!-- Header Section -->
    <div class="header-section">
      <div class="header-left">
        <h1 class="page-title">Tambah Data Umum Posyandu</h1>
        <p class="page-subtitle">Input multi data posyandu</p>
      </div>
      <div class="header-right">
        <Link href="/posyandu/data-umum" class="btn-back">
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
          <div class="filter-grid">
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
          </div>
        </div>

        <form @submit.prevent="submit">
          <!-- Data Posyandu Rows -->
          <div v-if="form.kelurahan_id" class="data-rows-section">
            <div class="section-header">
              <h6 class="section-title">Data Posyandu</h6>
              <div class="section-badge">
                <span class="badge-total">Total: {{ form.rows.length }} data</span>
              </div>
            </div>

            <div v-for="(row, i) in form.rows" :key="i" class="data-card">
              <div class="data-card-header">
                <div class="card-title">
                  <span class="card-number">{{ i+1 }}</span>
                  <strong>Data Posyandu</strong>
                </div>
                <button 
                  type="button" 
                  class="btn-delete-row" 
                  @click="deleteRow(i)"
                  v-if="form.rows.length > 1"
                >
                  <i class="icon-trash"></i>
                  <span>Hapus</span>
                </button>
              </div>

              <!-- Grid 2 kolom untuk data utama -->
              <div class="form-grid-2">
                <div class="form-field">
                  <label>Nama Posyandu <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.nama_posyandu"
                    placeholder="Masukkan nama posyandu"
                    :class="{ 'input-error': !row.nama_posyandu && showModal }"
                  >
                </div>
                <div class="form-field">
                  <label>Strata <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.strata_psy" 
                    :options="STRATA_OPTIONS"
                    placeholder="Pilih strata"
                    class="vue-select-custom"
                  />
                </div>
              </div>

              <div class="form-grid-2">
                <div class="form-field">
                  <label>Alamat <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.alamat_posyandu"
                    placeholder="Masukkan alamat"
                  >
                </div>
                <div class="form-field">
                  <label>PJ Umum <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.pj_umum"
                    placeholder="Nama penanggung jawab umum"
                  >
                </div>
              </div>

              <div class="form-grid-2">
                <div class="form-field">
                  <label>PJ Operasional <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.pj_operasional"
                    placeholder="Nama penanggung jawab operasional"
                  >
                </div>
                <div class="form-field">
                  <label>Ketua Pelaksana <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.ketuplak"
                    placeholder="Nama ketua pelaksana"
                  >
                </div>
              </div>

              <div class="form-grid-2">
                <div class="form-field">
                  <label>Sekretaris <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.sekretaris"
                    placeholder="Nama sekretaris"
                  >
                </div>
                <div class="form-field">
                  <label>Integrasi PAUD <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.int_paud" 
                    :options="YESNO_OPTIONS"
                    placeholder="Pilih Ya/Tidak"
                    class="vue-select-custom"
                  />
                </div>
              </div>

              <div class="form-grid-3">
                <div class="form-field">
                  <label>Integrasi BKD <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.int_bkd" 
                    :options="YESNO_OPTIONS"
                    placeholder="Pilih Ya/Tidak"
                    class="vue-select-custom"
                  />
                </div>
                <div class="form-field">
                  <label>Integrasi Terpadu <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.int_terpadu" 
                    :options="YESNO_OPTIONS"
                    placeholder="Pilih Ya/Tidak"
                    class="vue-select-custom"
                  />
                </div>
                <div class="form-field">
                  <label>Kader Aktif <span class="text-danger">*</span></label>
                  <input 
                    type="number" 
                    class="form-input" 
                    v-model="row.kader_aktif"
                    placeholder="Jumlah"
                  >
                </div>
              </div>

              <div class="form-grid-3">
                <div class="form-field">
                  <label>Kader Tidak Aktif <span class="text-danger">*</span></label>
                  <input 
                    type="number" 
                    class="form-input" 
                    v-model="row.kader_taktif"
                    placeholder="Jumlah"
                  >
                </div>
                <div class="form-field">
                  <label>Petugas KB <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.ptgs_kb"
                    placeholder="Nama petugas KB"
                  >
                </div>
                <div class="form-field">
                  <label>Petugas Medis <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.ptgs_medis"
                    placeholder="Nama petugas medis"
                  >
                </div>
              </div>

              <div class="form-grid-2 mt-2">
                <div class="form-field">
                  <label>Petugas Bidan <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="row.ptgs_bidan"
                    placeholder="Nama petugas bidan"
                  >
                </div>
              </div>
            </div>

            <div class="form-actions">
              <button type="button" class="btn-add-row" @click="addRow">
                <span>+</span>
                <span>Tambah Data</span>
              </button>
              <button type="submit" class="btn-save" :disabled="form.processing">
                <i class="icon-check"></i>
                <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Semua Data' }}</span>
              </button>
            </div>
          </div>

          <div v-else class="alert-empty">
            <i class="icon-info-circle"></i>
            <span>Silakan pilih kecamatan dan kelurahan terlebih dahulu</span>
          </div>
        </form>

      </div>
    </div>

    <!-- Modal Notifikasi -->
    <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
      <div class="modal-card">
        <div class="text-center">
          <i 
            class="icon" 
            :class="{
              'icon-check-circle text-success': modalType === 'success',
              'icon-exclamation-circle text-danger': modalType === 'error'
            }"
            style="font-size: 48px;"
          ></i>
          <h4 class="modal-title-text">{{ modalTitle }}</h4>
          <p class="modal-message">{{ modalMessage }}</p>
          
          <!-- Tampilkan detail error jika ada -->
          <div v-if="validationErrors.length > 0" class="error-details">
            <div v-for="(error, idx) in validationErrors" :key="idx" class="error-item">
              <strong>Baris {{ error.row }}:</strong>
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
  gap: 5px;
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

.btn-back i {
  font-size: 16px;
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
  margin-bottom: 24px;
  border: 1px solid #e2e8f0;
}

.filter-section-title {
  font-size: 16px;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 16px 0;
}

.filter-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
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

.badge-total {
  display: inline-block;
  padding: 6px 12px;
  background: #e2e8f0;
  color: #1e293b;
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

.btn-delete-row i {
  font-size: 14px;
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

.input-error {
  border-color: #ef4444;
}

.input-error:focus {
  border-color: #ef4444;
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
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

.btn-add-row i {
  font-size: 16px;
}

.btn-add-row:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
}

.btn-add-row:active {
  background: #cbd5e1;
  transform: translateY(0);
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

.btn-save i {
  font-size: 16px;
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
}

.alert-empty i {
  font-size: 18px;
  color: #3b82f6;
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

.toast-content i {
  font-size: 20px;
}

.toast-notification.success i {
  color: #10b981;
}

.toast-notification.error i {
  color: #ef4444;
}

.toast-notification.info i {
  color: #3b82f6;
}

.toast-notification.warning i {
  color: #f59e0b;
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

/* Icons */
.icon {
  display: inline-block;
}

/* Responsive */
@media (max-width: 1024px) {
  .filter-grid {
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