<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
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

      <hr />

      <div class="detail-card">
        <p><b>Nama:</b> {{ row.name }}</p>
        <p><b>Email:</b> {{ row.email }}</p>
        <p><b>Status:</b> {{ row.status }}</p>
        <p><b>Dibuat:</b> {{ row.created_at }}</p>
      </div>
    </div>
  </AdminLayout>
</template>