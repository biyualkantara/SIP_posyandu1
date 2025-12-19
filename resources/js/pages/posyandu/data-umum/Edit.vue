<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    duspy: Object,
    kecamatan: Array,
    kelurahan: Object
});

const kecamatanNama = ref(props.duspy?.kelurahan?.kecamatan?.nama_kec || "");
const kelurahanNama = ref(props.duspy?.kelurahan?.nama_kel || "");

const form = useForm({
    id_kel: props.duspy.id_kel,

    nama_posyandu: props.duspy.nama_posyandu,
    strata_psy: props.duspy.strata_psy,
    alamat_posyandu: props.duspy.alamat_posyandu,

    pj_umum: props.duspy.pj_umum,
    pj_operasional: props.duspy.pj_operasional,
    ketuplak: props.duspy.ketuplak,
    sekretaris: props.duspy.sekretaris,

    int_paud: props.duspy.int_paud,
    int_bkd: props.duspy.int_bkd,
    int_terpadu: props.duspy.int_terpadu,

    kader_aktif: props.duspy.kader_aktif,
    kader_taktif: props.duspy.kader_taktif,

    ptgs_kb: props.duspy.ptgs_kb,
    ptgs_medis: props.duspy.ptgs_medis,
    ptgs_bidan: props.duspy.ptgs_bidan
});

const selectedKecId = ref(props.duspy?.kelurahan?.kecamatan?.id_kec || null);

const kelurahanFiltered = computed(() => {
    if (!selectedKecId.value) return [];
    return props.kelurahan?.[selectedKecId.value] ?? [];
});

function pilihKecamatan(nama) {
    kecamatanNama.value = nama;
    const kec = props.kecamatan.find((x) => x.nama_kec === nama);
    if (kec) {
        selectedKecId.value = kec.id_kec;
        form.id_kel = null;
        kelurahanNama.value = "";
    }
}

function pilihKelurahan(nama) {
    kelurahanNama.value = nama;
    const kel = kelurahanFiltered.value.find((x) => x.nama_kel === nama);
    if (kel) {
        form.id_kel = kel.id_kel;
    }
}
</script>

<template>
<AdminLayout>
<div class="bg-white p-4 main-container">

    <div class="header-flex mb-3">
        <h2>Edit Data Posyandu</h2>
        <Link href="/posyandu/data-umum" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <form @submit.prevent="form.put(`/posyandu/data-umum/${props.duspy.id_posyandu}`)">

        <div class="row mb-4">
            <div class="col-lg-4 mb-3">
                <label>Kecamatan</label>
                <input class="form-control" list="listKec"
                       v-model="kecamatanNama"
                       @input="pilihKecamatan(kecamatanNama)">
                <datalist id="listKec">
                    <option v-for="k in kecamatan" :key="k.id_kec" :value="k.nama_kec"></option>
                </datalist>
            </div>

            <div class="col-lg-4 mb-3">
                <label>Kelurahan</label>
                <input class="form-control" list="listKel"
                       :disabled="!selectedKecId"
                       v-model="kelurahanNama"
                       @input="pilihKelurahan(kelurahanNama)">
                <datalist id="listKel">
                    <option v-for="k in kelurahanFiltered" :key="k.id_kel" :value="k.nama_kel"></option>
                </datalist>
            </div>
        </div>

        <div class="row form-grid">
            <div class="col-lg-4 mb-3">
                <label>Nama Posyandu</label>
                <input class="form-control" v-model="form.nama_posyandu">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Strata</label>
                <select class="form-control" v-model="form.strata_psy">
                    <option value="">--Pilih--</option>
                    <option>Pratama</option>
                    <option>Madya</option>
                    <option>Purnama</option>
                    <option>Mandiri</option>
                </select>
            </div>

            <div class="col-lg-8 mb-3">
                <label>Alamat</label>
                <input class="form-control" v-model="form.alamat_posyandu">
            </div>

            <div class="col-lg-4 mb-3">
                <label>PJ Umum</label>
                <input class="form-control" v-model="form.pj_umum">
            </div>

            <div class="col-lg-4 mb-3">
                <label>PJ Operasional</label>
                <input class="form-control" v-model="form.pj_operasional">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Ketua Pelaksana</label>
                <input class="form-control" v-model="form.ketuplak">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Sekretaris</label>
                <input class="form-control" v-model="form.sekretaris">
            </div>

            <div class="col-lg-4 mb-3">
                <label>PAUD</label>
                <select class="form-control" v-model="form.int_paud">
                    <option :value="1">Ada</option>
                    <option :value="0">Tidak</option>
                </select>
            </div>

            <div class="col-lg-4 mb-3">
                <label>BKD</label>
                <select class="form-control" v-model="form.int_bkd">
                    <option :value="1">Ada</option>
                    <option :value="0">Tidak</option>
                </select>
            </div>

            <div class="col-lg-4 mb-3">
                <label>Terpadu</label>
                <select class="form-control" v-model="form.int_terpadu">
                    <option :value="1">Ya</option>
                    <option :value="0">Tidak</option>
                </select>
            </div>

            <div class="col-lg-4 mb-3">
                <label>Kader Aktif</label>
                <input type="number" class="form-control" v-model="form.kader_aktif">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Kader Tidak Aktif</label>
                <input type="number" class="form-control" v-model="form.kader_taktif">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Petugas KB</label>
                <input class="form-control" v-model="form.ptgs_kb">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Petugas Medis</label>
                <input class="form-control" v-model="form.ptgs_medis">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Petugas Bidan</label>
                <input class="form-control" v-model="form.ptgs_bidan">
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5 py-2">Simpan Perubahan</button>
        </div>
    </form>

</div>
</AdminLayout>
</template>

<style scoped>
.main-container { min-height: 100vh }
.header-flex { display:flex;justify-content:space-between;align-items:center }
.form-grid > div { margin-bottom: 18px }
</style>