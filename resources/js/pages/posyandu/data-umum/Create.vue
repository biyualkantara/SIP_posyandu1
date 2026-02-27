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

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.rows = [emptyRow()]
})

watch(() => form.kelurahan_id, () => {
  form.rows = [emptyRow()]
})

function submit() {
  if (!form.kelurahan_id) {
    openError('Kelurahan wajib dipilih')
    return
  }

  try {
    form.rows = form.rows.map((row, index) => {
      const invalid =
        !row.nama_posyandu ||
        !row.strata_psy ||
        !row.alamat_posyandu ||
        !row.pj_umum ||
        !row.pj_operasional ||
        !row.ketuplak ||
        !row.sekretaris ||
        row.int_paud === null ||
        row.int_bkd === null ||
        row.int_terpadu === null ||
        row.kader_aktif === "" ||
        row.kader_taktif === "" ||
        !row.ptgs_kb ||
        !row.ptgs_medis ||
        !row.ptgs_bidan

      if (invalid) {
        openError(`Data ke-${index + 1} masih ada kolom kosong`)
        throw new Error('invalid')
      }

      return {
        ...row,
        id_kel: form.kelurahan_id
      }
    })
  } catch {
    return
  }

  form.post('/posyandu/data-umum/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data posyandu berhasil disimpan')
      setTimeout(() => {
        router.visit('/posyandu/data-umum')
      }, 700)
    },
    onError: () => {
      openError('Gagal menyimpan data')
    }
  })
}
</script>

<template>
  <div class="page-wrapper">
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
        <h4 class="mt-3">{{ modalType === 'success' ? 'Berhasil!' : 'Gagal!' }}</h4>
        <p class="text-muted">{{ modalMessage }}</p>
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
}

.btn-primary {
  background: #4299e1;
  border: none;
}

.btn-primary:hover:not(:disabled) {
  background: #3182ce;
  transform: translateY(-1px);
}

.btn-outline-success {
  border: 1.5px solid #48bb78;
  color: #48bb78;
}

.btn-outline-success:hover {
  background: #48bb78;
  color: white;
}

.btn-outline-danger {
  border: 1.5px solid #f56565;
  color: #f56565;
}

.btn-outline-danger:hover {
  background: #f56565;
  color: white;
}

.btn-outline-secondary {
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
  max-width: 400px;
  width: 90%;
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
}
</style>