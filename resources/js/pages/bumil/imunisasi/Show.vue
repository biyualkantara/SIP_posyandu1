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
        <h2>Detail Imunisasi Bumil</h2>
        <Link href="/posyandu/bumil-imun" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="detail-card">
        <h4 class="mb-2">{{ row.nama_wuspus }}</h4>
        <div class="text-muted">{{ row.nama_posyandu }}</div>

        <hr>

        <p><b>Jenis Imunisasi:</b> {{ row.jns_imun }}</p>
        <p><b>Tanggal Imunisasi:</b> {{ row.tgl_imun }}</p>

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