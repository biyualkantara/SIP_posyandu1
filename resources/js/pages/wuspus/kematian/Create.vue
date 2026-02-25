<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'

import { Link, useForm, router } from '@inertiajs/vue3'
import VueSelect from 'vue3-select-component'

const props = defineProps({
  wuspus: Array
})

const form = useForm({
  id_wuspus: null,
  tgl_wafat: '',
  penyebab: '',
  ket: ''
})

function submit(){
  if(!form.id_wuspus) return alert('WUS/PUS wajib dipilih')
  if(!form.tgl_wafat) return alert('Tanggal wafat wajib diisi')

  form.post('/posyandu/wuspus-kematian', {
    preserveScroll:true,
    onSuccess:()=>router.visit('/posyandu/wuspus-kematian')
  })
}
</script>

<template>

    <div class="p-4 bg-white main-container">
      <div class="header-flex mb-3">
        <h2>Tambah Data Kematian WUS/PUS</h2>
        <Link href="/posyandu/wuspus-kematian" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <form @submit.prevent="submit">
        <div class="mb-3">
          <label>WUS/PUS</label>
          <VueSelect
            v-model="form.id_wuspus"
            :options="(wuspus||[]).map(w=>({label:`${w.nik_wuspus} - ${w.nama_wuspus}`,value:w.id_wuspus}))"
            placeholder="Pilih WUS/PUS"
          />
        </div>

        <div class="mb-3">
          <label>Tanggal Wafat</label>
          <input type="date" class="form-control" v-model="form.tgl_wafat">
        </div>

        <div class="mb-3">
          <label>Penyebab</label>
          <input class="form-control" v-model="form.penyebab" placeholder="Contoh: Sakit">
        </div>

        <div class="mb-3">
          <label>Keterangan</label>
          <textarea class="form-control" v-model="form.ket" rows="2"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <Link href="/posyandu/wuspus-kematian" class="btn btn-secondary ms-2">Batal</Link>
      </form>
    </div>

</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
</style>