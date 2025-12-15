<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    kdrhdr: Object,
    kecamatan: Array,
    kelurahan: Object,
    posyandu: Object
});

const kecamatanNama = ref(props.kdrhdr?.nama_kec || "");
const kelurahanNama = ref(props.kdrhdr?.nama_kel || "");

const form = useForm({
    id_posyandu: props.kdrhdr.id_posyandu,
    bulan: props.kdrhdr.bulan, // YYYY-MM dari controller
    pkk: props.kdrhdr.pkk,
    plkb: props.kdrhdr.plkb,
    medis: props.kdrhdr.medis,
    id_kel: props.kdrhdr.id_kel,
});

const selectedKecId = ref(props.kdrhdr?.id_kec || null);

const kelurahanFiltered = computed(() => {
    if (!selectedKecId.value) return [];
    return props.kelurahan?.[selectedKecId.value] ?? [];
});

const posyanduFiltered = computed(() => {
    if (!form.id_kel) return [];
    return props.posyandu?.[form.id_kel] ?? [];
});

function pilihKecamatan(nama) {
    kecamatanNama.value = nama;
    const kec = props.kecamatan.find((x) => x.nama_kec === nama);
    if (kec) {
        selectedKecId.value = kec.id_kec;
        form.id_kel = null;
        kelurahanNama.value = "";
        form.id_posyandu = null;
    }
}

function pilihKelurahan(nama) {
    kelurahanNama.value = nama;
    const kel = kelurahanFiltered.value.find((x) => x.nama_kel === nama);
    if (kel) {
        form.id_kel = kel.id_kel;
        form.id_posyandu = null;
    }
}
</script>

<template>
<AdminLayout>
<div class="bg-white p-4 main-container">

    <div class="header-flex mb-3">
        <h2>Edit Kehadiran Kader</h2>
        <Link href="/posyandu/kehadiran-kader" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <form @submit.prevent="form.put(`/posyandu/kehadiran-kader/${props.kdrhdr.id_kdrhdr}`)">

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

            <div class="col-lg-4 mb-3">
                <label>Posyandu</label>
                <select class="form-control" v-model="form.id_posyandu" :disabled="!form.id_kel">
                    <option value="">--Pilih--</option>
                    <option v-for="p in posyanduFiltered" :key="p.id_posyandu" :value="p.id_posyandu">
                        {{ p.nama_posyandu }}
                    </option>
                </select>
            </div>
        </div>

        <div class="row form-grid">
            <div class="col-lg-4 mb-3">
                <label>Bulan</label>
                <input type="month" class="form-control" v-model="form.bulan">
            </div>

            <div class="col-lg-4 mb-3">
                <label>PKK</label>
                <input type="number" class="form-control" v-model="form.pkk">
            </div>

            <div class="col-lg-4 mb-3">
                <label>PLKB</label>
                <input type="number" class="form-control" v-model="form.plkb">
            </div>

            <div class="col-lg-4 mb-3">
                <label>Medis</label>
                <input type="number" class="form-control" v-model="form.medis">
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