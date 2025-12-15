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
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Tambah WUS/PUS (Multi Data)</h2>
        <Link href="/posyandu/wuspus" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
              <label>Kecamatan</label>
              <VueSelect
                v-model="form.kecamatan_id"
                :options="(kecamatan||[]).map(k => ({ label: k.nama_kec, value: k.id_kec }))"
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
                :options="kelurahanOptions.map(k => ({ label: k.nama_kel, value: k.id_kel }))"
                placeholder="Pilih Kelurahan"
                :isDisabled="!form.kecamatan_id"
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
                :options="posyanduOptions.map(p => ({ label: p.nama_posyandu, value: p.id_posyandu }))"
                placeholder="Pilih Posyandu"
                :isDisabled="!form.kelurahan_id"
              />
            </div>
          </div>
        </div>

        <Table class="mt-4">
          <TableHead>
            <TableRow>
              <TableCol asHead>Form Biodata WUS/PUS</TableCol>
              <TableCol asHead width="120">Aksi</TableCol>
            </TableRow>
          </TableHead>

          <tbody>
            <TableRow v-for="(row,i) in form.rows" :key="i">
              <TableCol>
                <h4>Data ke-{{ i+1 }}</h4>

                <div class="row">
                  <div class="col-lg-6 mb-3">
                    <label>NIK WUS/PUS</label>
                    <input class="form-control" v-model="row.nik_wuspus" placeholder="contoh: 3273xxxx">
                  </div>

                  <div class="col-lg-6 mb-3">
                    <label>Nama WUS/PUS</label>
                    <input class="form-control" v-model="row.nama_wuspus" placeholder="Nama lengkap">
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label>Umur</label>
                    <input type="number" class="form-control" v-model="row.umur">
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label>Tinggi Ibu (cm)</label>
                    <input type="number" class="form-control" v-model="row.tinggi_ibu">
                  </div>

                  <div class="col-lg-6 mb-3">
                    <label>Nama Suami</label>
                    <input class="form-control" v-model="row.nama_suami">
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label>Tinggi Ayah (cm)</label>
                    <input type="number" class="form-control" v-model="row.tinggi_ayah">
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label>Tahapan KS</label>
                    <input class="form-control" v-model="row.thpn_ks" placeholder="KS I / KS II / ...">
                  </div>

                  <div class="col-lg-6 mb-3">
                    <label>Kelompok Dasawisma</label>
                    <input class="form-control" v-model="row.klmpk_dasawisma">
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label>Jumlah Anak Hidup</label>
                    <input type="number" class="form-control" v-model="row.jml_anak_hdp">
                  </div>

                  <div class="col-lg-3 mb-3">
                    <label>Jumlah Anak Meninggal</label>
                    <input type="number" class="form-control" v-model="row.jml_anak_meninggal">
                  </div>

                  <div class="col-lg-4 mb-3">
                    <label>Tanggal Daftar</label>
                    <input type="date" class="form-control" v-model="row.tgl_daftar">
                  </div>

                  <div class="col-lg-4 mb-3">
                    <label>Status</label>
                    <input class="form-control" v-model="row.status" placeholder="Aktif / Tidak Aktif">
                  </div>

                  <div class="col-lg-12 mb-3">
                    <label>Keterangan</label>
                    <textarea class="form-control" rows="2" v-model="row.ket"></textarea>
                  </div>
                </div>
              </TableCol>

              <TableCol class="text-center">
                <span class="bg-danger p-3 d-inline-flex justify-content-center text-white"
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
      <div class="modal-card" :class="modalType === 'success' ? 'border border-success' : 'border border-danger'">
        <h3 class="text-xl font-semibold mb-3">
          {{ modalType === 'success' ? 'Berhasil' : 'Gagal' }}
        </h3>
        <p class="mb-0">{{ modalMessage }}</p>
        <button class="btn w-100 mt-4"
                :class="modalType === 'success' ? 'btn-success' : 'btn-danger'"
                @click="showModal=false">
          Tutup
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.overlay-blur{
  position: fixed; inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  display:flex; align-items:center; justify-content:center;
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