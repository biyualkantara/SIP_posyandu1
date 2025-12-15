<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: ''
})
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Edit Profil</h2>
        <Link href="/profile" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr />

      <form @submit.prevent="form.put('/profile')">
        <div class="mb-3">
          <label>Nama</label>
          <input class="form-control" v-model="form.name" />
          <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
        </div>

        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" v-model="form.email" />
          <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
        </div>

        <hr />

        <div class="mb-3">
          <label>Password Baru (Opsional)</label>
          <input type="password" class="form-control" v-model="form.password" />
        </div>

        <div class="mb-3">
          <label>Konfirmasi Password</label>
          <input type="password" class="form-control" v-model="form.password_confirmation" />
          <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
        </div>

        <div class="text-center mt-4">
          <button class="btn btn-primary px-5">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<style>
.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>
