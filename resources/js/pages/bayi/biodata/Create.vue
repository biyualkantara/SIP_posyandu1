<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue' // Pastikan ini ada
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  wuspus: Object
})

const emptyRow = () => ({
  id_wuspus: '',
  nama_bayi: '',
  tgl_lhr: '',
  jk: '',
  bb: '',
  ket: ''
})

const form = useForm({
  kecamatan_id: null,
  kelurahan_id: null,
  posyandu_id: null,
  rows: [emptyRow()]
})

// Untuk melacak ID ibu yang sudah dipilih di row lain
const selectedIbuIds = computed(() => {
  return form.rows
    .map(row => row.id_wuspus)
    .filter(id => id !== '')
})

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

function addRow() {
  // Cek apakah masih ada ibu yang tersedia
  const availableIbuCount = ibuOptions.value.length - selectedIbuIds.value.length
  
  if (availableIbuCount <= 0) {
    openError('Tidak ada lagi ibu yang tersedia untuk posyandu ini')
    return
  }
  
  form.rows.push(emptyRow())
}

function deleteRow(i) {
  if (form.rows.length > 1) {
    form.rows.splice(i, 1)
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

const ibuOptions = computed(() => {
  if (!form.posyandu_id) return []
  
  const options = props.wuspus?.[form.posyandu_id] ?? []
  
  // Map ke format yang dibutuhkan VueSelect
  return options.map(i => ({
    label: `${i.nama_wuspus} - ${i.nik_wuspus}`,
    value: i.id_wuspus
  }))
})

// Filter opsi ibu untuk row tertentu (tidak menampilkan ibu yang sudah dipilih di row lain)
const getIbuOptionsForRow = (currentRowIndex) => {
  if (!form.posyandu_id) return []
  
  const allOptions = ibuOptions.value
  
  // Filter out ibu yang sudah dipilih di row lain
  return allOptions.filter(option => {
    // Cek apakah ibu ini sudah dipilih di row lain
    const isSelectedElsewhere = form.rows.some((row, index) => 
      index !== currentRowIndex && row.id_wuspus === option.value
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

function submit() {
  if (!form.kelurahan_id) return openError('Kelurahan wajib dipilih')
  if (!form.posyandu_id) return openError('Posyandu wajib dipilih')

  // Validasi duplikasi ibu
  const ibuIds = form.rows.map(row => row.id_wuspus).filter(id => id)
  const uniqueIbuIds = [...new Set(ibuIds)]
  
  if (ibuIds.length !== uniqueIbuIds.length) {
    return openError('Tidak boleh memilih ibu yang sama untuk data bayi yang berbeda')
  }

  try {
    form.rows = form.rows.map((row, idx) => {
      if (!row.id_wuspus) {
        openError(`Data ke-${idx+1}: Ibu wajib dipilih`)
        throw new Error()
      }
      if (!row.nama_bayi) {
        openError(`Data ke-${idx+1}: Nama bayi wajib diisi`)
        throw new Error()
      }
      if (!row.tgl_lhr) {
        openError(`Data ke-${idx+1}: Tanggal lahir wajib diisi`)
        throw new Error()
      }
      if (!row.jk) {
        openError(`Data ke-${idx+1}: Jenis kelamin wajib dipilih`)
        throw new Error()
      }
      return row
    })
  } catch {
    return
  }
  
  form.post('/posyandu/bayi/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data bayi berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/bayi'), 700)
    },
    onError: (errors) => {
      console.error('Error:', errors)
      openError('Gagal menyimpan data')
    }
  })
}
</script>

<template>
  <div class="page-wrapper">
    <!-- Header dengan tombol kembali -->
    <div class="page-header">
      <div>
        <h2 class="mb-1">Tambah Biodata Bayi</h2>
        <p class="text-muted">Input multi data bayi</p>
      </div>
      <Link href="/posyandu/bayi" class="btn btn-outline-secondary">
        <i class="icon-arrow-left me-2"></i>Kembali
      </Link>
    </div>

    <div class="main-card">
      <div class="card-body">
        <!-- FILTER -->
        <div class="filter-box">
          <h6 class="mb-3">Pilih Lokasi</h6>
          <div class="grid-3">
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

            <div class="field">
              <label>Posyandu <span class="text-danger">*</span></label>
              <VueSelect
                v-model="form.posyandu_id"
                :options="posyanduOptions.map(p => ({ label: p.nama_posyandu, value: p.id_posyandu }))"
                :isDisabled="!form.kelurahan_id"
                placeholder="Pilih Posyandu"
              />
            </div>
          </div>
        </div>

        <form @submit.prevent="submit">
          <!-- Data Bayi Rows -->
          <div v-if="form.posyandu_id" class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Data Bayi</h6>
              <div>
                <span class="badge bg-info me-2">Total: {{ form.rows.length }} data</span>
                <span class="badge bg-success">Ibu tersedia: {{ ibuOptions.length - selectedIbuIds.length }}</span>
              </div>
            </div>

            <div v-for="(row, i) in form.rows" :key="i" class="data-card">
              <div class="data-header">
                <div>
                  <span class="badge bg-primary me-2">{{ i+1 }}</span>
                  <strong>Data Bayi</strong>
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

              <div class="grid-2">
                <div class="field">
                  <label>Nama Bayi <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.nama_bayi"
                    placeholder="Masukkan nama bayi"
                  >
                </div>
                <div class="field">
                  <label>Tanggal Lahir <span class="text-danger">*</span></label>
                  <input 
                    type="date" 
                    class="form-control" 
                    v-model="row.tgl_lhr"
                  >
                </div>
              </div>

              <div class="grid-3">
                <div class="field">
                  <label>Berat Badan (kg)</label>
                  <input 
                    type="number" 
                    step="0.01"
                    class="form-control" 
                    v-model="row.bb"
                    placeholder="Contoh: 3.5"
                  >
                </div>

                <div class="field">
                  <label>Jenis Kelamin <span class="text-danger">*</span></label>
                  <select class="form-control" v-model="row.jk">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                  </select>
                </div>

                <div class="field">
                  <label>Nama Ibu <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="row.id_wuspus"
                    :options="getIbuOptionsForRow(i)"
                    placeholder="Pilih ibu"
                    :key="`${form.posyandu_id}-${i}`"
                  />
                  <small v-if="getIbuOptionsForRow(i).length === 0" class="text-warning">
                    Tidak ada ibu tersedia untuk row ini
                  </small>
                </div>
              </div>

              <div class="field mt-3">
                <label>Keterangan</label>
                <textarea 
                  class="form-control" 
                  rows="2" 
                  v-model="row.ket"
                  placeholder="Masukkan keterangan tambahan (opsional)"
                ></textarea>
              </div>
            </div>

            <div class="form-footer">
              <button 
                type="button" 
                class="btn btn-outline-success" 
                @click="addRow"
                :disabled="ibuOptions.length - selectedIbuIds.length <= 0"
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
            Silakan pilih kecamatan, kelurahan, dan posyandu terlebih dahulu
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
  max-width: 1000px;
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
  width: 100%;
}

.form-control:focus {
  border-color: #4299e1;
  box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
  outline: none;
}

textarea.form-control {
  height: auto;
  padding: 10px 12px;
  resize: vertical;
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

.btn-outline-success {
  background: transparent;
  border: 1.5px solid #48bb78;
  color: #48bb78;
}

.btn-outline-success:hover:not(:disabled) {
  background: #48bb78;
  color: white;
}

.btn-outline-success:disabled {
  border-color: #cbd5e0;
  color: #cbd5e0;
  cursor: not-allowed;
}

.btn-outline-danger {
  background: transparent;
  border: 1.5px solid #f56565;
  color: #f56565;
}

.btn-outline-danger:hover {
  background: #f56565;
  color: white;
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

.alert {
  padding: 16px;
  border-radius: 8px;
}

.alert-info {
  background-color: #ebf8ff;
  border: 1px solid #90cdf4;
  color: #2c5282;
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
    flex-direction: column;
    gap: 12px;
  }
  
  .form-footer button {
    width: 100%;
    justify-content: center;
  }
}
</style>