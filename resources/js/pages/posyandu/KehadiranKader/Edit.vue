<script setup>
import AdminLayout from "@/layouts/AdminLayout.vue";
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
    bulan: props.kdrhdr.bulan,
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
<div class="page-container">
    <div class="header-flex">
        <h2>Edit Kehadiran Kader</h2>
        <Link href="/posyandu/kehadiran-kader" class="btn btn-light">← Kembali</Link>
    </div>

    <form @submit.prevent="form.put(`/posyandu/kehadiran-kader/${props.kdrhdr.id_kdrhdr}`)">

        <div class="data-card">
            <div class="card-title">Lokasi Posyandu</div>

            <div class="grid-3">
                <div>
                    <label>Kecamatan</label>
                    <input class="form-control" list="listKec"
                           v-model="kecamatanNama"
                           @input="pilihKecamatan(kecamatanNama)">
                    <datalist id="listKec">
                        <option v-for="k in kecamatan" :key="k.id_kec" :value="k.nama_kec"></option>
                    </datalist>
                </div>

                <div>
                    <label>Kelurahan</label>
                    <input class="form-control" list="listKel"
                           :disabled="!selectedKecId"
                           v-model="kelurahanNama"
                           @input="pilihKelurahan(kelurahanNama)">
                    <datalist id="listKel">
                        <option v-for="k in kelurahanFiltered" :key="k.id_kel" :value="k.nama_kel"></option>
                    </datalist>
                </div>

                <div>
                    <label>Posyandu</label>
                    <select class="form-control" v-model="form.id_posyandu" :disabled="!form.id_kel">
                        <option value="">-- Pilih --</option>
                        <option v-for="p in posyanduFiltered" :key="p.id_posyandu" :value="p.id_posyandu">
                            {{ p.nama_posyandu }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="data-card">
            <div class="card-title">Data Kehadiran</div>

            <div class="grid-4">
                <div>
                    <label>Bulan</label>
                    <input type="month" class="form-control" v-model="form.bulan">
                </div>

                <div>
                    <label>PKK</label>
                    <input type="number" class="form-control" v-model="form.pkk">
                </div>

                <div>
                    <label>PLKB</label>
                    <input type="number" class="form-control" v-model="form.plkb">
                </div>

                <div>
                    <label>Medis</label>
                    <input type="number" class="form-control" v-model="form.medis">
                </div>
            </div>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
        </div>
    </form>
</div>
</template>

<style scoped>
.page-container{
    background:#fff;
    min-height:100vh;
    padding:24px;
}

.header-flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.data-card{
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:20px;
    margin-bottom:20px;
    box-shadow:0 6px 20px rgba(0,0,0,.05);
}

.card-title{
    font-weight:600;
    margin-bottom:16px;
}

.grid-3{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:16px;
}

.grid-4{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
}

.form-footer{
    text-align:center;
    margin-top:24px;
}
</style>