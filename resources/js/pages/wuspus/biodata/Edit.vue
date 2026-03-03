<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  row: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
})

const form = useForm({
  id_posyandu: props.row?.id_posyandu ?? null,
  nik_wuspus: props.row.nik_wuspus ?? '',
  nama_wuspus: props.row.nama_wuspus ?? '',
  umur: props.row.umur ?? '',
  tinggi_ibu: props.row.tinggi_ibu ?? '',
  nama_suami: props.row.nama_suami ?? '',
  tinggi_ayah: props.row.tinggi_ayah ?? '',
  thpn_ks: props.row.thpn_ks ?? '',
  klmpk_dasawisma: props.row.klmpk_dasawisma ?? '',
  jml_anak_hdp: props.row.jml_anak_hdp ?? '',
  jml_anak_meninggal: props.row.jml_anak_meninggal ?? '',
  tgl_daftar: props.row.tgl_daftar ?? '',
  status: props.row.status ?? '',
  ket: props.row.ket ?? '',
})

// State untuk select lokasi
const selectedKec = ref(props.row?.id_kec ? String(props.row.id_kec) : '')
const selectedKel = ref(props.row?.id_kel ? String(props.row.id_kel) : '')
const selectedPos = ref(props.row?.id_posyandu ? String(props.row.id_posyandu) : '')

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

// Options untuk select
const kecamatanOptions = computed(() =>
  (props.kecamatan || []).map(k => ({ label: k.nama_kec, value: String(k.id_kec) }))
)

const kelurahanOptions = computed(() => {
  if (!selectedKec.value) return []
  const key = String(selectedKec.value)
  const arr = props.kelurahan?.[key]
  if (!Array.isArray(arr)) return []
  return arr.map(k => ({ label: k.nama_kel, value: String(k.id_kel) }))
})

const posyanduOptions = computed(() => {
  if (!selectedKel.value) return []
  const key = String(selectedKel.value)
  const arr = props.posyandu?.[key]
  if (!Array.isArray(arr)) return []
  return arr.map(p => ({ label: p.nama_posyandu, value: String(p.id_posyandu) }))
})

// Watch untuk reset
watch(selectedKec, () => {
  selectedKel.value = ''
  selectedPos.value = ''
  form.id_posyandu = null
})

watch(selectedKel, () => {
  selectedPos.value = ''
  form.id_posyandu = null
})

watch(selectedPos, (val) => {
  form.id_posyandu = val ? Number(val) : null
})

function submitForm() {
  if (!selectedKec.value) {
    openError('Kecamatan wajib dipilih')
    return
  }
  if (!selectedKel.value) {
    openError('Kelurahan wajib dipilih')
    return
  }
  if (!selectedPos.value) {
    openError('Posyandu wajib dipilih')
    return
  }
  if (!form.nik_wuspus || !form.nama_wuspus) {
    openError('NIK & Nama wajib diisi')
    return
  }

  form.put(`/posyandu/wuspus/${props.row.id_wuspus}`, {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data biodata WUS/PUS berhasil diperbarui')
      setTimeout(() => {
        window.location.href = '/posyandu/wuspus'
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
        <h2 class="mb-1">Edit Biodata WUS/PUS</h2>
        <p class="text-muted">Edit data WUS/PUS</p>
      </div>
      <Link href="/posyandu/wuspus" class="btn btn-outline-secondary">
        <i class="icon-arrow-left me-2"></i>Kembali
      </Link>
    </div>

    <div class="main-card">
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <!-- Filter Lokasi (bisa diedit) -->
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

          <!-- Form Data WUS/PUS -->
          <div class="data-card mt-4">
            <div class="data-header">
              <div>
                <span class="badge bg-primary me-2">1</span>
                <strong>Edit Data WUS/PUS</strong>
              </div>
            </div>

            <div class="grid-2">
              <div class="field">
                <label>NIK WUS/PUS <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control" 
                  v-model="form.nik_wuspus"
                  placeholder="Masukkan NIK"
                />
              </div>

              <div class="field">
                <label>Nama WUS/PUS <span class="text-danger">*</span></label>
                <input 
                  type="text" 
                  class="form-control" 
                  v-model="form.nama_wuspus"
                  placeholder="Masukkan nama lengkap"
                />
              </div>
            </div>

            <div class="grid-3 mt-3">
              <div class="field">
                <label>Umur (Tahun)</label>
                <input 
                  type="number" 
                  class="form-control" 
                  v-model="form.umur"
                  placeholder="Contoh: 25"
                />
              </div>

              <div class="field">
                <label>Tinggi Ibu (cm)</label>
                <input 
                  type="number" 
                  class="form-control" 
                  v-model="form.tinggi_ibu"
                  placeholder="Contoh: 155"
                />
              </div>

              <div class="field">
                <label>Tinggi Ayah (cm)</label>
                <input 
                  type="number" 
                  class="form-control" 
                  v-model="form.tinggi_ayah"
                  placeholder="Contoh: 165"
                />
              </div>
            </div>

            <div class="grid-2 mt-3">
              <div class="field">
                <label>Nama Suami</label>
                <input 
                  type="text" 
                  class="form-control" 
                  v-model="form.nama_suami"
                  placeholder="Masukkan nama suami"
                />
              </div>

              <div class="field">
                <label>Tahapan KS</label>
                <input 
                  type="text" 
                  class="form-control" 
                  v-model="form.thpn_ks"
                  placeholder="Masukkan tahapan KS"
                />
              </div>
            </div>

            <div class="grid-3 mt-3">
              <div class="field">
                <label>Kelompok Dasawisma</label>
                <input 
                  type="text" 
                  class="form-control" 
                  v-model="form.klmpk_dasawisma"
                  placeholder="Kelompok dasawisma"
                />
              </div>

              <div class="field">
                <label>Jumlah Anak Hidup</label>
                <input 
                  type="number" 
                  class="form-control" 
                  v-model="form.jml_anak_hdp"
                  placeholder="Contoh: 2"
                />
              </div>

              <div class="field">
                <label>Jumlah Anak Meninggal</label>
                <input 
                  type="number" 
                  class="form-control" 
                  v-model="form.jml_anak_meninggal"
                  placeholder="Contoh: 0"
                />
              </div>
            </div>

            <div class="grid-2 mt-3">
              <div class="field">
                <label>Tanggal Daftar</label>
                <input 
                  type="date" 
                  class="form-control" 
                  v-model="form.tgl_daftar"
                />
              </div>

              <div class="field">
                <label>Status</label>
                <select class="form-control" v-model="form.status">
                  <option value="">-- Pilih Status --</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Tidak Aktif">Tidak Aktif</option>
                  <option value="Meninggal">Meninggal</option>
                </select>
              </div>
            </div>

            <div class="field mt-3">
              <label>Keterangan</label>
              <textarea 
                class="form-control" 
                rows="3" 
                v-model="form.ket"
                placeholder="Masukkan keterangan tambahan (opsional)"
              ></textarea>
            </div>
          </div>

          <div class="form-footer">
            <Link href="/posyandu/wuspus" class="btn btn-outline-secondary">
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