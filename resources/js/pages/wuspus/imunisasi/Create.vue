<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  wuspus: Object,
  imun: Array
})

// Row kosong
const emptyRow = () => ({
  id_wuspus: null,
  id_imun: null,
  tgl_imun: '',
  ket: ''
})

// Form
const form = useForm({
  kecamatan_id: null,
  kelurahan_id: null,
  posyandu_id: null,
  rows: [emptyRow()]
})

// Modal
const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

// Options untuk select
const kelurahanOptions = computed(() => form.kecamatan_id ? props.kelurahan?.[form.kecamatan_id] ?? [] : [])
const posyanduOptions = computed(() => form.kelurahan_id ? props.posyandu?.[form.kelurahan_id] ?? [] : [])
const wuspusOptions = computed(() => form.posyandu_id ? props.wuspus?.[form.posyandu_id] ?? [] : [])

// Watch reset saat ganti wilayah
watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.posyandu_id = null
  form.rows.forEach(r => r.id_wuspus = null)
})
watch(() => form.kelurahan_id, () => {
  form.posyandu_id = null
  form.rows.forEach(r => r.id_wuspus = null)
})
watch(() => form.posyandu_id, () => {
  form.rows.forEach(r => r.id_wuspus = null)
})

// Fungsi modal
function openError(msg){ modalType.value='error'; modalMessage.value=msg; showModal.value=true }
function openSuccess(msg){ modalType.value='success'; modalMessage.value=msg; showModal.value=true }

// CRUD row
function addRow(){ form.rows.push(emptyRow()) }
function deleteRow(i){ if(form.rows.length>1) form.rows.splice(i,1) }

// Submit
function submit(){
  if(!form.kelurahan_id) return openError('Kelurahan wajib dipilih')
  if(!form.posyandu_id) return openError('Posyandu wajib dipilih')

  try{
    form.rows.forEach((r,idx)=>{
      if(!r.id_wuspus || !r.id_imun || !r.tgl_imun){
        openError(`Data ke-${idx+1}: WUS/PUS, Imunisasi, dan Tanggal wajib diisi`)
        throw new Error('invalid')
      }
    })
  }catch{ return }

  form.post('/posyandu/wuspus-imun/store-multiple',{
    preserveScroll:true,
    onSuccess:()=>{
      openSuccess('Data imunisasi WUS/PUS berhasil disimpan')
      setTimeout(()=>router.visit('/posyandu/wuspus-imun'),700)
    },
    onError:()=>openError('Gagal menyimpan data')
  })
}
</script>

<template>
  <div class="px-4 py-4">

    <!-- Breadcrumb -->
    <div class="d-flex align-items-center gap-2 mb-4 text-secondary">
      <Link href="/dashboard" class="text-decoration-none text-secondary">Dashboard</Link>
      <span>/</span>
      <Link href="/wuspus-imun" class="text-decoration-none text-secondary">Imunisasi WUS/PUS</Link>
      <span>/</span>
      <span class="text-dark">Tambah Data</span>
    </div>

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
          <i class="icon-plus-circle text-primary fs-2"></i>
        </div>
        <div>
          <h2 class="fw-semibold mb-1">Tambah Imunisasi WUS/PUS</h2>
          <p class="text-secondary mb-0">Multi Data</p>
        </div>
      </div>
      <Link href="/posyandu/wuspus-imun" class="btn btn-outline-secondary px-4 py-2">
        <i class="icon-arrow-left me-2"></i>
        Kembali
      </Link>
    </div>

    <!-- Form Wilayah -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
      <div class="row g-4">
        <div class="col-md-4">
          <label class="form-label fw-medium text-secondary mb-2">Kecamatan <span class="text-danger">*</span></label>
          <VueSelect v-model="form.kecamatan_id"
                     :options="(kecamatan||[]).map(k=>({label:k.nama_kec,value:k.id_kec}))"
                     placeholder="Pilih Kecamatan"
                     :clearable="true" />
        </div>
        <div class="col-md-4">
          <label class="form-label fw-medium text-secondary mb-2">Kelurahan <span class="text-danger">*</span></label>
          <VueSelect v-model="form.kelurahan_id"
                     :options="kelurahanOptions.map(k=>({label:k.nama_kel,value:k.id_kel}))"
                     placeholder="Pilih Kelurahan"
                     :clearable="true"
                     :disabled="!form.kecamatan_id" />
        </div>
        <div class="col-md-4">
          <label class="form-label fw-medium text-secondary mb-2">Posyandu <span class="text-danger">*</span></label>
          <VueSelect v-model="form.posyandu_id"
                     :options="posyanduOptions.map(p=>({label:p.nama_posyandu,value:p.id_posyandu}))"
                     placeholder="Pilih Posyandu"
                     :clearable="true"
                     :disabled="!form.kelurahan_id" />
        </div>
      </div>
    </div>

    <!-- Alert jika posyandu belum dipilih -->
    <div v-if="!form.posyandu_id" class="alert alert-warning bg-warning bg-opacity-10 border-0 rounded-3 d-flex align-items-center gap-3 mb-4">
      <i class="icon-info-circle fs-5 text-warning"></i>
      <span>Silakan pilih Posyandu terlebih dahulu untuk menampilkan data WUS/PUS</span>
    </div>

    <!-- Form Rows -->
    <form @submit.prevent="submit">
      <div class="mb-4">
        <div class="d-flex align-items-center gap-3 mb-3">
          <h6 class="fw-semibold mb-0">Form Imunisasi WUS/PUS</h6>
          <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
            Total: {{ form.rows.length }} Data
          </span>
        </div>

        <div v-for="(row,index) in form.rows" :key="index" class="card border rounded-3 mb-3">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="bg-primary bg-opacity-10 text-primary rounded-2 px-3 py-1 fw-medium">Data #{{ index+1 }}</span>
              <button type="button" class="btn btn-outline-danger btn-sm rounded-3 px-3 py-2"
                      @click="deleteRow(index)" :disabled="form.rows.length===1">
                <i class="icon-trash me-2"></i> Hapus
              </button>
            </div>

            <div class="row g-4">
              <div class="col-lg-6">
                <label class="form-label fw-medium">Pilih WUS/PUS <span class="text-danger">*</span></label>
                <VueSelect v-model="row.id_wuspus"
                           :options="wuspusOptions.map(w=>({label:`${w.nik_wuspus} - ${w.nama_wuspus}`,value:w.id_wuspus}))"
                           placeholder="Pilih WUS/PUS"
                           :disabled="!form.posyandu_id" />
              </div>

              <div class="col-lg-6">
                <label class="form-label fw-medium">Jenis Imunisasi <span class="text-danger">*</span></label>
                <VueSelect v-model="row.id_imun"
                           :options="imun.map(i=>({label:i.jns_imun,value:i.id_imun}))"
                           placeholder="Pilih Imunisasi" />
              </div>

              <div class="col-lg-4">
                <label class="form-label fw-medium">Tanggal Imunisasi <span class="text-danger">*</span></label>
                <input type="date" class="form-control" v-model="row.tgl_imun" />
              </div>

              <div class="col-12">
                <label class="form-label fw-medium">Keterangan</label>
                <textarea class="form-control" rows="2" v-model="row.ket"></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol Tambah & Simpan -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pt-3 border-top">
        <button type="button" class="btn btn-outline-success px-4 py-2 rounded-3 d-flex align-items-center gap-2" @click="addRow">
          <i class="icon-plus"></i> Tambah Data
        </button>
        <button type="submit" class="btn btn-primary px-5 py-2 rounded-3 d-flex align-items-center gap-2">
          <i class="icon-save"></i> Simpan Data
        </button>
      </div>
    </form>

    <!-- Modal -->
    <div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
      <div class="modal-card" :class="modalType==='success'?'border border-success':'border border-danger'">
        <h3 class="text-xl font-semibold mb-3">{{ modalType==='success'?'Berhasil':'Gagal' }}</h3>
        <p class="mb-0">{{ modalMessage }}</p>
        <button class="btn w-100 mt-4" :class="modalType==='success'?'btn-success':'btn-danger'" @click="showModal=false">Tutup</button>
      </div>
    </div>

  </div>
</template>

<style scoped>
.form-control{height:44px;border-radius:10px;border:1px solid #e5e7eb;padding:0 10px;width:100%}
textarea.form-control{height:auto;padding:10px}

.overlay-blur{
  position: fixed; inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  display:flex; align-items:center; justify-content:center;
  z-index:9999;
}
.modal-card{
  width:420px;
  background:#fff;
  border-radius:14px;
  padding:20px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}

@media(max-width:768px){
  .row.g-4{gap:16px}
}
</style>