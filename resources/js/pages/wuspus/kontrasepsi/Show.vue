<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  row: Object
})
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Detail Kontrasepsi WUS/PUS</h2>
        <Link href="/posyandu/wuspus-kontrasepsi" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="row">
        <div class="col-lg-6 mb-3">
          <label>ID</label>
          <input class="form-control" :value="row.id_wkp" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>ID WUS/PUS</label>
          <input class="form-control" :value="row.id_wuspus" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Jenis Kontrasepsi</label>
          <input class="form-control" :value="row.jns_kontrasepsi" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Tanggal Ganti</label>
          <input class="form-control" :value="row.tgl_ganti" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Kontrasepsi Baru</label>
          <input class="form-control" :value="row.kontrasepsi_baru" disabled>
        </div>

        <div class="col-lg-12 mb-3">
          <label>Keterangan</label>
          <textarea class="form-control" rows="3" :value="row.ket" disabled></textarea>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
</style>