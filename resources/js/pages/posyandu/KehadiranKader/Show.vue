<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    kdrhdr: Object
});
</script>

<template>
<AdminLayout>
<div class="bg-white p-4 main-container">

    <div class="header-flex mb-3">
        <h2>Detail Kehadiran Kader</h2>
        <Link href="/posyandu/kehadiran-kader" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <div class="detail-card">
        <h4>{{ kdrhdr.nama_posyandu }}</h4>

        <p><b>Kecamatan:</b> {{ kdrhdr.nama_kec }}</p>
        <p><b>Kelurahan:</b> {{ kdrhdr.nama_kel }}</p>

        <hr>

        <p><b>Bulan/Tahun:</b> {{ (kdrhdr.bulan_tahun || '').toString().slice(0,7) }}</p>

        <hr>

        <p><b>PKK:</b> {{ kdrhdr.pkk }}</p>
        <p><b>PLKB:</b> {{ kdrhdr.plkb }}</p>
        <p><b>Medis:</b> {{ kdrhdr.medis }}</p>
    </div>

</div>
</AdminLayout>
</template>

<style scoped>
.detail-card {
    border: 1px solid #eaeaea;
    border-radius: 8px;
    padding: 20px;
    background: #fafafa;
}
.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.main-container { min-height: 100vh; }
</style>