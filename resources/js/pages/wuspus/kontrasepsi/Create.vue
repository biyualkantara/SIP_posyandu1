<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  wuspus: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object
})

const selectedKec = ref('')
const selectedKel = ref('')
const selectedPos = ref('')

const kecamatanOptions = computed(() => 
  (props.kecamatan || []).map(k => ({
    label: k.nama_kec,
    value: k.id_kec
  }))
)

const kelurahanOptions = computed(() => {
  if (!selectedKec.value) return []
  return (props.kelurahan?.[selectedKec.value] || []).map(k => ({
    label: k.nama_kel,
    value: k.id_kel
  }))
})

const posyanduOptions = computed(() => {
  if (!selectedKel.value) return []
  return (props.posyandu?.[selectedKel.value] || []).map(p => ({
    label: p.nama_posyandu,
    value: p.id_posyandu
  }))
})

const wuspusOptions = computed(() => {
  if (!selectedPos.value) return []
  const wuspusList = props.wuspus?.[selectedPos.value] || []
  return wuspusList.map(w => ({
    label: `${w.nik_wuspus || ''} - ${w.nama_wuspus || ''}`,
    value: w.id_wuspus
  }))
})

watch(selectedKec, () => {
  selectedKel.value = ''
  selectedPos.value = ''
  form.rows = [emptyRow()]
})

watch(selectedKel, () => {
  selectedPos.value = ''
  form.rows = [emptyRow()]
})

watch(selectedPos, () => {
  form.rows = [emptyRow()]
})

const emptyRow = () => ({
  id_wuspus: null,
  jns_kontrasepsi: '',
  tgl_ganti: '',
  kontrasepsi_baru: '',
  ket: ''
})

const form = useForm({
  kelurahan_id: '',
  posyandu_id: '',
  rows: [emptyRow()]
})

watch(selectedPos, (val) => form.posyandu_id = val)
watch(selectedKel, (val) => form.kelurahan_id = val)

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

const addRow = () => {
  if (wuspusOptions.value.length <= form.rows.length) {
    openError('Tidak ada lagi WUS/PUS yang tersedia untuk posyandu ini')
    return
  }
  form.rows.push(emptyRow())
}

const deleteRow = (i) => {
  if (form.rows.length > 1) form.rows.splice(i, 1)
}

// Cek duplikasi pemilihan WUS/PUS
const selectedWuspusIds = computed(() => {
  return form.rows.map(row => row.id_wuspus).filter(id => id)
})

const getWuspusOptionsForRow = (currentRowIndex) => {
  return wuspusOptions.value.filter(option => {
    const isSelectedElsewhere = form.rows.some((row, index) => 
      index !== currentRowIndex && row.id_wuspus === option.value
    )
    return !isSelectedElsewhere
  })
}

const validateForm = () => {
  if (!selectedKec.value) {
    openError('Kecamatan wajib dipilih')
    return false
  }
  if (!selectedKel.value) {
    openError('Kelurahan wajib dipilih')
    return false
  }
  if (!selectedPos.value) {
    openError('Posyandu wajib dipilih')
    return false
  }

  // Cek duplikasi WUS/PUS
  const wuspusIds = form.rows.map(row => row.id_wuspus).filter(id => id)
  const uniqueIds = [...new Set(wuspusIds)]
  if (wuspusIds.length !== uniqueIds.length) {
    openError('Tidak boleh memilih WUS/PUS yang sama untuk data yang berbeda')
    return false
  }

  for (let i = 0; i < form.rows.length; i++) {
    const r = form.rows[i]
    if (!r.id_wuspus) {
      openError(`Data ke-${i+1}: WUS/PUS wajib dipilih`)
      return false
    }
    if (!r.jns_kontrasepsi) {
      openError(`Data ke-${i+1}: Jenis kontrasepsi wajib dipilih`)
      return false
    }
    if (!r.tgl_ganti) {
      openError(`Data ke-${i+1}: Tanggal ganti wajib diisi`)
      return false
    }
    if (!r.kontrasepsi_baru) {
      openError(`Data ke-${i+1}: Kontrasepsi baru wajib diisi`)
      return false
    }
  }
  return true
}

const submit = () => {
  if (!validateForm()) return

  form.post('/posyandu/wuspus-kontrasepsi/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data kontrasepsi WUS/PUS berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/wuspus-kontrasepsi'), 700)
    },
    onError: () => openError('Gagal menyimpan data')
  })
}
</script>

<template>
  <div class="page-wrapper">
    <!-- Header -->
    <div class="page-header">
      <div>
        <h2 class="mb-1">Tambah Kontrasepsi WUS/PUS</h2>
        <p class="text-muted">Input multi data kontrasepsi WUS/PUS</p>
      </div>
      <Link href="/posyandu/wuspus-kontrasepsi" class="btn btn-outline-secondary">
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
                v-model="selectedKec"
                :options="kecamatanOptions"
                placeholder="Pilih Kecamatan"
              />
            </div>

            <div class="field">
              <label>Kelurahan <span class="text-danger">*</span></label>
              <VueSelect
                v-model="selectedKel"
                :options="kelurahanOptions"
                :isDisabled="!selectedKec"
                placeholder="Pilih Kelurahan"
              />
            </div>

            <div class="field">
              <label>Posyandu <span class="text-danger">*</span></label>
              <VueSelect
                v-model="selectedPos"
                :options="posyanduOptions"
                :isDisabled="!selectedKel"
                placeholder="Pilih Posyandu"
              />
            </div>
          </div>
        </div>

        <form @submit.prevent="submit">
          <!-- Data Kontrasepsi Rows -->
          <div v-if="selectedPos" class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6>Data Kontrasepsi WUS/PUS</h6>
              <div>
                <span class="badge bg-info me-2">Total: {{ form.rows.length }} data</span>
                <span class="badge bg-success">WUS/PUS tersedia: {{ wuspusOptions.length - selectedWuspusIds.length }}</span>
              </div>
            </div>

            <div v-for="(row, i) in form.rows" :key="i" class="data-card">
              <div class="data-header">
                <div>
                  <span class="badge bg-primary me-2">{{ i+1 }}</span>
                  <strong>Data Kontrasepsi</strong>
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
                  <label>Pilih WUS/PUS <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="row.id_wuspus"
                    :options="getWuspusOptionsForRow(i)"
                    :isDisabled="!selectedPos"
                    placeholder="Pilih WUS/PUS"
                    :key="`${selectedPos}-${i}`"
                  />
                  <small v-if="getWuspusOptionsForRow(i).length === 0" class="text-warning">
                    Tidak ada WUS/PUS tersedia untuk row ini
                  </small>
                </div>

                <div class="field">
                  <label>Jenis Kontrasepsi <span class="text-danger">*</span></label>
                  <select class="form-control" v-model="row.jns_kontrasepsi">
                    <option value="">-- Pilih Jenis Kontrasepsi --</option>
                    <option value="PIL">PIL</option>
                    <option value="SUNTIK">SUNTIK</option>
                    <option value="IUD">IUD</option>
                    <option value="IMPLAN">IMPLAN</option>
                    <option value="MOW">MOW</option>
                    <option value="MOP">MOP</option>
                    <option value="KONDOM">KONDOM</option>
                  </select>
                </div>
              </div>

              <div class="grid-2">
                <div class="field">
                  <label>Tanggal Ganti <span class="text-danger">*</span></label>
                  <input 
                    type="date" 
                    class="form-control" 
                    v-model="row.tgl_ganti"
                  />
                </div>
                <div class="field">
                  <label>Kontrasepsi Baru <span class="text-danger">*</span></label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="row.kontrasepsi_baru"
                    placeholder="Masukkan kontrasepsi baru"
                  />
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
                :disabled="wuspusOptions.length - selectedWuspusIds.length <= 0"
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