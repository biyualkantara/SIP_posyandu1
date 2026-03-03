<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  row: Object
})

const form = useForm({
  ket: props.row.ket ?? '',
  restore: false
})

// Data untuk ditampilkan (read-only) - tambah lokasi
const displayData = {
  kecamatan: props.row?.nama_kec || '-',
  kelurahan: props.row?.nama_kel || '-',
  posyandu: props.row?.nama_posyandu || '-',
  nik: props.row?.nik_wuspus || '-',
  nama: props.row?.nama_wuspus || '-',
  status: props.row?.status || '-'
}

const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

function openError(msg) {
  modalType.value = 'error'
  modalMessage.value = msg
  showModal.value = true
}

function openSuccess(msg) {
  modalType.value = 'success'
  modalMessage.value = msg
  showModal.value = true
}

function submitForm() {
  form.put(`/posyandu/wuspus-kematian/${props.row.id}`, { // PERBAIKAN: pakai row.id (bukan id_wuspus)
    preserveScroll: true,
    data: { ket: form.ket, restore: form.restore },
    onSuccess: () => {
      openSuccess('Data kematian WUS/PUS berhasil diperbarui')
      setTimeout(() => {
        window.location.href = '/posyandu/wuspus-kematian'
      }, 1000)
    },
    onError: (errors) => {
      console.error('Error:', errors)
      openError('Gagal memperbarui data')
    }
  })
}
</script>

<template>
  <div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h2 class="mb-1">Edit Kematian WUS/PUS</h2>
        <p class="text-muted">Edit data kematian WUS/PUS</p>
      </div>
      <Link href="/posyandu/wuspus-kematian" class="btn btn-outline-secondary">
        <i class="icon-arrow-left me-2"></i>Kembali
      </Link>
    </div>

    <div class="main-card">
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <!-- Read Only Info - Lokasi -->
          <div class="filter-box">
            <h6 class="mb-3">Informasi Lokasi</h6>
            <div class="grid-3">
              <div class="field">
                <label>Kecamatan</label>
                <div class="readonly-field">{{ displayData.kecamatan }}</div>
              </div>
              <div class="field">
                <label>Kelurahan</label>
                <div class="readonly-field">{{ displayData.kelurahan }}</div>
              </div>
              <div class="field">
                <label>Posyandu</label>
                <div class="readonly-field">{{ displayData.posyandu }}</div>
              </div>
            </div>
          </div>

          <!-- Read Only Info - Data WUS/PUS -->
          <div class="filter-box mt-4">
            <h6 class="mb-3">Informasi WUS/PUS</h6>
            <div class="grid-3">
              <div class="field">
                <label>NIK</label>
                <div class="readonly-field">{{ displayData.nik }}</div>
              </div>
              <div class="field">
                <label>Nama</label>
                <div class="readonly-field">{{ displayData.nama }}</div>
              </div>
              <div class="field">
                <label>Status</label>
                <div class="readonly-field" :class="{'text-danger': !form.restore, 'text-success': form.restore}">
                  {{ form.restore ? 'Aktif' : 'Meninggal' }}
                </div>
              </div>
            </div>
          </div>

          <!-- Form Data yang bisa diedit -->
          <div class="data-card mt-4">
            <div class="data-header">
              <div>
                <span class="badge bg-primary me-2">1</span>
                <strong>Edit Data Kematian</strong>
              </div>
            </div>

            <div class="field">
              <label>Keterangan</label>
              <textarea 
                class="form-control" 
                rows="3" 
                v-model="form.ket"
                placeholder="Masukkan keterangan"
              ></textarea>
            </div>

            <div class="field mt-3">
              <div class="checkbox-field">
                <input 
                  type="checkbox" 
                  id="restore" 
                  v-model="form.restore"
                  class="checkbox-input"
                />
                <label for="restore" class="checkbox-label text-warning">
                  Pulihkan status WUS/PUS menjadi AKTIF (jika salah input)
                </label>
              </div>
            </div>
          </div>

          <div class="form-footer">
            <Link href="/posyandu/wuspus-kematian" class="btn btn-outline-secondary">
              <i class="icon-close me-2"></i>Batal
            </Link>
            <button type="submit" class="btn btn-primary" :disabled="form.processing">
              <i class="icon-check me-2"></i>
              {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
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
        <i 
          class="icon" 
          :class="{
            'icon-check-circle text-success': modalType === 'success',
            'icon-exclamation-circle text-danger': modalType === 'error'
          }"
          style="font-size: 48px;"
        ></i>
        <h4 class="mt-3">{{ modalType === 'success' ? 'Berhasil!' : 'Gagal!' }}</h4>
        <p class="text-muted">{{ modalMessage }}</p>
        <button class="btn btn-primary mt-3" @click="showModal = false">Tutup</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-wrapper {
  max-width: 900px;
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
  margin: 0;
}

.page-header p {
  color: #64748b;
  margin: 4px 0 0 0;
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

.readonly-field {
  background: #edf2f7;
  border: 1px solid #cbd5e0;
  border-radius: 8px;
  padding: 10px 12px;
  font-size: 14px;
  color: #2d3748;
  min-height: 42px;
  display: flex;
  align-items: center;
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
  width: 100%;
}

.form-control:focus {
  border-color: #4299e1;
  box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
  outline: none;
}

.form-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
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
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-primary {
  background: #4299e1;
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

.btn-outline-secondary {
  background: transparent;
  border: 1.5px solid #718096;
  color: #718096;
}

.btn-outline-secondary:hover {
  background: #718096;
  color: white;
}

.badge {
  padding: 10px 12px;
  border-radius: 20px;
  font-weight: 500;
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
  max-width: 400px;
  width: 90%;
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
    flex-direction: column-reverse;
  }
  
  .form-footer .btn {
    width: 100%;
    justify-content: center;
  }
}
</style>