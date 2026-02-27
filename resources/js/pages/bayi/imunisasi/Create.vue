<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  bayi: Object,
  imun: Array
})

const selectedKec = ref('')
const selectedKel = ref('')
const selectedPos = ref('')

const kecamatanOptions = computed(() => 
  (props.kecamatan || []).map(k => ({ label: k.nama_kec, value: k.id_kec }))
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

const bayiOptions = computed(() => {
  if (!selectedPos.value) return []
  return (props.bayi?.[selectedPos.value] || []).map(b => ({
    label: b.nama_bayi,
    value: b.id_bayi
  }))
})

const form = useForm({
  id_bayi: null,
  id_imun: null,
  tgl_imun: '',
  ket: ''
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

function submit() {
  if (!selectedKec.value) return openError('Kecamatan wajib dipilih')
  if (!selectedKel.value) return openError('Kelurahan wajib dipilih')
  if (!selectedPos.value) return openError('Posyandu wajib dipilih')
  if (!form.id_bayi) return openError('Bayi wajib dipilih')
  if (!form.id_imun) return openError('Jenis imunisasi wajib dipilih')
  if (!form.tgl_imun) return openError('Tanggal imunisasi wajib diisi')

  form.post('/posyandu/bayi-imun', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data imunisasi bayi berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/bayi-imun'), 700)
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
    <!-- Header -->
    <div class="page-header">
      <div>
        <h2 class="mb-1">Tambah Imunisasi Bayi</h2>
        <p class="text-muted">Input data imunisasi bayi</p>
      </div>
      <Link href="/posyandu/bayi-imun" class="btn btn-outline-secondary">
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
          <!-- Form Data -->
          <div v-if="selectedPos" class="mt-4">
            <div class="data-card">
              <div class="data-header">
                <div>
                  <span class="badge bg-primary me-2">1</span>
                  <strong>Data Imunisasi</strong>
                </div>
              </div>

              <div class="grid-2">
                <div class="field">
                  <label>Pilih Bayi <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="form.id_bayi"
                    :options="bayiOptions"
                    :isDisabled="!selectedPos"
                    placeholder="Pilih Bayi"
                  />
                  <small v-if="bayiOptions.length === 0" class="text-warning">
                    Tidak ada data bayi untuk posyandu ini
                  </small>
                </div>

                <div class="field">
                  <label>Jenis Imunisasi <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="form.id_imun"
                    :options="imun.map(i => ({ label: i.jns_imun, value: i.id_imun }))"
                    placeholder="Pilih Jenis Imunisasi"
                  />
                </div>
              </div>

              <div class="grid-2 mt-3">
                <div class="field">
                  <label>Tanggal Imunisasi <span class="text-danger">*</span></label>
                  <input 
                    type="date" 
                    class="form-control" 
                    v-model="form.tgl_imun"
                  />
                </div>

                <div class="field">
                  <label>Keterangan</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    v-model="form.ket"
                    placeholder="Masukkan keterangan (opsional)"
                  />
                </div>
              </div>
            </div>

            <div class="form-footer">
              <div></div>
              <button type="submit" class="btn btn-primary" :disabled="form.processing">
                <i class="icon-check me-2"></i>
                {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
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
  max-width: 800px;
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
}

.grid-3 {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 16px;
}

.data-card {
  border: 1px solid #eef1f4;
  border-radius: 12px;
  padding: 20px;
  background: white;
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

.btn-outline-secondary {
  border: 1.5px solid #718096;
  color: #718096;
}

.btn-outline-secondary:hover {
  background: #718096;
  color: white;
}

.badge {
  padding: 6px 12px;
  border-radius: 20px;
  font-weight: 500;
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
}
</style>