<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
  posyandu: Array,
  kecamatan: Array,
  kelurahan: Array
})

const form = useForm({
  nama: '',
  username: '',
  password: '',
  role: '',
  id_posyandu: null,
  email: '',
  no_hp: '',
  alamat: '',
  kcmtn: null,
  klrhn: null
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
          <label>Email</label>
          <input class="form-control" v-model="form.email">
        </div>
        
        <div class="col-lg-6 mb-3">
          <label>Username</label>
          <input class="form-control" v-model="form.username">
        </div>
        
        <div class="col-lg-6 mb-3">
          <label>Posyandu</label>
          <select class="form-control" v-model="form.id_posyandu">
            <option :value="null">-- Opsional --</option>
            <option v-for="p in posyandu" :key="p.id_posyandu" :value="p.id_posyandu">
              {{ p.nama_posyandu }}
            </option>
          </select>
        </div>
        
        <div class="col-lg-6 mb-3">
          <label>Password</label>
          <input type="password" class="form-control" v-model="form.password">
        </div>
        
        <div class="col-lg-6 mb-3">
          <label>Kecamatan</label>
          <select class="form-control" v-model="form.kcmtn">
            <option :value="null">-- Pilih Kecamatan --</option>
            <option
              v-for="k in kecamatan"
              :key="k.id_kec"
              :value="k.id_kec"
            >
              {{ k.nama_kec }}
            </option>
          </select>
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
          <label>Kelurahan</label>
          <select class="form-control" v-model="form.klrhn">
            <option :value="null">-- Pilih Kelurahan --</option>
            <option
              v-for="l in kelurahan.filter(x => x.id_kec === form.kcmtn)"
              :key="l.id_kel"
              :value="l.id_kel"
            >
              {{ l.nama_kel }}
            </option>
          </select>
        </div>
        
        <div class="col-lg-6 mb-3">
          <label>No HP</label>
          <input class="form-control" v-model="form.no_hp">
        </div>

        <div class="col-lg-6 mb-3">
          <label>Alamat</label>
          <textarea class="form-control" v-model="form.alamat"></textarea>
        </div>
      </div>

      <button class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</AdminLayout>
</template>