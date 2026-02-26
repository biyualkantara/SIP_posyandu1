<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  row: Object
})

const form = useForm({
  ket: props.row.ket ?? '',
  restore: false
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
  form.put(`/posyandu/wuspus-kematian/${props.row.id_wuspus}`, {
    preserveScroll: true,
    data: { ket: form.ket, restore: form.restore },
    onSuccess: () => {
      openSuccess('Data kematian WUS/PUS berhasil diperbarui')
      router.reload({ only: ['data'] }) // reload Index.vue
    },
    onError: () => openError('Gagal memperbarui data')
  })
}
</script>

<template>
<div class="bg-white p-4 main-container">
  <div class="header-flex mb-3">
    <h2>Edit Kematian WUS/PUS</h2>
    <Link href="/posyandu/wuspus-kematian" class="btn btn-secondary">← Kembali</Link>
  </div>

  <hr>

  <form @submit.prevent="submit">
    <div class="row">
      <div class="col-lg-4 mb-3">
        <label>NIK</label>
        <input class="form-control" :value="props.row.nik_wuspus" disabled>
      </div>

      <div class="col-lg-4 mb-3">
        <label>Nama</label>
        <input class="form-control" :value="props.row.nama_wuspus" disabled>
      </div>

      <div class="col-lg-4 mb-3">
        <label>Status Saat Ini</label>
        <input class="form-control text-danger fw-bold" :value="form.restore ? 'Aktif' : 'Meninggal'" disabled>
      </div>

      <div class="col-lg-12 mb-3">
        <label>Keterangan</label>
        <textarea class="form-control" rows="3" v-model="form.ket"></textarea>
      </div>

      <div class="col-lg-12 mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="restore" v-model="form.restore">
          <label class="form-check-label text-warning fw-bold" for="restore">
            Pulihkan status WUS/PUS menjadi AKTIF (jika salah input)
          </label>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
  </form>

  <!-- MODAL -->
  <div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
    <div class="modal-card" :class="modalType==='success'?'border border-success':'border border-danger'">
      <h3>{{ modalType==='success'?'Berhasil':'Gagal' }}</h3>
      <p>{{ modalMessage }}</p>
      <button class="btn w-100 mt-3" :class="modalType==='success'?'btn-success':'btn-danger'" @click="showModal=false">Tutup</button>
    </div>
  </div>
</div>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.overlay-blur{
  position:fixed; inset:0; background:rgba(0,0,0,.35);
  backdrop-filter:blur(6px); display:flex; align-items:center; justify-content:center;
  z-index:9999;
}
.modal-card{
  width:420px; background:#fff; border-radius:14px; padding:18px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}
</style>