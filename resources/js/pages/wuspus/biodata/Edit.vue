<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import VueSelect from "vue3-select-component"

const props = defineProps({
  row: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  meta: Object
})

const form = useForm({
  kecamatan_id: props.meta?.id_kec ?? null,
  kelurahan_id: props.meta?.id_kel ?? null,
  id_posyandu: props.row.id_posyandu ?? null,

  nik_wuspus: props.row.nik_wuspus ?? '',
  nama_wuspus: props.row.nama_wuspus ?? '',
  umur: props.row.umur ?? '',
  tinggi_ibu: props.row.tinggi_ibu ?? '',
  nama_suami: props.row.nama_suami ?? '',
  tinggi_ayah: props.row.tinggi_ayah ?? '',
  thpn_ks: props.row.thpn_ks ?? '',
  klmpk_dasawisma: props.row.klmpk_dasawisma ?? '',
  jml_anak_hdp: props.row.jml_anak_hdp ?? '',
  jml_anak_meninggal: props.row.jml_anak_meninggal ?? '',
  tgl_daftar: props.row.tgl_daftar ?? '',
  status: props.row.status ?? '',
  ket: props.row.ket ?? '',
})

const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

function openError(msg){
  modalType.value='error'
  modalMessage.value=msg
  showModal.value=true
}
function openSuccess(msg){
  modalType.value='success'
  modalMessage.value=msg
  showModal.value=true
}

const kelurahanOptions = computed(() => {
  if(!form.kecamatan_id) return []
  return props.kelurahan?.[form.kecamatan_id] ?? []
})
const posyanduOptions = computed(() => {
  if(!form.kelurahan_id) return []
  return props.posyandu?.[form.kelurahan_id] ?? []
})

watch(() => form.kecamatan_id, () => {
  form.kelurahan_id = null
  form.id_posyandu = null
})
watch(() => form.kelurahan_id, () => {
  form.id_posyandu = null
})

function submit(){
  if(!form.id_posyandu) return openError('Posyandu wajib dipilih')
  if(!form.nik_wuspus || !form.nama_wuspus) return openError('NIK & Nama wajib diisi')

  form.put(`/posyandu/wuspus/${props.row.id_wuspus}`,{
    preserveScroll:true,
    onSuccess:()=>{
      openSuccess('Data biodata WUS/PUS berhasil diperbarui')
      setTimeout(()=>router.visit('/posyandu/wuspus'),700)
    },
    onError:()=>openError('Gagal memperbarui data')
  })
}
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Edit WUS/PUS</h2>
        <Link href="/posyandu/wuspus" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-lg-6 mb-3">
            <label>Kecamatan</label>
            <VueSelect
              v-model="form.kecamatan_id"
              :options="(kecamatan||[]).map(k => ({ label: k.nama_kec, value: k.id_kec }))"
              placeholder="Pilih Kecamatan"
            />
          </div>

          <div class="col-lg-6 mb-3">
            <label>Kelurahan</label>
            <VueSelect
              v-model="form.kelurahan_id"
              :options="kelurahanOptions.map(k => ({ label: k.nama_kel, value: k.id_kel }))"
              placeholder="Pilih Kelurahan"
              :isDisabled="!form.kecamatan_id"
            />
          </div>

          <div class="col-lg-6 mb-3">
            <label>Posyandu</label>
            <VueSelect
              v-model="form.id_posyandu"
              :options="posyanduOptions.map(p => ({ label: p.nama_posyandu, value: p.id_posyandu }))"
              placeholder="Pilih Posyandu"
              :isDisabled="!form.kelurahan_id"
            />
          </div>

          <div class="col-lg-6 mb-3">
            <label>NIK WUS/PUS</label>
            <input class="form-control" v-model="form.nik_wuspus">
          </div>

          <div class="col-lg-6 mb-3">
            <label>Nama WUS/PUS</label>
            <input class="form-control" v-model="form.nama_wuspus">
          </div>

          <div class="col-lg-3 mb-3">
            <label>Umur</label>
            <input type="number" class="form-control" v-model="form.umur">
          </div>

          <div class="col-lg-3 mb-3">
            <label>Tinggi Ibu</label>
            <input type="number" class="form-control" v-model="form.tinggi_ibu">
          </div>

          <div class="col-lg-6 mb-3">
            <label>Nama Suami</label>
            <input class="form-control" v-model="form.nama_suami">
          </div>

          <div class="col-lg-3 mb-3">
            <label>Tinggi Ayah</label>
            <input type="number" class="form-control" v-model="form.tinggi_ayah">
          </div>

          <div class="col-lg-3 mb-3">
            <label>Tahapan KS</label>
            <input class="form-control" v-model="form.thpn_ks">
          </div>

          <div class="col-lg-6 mb-3">
            <label>Kelompok Dasawisma</label>
            <input class="form-control" v-model="form.klmpk_dasawisma">
          </div>

          <div class="col-lg-3 mb-3">
            <label>Anak Hidup</label>
            <input type="number" class="form-control" v-model="form.jml_anak_hdp">
          </div>

          <div class="col-lg-3 mb-3">
            <label>Anak Meninggal</label>
            <input type="number" class="form-control" v-model="form.jml_anak_meninggal">
          </div>

          <div class="col-lg-4 mb-3">
            <label>Tanggal Daftar</label>
            <input type="date" class="form-control" v-model="form.tgl_daftar">
          </div>

          <div class="col-lg-4 mb-3">
            <label>Status</label>
            <input class="form-control" v-model="form.status">
          </div>

          <div class="col-lg-12 mb-3">
            <label>Keterangan</label>
            <textarea class="form-control" rows="3" v-model="form.ket"></textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
      </form>
    </div>

    <div v-if="showModal" class="overlay-blur" @click.self="showModal=false">
      <div class="modal-card"
           :class="modalType==='success'?'border border-success':'border border-danger'">
        <h3>{{ modalType==='success'?'Berhasil':'Gagal' }}</h3>
        <p>{{ modalMessage }}</p>
        <button class="btn w-100 mt-3"
                :class="modalType==='success'?'btn-success':'btn-danger'"
                @click="showModal=false">
          Tutup
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.overlay-blur{
  position:fixed; inset:0;
  background:rgba(0,0,0,.35);
  backdrop-filter:blur(6px);
  display:flex; align-items:center; justify-content:center;
  z-index:9999;
}
.modal-card{
  width:420px;
  background:#fff;
  background:#fff;
  border-radius:14px;
  padding:18px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}
</style>