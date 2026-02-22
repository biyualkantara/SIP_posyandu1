<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  row: Object,
  posyandu: Array
})

const form = useForm({
  nama: props.row.nama,
  username: props.row.username,
  role: props.row.role,
  id_posyandu: props.row.id_posyandu,
  email: props.row.email,
  no_hp: props.row.no_hp
})

function submit() {
  form.put(`/operator/${props.row.id_operator}`, {
    onSuccess: () => router.visit('/operator')
  })
}
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Edit Operator</h2>
      <Link href="/operator" class="btn btn-secondary">← Kembali</Link>
    </div>

    <form @submit.prevent="submit">
      <input class="form-control mb-3" v-model="form.nama">
      <input class="form-control mb-3" v-model="form.username">

      <select class="form-control mb-3" v-model="form.role">
        <option value="superadmin">Super Admin</option>
        <option value="admin">Admin</option>
        <option value="kader">Kader</option>
      </select>

      <select class="form-control mb-3" v-model="form.id_posyandu">
        <option value="">-- Posyandu --</option>
        <option v-for="p in posyandu" :key="p.id_posyandu" :value="p.id_posyandu">
          {{ p.nama_posyandu }}
        </option>
      </select>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</AdminLayout>
</template>