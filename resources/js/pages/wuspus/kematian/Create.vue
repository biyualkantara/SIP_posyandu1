<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({ 
  wuspus: Array 
})

// Filter WUS/PUS yang masih aktif saja
const wuspusAktif = computed(() => {
  return props.wuspus || []
})

const form = useForm({
  id_wuspus: null,
  tgl_wafat: '',
  penyebab: '',
  ket: ''
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
  if (toast.value.timeout) clearTimeout(toast.value.timeout)
  
  toast.value.show = true
  toast.value.type = type
  toast.value.message = message
  
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
  showToast('error', msg, 4000)
}

function openSuccess(msg) {
  modalType.value = 'success'
  modalTitle.value = 'Berhasil!'
  modalMessage.value = msg
  validationErrors.value = []
  showModal.value = true
  showToast('success', msg, 3000)
}

function submit() {
  if (!form.id_wuspus) {
    openError('WUS/PUS wajib dipilih')
    return
  }
  if (!form.tgl_wafat) {
    openError('Tanggal wafat wajib diisi')
    return
  }

  showToast('info', 'Menyimpan data...', 0)

  form.post('/posyandu/wuspus-kematian', {
    preserveScroll: true,
    onSuccess: () => {
      hideToast()
      openSuccess('Data kematian WUS/PUS berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/wuspus-kematian'), 1500)
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
          <h1 class="page-title">Tambah Data Kematian WUS/PUS</h1>
          <p class="page-subtitle">Input data kematian WUS/PUS</p>
        </div>
        <div class="header-right">
          <Link href="/posyandu/wuspus-kematian" class="btn-back">
            <span>←</span>
            <span>Kembali</span>
          </Link>
        </div>
      </div>

      <!-- Main Card -->
      <div class="main-card">
        <div class="card-body">
          <!-- Info Alert -->
          <div class="alert alert-info mb-4">
            <span class="alert-icon">ℹ️</span>
            <span>Data WUS/PUS yang ditampilkan hanya yang berstatus <strong>Aktif</strong></span>
          </div>

          <form @submit.prevent="submit">
            <!-- Data Kematian -->
            <div class="data-card">
              <div class="data-card-header">
                <div class="card-title">
                  <span class="card-number">1</span>
                  <strong>Data Kematian</strong>
                </div>
              </div>

              <div class="form-grid-2">
                <div class="form-field">
                  <label>Pilih WUS/PUS <span class="text-danger">*</span></label>
                  <div class="select-wrapper">
                    <VueSelect
                      v-model="form.id_wuspus"
                      :options="wuspusAktif.map(w => ({
                        label: `${w.nik_wuspus} - ${w.nama_wuspus} (${w.nama_posyandu || '-'})`,
                        value: w.id_wuspus
                      }))"
                      placeholder="Pilih WUS/PUS"
                      class="vue-select-custom"
                    />
                  </div>
                  <small v-if="wuspusAktif.length === 0" class="text-warning">
                    Tidak ada WUS/PUS dengan status Aktif
                  </small>
                </div>

                <div class="form-field">
                  <label>Tanggal Wafat <span class="text-danger">*</span></label>
                  <input 
                    type="date" 
                    class="form-input" 
                    v-model="form.tgl_wafat"
                  />
                </div>
              </div>

              <div class="form-grid-2 mt-3">
                <div class="form-field">
                  <label>Penyebab</label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="form.penyebab"
                    placeholder="Masukkan penyebab (opsional)"
                  />
                </div>

                <div class="form-field">
                  <label>Keterangan</label>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="form.ket"
                    placeholder="Masukkan keterangan (opsional)"
                  />
                </div>
              </div>
            </div>

            <div class="form-actions">
              <Link href="/posyandu/wuspus-kematian" class="btn-cancel">
                <span>✕</span>
                <span>Batal</span>
              </Link>
              <button type="submit" class="btn-save" :disabled="form.processing">
                <span>✓</span>
                <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}</span>
              </button>
            </div>
          </form>

        </div>
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

/* Button Cancel */
.btn-cancel {
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
  text-decoration: none;
}

.btn-cancel:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
}

.btn-cancel:active {
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

/* Alert Info */
.alert {
  padding: 16px 20px;
  border-radius: 12px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.alert-info {
  background-color: #ebf8ff;
  border: 1px solid #90cdf4;
  color: #2c5282;
}

.alert-icon {
  font-size: 18px;
}

/* Data Card */
.data-card {
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 24px;
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

/* Form Grid */
.form-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
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

/* Select Wrapper */
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

/* Text Warning */
.text-warning {
  color: #d97706;
  font-size: 12px;
  margin-top: 4px;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-top: 28px;
  padding-top: 24px;
  border-top: 2px solid #f1f5f9;
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

/* Margin */
.mt-3 {
  margin-top: 12px;
}

/* Responsive */
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
  
  .btn-back,
  .btn-cancel,
  .btn-save {
    width: 100%;
    justify-content: center;
  }
  
  .form-grid-2 {
    grid-template-columns: 1fr;
  }
  
  .form-actions {
    flex-direction: column;
    gap: 12px;
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