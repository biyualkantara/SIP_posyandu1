<script setup>
// PERBAIKAN: Import AdminLayout
import AdminLayout from '@/layouts/AdminLayout.vue'
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'

import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  wuspus: Object, 
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object
})

// State untuk filter wilayah
const selectedKec = ref('')
const selectedKel = ref('')
const selectedPos = ref('')

// Options untuk filter
const kecamatanOptions = computed(() => {
  return (props.kecamatan || []).map(k => ({
    label: k.nama_kec,
    value: k.id_kec
  }))
})

const kelurahanOptions = computed(() => {
  if (!selectedKec.value) return []
  return (props.kelurahan[selectedKec.value] || []).map(k => ({
    label: k.nama_kel,
    value: k.id_kel
  }))
})

const posyanduOptions = computed(() => {
  if (!selectedKel.value) return []
  return (props.posyandu[selectedKel.value] || []).map(p => ({
    label: p.nama_posyandu,
    value: p.id_posyandu
  }))
})

// Options untuk WUS/PUS berdasarkan posyandu terpilih
const wuspusOptions = computed(() => {
  if (!selectedPos.value) return []
  const wuspusList = props.wuspus[selectedPos.value] || []
  return wuspusList.map(w => ({
    label: `${w.nik_wuspus || ''} - ${w.nama_wuspus || ''}`,
    value: w.id_wuspus
  }))
})

// Reset kelurahan saat kecamatan berubah
watch(selectedKec, () => {
  selectedKel.value = ''
  selectedPos.value = ''
})

// Reset posyandu saat kelurahan berubah
watch(selectedKel, () => {
  selectedPos.value = ''
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

// Update form fields saat posyandu dipilih
watch(selectedPos, (newVal) => {
  form.posyandu_id = newVal
})

watch(selectedKel, (newVal) => {
  form.kelurahan_id = newVal
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
  if(form.rows.length > 1) form.rows.splice(i,1) 
}

function validateForm() {
  if (!selectedKec.value) {
    openError('Silakan pilih kecamatan terlebih dahulu')
    return false
  }
  if (!selectedKel.value) {
    openError('Silakan pilih kelurahan terlebih dahulu')
    return false
  }
  if (!selectedPos.value) {
    openError('Silakan pilih posyandu terlebih dahulu')
    return false
  }
  
  for (let i = 0; i < form.rows.length; i++) {
    const row = form.rows[i]
    if (!row.id_wuspus || !row.jns_kontrasepsi || !row.tgl_ganti || !row.kontrasepsi_baru) {
      openError(`Data ke-${i+1}: WUS/PUS, Jenis, Tanggal ganti, dan Kontrasepsi baru wajib diisi`)
      return false
    }
  }
  return true
}

function submit() {
  if (!validateForm()) return

  form.post('/posyandu/wuspus-kontrasepsi/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data kontrasepsi WUS/PUS berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/wuspus-kontrasepsi'), 1500)
    },
    onError: (errors) => {
      console.error(errors)
      openError('Gagal menyimpan data: ' + (errors.message || 'Unknown error'))
    }
  })
}
</script>

<template>
    <div class="container-fluid py-4">
      <!-- Breadcrumb (Navigasi posisi halaman) -->
      <div class="row mb-4">
        <div class="col-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/dashboard" class="text-decoration-none">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/wuspus-kontrasepsi" class="text-decoration-none">Kontrasepsi WUS/PUS</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
            </ol>
          </nav>
        </div>
      </div>

      <!-- Header dengan judul dan tombol kembali -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
              <i class="icon-plus-circle me-2 text-primary"></i>
              Tambah Kontrasepsi WUS/PUS (Multi Data)
            </h2>
            <Link href="/posyandu/wuspus-kontrasepsi" class="btn btn-outline-secondary">
              <i class="icon-arrow-left me-2"></i>
              Kembali
            </Link>
          </div>
        </div>
      </div>

      <!-- Main Content Card -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <!-- Filter Wilayah -->
              <div class="row g-3 mb-4 p-3 bg-light rounded">
                <div class="col-md-4">
                  <label class="form-label fw-bold">Kecamatan <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="selectedKec"
                    :options="kecamatanOptions"
                    placeholder="Pilih Kecamatan"
                    :clearable="true"
                    :searchable="true"
                  />
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-bold">Kelurahan <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="selectedKel"
                    :options="kelurahanOptions"
                    placeholder="Pilih Kelurahan"
                    :clearable="true"
                    :searchable="true"
                    :disabled="!selectedKec"
                  />
                </div>

                <div class="col-md-4">
                  <label class="form-label fw-bold">Posyandu <span class="text-danger">*</span></label>
                  <VueSelect
                    v-model="selectedPos"
                    :options="posyanduOptions"
                    placeholder="Pilih Posyandu"
                    :clearable="true"
                    :searchable="true"
                    :disabled="!selectedKel"
                  />
                </div>
              </div>

              <form @submit.prevent="submit">
                <!-- Pesan jika belum pilih posyandu -->
                <div v-if="!selectedPos" class="alert alert-warning">
                  <i class="icon-info-circle me-2"></i>
                  Silakan pilih Posyandu terlebih dahulu untuk menampilkan data WUS/PUS
                </div>

                <!-- Tabel Data Kontrasepsi -->
                <div class="table-responsive">
                  <Table class="table-bordered">
                    <TableHead>
                      <TableRow>
                        <TableCol asHead width="80" class="text-center">No</TableCol>
                        <TableCol asHead>Form Kontrasepsi WUS/PUS</TableCol>
                        <TableCol asHead width="100" class="text-center">Aksi</TableCol>
                      </TableRow>
                    </TableHead>
                    
                    <tbody>
                      <TableRow v-for="(row,i) in form.rows" :key="i">
                        <!-- Nomor -->
                        <TableCol class="text-center align-middle">
                          <span class="badge bg-secondary">{{ i+1 }}</span>
                        </TableCol>

                        <!-- Form Fields -->
                        <TableCol>
                          <div class="row g-3">
                            <!-- Pilih WUS/PUS -->
                            <div class="col-lg-6">
                              <label class="form-label fw-bold">
                                Pilih WUS/PUS <span class="text-danger">*</span>
                              </label>
                              <VueSelect
                                v-model="row.id_wuspus"
                                :options="wuspusOptions"
                                placeholder="Pilih WUS/PUS"
                                :disabled="!selectedPos"
                              />
                            </div>

                            <!-- Jenis Kontrasepsi -->
                            <div class="col-lg-6">
                              <label class="form-label fw-bold">
                                Jenis Kontrasepsi <span class="text-danger">*</span>
                              </label>
                              <select class="form-select" v-model="row.jns_kontrasepsi">
                                <option value="">Pilih Jenis Kontrasepsi</option>
                                <option value="PIL">PIL</option>
                                <option value="SUNTIK">SUNTIK</option>
                                <option value="IUD">IUD</option>
                                <option value="IMPLAN">IMPLAN</option>
                                <option value="MOW">MOW</option>
                                <option value="MOP">MOP</option>
                                <option value="KONDOM">KONDOM</option>
                                <option value="LAINNYA">Lainnya</option>
                              </select>
                            </div>

                            <!-- Tanggal Ganti -->
                            <div class="col-lg-4">
                              <label class="form-label fw-bold">
                                Tanggal Ganti <span class="text-danger">*</span>
                              </label>
                              <input type="date" class="form-control" v-model="row.tgl_ganti">
                            </div>

                            <!-- Kontrasepsi Baru -->
                            <div class="col-lg-8">
                              <label class="form-label fw-bold">
                                Kontrasepsi Baru <span class="text-danger">*</span>
                              </label>
                              <input class="form-control" v-model="row.kontrasepsi_baru" placeholder="Contoh: SUNTIK 3 BULAN">
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12">
                              <label class="form-label fw-bold">Keterangan</label>
                              <textarea class="form-control" rows="2" v-model="row.ket" placeholder="Opsional"></textarea>
                            </div>
                          </div>
                        </TableCol>

                        <!-- Tombol Hapus -->
                        <TableCol class="text-center align-middle">
                          <button 
                            type="button"
                            class="btn btn-danger btn-sm rounded-circle"
                            style="width: 38px; height: 38px;"
                            @click="deleteRow(i)"
                            :disabled="form.rows.length === 1"
                          >
                            <i class="icon-trash"></i>
                          </button>
                        </TableCol>
                      </TableRow>
                    </tbody>
                  </Table>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                  <button 
                    type="button" 
                    class="btn btn-success"
                    @click="addRow"
                    :disabled="!selectedPos"
                  >
                    <i class="icon-plus me-2"></i>
                    Tambah Data
                  </button>
                  
                  <div>
                    <span class="text-muted me-3">
                      Total: {{ form.rows.length }} data
                    </span>
                    
                    <button 
                      type="submit" 
                      class="btn btn-primary"
                      :disabled="form.processing || !selectedPos"
                    >
                      <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                      <i v-else class="icon-save me-2"></i>
                      {{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL -->
    <div v-if="showModal" class="modal-overlay" @click.self="showModal=false">
      <div class="modal-card" :class="modalType">
        <div class="modal-header" :class="modalType">
          <h5 class="modal-title">
            <i :class="modalType==='success'?'icon-check-circle':'icon-exclamation-triangle'" class="me-2"></i>
            {{ modalType==='success'?'Berhasil':'Gagal' }}
          </h5>
          <button type="button" class="btn-close" @click="showModal=false"></button>
        </div>
        <div class="modal-body">
          <p class="mb-0">{{ modalMessage }}</p>
        </div>
        <div class="modal-footer">
          <button class="btn w-100" :class="modalType==='success'?'btn-success':'btn-danger'" @click="showModal=false">
            Tutup
          </button>
        </div>
      </div>
    </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.modal-card {
  width: 400px;
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}

.modal-card.success {
  border-top: 4px solid #28a745;
}

.modal-card.error {
  border-top: 4px solid #dc3545;
}

.modal-header {
  padding: 16px 20px;
  border-bottom: 1px solid #dee2e6;
}

.modal-header.success {
  background: #d4edda;
  color: #155724;
}

.modal-header.error {
  background: #f8d7da;
  color: #721c24;
}

.modal-body {
  padding: 20px;
}

.modal-footer {
  padding: 16px 20px;
  border-top: 1px solid #dee2e6;
}

.btn-close {
  background: transparent;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  opacity: 0.5;
}

.btn-close:hover {
  opacity: 1;
}
</style>