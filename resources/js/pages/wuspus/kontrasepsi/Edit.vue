<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  row: Object,
})

const form = useForm({
  jns_kontrasepsi: props.row.jns_kontrasepsi,
  tgl_ganti: props.row.tgl_ganti,
  kontrasepsi_baru: props.row.kontrasepsi_baru,
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
  if(!form.jns_kontrasepsi || !form.tgl_ganti || !form.kontrasepsi_baru){
    openError('Jenis kontrasepsi, Tanggal ganti, dan Kontrasepsi baru wajib diisi')
    return
  }

  form.put(`/posyandu/wuspus-kb/${props.row.id_wkp}`,{
    preserveScroll:true,
    onSuccess:()=>{
      openSuccess('Data kontrasepsi berhasil diperbarui')
      setTimeout(()=>router.visit('/posyandu/wuspus-kb'),700)
    },
    onError:()=>openError('Gagal memperbarui data')
  })
}
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Edit Kontrasepsi WUS/PUS</h2>
        <Link href="/posyandu/wuspus-kb" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-lg-6 mb-3">
            <label>Jenis Kontrasepsi</label>
            <input class="form-control" v-model="form.jns_kontrasepsi">
          </div>

          <div class="col-lg-6 mb-3">
            <label>Tanggal Ganti</label>
            <input type="date" class="form-control" v-model="form.tgl_ganti">
          </div>

          <div class="col-lg-6 mb-3">
            <label>Kontrasepsi Baru</label>
            <input class="form-control" v-model="form.kontrasepsi_baru">
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
      <div class="modal-card" :class="modalType==='success'?'border border-success':'border border-danger'">
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
  position:fixed; inset:0;
  background:rgba(0,0,0,.35);
  backdrop-filter:blur(6px);
  -webkit-backdrop-filter:blur(6px);
  display:flex; align-items:center; justify-content:center;
  z-index:9999;
}
.modal-card{
  width:420px; background:#fff;
  border-radius:14px; padding:18px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}
</style>