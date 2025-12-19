<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Profil Saya</h2>
      </div>

      <hr />

      <div class="detail-card">
        <p><b>Nama:</b> {{ user.name }}</p>
        <p><b>Email:</b> {{ user.email }}</p>
        <p><b>Role:</b> {{ user.role }}</p>
        <p><b>Status:</b> {{ user.status }}</p>
        <p><b>Dibuat:</b> {{ user.created_at }}</p>
      </div>
        <Link href="/profile/edit" class="btn btn-primary" style="margin-left: 1050px;">Edit Profil</Link>
    </div>
  </AdminLayout>
</template>