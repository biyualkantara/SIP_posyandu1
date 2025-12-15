<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  row: Object
});
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Detail BUMIL</h2>
      <Link href="/posyandu/bumil" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <div class="detail-card">
      <h4>{{ row.nama_wuspus }}</h4>
      <p><b>NIK:</b> {{ row.nik_wuspus }}</p>

      <hr>

      <p><b>Posyandu:</b> {{ row.nama_posyandu || '-' }}</p>
      <p><b>Kelurahan:</b> {{ row.nama_kel || '-' }}</p>
      <p><b>Kecamatan:</b> {{ row.nama_kec || '-' }}</p>

      <hr>

      <p><b>Tanggal Daftar:</b> {{ row.tgl_daftar || '-' }}</p>
      <p><b>Umur Kehamilan:</b> {{ row.umur_kehamilan ?? '-' }}</p>
      <p><b>Hamil Ke:</b> {{ row.hamil_ke ?? '-' }}</p>
      <p><b>PMT Pemulihan:</b> {{ row.pmt_pemulihan || '-' }}</p>
      <p><b>LILA:</b> {{ row.lila ?? '-' }}</p>

      <hr>

      <p><b>Keterangan:</b> {{ row.ket || '-' }}</p>
    </div>
  </div>
</AdminLayout>
</template>

<style scoped>
.detail-card {
  border: 1px solid #eaeaea;
  border-radius: 8px;
  padding: 20px;
  background: #fafafa;
}
.header-flex { display:flex;justify-content:space-between;align-items:center }
.main-container { min-height: 100vh; }
</style>