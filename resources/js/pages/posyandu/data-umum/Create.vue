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
  <div class="page-wrapper">
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

    <!-- Header -->
    <div class="page-header">
      <div>
        <h2 class="mb-1">Tambah Data Umum Posyandu</h2>
        <p class="text-muted">Input multi data posyandu</p>
      </div>
      <Link href="/posyandu/data-umum" class="btn btn-outline-secondary">
        <i class="icon-arrow-left me-2"></i>Kembali
      </Link>
    </div>

    <div class="main-card">
      <div class="card-body">
        <!-- FILTER -->
        <div class="filter-box">
          <h6 class="mb-3">Pilih Lokasi</h6>
          <div class="grid-2">
            <div class="field">
              <label>Kecamatan <span class="text-danger">*</span></label>
              <VueSelect
                v-model="form.kecamatan_id"
                :options="(kecamatan||[]).map(k => ({ label: k.nama_kec, value: k.id_kec }))"
                placeholder="Pilih Kecamatan"
              />
            </div>

            <div class="field">
              <label>Kelurahan <span class="text-danger">*</span></label>
              <VueSelect
                v-model="form.kelurahan_id"
                :options="kelurahanOptions.map(k => ({ label: k.nama_kel, value: k.id_kel }))"
                :isDisabled="!form.kecamatan_id"
                placeholder="Pilih Kelurahan"
              />
            </div>
          </div>
        </div>

        <form @submit.prevent="submit">
          <!-- Data Posyandu Rows -->
          <div v-if="form.kelurahan_id" class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Data Posyandu</h6>
              <div>
                <span class="badge bg-info me-2">Total: {{ form.rows.length }} data</span>
              </div>
            </div>

            <div v-for="(row, i) in form.rows" :key="i" class="data-card">
              <div class="data-header">
                <div>
                  <span class="badge bg-primary me-2">{{ i+1 }}</span>
                  <strong>Data Posyandu</strong>
                </div>
                <button 
                  type="button" 
                  class="btn btn-outline-danger btn-sm" 
                  @click="deleteRow(i)"
                  v-if="form.rows.length > 1"
                >
                  <i class="icon-trash me-1"></i>Hapus
                </button>
              </div>

              <!-- Grid 2 kolom untuk data utama -->
              <div class="grid-2">
                <div class="field">
                  <label>Nama Posyandu <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.nama_posyandu"
                    placeholder="Masukkan nama posyandu"
                    :class="{ 'is-invalid': !row.nama_posyandu && showModal }"
                  >
                </div>
                <div class="field">
                  <label>Strata <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.strata_psy" 
                    :options="STRATA_OPTIONS"
                    placeholder="Pilih strata"
                  />
                </div>
              </div>

              <div class="grid-2">
                <div class="field">
                  <label>Alamat <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.alamat_posyandu"
                    placeholder="Masukkan alamat"
                  >
                </div>
                <div class="field">
                  <label>PJ Umum <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.pj_umum"
                    placeholder="Nama penanggung jawab umum"
                  >
                </div>
              </div>

              <div class="grid-2">
                <div class="field">
                  <label>PJ Operasional <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.pj_operasional"
                    placeholder="Nama penanggung jawab operasional"
                  >
                </div>
                <div class="field">
                  <label>Ketua Pelaksana <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.ketuplak"
                    placeholder="Nama ketua pelaksana"
                  >
                </div>
              </div>

              <div class="grid-2">
                <div class="field">
                  <label>Sekretaris <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.sekretaris"
                    placeholder="Nama sekretaris"
                  >
                </div>
                <div class="field">
                  <label>Integrasi PAUD <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.int_paud" 
                    :options="YESNO_OPTIONS"
                    placeholder="Pilih Ya/Tidak"
                  />
                </div>
              </div>

              <div class="grid-3">
                <div class="field">
                  <label>Integrasi BKD <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.int_bkd" 
                    :options="YESNO_OPTIONS"
                    placeholder="Pilih Ya/Tidak"
                  />
                </div>
                <div class="field">
                  <label>Integrasi Terpadu <span class="text-danger">*</span></label>
                  <VueSelect 
                    v-model="row.int_terpadu" 
                    :options="YESNO_OPTIONS"
                    placeholder="Pilih Ya/Tidak"
                  />
                </div>
                <div class="field">
                  <label>Kader Aktif <span class="text-danger">*</span></label>
                  <input 
                    type="number" 
                    class="form-control" 
                    v-model="row.kader_aktif"
                    placeholder="Jumlah"
                  >
                </div>
              </div>

              <div class="grid-3">
                <div class="field">
                  <label>Kader Tidak Aktif <span class="text-danger">*</span></label>
                  <input 
                    type="number" 
                    class="form-control" 
                    v-model="row.kader_taktif"
                    placeholder="Jumlah"
                  >
                </div>
                <div class="field">
                  <label>Petugas KB <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.ptgs_kb"
                    placeholder="Nama petugas KB"
                  >
                </div>
                <div class="field">
                  <label>Petugas Medis <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.ptgs_medis"
                    placeholder="Nama petugas medis"
                  >
                </div>
              </div>

              <div class="grid-2 mt-2">
                <div class="field">
                  <label>Petugas Bidan <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.ptgs_bidan"
                    placeholder="Nama petugas bidan"
                  >
                </div>
              </div>
            </div>

            <div class="form-footer">
              <button 
                type="button" 
                class="btn btn-outline-success" 
                @click="addRow"
              >
                <i class="icon-plus me-2"></i>Tambah Data
              </button>
              <button type="submit" class="btn btn-primary" :disabled="form.processing">
                <i class="icon-check me-2"></i>
                {{ form.processing ? 'Menyimpan...' : 'Simpan Semua Data' }}
              </button>
            </div>
          </div>

          <div v-else class="alert alert-info mt-4">
            <i class="icon-info-circle me-2"></i>
            Silakan pilih kecamatan dan kelurahan terlebih dahulu
          </div>
        </form>

      </div>
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
        <h4 class="mt-3">{{ modalTitle }}</h4>
        <p class="text-muted">{{ modalMessage }}</p>
        
        <!-- Tampilkan detail error jika ada -->
        <div v-if="validationErrors.length > 0" class="error-details mt-3">
          <div v-for="(error, idx) in validationErrors" :key="idx" class="error-item">
            <strong>Baris {{ error.row }}:</strong>
            <ul>
              <li v-for="(err, errIdx) in error.errors" :key="errIdx">{{ err }}</li>
            </ul>
          </div>
        </div>
        
        <button class="btn btn-primary mt-3" @click="showModal = false">Tutup</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-wrapper {
  max-width: 1200px;
  margin: 0 auto;
  padding: 24px 16px 40px;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}

.page-header h2 {
  font-size: 24px;
  font-weight: 600;
  color: #2c3e50;
}

.main-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.06);
  overflow: hidden;
}

.card-body {
  padding: 28px;
}

.filter-box {
  background: #f8fafc;
  padding: 24px;
  border-radius: 12px;
  margin-bottom: 24px;
  border: 1px solid #eef2f6;
}

.field {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.field label {
  font-weight: 500;
  font-size: 14px;
  color: #4a5568;
}

.grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-top: 16px;
}

.grid-3 {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 16px;
  margin-top: 16px;
}

.data-card {
  border: 1px solid #eef1f4;
  border-radius: 12px;
  padding: 20px;
  margin-top: 16px;
  background: white;
  transition: all 0.2s;
}

.data-card:hover {
  border-color: #cbd5e0;
  box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}

.data-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid #eef1f4;
}

.form-control {
  height: 42px;
  border-radius: 8px;
  border: 1.5px solid #e5e7eb;
  padding: 0 12px;
  font-size: 14px;
  transition: all 0.2s;
}

.form-control:focus {
  border-color: #4299e1;
  box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
  outline: none;
}

.form-control.is-invalid {
  border-color: #f56565;
}

.form-footer {
  display: flex;
  justify-content: space-between;
  margin-top: 28px;
  padding-top: 24px;
  border-top: 2px solid #f0f2f5;
}

.btn {
  padding: 10px 20px;
  font-weight: 500;
  border-radius: 8px;
  transition: all 0.2s;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-primary {
  background: #4299e1;
  border: none;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background: #3182ce;
  transform: translateY(-1px);
}

.btn-primary:disabled {
  background: #a0aec0;
  cursor: not-allowed;
}

.btn-outline-success {
  border: 1.5px solid #48bb78;
  color: #48bb78;
  background: transparent;
}

.btn-outline-success:hover {
  background: #48bb78;
  color: white;
}

.btn-outline-danger {
  border: 1.5px solid #f56565;
  color: #f56565;
  background: transparent;
}

.btn-outline-danger:hover {
  background: #f56565;
  color: white;
}

.btn-outline-secondary {
  border: 1.5px solid #718096;
  color: #718096;
  background: transparent;
}

.btn-outline-secondary:hover {
  background: #718096;
  color: white;
}

.badge {
  padding: 10px 12px;
  border-radius: 20px;
  font-weight: 500;
  font-size: 13px;
  margin-left: 10px; 
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.modal-card {
  background: white;
  padding: 32px;
  border-radius: 20px;
  max-width: 500px;
  width: 90%;
  max-height: 80vh;
  overflow-y: auto;
}

.alert {
  padding: 16px;
  border-radius: 8px;
}

.alert-info {
  background-color: #ebf8ff;
  border: 1px solid #90cdf4;
  color: #2c5282;
}

/* Toast Notification */
.toast-notification {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 10000;
  min-width: 300px;
  max-width: 400px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  overflow: hidden;
  animation: slideIn 0.3s ease;
}

.toast-notification.success {
  border-left: 4px solid #48bb78;
}

.toast-notification.error {
  border-left: 4px solid #f56565;
}

.toast-notification.info {
  border-left: 4px solid #4299e1;
}

.toast-notification.warning {
  border-left: 4px solid #ed8936;
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
  color: #48bb78;
}

.toast-notification.error i {
  color: #f56565;
}

.toast-notification.info i {
  color: #4299e1;
}

.toast-notification.warning i {
  color: #ed8936;
}

.toast-message {
  flex: 1;
  font-size: 14px;
  color: #2d3748;
}

.toast-close {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #a0aec0;
  padding: 0 4px;
}

.toast-close:hover {
  color: #4a5568;
}

/* Animations */
.slide-fade-enter-active {
  transition: all 0.3s ease;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.error-details {
  text-align: left;
  background: #fef5f5;
  border-radius: 8px;
  padding: 12px;
  max-height: 300px;
  overflow-y: auto;
}

.error-item {
  margin-bottom: 12px;
  padding-bottom: 8px;
  border-bottom: 1px solid #fed7d7;
}

.error-item:last-child {
  border-bottom: none;
}

.error-item strong {
  color: #c53030;
  font-size: 14px;
}

.error-item ul {
  margin: 4px 0 0 0;
  padding-left: 20px;
}

.error-item li {
  color: #742a2a;
  font-size: 13px;
  margin: 2px 0;
}

@media (max-width: 768px) {
  .grid-2,
  .grid-3 {
    grid-template-columns: 1fr;
  }
  
  .page-header {
    flex-direction: column;
    gap: 12px;
    align-items: start;
  }
  
  .form-footer {
    flex-direction: column;
    gap: 12px;
  }
  
  .form-footer button {
    width: 100%;
  }
  
  .toast-notification {
    top: 10px;
    right: 10px;
    left: 10px;
    max-width: none;
  }
}
</style>