<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  posyandu: Array
})

const form = useForm({
  nama: '',
  username: '',
  password: '',
  role: '',
  id_posyandu: null,
  email: '',
  no_hp: ''
})

function submit() {
  form.post('/operator', {
    onSuccess: () => router.visit('/operator')
  })
}
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Tambah Operator</h2>
      <Link href="/operator" class="btn btn-secondary">← Kembali</Link>
    </div>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-6 mb-3">
          <label>Nama Operator</label>
          <input class="form-control" v-model="form.nama">
        </div>

        <div class="col-lg-6 mb-3">
          <label>Username</label>
          <input class="form-control" v-model="form.username">
        </div>

        <div class="col-lg-6 mb-3">
          <label>Password</label>
          <input type="password" class="form-control" v-model="form.password">
        </div>

        <div class="col-lg-6 mb-3">
          <label>Role</label>
          <select class="form-control" v-model="form.role">
            <option value="">-- Pilih --</option>
            <option value="superadmin">Super Admin</option>
            <option value="admin">Admin</option>
            <option value="kader">Kader</option>
          </select>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Posyandu</label>
          <select class="form-control" v-model="form.id_posyandu">
            <option value="">-- Opsional --</option>
            <option v-for="p in posyandu" :key="p.id_posyandu" :value="p.id_posyandu">
              {{ p.nama_posyandu }}
            </option>
          </select>
        </div>
      </div>

      <button class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</AdminLayout>
</template>