<script setup>
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'

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

const emptyRow = () => ({
  id_bayi: null,
  id_imun: null,
  tgl_imun: '',
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

function addRow(){ form.rows.push(emptyRow()) }
function deleteRow(i){ if(form.rows.length>1) form.rows.splice(i,1) }

function openError(msg){
  modalType.value='error'; modalMessage.value=msg; showModal.value=true
}
function openSuccess(msg){
  modalType.value='success'; modalMessage.value=msg; showModal.value=true
}

const kelurahanOptions = computed(() => {
  if(!form.kecamatan_id) return []
  return props.kelurahan?.[form.kecamatan_id] ?? []
})
const posyanduOptions = computed(() => {
  if(!form.kelurahan_id) return []
  return props.posyandu?.[form.kelurahan_id] ?? []
})
const bayiOptions = computed(() => {
  if(!form.posyandu_id) return []
  return props.bayi?.[form.posyandu_id] ?? []
})

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id=null; form.posyandu_id=null
  form.rows.forEach(r => r.id_bayi=null)
})
watch(() => form.kelurahan_id, () => {
  form.posyandu_id=null
  form.rows.forEach(r => r.id_bayi=null)
})
watch(() => form.posyandu_id, () => {
  form.rows.forEach(r => r.id_bayi=null)
})

function submit(){
  if(!form.kelurahan_id){ openError('Kelurahan wajib dipilih'); return }
  if(!form.posyandu_id){ openError('Posyandu wajib dipilih'); return }

  try{
    form.rows = form.rows.map((row, idx) => {
      if(!row.id_bayi){ openError(`Data ke-${idx+1}: Bayi wajib dipilih`); throw new Error('invalid') }
      if(!row.id_imun){ openError(`Data ke-${idx+1}: Jenis imunisasi wajib dipilih`); throw new Error('invalid') }
      if(!row.tgl_imun){ openError(`Data ke-${idx+1}: Tanggal imunisasi wajib diisi`); throw new Error('invalid') }
      return { ...row }
    })
  }catch{ return }

  form.post('/posyandu/bayi-imun/store-multiple', {
    preserveScroll:true,
    onSuccess:() => {
      openSuccess('Data imunisasi bayi berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/bayi-imun'), 700)
    },
    onError:() => openError('Gagal menyimpan data')
  })
}
</script>

<template>
<AdminLayout>
<div class="bg-white p-4 main-container">
  <div class="header-flex mb-3">
    <h2>Tambah Imunisasi Bayi</h2>
    <Link href="/posyandu/bayi-imun" class="btn btn-secondary">← Kembali</Link>
  </div>

  <hr>

  <form @submit.prevent="submit">

    <div class="row">
      <div class="col-lg-6">
        <div class="form-group">
          <label>Kecamatan</label>
          <VueSelect
            v-model="form.kecamatan_id"
            :options="kecamatan.map(k => ({ label:k.nama_kec, value:k.id_kec }))"
            placeholder="Pilih Kecamatan"
          />
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="form-group">
          <label>Kelurahan</label>
          <VueSelect
            v-model="form.kelurahan_id"
            :options="kelurahanOptions.map(k => ({ label:k.nama_kel, value:k.id_kel }))"
            :isDisabled="!form.kecamatan_id"
            placeholder="Pilih Kelurahan"
          />
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="form-group">
          <label>Posyandu</label>
          <VueSelect
            v-model="form.posyandu_id"
            :options="posyanduOptions.map(p => ({ label:p.nama_posyandu, value:p.id_posyandu }))"
            :isDisabled="!form.kelurahan_id"
            placeholder="Pilih Posyandu"
          />
        </div>
      </div>
    </div>

    <Table class="mt-4">
      <TableHead>
        <TableRow>
          <TableCol asHead>Form Imunisasi Bayi</TableCol>
          <TableCol asHead width="120">Aksi</TableCol>
        </TableRow>
      </TableHead>

      <tbody>
        <TableRow v-for="(row,i) in form.rows" :key="i">
          <TableCol>
            <h4>Data ke-{{ i+1 }}</h4>

            <div class="row">
              <div class="col-lg-6 mb-3">
                <label>Pilih Bayi</label>
                <VueSelect
                  v-model="row.id_bayi"
                  placeholder="Pilih Bayi"
                  :options="bayiOptions.map(b => ({ label:`${b.nik_bayi} - ${b.nama_bayi}`, value:b.id_bayi }))"
                  :isDisabled="!form.posyandu_id"
                />
              </div>

              <div class="col-lg-6 mb-3">
                <label>Jenis Imunisasi</label>
                <VueSelect
                  v-model="row.id_imun"
                  placeholder="Pilih Imunisasi"
                  :options="imun.map(i => ({ label:i.jns_imun, value:i.id_imun }))"
                />
              </div>

              <div class="col-lg-6 mb-3">
                <label>Tanggal Imunisasi</label>
                <input type="date" class="form-control" v-model="row.tgl_imun">
              </div>

              <div class="col-lg-12 mb-3">
                <label>Keterangan</label>
                <textarea class="form-control" rows="2" v-model="row.ket"></textarea>
              </div>
            </div>
          </TableCol>

          <TableCol class="text-center">
            <span class="bg-danger p-3 d-inline-flex justify-content-center"
                  style="border-radius:1000px;cursor:pointer"
                  @click="deleteRow(i)">
              <i class="icon-trash"></i>
            </span>
          </TableCol>
        </TableRow>
      </tbody>
    </Table>

    <button type="button" class="btn btn-success mt-4" @click="addRow">Tambah Data +</button>
    <button type="submit" class="btn btn-primary mt-4 ms-3" style="margin-left: 1050px;">Simpan Data</button>
  </form>
</div>

<div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
  <div class="modal-card"
       :class="modalType === 'success' ? 'border border-success' : 'border border-danger'">
    <h3 class="text-xl font-semibold mb-3">
      {{ modalType === 'success' ? 'Berhasil' : 'Gagal' }}
    </h3>
    <p>{{ modalMessage }}</p>
    <button class="btn w-100 mt-4" :class="modalType === 'success' ? 'btn-success' : 'btn-danger'"
            @click="showModal=false">
      Tutup
    </button>
  </div>
</div>
</AdminLayout>
</template>

<style scoped>
.overlay-blur{
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index: 9999;
}
.modal-card{
  width: 420px;
  background: #fff;
  border-radius: 14px;
  padding: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.main-container{min-height:100vh}
</style>