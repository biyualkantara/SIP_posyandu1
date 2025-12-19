<script setup>
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'

import { Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object
})

const emptyRow = () => ({
  id_posyandu: null,
  bulan: "",
  pkk: "",
  plkb: "",
  medis: ""
})

const form = useForm({
  kecamatan_id: null,
  kelurahan_id: null,
  rows: [emptyRow()]
})

const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

function addRow() {
  form.rows.push(emptyRow())
}

function deleteRow(i) {
  if (form.rows.length > 1) form.rows.splice(i, 1)
}

function openError(msg) {
  modalType.value = 'error'
  modalMessage.value = msg
  showModal.value = true
}
function openSuccess(msg) {
  modalType.value = 'success'
  modalMessage.value = msg
  showModal.value = true
}

function submit() {
  if (!form.kelurahan_id) {
    openError('Kelurahan wajib dipilih')
    return
  }

  try {
    form.rows = form.rows.map((row, index) => {
      const invalid =
        !row.id_posyandu ||
        !row.bulan ||
        row.pkk === "" ||
        row.plkb === "" ||
        row.medis === ""

      if (invalid) {
        openError(`Data ke-${index + 1} masih ada kolom kosong`)
        throw new Error('invalid')
      }

      return { ...row }
    })
  } catch {
    return
  }

  form.post('/posyandu/kehadiran-kader/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data kehadiran kader berhasil disimpan')
      setTimeout(() => {
        router.visit('/posyandu/kehadiran-kader')
      }, 700)
    },
    onError: () => {
      openError('Gagal menyimpan data')
    }
  })
}
</script>

<template>
<AdminLayout>
<div class="bg-white p-4 main-container">
  <div class="header-flex mb-3">
    <h2>Tambah Data Kehadiran Kader</h2>
    <Link href="/posyandu/kehadiran-kader" class="btn btn-secondary">← Kembali</Link>
  </div>

  <hr>

  <form @submit.prevent="submit">

    <!-- Kecamatan -->
    <div class="row">
      <div class="col-lg-6">
        <div class="form-group" :class="{'has-error': form.errors.kecamatan_id}">
          <label for="kecamatan">Kecamatan</label>
          <VueSelect
            v-model="form.kecamatan_id"
            :options="kecamatan.map(item => ({ label: item.nama_kec, value: item.id_kec }))"
            placeholder="Pilih Kecamatan"
          />
          <span class="help-block" v-if="form.errors.kecamatan_id">Kecamatan wajib diisi</span>
        </div>
      </div>
    </div>

    <!-- Kelurahan -->
    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="form-group" :class="{'has-error': form.errors.kelurahan_id}">
          <label for="kelurahan">Kelurahan</label>
          <VueSelect
            v-model="form.kelurahan_id"
            placeholder="Pilih Kelurahan"
            :options="kelurahan[form.kecamatan_id]?.map(item => ({ label: item.nama_kel, value: item.id_kel })) || []"
            :isDisabled="!form.kecamatan_id"
          />
          <span class="help-block" v-if="form.errors.kelurahan_id">Kelurahan wajib diisi</span>
        </div>
      </div>
    </div>

    <Table class="mt-4">
      <TableHead>
        <TableRow>
          <TableCol asHead>Form Kehadiran Kader</TableCol>
          <TableCol asHead width="120">Aksi</TableCol>
        </TableRow>
      </TableHead>

      <tbody>
        <TableRow v-for="(row,i) in form.rows" :key="i">
          <TableCol>
            <h4>Data ke-{{ i+1 }}</h4>

            <div class="row">
              <div class="col-lg-6 mb-3">
                <label>Posyandu</label>
                <VueSelect
                  v-model="row.id_posyandu"
                  placeholder="Pilih Posyandu"
                  :options="props.posyandu?.[form.kelurahan_id]?.map(p => ({ label: p.nama_posyandu, value: p.id_posyandu })) || []"
                  :isDisabled="!form.kelurahan_id"
                />
              </div>

              <div class="col-lg-6 mb-3">
                <label>Bulan</label>
                <input type="month" class="form-control" v-model="row.bulan">
              </div>

              <div class="col-lg-2 mb-3">
                <label>PKK</label>
                <input type="number" class="form-control" v-model="row.pkk">
              </div>

              <div class="col-lg-2 mb-3">
                <label>PLKB</label>
                <input type="number" class="form-control" v-model="row.plkb">
              </div>

              <div class="col-lg-2 mb-3">
                <label>Medis</label>
                <input type="number" class="form-control" v-model="row.medis">
              </div>
            </div>
          </TableCol>

          <TableCol class="text-center">
            <span class="bg-primary p-3 d-inline-flex justify-content-center"
                  style="border-radius:1000px;cursor:pointer"
                  @click="deleteRow(i)">
              <i class="icon-trash"></i>
            </span>
          </TableCol>
        </TableRow>
      </tbody>
    </Table>

    <button type="button" class="btn btn-success mt-4" @click="addRow">Tambah Data +</button>
    <button type="submit" class="btn btn-primary mt-4 ms-3" style="margin-left: 1050px;">Simpan Data</button>

  </form>

</div>

<!-- MODAL -->
<div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
  <div class="modal-card"
       :class="modalType === 'success' ? 'border border-success' : 'border border-danger'">
    <h3 class="text-xl font-semibold mb-3">
      {{ modalType === 'success' ? 'Berhasil' : 'Gagal' }}
    </h3>
    <p>{{ modalMessage }}</p>
    <button class="btn w-100 mt-4" :class="modalType === 'success' ? 'btn-success' : 'btn-danger'"
            @click="showModal=false">
      Tutup
    </button>
  </div>
</div>

</AdminLayout>
</template>

<style scoped>
.overlay-blur{
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  display:flex;
  align-items:center;
  justify-content:center;
  z-index: 9999;
}
.modal-card{
  width: 420px;
  background: #fff;
  border-radius: 14px;
  padding: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>