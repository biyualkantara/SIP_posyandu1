<script setup>
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'

import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
})

const emptyRow = () => ({
  nik_wuspus: '',
  nama_wuspus: '',
  umur: '',
  tinggi_ibu: '',
  nama_suami: '',
  tinggi_ayah: '',
  thpn_ks: '',
  klmpk_dasawisma: '',
  jml_anak_hdp: '',
  jml_anak_meninggal: '',
  tgl_daftar: '',
  status: '',
  ket: '',
})

const form = useForm({
  kecamatan_id: null,
  kelurahan_id: null,
  posyandu_id: null,
  rows: [emptyRow()],
})

const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

function openError(msg){
  modalType.value = 'error'
  modalMessage.value = msg
  showModal.value = true
}
function openSuccess(msg){
  modalType.value = 'success'
  modalMessage.value = msg
  showModal.value = true
}

function addRow(){ form.rows.push(emptyRow()) }
function deleteRow(i){ if(form.rows.length>1) form.rows.splice(i,1) }

const kelurahanOptions = computed(() => {
  if (!form.kecamatan_id) return []
  return props.kelurahan?.[form.kecamatan_id] ?? []
})
const posyanduOptions = computed(() => {
  if (!form.kelurahan_id) return []
  return props.posyandu?.[form.kelurahan_id] ?? []
})

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.posyandu_id = null
})
watch(() => form.kelurahan_id, () => {
  form.posyandu_id = null
})

function submit(){
  if(!form.kelurahan_id) return openError('Kelurahan wajib dipilih')
  if(!form.posyandu_id) return openError('Posyandu wajib dipilih')

  try{
    form.rows.forEach((r, idx) => {
      if(!r.nik_wuspus || !r.nama_wuspus){
        openError(`Data ke-${idx+1}: NIK & Nama wajib diisi`)
        throw new Error('invalid')
      }
    })
  }catch{ return }

  form.post('/posyandu/wuspus/store-multiple',{
    preserveScroll:true,
    onSuccess:()=>{
      openSuccess('Data biodata WUS/PUS berhasil disimpan')
      setTimeout(()=>router.visit('/posyandu/wuspus'),700)
    },
    onError:()=>openError('Gagal menyimpan data')
  })
}
</script>

<template>
<div class="page-wrapper">

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <Link href="/dashboard">Dashboard</Link>
    <span>/</span>
    <Link href="/posyandu/wuspus">WUS/PUS</Link>
    <span>/</span>
    <span>Tambah Data</span>
  </div>

  <!-- Header -->
  <div class="page-header">
    <div>
      <h2>Tambah Biodata WUS/PUS</h2>
      <p>Input multi data peserta</p>
    </div>
    <Link href="/posyandu/wuspus" class="btn btn-outline-secondary">
      Kembali
    </Link>
  </div>

  <!-- Card -->
  <div class="main-card">
    <div class="card-body">

      <!-- Filter Wilayah -->
      <div class="filter-section">
        <h6>Pilih Wilayah</h6>
        <div class="grid-3">
          <div>
            <label>Kecamatan</label>
            <VueSelect
              v-model="form.kecamatan_id"
              :options="(kecamatan||[]).map(k => ({ label: k.nama_kec, value: k.id_kec }))"
              placeholder="Pilih Kecamatan"
            />
          </div>

          <div>
            <label>Kelurahan</label>
            <VueSelect
              v-model="form.kelurahan_id"
              :options="kelurahanOptions.map(k => ({ label: k.nama_kel, value: k.id_kel }))"
              :isDisabled="!form.kecamatan_id"
              placeholder="Pilih Kelurahan"
            />
          </div>

          <div>
            <label>Posyandu</label>
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

        <!-- Form Header -->
        <div class="form-header">
          <h6>Form Biodata</h6>
          <span class="count-badge">{{ form.rows.length }} Data</span>
        </div>

        <!-- Rows -->
        <div v-for="(row,i) in form.rows" :key="i" class="data-card">

          <div class="data-header">
            <span class="data-badge">Data #{{ i+1 }}</span>
            <button type="button" class="btn btn-outline-danger btn-sm" @click="deleteRow(i)">
              Hapus
            </button>
          </div>

          <div class="grid-2">
            <div>
              <label>NIK WUS/PUS</label>
              <input class="form-control" v-model="row.nik_wuspus">
            </div>
            <div>
              <label>Nama WUS/PUS</label>
              <input class="form-control" v-model="row.nama_wuspus">
            </div>
          </div>

          <div class="grid-3">
            <div>
              <label>Umur</label>
              <input type="number" class="form-control" v-model="row.umur">
            </div>
            <div>
              <label>Tinggi Ibu</label>
              <input type="number" class="form-control" v-model="row.tinggi_ibu">
            </div>
            <div>
              <label>Tinggi Ayah</label>
              <input type="number" class="form-control" v-model="row.tinggi_ayah">
            </div>
          </div>

          <div class="grid-2">
            <div>
              <label>Nama Suami</label>
              <input class="form-control" v-model="row.nama_suami">
            </div>
            <div>
              <label>Tahapan KS</label>
              <input class="form-control" v-model="row.thpn_ks">
            </div>
          </div>

          <div class="grid-2">
            <div>
              <label>Jumlah Anak Hidup</label>
              <input type="number" class="form-control" v-model="row.jml_anak_hdp">
            </div>
            <div>
              <label>Jumlah Anak Meninggal</label>
              <input type="number" class="form-control" v-model="row.jml_anak_meninggal">
            </div>
          </div>

          <div class="grid-2">
            <div>
              <label>Tanggal Daftar</label>
              <input type="date" class="form-control" v-model="row.tgl_daftar">
            </div>
            <div>
              <label>Status</label>
              <input class="form-control" v-model="row.status">
            </div>
          </div>

          <div>
            <label>Keterangan</label>
            <textarea class="form-control" rows="2" v-model="row.ket"></textarea>
          </div>

        </div>

        <div class="form-footer">
          <button type="button" class="btn btn-outline-success" @click="addRow">
            Tambah Data
          </button>
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            Simpan Data
          </button>
        </div>

      </form>

    </div>
  </div>

</div>

<!-- Modal -->
<div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
  <div class="modal-card">
    <h4>{{ modalType === 'success' ? 'Berhasil' : 'Gagal' }}</h4>
    <p>{{ modalMessage }}</p>
    <button class="btn w-100 mt-3"
      :class="modalType==='success' ? 'btn-success' : 'btn-danger'"
      @click="showModal=false">
      Tutup
    </button>
  </div>
</div>
</template>

<style scoped>
.page-wrapper {
  max-width: 1100px;
  margin: auto;
  padding: 24px 16px 40px;
}

.breadcrumb {
  display:flex;
  gap:8px;
  color:#6b7280;
  margin-bottom:20px;
}

.page-header {
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.main-card {
  border-radius:16px;
  box-shadow:0 10px 30px rgba(0,0,0,0.06);
  background:white;
}

.card-body { padding:32px }

.filter-section {
  background:#f8fafc;
  border-radius:12px;
  padding:24px;
  margin-bottom:20px;
}

.grid-3 {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:16px;
}

.grid-2 {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:16px;
  margin-top:16px;
}

.data-card {
  border:1px solid #eef1f4;
  border-radius:14px;
  padding:20px;
  margin-top:16px;
}

.data-header {
  display:flex;
  justify-content:space-between;
  margin-bottom:12px;
}

.data-badge {
  background:#eef4ff;
  color:#2f6fed;
  padding:4px 10px;
  border-radius:8px;
  font-size:13px;
  font-weight:600;
}

.form-control {
  height:44px;
  border-radius:10px;
  border:1px solid #e5e7eb;
  width:100%;
  padding:0 10px;
}

textarea.form-control {
  height:auto;
  padding:10px;
}

.form-footer {
  display:flex;
  justify-content:space-between;
  margin-top:24px;
  padding-top:20px;
  border-top:1px solid #f0f2f5;
}

.overlay-blur{
  position: fixed; inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  display:flex; align-items:center; justify-content:center;
  z-index:9999;
}

.modal-card{
  width:420px;
  background:white;
  border-radius:14px;
  padding:20px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}

@media(max-width:768px){
  .grid-3{ grid-template-columns:1fr }
  .grid-2{ grid-template-columns:1fr }
  .form-footer{ flex-direction:column; gap:12px }
}
</style>