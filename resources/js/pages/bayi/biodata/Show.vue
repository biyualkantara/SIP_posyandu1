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
      <h2>Detail Bayi</h2>
      <Link href="/posyandu/bayi" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <div class="detail-card">
      <h4 class="mb-1">{{ row.nama_bayi }}</h4>
      <div class="text-muted">{{ row.jk === 'L' ? 'Laki-laki' : (row.jk === 'P' ? 'Perempuan' : '-') }}</div>

      <hr>

      <p><b>Ibu (WUS/PUS):</b> {{ row.nik_wuspus }} - {{ row.nama_wuspus }}</p>

      <hr>

      <p><b>Posyandu:</b> {{ row.nama_posyandu || '-' }}</p>
      <p><b>Kelurahan:</b> {{ row.nama_kel || '-' }}</p>
      <p><b>Kecamatan:</b> {{ row.nama_kec || '-' }}</p>

      <hr>

      <p><b>Tanggal Daftar:</b> {{ row.tgl_daftar || '-' }}</p>
      <p><b>Tanggal Lahir:</b> {{ row.tgl_lhr || '-' }}</p>
      <p><b>BB:</b> {{ row.bb ?? '-' }}</p>

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