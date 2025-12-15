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
        <h2>Detail Imunisasi WUS/PUS</h2>
        <Link href="/posyandu/wuspus-imun" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="row">
        <div class="col-lg-6 mb-3">
          <label>Nama WUS/PUS</label>
          <input class="form-control" :value="row.nik_wuspus + ' - ' + row.nama_wuspus" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Posyandu</label>
          <input class="form-control" :value="row.nama_posyandu" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Kecamatan</label>
          <input class="form-control" :value="row.nama_kec" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Kelurahan</label>
          <input class="form-control" :value="row.nama_kel" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Jenis Imunisasi</label>
          <input class="form-control" :value="row.jns_imun" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Tanggal Imunisasi</label>
          <input class="form-control" :value="row.tgl_imun" disabled>
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