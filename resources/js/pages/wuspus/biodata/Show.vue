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
        <h2>Detail WUS/PUS</h2>
        <Link href="/posyandu/wuspus" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="row">
        <div class="col-lg-6 mb-3">
          <label>NIK - Nama</label>
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

        <div class="col-lg-3 mb-3">
          <label>Umur</label>
          <input class="form-control" :value="row.umur" disabled>
        </div>

        <div class="col-lg-3 mb-3">
          <label>Tinggi Ibu</label>
          <input class="form-control" :value="row.tinggi_ibu" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Nama Suami</label>
          <input class="form-control" :value="row.nama_suami" disabled>
        </div>

        <div class="col-lg-3 mb-3">
          <label>Tinggi Ayah</label>
          <input class="form-control" :value="row.tinggi_ayah" disabled>
        </div>

        <div class="col-lg-3 mb-3">
          <label>Tahapan KS</label>
          <input class="form-control" :value="row.thpn_ks" disabled>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Kelompok Dasawisma</label>
          <input class="form-control" :value="row.klmpk_dasawisma" disabled>
        </div>

        <div class="col-lg-3 mb-3">
          <label>Anak Hidup</label>
          <input class="form-control" :value="row.jml_anak_hdp" disabled>
        </div>

        <div class="col-lg-3 mb-3">
          <label>Anak Meninggal</label>
          <input class="form-control" :value="row.jml_anak_meninggal" disabled>
        </div>

        <div class="col-lg-4 mb-3">
          <label>Tanggal Daftar</label>
          <input class="form-control" :value="row.tgl_daftar" disabled>
        </div>

        <div class="col-lg-4 mb-3">
          <label>Status</label>
          <input class="form-control" :value="row.status" disabled>
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