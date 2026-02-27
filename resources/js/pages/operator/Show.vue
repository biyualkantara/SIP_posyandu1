<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({ row: Object })
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Detail Operator</h2>
      <Link href="/operator" class="btn btn-secondary">← Kembali</Link>
    </div>

    <div class="detail-card">
      <p><b>Nama:</b> {{ row.nama }}</p>
      <p><b>Email:</b> {{ row.email }}</p>
      <p><b>Username:</b> {{ row.username }}</p>
      <p><b>Role:</b> {{ row.role }}</p>
      <p><b>Posyandu:</b> {{ row.nama_posyandu || '-' }}</p>
      <p><b>Kecamatan:</b> {{ row.nama_kec || '-' }}</p>
      <p><b>Kelurahan:</b> {{ row.nama_kel || '-' }}</p>
      <p><b>No HP:</b> {{ row.no_hp || '-' }}</p>
      <p><b>Alamat:</b> {{ row.alamat || '-' }}</p>
    </div>
  </div>
</AdminLayout>
</template>

<style scoped>
.detail-card{
  border:1px solid #eee;
  padding:20px;
  border-radius:8px
}
</style>