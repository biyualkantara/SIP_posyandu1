<script setup>
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'

import { Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import VueSelect from 'vue3-select-component'

const props = defineProps({
  row: Object,
  wuspus: Array,
  imun: Array
})

const form = useForm({
  id_wuspus: props.row.id_wuspus,
  id_imun: props.row.id_imun,
  tgl_imun: props.row.tgl_imun,
  ket: props.row.ket
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

function submit(){
  if(!form.id_wuspus || !form.id_imun || !form.tgl_imun){
    openError('WUS/PUS, Imunisasi, dan Tanggal wajib diisi')
    return
  }

  form.put(`/posyandu/wuspus-imun/${props.row.id_wuspus_imun}`,{
    preserveScroll:true,
    onSuccess:()=>{
      openSuccess('Data imunisasi WUS/PUS berhasil diperbarui')
      setTimeout(()=>router.visit('/posyandu/wuspus-imun'),700)
    },
    onError:()=>openError('Gagal memperbarui data')
  })
}
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Edit Imunisasi WUS/PUS</h2>
        <Link href="/posyandu/wuspus-imun" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-lg-6 mb-3">
            <label>WUS/PUS</label>
            <VueSelect
              v-model="form.id_wuspus"
              :options="(wuspus||[]).map(w=>({
                label: `${w.nik_wuspus} - ${w.nama_wuspus}`,
                value: w.id_wuspus
              }))"
              placeholder="Pilih WUS/PUS"
            />
          </div>

          <div class="col-lg-6 mb-3">
            <label>Jenis Imunisasi</label>
            <VueSelect
              v-model="form.id_imun"
              :options="(imun||[]).map(i=>({
                label: i.jns_imun,
                value: i.id_imun
              }))"
              placeholder="Pilih Imunisasi"
            />
          </div>

          <div class="col-lg-4 mb-3">
            <label>Tanggal Imunisasi</label>
            <input type="date" class="form-control" v-model="form.tgl_imun">
          </div>

          <div class="col-lg-12 mb-3">
            <label>Keterangan</label>
            <textarea class="form-control" rows="3" v-model="form.ket"></textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
      </form>
    </div>

    <!-- MODAL -->
    <div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
      <div class="modal-card"
           :class="modalType==='success'?'border border-success':'border border-danger'">
        <h3>{{ modalType==='success'?'Berhasil':'Gagal' }}</h3>
        <p>{{ modalMessage }}</p>
        <button class="btn w-100 mt-3"
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
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.35);
  backdrop-filter:blur(6px);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index:9999;
}
.modal-card{
  width:420px;
  background:#fff;
  border-radius:14px;
  padding:18px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}
</style>