<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({ row: Object })

const form = useForm({
  name: props.row.name,
  email: props.row.email,
  password: '',
  status: props.row.status
})
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Edit Operator</h2>
        <Link href="/operator" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr />

      <form @submit.prevent="form.put(`/operator/${props.row.id}`)">
        <div class="mb-3">
          <label>Nama</label>
          <input class="form-control" v-model="form.name" />
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" v-model="form.email" />
        </div>

        <div class="mb-3">
          <label>Password (Opsional)</label>
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
          <button class="btn btn-primary px-5">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>