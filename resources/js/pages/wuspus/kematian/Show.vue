<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  row: Object // data wuspus (status = Meninggal)
})
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Detail Kematian WUS/PUS</h2>
        <Link href="/posyandu/wuspus-kematian" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="row">
        <div class="col-lg-4 mb-3">
          <label>ID WUS/PUS</label>
          <input class="form-control" :value="row.id_wuspus" disabled>
        </div>

        <div class="col-lg-4 mb-3">
          <label>NIK</label>
          <input class="form-control" :value="row.nik_wuspus" disabled>
        </div>

        <div class="col-lg-4 mb-3">
          <label>Nama</label>
          <input class="form-control" :value="row.nama_wuspus" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Posyandu</label>
          <input class="form-control" :value="row.nama_posyandu" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Kelurahan</label>
          <input class="form-control" :value="row.nama_kel" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Kecamatan</label>
          <input class="form-control" :value="row.nama_kec" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Status</label>
          <input class="form-control text-danger fw-bold" value="MENINGGAL" disabled>
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