<script setup>
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'

import { Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  wuspus: Array, // dari controller create()
})

const emptyRow = () => ({
  id_wuspus: null,
  jns_kontrasepsi: '',
  tgl_ganti: '',
  kontrasepsi_baru: '',
  ket: ''
})

const form = useForm({
  rows: [emptyRow()]
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
function deleteRow(i){ if(form.rows.length > 1) form.rows.splice(i,1) }

function submit(){
  try{
    form.rows.forEach((r,idx)=>{
      if(!r.id_wuspus || !r.jns_kontrasepsi || !r.tgl_ganti || !r.kontrasepsi_baru){
        openError(`Data ke-${idx+1}: WUS/PUS, Jenis, Tanggal ganti, dan Kontrasepsi baru wajib diisi`)
        throw new Error('invalid')
      }
    })
  }catch{ return }

  form.post('/posyandu/wuspus-kb/store-multiple',{
    preserveScroll:true,
    onSuccess:()=>{
      openSuccess('Data kontrasepsi WUS/PUS berhasil disimpan')
      setTimeout(()=>router.visit('/posyandu/wuspus-kb'),700)
    },
    onError:()=>openError('Gagal menyimpan data')
  })
}
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Tambah Kontrasepsi WUS/PUS (Multi Data)</h2>
        <Link href="/posyandu/wuspus-kb" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <form @submit.prevent="submit">
        <Table class="mt-2">
          <TableHead>
            <TableRow>
              <TableCol asHead>Form Kontrasepsi WUS/PUS</TableCol>
              <TableCol asHead width="120">Aksi</TableCol>
            </TableRow>
          </TableHead>

          <tbody>
            <TableRow v-for="(row,i) in form.rows" :key="i">
              <TableCol>
                <h4>Data ke-{{ i+1 }}</h4>

                <div class="row">
                  <div class="col-lg-6 mb-3">
                    <label>Pilih WUS/PUS</label>
                    <VueSelect
                      v-model="row.id_wuspus"
                      :options="(props.wuspus||[]).map(w=>({label:`${w.nik_wuspus} - ${w.nama_wuspus}`,value:w.id_wuspus}))"
                      placeholder="Pilih WUS/PUS"
                    />
                  </div>

                  <div class="col-lg-6 mb-3">
                    <label>Jenis Kontrasepsi</label>
                    <input class="form-control" v-model="row.jns_kontrasepsi" placeholder="Contoh: Pil / Suntik / IUD / Implan">
                  </div>

                  <div class="col-lg-4 mb-3">
                    <label>Tanggal Ganti</label>
                    <input type="date" class="form-control" v-model="row.tgl_ganti">
                  </div>

                  <div class="col-lg-8 mb-3">
                    <label>Kontrasepsi Baru</label>
                    <input class="form-control" v-model="row.kontrasepsi_baru" placeholder="Kontrasepsi yang dipakai setelah ganti">
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

    <!-- MODAL -->
    <div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
      <div class="modal-card" :class="modalType==='success'?'border border-success':'border border-danger'">
        <h3 class="text-xl font-semibold mb-3">{{ modalType==='success'?'Berhasil':'Gagal' }}</h3>
        <p class="mb-0">{{ modalMessage }}</p>
        <button class="btn w-100 mt-4"
                :class="modalType==='success'?'btn-success':'btn-danger'"
                @click="showModal=false">
          Tutup
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.overlay-blur{
  position: fixed; inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  display:flex; align-items:center; justify-content:center;
  z-index: 9999;
}
.modal-card{
  width: 420px; background: #fff;
  border-radius: 14px; padding: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
</style>