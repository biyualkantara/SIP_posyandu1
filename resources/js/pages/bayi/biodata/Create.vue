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
  if (form.rows.length > 1) form.rows.splice(i, 1)
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
  return props.wuspus?.[form.posyandu_id] ?? []
})

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.posyandu_id = null
})

watch(() => form.kelurahan_id, () => {
  form.posyandu_id = null
})

function submit() {
  if (!form.kelurahan_id) return openError('Kelurahan wajib dipilih')
  if (!form.posyandu_id) return openError('Posyandu wajib dipilih')

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
    onError: () => openError('Gagal menyimpan data')
  })
}
</script>

<template>
<div class="page-wrapper">

  <!-- Header -->
  <div class="page-header">
    <div>
      <h2>Tambah Biodata Bayi</h2>
      <p>Input multi data bayi</p>
    </div>
    <Link href="/posyandu/bayi" class="btn btn-outline-secondary">
      Kembali
    </Link>
  </div>

  <div class="main-card">
    <div class="card-body">

      <!-- FILTER -->
      <div class="filter-box">
        <div class="grid-3">
          <div class="field">
            <label>Kecamatan</label>
            <VueSelect
              v-model="form.kecamatan_id"
              :options="(kecamatan||[]).map(k => ({ label: k.nama_kec, value: k.id_kec }))"
              placeholder="Pilih Kecamatan"
            />
          </div>

          <div class="field">
            <label>Kelurahan</label>
            <VueSelect
              v-model="form.kelurahan_id"
              :options="kelurahanOptions.map(k => ({ label: k.nama_kel, value: k.id_kel }))"
              :isDisabled="!form.kecamatan_id"
              placeholder="Pilih Kelurahan"
            />
          </div>

          <div class="field">
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

        <!-- ROW -->
        <div v-for="(row,i) in form.rows" :key="i" class="data-card">

          <div class="data-header">
            <strong>Data #{{ i+1 }}</strong>
            <button type="button" class="btn btn-outline-danger btn-sm" @click="deleteRow(i)">
              Hapus
            </button>
          </div>

          <div class="grid-2">
            <div class="field">
              <label>Nama Bayi</label>
              <input class="form-control" v-model="row.nama_bayi">
            </div>
            <div class="field">
              <label>Tanggal Lahir</label>
              <input type="date" class="form-control" v-model="row.tgl_lhr">
            </div>
          </div>

          <div class="grid-3">
            <div class="field">
              <label>Berat Badan</label>
              <input type="number" class="form-control" v-model="row.bb">
            </div>

            <div class="field">
              <label>Jenis Kelamin</label>
              <select class="form-control" v-model="row.jk">
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>

            <div class="field">
              <label>Nama Ibu</label>
              <VueSelect
                v-model="row.id_wuspus"
                :options="ibuOptions.map(i => ({
                  label: i.nama_wuspus + ' - ' + i.nik_wuspus,
                  value: i.id_wuspus
                }))"
              />
            </div>
          </div>

          <div class="field mt-3">
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
</template>

<style scoped>

.page-wrapper{
  max-width: 1000px;
  margin: 0 auto;
  padding: 24px 16px 40px;
}

.page-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.main-card{
  background:white;
  border-radius:14px;
  box-shadow:0 8px 24px rgba(0,0,0,0.06);
}

.card-body{ padding:28px }

.filter-box{
  background:#f8fafc;
  padding:20px;
  border-radius:10px;
  margin-bottom:20px;
}

.field{
  display:flex;
  flex-direction:column;
  gap:6px;
}

.grid-2{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:16px;
  margin-top:16px;
}

.grid-3{
  display:grid;
  grid-template-columns:1fr 1fr 1fr;
  gap:16px;
  margin-top:16px;
}

.data-card{
  border:1px solid #eef1f4;
  border-radius:12px;
  padding:18px;
  margin-top:16px;
}

.data-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:10px;
}

.form-control{
  height:42px;
  border-radius:8px;
  border:1px solid #e5e7eb;
  padding:0 10px;
}

textarea.form-control{
  height:auto;
  padding:10px;
}

.form-footer{
  display:flex;
  justify-content:space-between;
  margin-top:24px;
  padding-top:20px;
  border-top:1px solid #f0f2f5;
}

@media(max-width:768px){
  .grid-2,
  .grid-3{
    grid-template-columns:1fr;
  }
}

</style>