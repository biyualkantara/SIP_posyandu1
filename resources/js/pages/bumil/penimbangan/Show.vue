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
        <h2>Detail Penimbangan Bumil</h2>
        <Link href="/posyandu/bumil-pnb" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="detail-card">
        <h4 class="mb-2">{{ row.nama_wuspus }}</h4>
        <div class="text-muted">{{ row.nama_posyandu }}</div>

        <hr>

        <p><b>Bulan Hamil:</b> {{ row.bln_hamil ?? '-' }}</p>
        <p><b>Tanggal PNB:</b> {{ row.tgl_pnb }}</p>
        <p><b>Berat:</b> {{ row.berat ?? '-' }}</p>
        <p><b>Hasil:</b> {{ row.hasil ?? '-' }}</p>

        <hr>

        <p class="mb-0"><b>Keterangan:</b><br> {{ row.ket ?? '-' }}</p>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.detail-card{border:1px solid #eaeaea;border-radius:10px;padding:18px;background:#fafafa}
</style>