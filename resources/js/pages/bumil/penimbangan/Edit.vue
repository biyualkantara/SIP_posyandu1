<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
  row: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  wuspus: Object,
});

const kecamatanNama = ref(props.row?.nama_kec || "");
const kelurahanNama = ref(props.row?.nama_kel || "");

const form = useForm({
  id_wuspus: props.row.id_wuspus,
  bln_hamil: props.row.bln_hamil ?? "",
  tgl_pnb: props.row.tgl_pnb,
  berat: props.row.berat ?? "",
  hasil: props.row.hasil ?? "",
  ket: props.row.ket ?? "",

  id_kec: props.row?.id_kec ?? null,
  id_kel: props.row?.id_kel ?? null,
  id_posyandu: props.row?.id_posyandu ?? null,
});

const selectedKecId = ref(props.row?.id_kec ?? null);

const kelurahanFiltered = computed(() => {
  if (!selectedKecId.value) return [];
  return props.kelurahan?.[selectedKecId.value] ?? [];
});

const posyanduFiltered = computed(() => {
  if (!form.id_kel) return [];
  return props.posyandu?.[form.id_kel] ?? [];
});

const wuspusFiltered = computed(() => {
  if (!form.id_posyandu) return [];
  return props.wuspus?.[form.id_posyandu] ?? [];
});

function pilihKecamatan(nama) {
  kecamatanNama.value = nama;
  const kec = props.kecamatan.find(x => x.nama_kec === nama);
  if (kec) {
    selectedKecId.value = kec.id_kec;
    form.id_kec = kec.id_kec;
    form.id_kel = null;
    form.id_posyandu = null;
    form.id_wuspus = null;
    kelurahanNama.value = "";
  }
}

function pilihKelurahan(nama) {
  kelurahanNama.value = nama;
  const kel = kelurahanFiltered.value.find(x => x.nama_kel === nama);
  if (kel) {
    form.id_kel = kel.id_kel;
    form.id_posyandu = null;
    form.id_wuspus = null;
  }
}
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Edit Penimbangan Bumil</h2>
      <Link href="/posyandu/bumil-pnb" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <form @submit.prevent="form.put(`/posyandu/bumil-pnb/${row.id_bumil_pnb}`)">
      <div class="row mb-4">
        <div class="col-lg-4 mb-3">
          <label>Kecamatan</label>
          <input class="form-control" list="listKec" v-model="kecamatanNama" @input="pilihKecamatan(kecamatanNama)" readonly>
          <datalist id="listKec">
            <option v-for="k in kecamatan" :key="k.id_kec" :value="k.nama_kec"/>
          </datalist>
        </div>

        <div class="col-lg-4 mb-3">
          <label>Kelurahan</label>
          <input class="form-control" list="listKel" :disabled="!selectedKecId"
                 v-model="kelurahanNama" @input="pilihKelurahan(kelurahanNama)" readonly>
          <datalist id="listKel">
            <option v-for="k in kelurahanFiltered" :key="k.id_kel" :value="k.nama_kel"/>
          </datalist>
        </div>

        <div class="col-lg-4 mb-3">
          <label>Posyandu</label>
         <input
            type="text"
            class="form-control"
            :value="props.row.nama_posyandu"
            readonly
          />
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6 mb-3">
          <label>WUS/PUS</label>
          <select class="form-control" v-model="form.id_wuspus" :disabled="!form.id_posyandu">
            <option value="" disabled>-- Pilih --</option>
            <option v-for="w in wuspusFiltered" :key="w.id_wuspus" :value="w.id_wuspus">
              {{ w.nik_wuspus }} - {{ w.nama_wuspus }}
            </option>
          </select>
        </div>

        <div class="col-lg-3 mb-3">
          <label>Bulan Hamil</label>
          <input class="form-control" v-model="form.bln_hamil">
        </div>

        <div class="col-lg-3 mb-3">
          <label>Tanggal Timbang</label>
          <input type="date" class="form-control" v-model="form.tgl_pnb">
        </div>

        <div class="col-lg-4 mb-3">
          <label>Berat Badan</label>
          <input type="number" step="0.01" class="form-control" v-model="form.berat">
        </div>

        <div class="col-lg-4 mb-3">
          <label>Hasil</label>
          <input class="form-control" v-model="form.hasil">
        </div>

        <div class="col-lg-12 mb-3">
          <label>Keterangan</label>
          <textarea class="form-control" rows="3" v-model="form.ket"></textarea>
        </div>
      </div>

      <div class="text-center mt-4">
        <button class="btn btn-primary px-5 py-2">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</AdminLayout>
</template>

<style scoped>
.main-container { min-height: 100vh }
.header-flex { display:flex;justify-content:space-between;align-items:center }
</style>