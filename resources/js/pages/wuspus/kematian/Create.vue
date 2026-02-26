<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import VueSelect from 'vue3-select-component'
import { ref } from 'vue'

const props = defineProps({ wuspus: Array })

// state khusus untuk tampilan select
const selectedWuspus = ref(null)

const form = useForm({
  id_wuspus: null,
  tgl_wafat: '',
  penyebab: '',
  ket: ''
})

// ============================
// Fungsi submit disini
// ============================
function submit(){
  if(!form.id_wuspus) return alert('WUS/PUS wajib dipilih')
  if(!form.tgl_wafat) return alert('Tanggal wafat wajib diisi')

  form.post('/posyandu/wuspus-kematian', {
    preserveScroll:true,
    onSuccess:()=> router.reload({ only: ['data'] })
  })
}
</script>

<template>
  <div class="p-4 bg-white main-container position-relative">

    <!-- tombol kanan atas -->
    <Link href="/posyandu/wuspus-kematian" class="btn btn-secondary back-btn">
      ← Kembali
    </Link>

    <h2 class="mb-3">Tambah Data Kematian WUS/PUS</h2>
    <hr>

    <form @submit.prevent="submit">

      <div class="mb-3">
        <label>WUS/PUS</label>
        <VueSelect
            v-model="form.id_wuspus"
            :options="(wuspus||[]).map(w=>({
              label:`${w.nik_wuspus} - ${w.nama_wuspus}`,
              value:w.id_wuspus
            }))"
            :reduce="option => option.value"
            placeholder="Pilih WUS/PUS"
          />
      </div>

      <div class="mb-3">
        <label>Tanggal Wafat</label>
        <input type="date" class="form-control" v-model="form.tgl_wafat">
      </div>

      <div class="mb-3">
        <label>Penyebab</label>
        <input class="form-control" v-model="form.penyebab">
      </div>

      <div class="mb-3">
        <label>Keterangan</label>
        <textarea class="form-control" v-model="form.ket"></textarea>
      </div>

      <button class="btn btn-primary">Simpan</button>

    </form>
  </div>
</template>

<style scoped>
.main-container{
  min-height:100vh;
}
.back-btn{
  position:absolute;
  top:16px;
  right:16px;
}
</style>