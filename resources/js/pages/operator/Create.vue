<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  status: 'aktif'
})
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Tambah Operator</h2>
        <Link href="/operator" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr />

      <form @submit.prevent="form.post('/operator')">
        <div class="mb-3">
          <label>Nama</label>
          <input class="form-control" v-model="form.name" />
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" v-model="form.email" />
        </div>

        <div class="mb-3">
          <label>Password</label>
          <input type="password" class="form-control" v-model="form.password" />
        </div>

        <div class="mb-3">
          <label>Status</label>
          <select class="form-control" v-model="form.status">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>

        <div class="text-center">
          <button class="btn btn-primary px-5">Simpan</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>