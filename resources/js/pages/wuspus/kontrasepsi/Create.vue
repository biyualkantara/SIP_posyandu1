<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  wuspus: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object
})

const selectedKec = ref('')
const selectedKel = ref('')
const selectedPos = ref('')

const kecamatanOptions = computed(() => 
  (props.kecamatan || []).map(k => ({
    label: k.nama_kec,
    value: k.id_kec
  }))
)

const kelurahanOptions = computed(() => {
  if (!selectedKec.value) return []
  return (props.kelurahan[selectedKec.value] || []).map(k => ({
    label: k.nama_kel,
    value: k.id_kel
  }))
})

const posyanduOptions = computed(() => {
  if (!selectedKel.value) return []
  return (props.posyandu[selectedKel.value] || []).map(p => ({
    label: p.nama_posyandu,
    value: p.id_posyandu
  }))
})

const wuspusOptions = computed(() => {
  if (!selectedPos.value) return []
  const wuspusList = props.wuspus[selectedPos.value] || []
  return wuspusList.map(w => ({
    label: `${w.nik_wuspus || ''} - ${w.nama_wuspus || ''}`,
    value: w.id_wuspus
  }))
})

watch(selectedKec, () => {
  selectedKel.value = ''
  selectedPos.value = ''
})

watch(selectedKel, () => {
  selectedPos.value = ''
})

const emptyRow = () => ({
  id_wuspus: null,
  jns_kontrasepsi: '',
  tgl_ganti: '',
  kontrasepsi_baru: '',
  ket: ''
})

const form = useForm({
  kelurahan_id: '',
  posyandu_id: '',
  rows: [emptyRow()]
})

watch(selectedPos, (val) => form.posyandu_id = val)
watch(selectedKel, (val) => form.kelurahan_id = val)

const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

const openModal = (type, msg) => {
  modalType.value = type
  modalMessage.value = msg
  showModal.value = true
}

const addRow = () => form.rows.push(emptyRow())
const deleteRow = (i) => {
  if (form.rows.length > 1) form.rows.splice(i, 1)
}

const validateForm = () => {
  if (!selectedKec.value) return openModal('error','Silakan pilih kecamatan'), false
  if (!selectedKel.value) return openModal('error','Silakan pilih kelurahan'), false
  if (!selectedPos.value) return openModal('error','Silakan pilih posyandu'), false

  for (let i = 0; i < form.rows.length; i++) {
    const r = form.rows[i]
    if (!r.id_wuspus || !r.jns_kontrasepsi || !r.tgl_ganti || !r.kontrasepsi_baru) {
      openModal('error', `Data ke-${i+1}: Semua field wajib diisi`)
      return false
    }
  }
  return true
}

const submit = () => {
  if (!validateForm()) return

  form.post('/posyandu/wuspus-kontrasepsi/store-multiple', {
    preserveScroll: true,
    onSuccess: () => {
      openModal('success','Data berhasil disimpan')
      setTimeout(() => router.visit('/posyandu/wuspus-kontrasepsi'), 1500)
    },
    onError: () => openModal('error','Gagal menyimpan data')
  })
}
</script>

<template>
<div class="page-wrapper">

  <!-- Breadcrumb -->
  <div class="breadcrumb">
    <Link href="/dashboard">Dashboard</Link>
    <span>/</span>
    <Link href="/wuspus-kontrasepsi">Kontrasepsi WUS/PUS</Link>
    <span>/</span>
    <span>Tambah Data</span>
  </div>

  <!-- Header -->
  <div class="page-header">
    <div>
      <h2>Tambah Kontrasepsi WUS/PUS</h2>
      <p>Input multi data peserta</p>
    </div>
    <Link href="/posyandu/wuspus-kontrasepsi" class="btn btn-outline-secondary">
      Kembali
    </Link>
  </div>

  <!-- Card -->
  <div class="main-card">
    <div class="card-body">

      <!-- Filter -->
      <div class="filter-section">
        <h6>Pilih Wilayah</h6>
        <div class="grid-3">
          <div>
            <label>Kecamatan</label>
            <VueSelect v-model="selectedKec" :options="kecamatanOptions"/>
          </div>
          <div>
            <label>Kelurahan</label>
            <VueSelect v-model="selectedKel" :options="kelurahanOptions" :disabled="!selectedKec"/>
          </div>
          <div>
            <label>Posyandu</label>
            <VueSelect v-model="selectedPos" :options="posyanduOptions" :disabled="!selectedKel"/>
          </div>
        </div>
      </div>

      <div v-if="!selectedPos" class="info-alert">
        Pilih posyandu untuk menampilkan data WUS/PUS
      </div>

      <!-- Form -->
      <form @submit.prevent="submit">

        <div class="form-header">
          <h6>Form Data</h6>
          <span class="count-badge">{{ form.rows.length }} Data</span>
        </div>

        <div v-for="(row,index) in form.rows" :key="index" class="data-card">
          <div class="data-header">
            <span class="data-badge">Data #{{ index + 1 }}</span>
            <button type="button" class="btn btn-outline-danger btn-sm" @click="deleteRow(index)">
              Hapus
            </button>
          </div>

          <div class="grid-2">
            <div>
              <label>WUS/PUS</label>
              <VueSelect v-model="row.id_wuspus" :options="wuspusOptions"/>
            </div>
            <div>
              <label>Jenis Kontrasepsi</label>
              <select v-model="row.jns_kontrasepsi" class="form-control">
                <option value="">Pilih</option>
                <option>PIL</option>
                <option>SUNTIK</option>
                <option>IUD</option>
                <option>IMPLAN</option>
                <option>MOW</option>
                <option>MOP</option>
                <option>KONDOM</option>
              </select>
            </div>
          </div>

          <div class="grid-2">
            <div>
              <label>Tanggal Ganti</label>
              <input type="date" v-model="row.tgl_ganti" class="form-control"/>
            </div>
            <div>
              <label>Kontrasepsi Baru</label>
              <input v-model="row.kontrasepsi_baru" class="form-control"/>
            </div>
          </div>

          <div>
            <label>Keterangan</label>
            <textarea v-model="row.ket" class="form-control"></textarea>
          </div>
        </div>

        <div class="form-footer">
          <button type="button" class="btn btn-outline-success" @click="addRow">
            Tambah Data
          </button>
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            Simpan Data
          </button>
        </div>

      </form>

    </div>
  </div>

</div>
</template>

<style scoped>
.page-wrapper {
  max-width: 1100px;
  margin: auto;
  padding: 24px 16px 40px;
}

.breadcrumb {
  display:flex;
  gap:8px;
  color:#6b7280;
  margin-bottom:20px;
}

.page-header {
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.main-card {
  border-radius:16px;
  box-shadow:0 10px 30px rgba(0,0,0,0.06);
  background:white;
}

.card-body {
  padding:32px;
}

.filter-section {
  background:#f8fafc;
  border-radius:12px;
  padding:24px;
  margin-bottom:20px;
}

.grid-3 {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:16px;
}

.grid-2 {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:16px;
  margin-top:16px;
}

.data-card {
  border:1px solid #eef1f4;
  border-radius:14px;
  padding:20px;
  margin-top:16px;
}

.data-header {
  display:flex;
  justify-content:space-between;
  margin-bottom:12px;
}

.data-badge {
  background:#eef4ff;
  color:#2f6fed;
  padding:4px 10px;
  border-radius:8px;
  font-size:13px;
  font-weight:600;
}

.form-control {
  height:44px;
  border-radius:10px;
  border:1px solid #e5e7eb;
  width:100%;
  padding:0 10px;
}

textarea.form-control {
  height:auto;
  padding:10px;
}

.form-footer {
  display:flex;
  justify-content:space-between;
  margin-top:24px;
  padding-top:20px;
  border-top:1px solid #f0f2f5;
}

.info-alert {
  background:#fff8e6;
  border:1px solid #ffe7a3;
  padding:12px 16px;
  border-radius:10px;
  margin-bottom:20px;
}

.count-badge {
  background:#eef1f4;
  padding:4px 10px;
  border-radius:8px;
  font-size:13px;
}

@media(max-width:768px){
  .grid-3 { grid-template-columns:1fr }
  .grid-2 { grid-template-columns:1fr }
  .form-footer { flex-direction:column; gap:12px }
}
</style>