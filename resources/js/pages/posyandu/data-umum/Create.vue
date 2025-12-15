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
  kelurahan: Object
})

const STRATA_OPTIONS = [
  { label: 'Pratama', value: 'Pratama' },
  { label: 'Madya', value: 'Madya' },
  { label: 'Purnama', value: 'Purnama' },
  { label: 'Mandiri', value: 'Mandiri' },
]

const YESNO_OPTIONS = [
  { label: 'Ya', value: 1 },
  { label: 'Tidak', value: 0 },
]

const emptyRow = () => ({
  id_kel: null,
  nama_posyandu: "",
  strata_psy: "",
  alamat_posyandu: "",
  pj_umum: "",
  pj_operasional: "",
  ketuplak: "",
  sekretaris: "",
  int_paud: null,
  int_bkd: null,
  int_terpadu: null,
  kader_aktif: "",
  kader_taktif: "",
  ptgs_kb: "",
  ptgs_medis: "",
  ptgs_bidan: ""
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
        !row.nama_posyandu ||
        !row.strata_psy ||
        !row.alamat_posyandu ||
        !row.pj_umum ||
        !row.pj_operasional ||
        !row.ketuplak ||
        !row.sekretaris ||
        row.int_paud === null ||
        row.int_bkd === null ||
        row.int_terpadu === null ||
        row.kader_aktif === "" ||
        row.kader_taktif === "" ||
        !row.ptgs_kb ||
        !row.ptgs_medis ||
        !row.ptgs_bidan

      if (invalid) {
        openError(`Data ke-${index + 1} masih ada kolom kosong`)
        throw new Error('invalid')
      }

      return {
        ...row,
        id_kel: form.kelurahan_id
      }
    })
  } catch {
    return
  }

  form.post('/posyandu/data-umum/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openSuccess('Data posyandu berhasil disimpan')
      setTimeout(() => {
        router.visit('/posyandu/data-umum')
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
    <h2>Tambah Data Umum Posyandu</h2>
    <Link href="/posyandu/data-umum" class="btn btn-secondary">← Kembali</Link>
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
          <TableCol asHead>Form Data Posyandu</TableCol>
          <TableCol asHead width="120">Aksi</TableCol>
        </TableRow>
      </TableHead>

      <tbody>
        <TableRow v-for="(row,i) in form.rows" :key="i">
          <TableCol>
            <h4>Data ke-{{ i+1 }}</h4>

            <div class="row">
              <div class="col-lg-4 mb-3">
                <label>Nama Posyandu</label>
                <input class="form-control" v-model="row.nama_posyandu">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Strata</label>
                <VueSelect v-model="row.strata_psy" :options="STRATA_OPTIONS" />
              </div>

              <div class="col-lg-4 mb-3">
                <label>Alamat</label>
                <input class="form-control" v-model="row.alamat_posyandu">
              </div>

              <div class="col-lg-4 mb-3">
                <label>PJ Umum</label>
                <input class="form-control" v-model="row.pj_umum">
              </div>

              <div class="col-lg-4 mb-3">
                <label>PJ Operasional</label>
                <input class="form-control" v-model="row.pj_operasional">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Ketua Pelaksana</label>
                <input class="form-control" v-model="row.ketuplak">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Sekretaris</label>
                <input class="form-control" v-model="row.sekretaris">
              </div>

              <div class="col-lg-4 mb-3">
                <label>PAUD</label>
                <VueSelect v-model="row.int_paud" :options="YESNO_OPTIONS" />
              </div>

              <div class="col-lg-4 mb-3">
                <label>BKD</label>
                <VueSelect v-model="row.int_bkd" :options="YESNO_OPTIONS" />
              </div>

              <div class="col-lg-4 mb-3">
                <label>Terpadu</label>
                <VueSelect v-model="row.int_terpadu" :options="YESNO_OPTIONS" />
              </div>

              <div class="col-lg-4 mb-3">
                <label>Kader Aktif</label>
                <input type="number" class="form-control" v-model="row.kader_aktif">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Kader Tidak Aktif</label>
                <input type="number" class="form-control" v-model="row.kader_taktif">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Petugas KB</label>
                <input class="form-control" v-model="row.ptgs_kb">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Petugas Medis</label>
                <input class="form-control" v-model="row.ptgs_medis">
              </div>

              <div class="col-lg-4 mb-3">
                <label>Petugas Bidan</label>
                <input class="form-control" v-model="row.ptgs_bidan">
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