<script setup>
import { Link, useForm, router } from "@inertiajs/vue3"
import { ref, computed, watch } from "vue"
import VueSelect from "vue3-select-component"

const props = defineProps({
  row: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  wuspus: Object
})

const form = useForm({
  id_wuspus: props.row?.id_wuspus ?? null,
  tgl_daftar: props.row?.tgl_daftar ?? '',
  nama_bayi: props.row?.nama_bayi ?? '',
  jk: props.row?.jk ?? '',
  tgl_lhr: props.row?.tgl_lhr ?? '',
  bb: props.row?.bb ?? '',
  ket: props.row?.ket ?? '',

  id_kec: props.row?.id_kec ?? null,
  id_kel: props.row?.id_kel ?? null,
  id_posyandu: props.row?.id_posyandu ?? null,
})

const selectedKec = ref(props.row?.id_kec ? String(props.row.id_kec) : '')
const selectedKel = ref(props.row?.id_kel ? String(props.row.id_kel) : '')
const selectedPos = ref(props.row?.id_posyandu ? String(props.row.id_posyandu) : '')

const kecamatanOptions = computed(() =>
  (props.kecamatan ?? []).map(k => ({ label: k.nama_kec, value: String(k.id_kec) }))
)

const kelurahanOptions = computed(() => {
  const key = String(selectedKec.value || '')
  const arr = props.kelurahan?.[key]
  if (!Array.isArray(arr)) return []
  return arr.map(k => ({ label: k.nama_kel, value: String(k.id_kel) }))
})

const posyanduOptions = computed(() => {
  const key = String(selectedKel.value || '')
  const arr = props.posyandu?.[key]
  if (!Array.isArray(arr)) return []
  return arr.map(p => ({ label: p.nama_posyandu, value: String(p.id_posyandu) }))
})

const wuspusOptions = computed(() => {
  const key = String(selectedPos.value || '')
  const arr = props.wuspus?.[key]
  if (!Array.isArray(arr)) return []
  return arr.map(w => ({ label: `${w.nik_wuspus} - ${w.nama_wuspus}`, value: String(w.id_wuspus) }))
})

watch(selectedKec, () => {
  selectedKel.value = ''
  selectedPos.value = ''
  form.id_wuspus = null
})

watch(selectedKel, () => {
  selectedPos.value = ''
  form.id_wuspus = null
})

watch(selectedPos, () => {
  form.id_wuspus = null
})

watch(selectedKec, (v) => { form.id_kec = v ? Number(v) : null })
watch(selectedKel, (v) => { form.id_kel = v ? Number(v) : null })
watch(selectedPos, (v) => { form.id_posyandu = v ? Number(v) : null })

function submit() {
  form.put(`/posyandu/bayi/${props.row.id_bayi}`, {
    preserveScroll: true,
    onSuccess: () => router.visit('/posyandu/bayi')
  })
}
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Edit Data Bayi</h2>
      <Link href="/posyandu/bayi" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-6 mb-3">
          <label>Tanggal Daftar</label>
          <input type="date" class="form-control" v-model="form.tgl_daftar">
          <div v-if="form.errors.tgl_daftar" class="text-danger mt-1">{{ form.errors.tgl_daftar }}</div>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Nama Bayi</label>
          <input class="form-control" v-model="form.nama_bayi" placeholder="Nama bayi">
          <div v-if="form.errors.nama_bayi" class="text-danger mt-1">{{ form.errors.nama_bayi }}</div>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Jenis Kelamin</label>
          <select class="form-control" v-model="form.jk">
            <option value="">-- Pilih --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
          <div v-if="form.errors.jk" class="text-danger mt-1">{{ form.errors.jk }}</div>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Tanggal Lahir</label>
          <input type="date" class="form-control" v-model="form.tgl_lhr">
          <div v-if="form.errors.tgl_lhr" class="text-danger mt-1">{{ form.errors.tgl_lhr }}</div>
        </div>

        <div class="col-lg-6 mb-3">
          <label>Berat Badan (BB)</label>
          <input type="number" step="0.01" class="form-control" v-model="form.bb" placeholder="BB">
          <div v-if="form.errors.bb" class="text-danger mt-1">{{ form.errors.bb }}</div>
        </div>

        <div class="col-lg-12 mb-3">
          <label>Keterangan</label>
          <textarea class="form-control" rows="3" v-model="form.ket"></textarea>
          <div v-if="form.errors.ket" class="text-danger mt-1">{{ form.errors.ket }}</div>
        </div>
      </div>

      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary px-5 py-2" :disabled="form.processing">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</AdminLayout>
</template>

<style scoped>
.main-container { min-height: 100vh }
.header-flex { display:flex;justify-content:space-between;align-items:center }
</style>