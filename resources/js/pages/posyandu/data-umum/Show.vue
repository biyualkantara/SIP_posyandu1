<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    duspy: Object
});
</script>

<template>
<AdminLayout>
<div class="bg-white p-4 main-container">

    <div class="header-flex mb-3">
        <h2>Detail Data Posyandu</h2>
        <Link href="/posyandu/data-umum" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <div class="detail-card">
        <h4>{{ duspy.nama_posyandu }}</h4>

        <p><b>Kecamatan:</b> {{ duspy?.kelurahan?.kecamatan?.nama_kec }}</p>
        <p><b>Kelurahan:</b> {{ duspy?.kelurahan?.nama_kel }}</p>

        <hr>

        <p><b>Strata:</b> {{ duspy.strata_psy }}</p>
        <p><b>Alamat:</b> {{ duspy.alamat_posyandu }}</p>

        <hr>

        <p><b>PJ Umum:</b> {{ duspy.pj_umum }}</p>
        <p><b>PJ Operasional:</b> {{ duspy.pj_operasional }}</p>
        <p><b>Ketua Pelaksana:</b> {{ duspy.ketuplak }}</p>
        <p><b>Sekretaris:</b> {{ duspy.sekretaris }}</p>

        <hr>

        <p><b>Kader Aktif:</b> {{ duspy.kader_aktif }}</p>
        <p><b>Kader Tidak Aktif:</b> {{ duspy.kader_taktif }}</p>

        <hr>

        <p><b>Petugas KB:</b> {{ duspy.ptgs_kb }}</p>
        <p><b>Petugas Medis:</b> {{ duspy.ptgs_medis }}</p>
        <p><b>Petugas Bidan:</b> {{ duspy.ptgs_bidan }}</p>
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