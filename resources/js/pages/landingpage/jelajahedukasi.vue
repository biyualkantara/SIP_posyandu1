<template>
    <PublicLayout>
        <div class="esip-edukasi-page">
            <!-- BACK BUTTON -->
            <div class="btn-back">
                <a href="javascript:void(0)" @click.prevent="goBack"
                    >← Kembali</a
                >
            </div>

            <!-- HEADER -->
            <header class="judul-section text-center">
                <h1 class="judul-page">Edukasi Kesehatan Ibu dan Anak</h1>
                <p class="subjudul">
                    Temukan panduan kesehatan, gizi, dan tumbuh kembang anak
                    dari Posyandu Kota Cimahi
                </p>
            </header>

            <!-- SEARCH -->
            <div class="search-container">
                <input
                    v-model.trim="keyword"
                    type="text"
                    placeholder="Cari edukasi kesehatan..."
                    @keydown.enter.prevent="/* auto reactive */ null"
                />
                <button type="button" @click="/* auto reactive */ null">
                    🔍
                </button>
            </div>

            <!-- FILTER KATEGORI -->
            <div class="kategori-wrapper">
                <a
                    href="#"
                    class="btn-kategori"
                    :class="{ active: activeFilter === 'all' }"
                    @click.prevent="activeFilter = 'all'"
                >
                    Semua
                </a>

                <!-- sesuai data-filter HTML kamu -->
                <a
                    href="#"
                    class="btn-kategori"
                    :class="{ active: activeFilter === 'artikel' }"
                    @click.prevent="activeFilter = 'artikel'"
                >
                    Gizi Anak
                </a>

                <a
                    href="#"
                    class="btn-kategori"
                    :class="{ active: activeFilter === 'video' }"
                    @click.prevent="activeFilter = 'video'"
                >
                    Imunisasi
                </a>

                <a
                    href="#"
                    class="btn-kategori"
                    :class="{ active: activeFilter === 'artikel' }"
                    @click.prevent="activeFilter = 'artikel'"
                >
                    Kesehatan ibu hamil
                </a>

                <a
                    href="#"
                    class="btn-kategori"
                    :class="{ active: activeFilter === 'video' }"
                    @click.prevent="activeFilter = 'video'"
                >
                    Stunting
                </a>

                <a
                    href="#"
                    class="btn-kategori"
                    :class="{ active: activeFilter === 'artikel' }"
                    @click.prevent="activeFilter = 'artikel'"
                >
                    Tumbuh
                </a>
            </div>

            <!-- CONTENT -->
            <section class="konten-edukasi">
                <div
                    v-for="item in filteredItems"
                    :key="item.id"
                    class="card-edukasi panel panel-body"
                >
                    <span
                        class="badge"
                        :class="{
                            'badge-artikel': item.type === 'artikel',
                            'badge-video': item.type === 'video',
                            'badge-berita': item.type === 'berita',
                        }"
                    >
                        {{ labelType(item.type) }}
                    </span>

                    <h3>{{ item.title }}</h3>

                    <img :src="item.img" :alt="item.title" />

                    <Link :href="`/edukasi-detail/${item.id}`" class="btn-aksi">
                        {{ ctaText(item.type) }}
                    </Link>
                </div>

                <!-- empty state -->
                <div
                    v-if="filteredItems.length === 0"
                    class="empty panel panel-body"
                >
                    Tidak ada hasil untuk “{{ keyword }}”
                </div>
            </section>

            <!-- WA BOX -->
            <div class="wa-box panel panel-body">
                <p class="wa-text">
                    Ingin tahu informasi terbaru dari Posyandu Kota Cimahi?
                </p>
                <a
                    href="https://wa.me/62812XXXXXXX"
                    target="_blank"
                    rel="noopener"
                    class="btn-wa"
                >
                    <i class="fa-brands fa-whatsapp"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </PublicLayout>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3'
const keyword = ref('');
const activeFilter = ref('all');
/* dummy data (tinggal ganti dari API nanti) */
const items = ref([
    {
        id: 1,
        title: 'Pentingnya Imunisasi Dasar Untuk Anak',
        searchTitle: 'imunisasi anak',
        type: 'artikel',
        img: '/storage/edukasi_page/periksa2.png',
        href: '/edukasi-detail',
    },
    {
        id: 2,
        title: 'Rekomendasi Menu untuk MP-ASI',
        searchTitle: 'mpasi menu',
        type: 'berita',
        img: '/storage/edukasi_page/makanan2.png',
        href: '/edukasi-detail',
    },
    {
        id: 3,
        title: 'Cara memberikan MP-ASI Pertama kali',
        searchTitle: 'cara mpasi video',
        type: 'video',
        img: '/storage/edukasi_page/bayi2.png',
        href: '/edukasi-detail',
    },
    {
        id: 4,
        title: 'Cegah stunting dengan pola makan seimbang',
        searchTitle: 'stunting pola makan',
        type: 'video',
        img: '/storage/edukasi_page/makanan2.png',
        href: '/edukasi-detail',
    },
    {
        id: 5,
        title: 'Panduan Pencegahan Stunting Anak usia 0 sampai 5 tahun',
        searchTitle: 'panduan stunting anak',
        type: 'artikel',
        img: '/storage/edukasi_page/imunisasi2.png',
        href: '/edukasi-detail',
    },
    {
        id: 6,
        title: 'Pencegahan Stunting pada Ibu Hamil untuk Janin',
        searchTitle: 'pencegahan stunting ibu hamil',
        type: 'artikel',
        img: '/storage/edukasi_page/bumil2.png',
        href: '/edukasi-detail',
    },
]);

const filteredItems = computed(() => {
    const k = keyword.value.toLowerCase().trim();
    return items.value.filter((it) => {
        const matchText =
            !k ||
            it.title.toLowerCase().includes(k) ||
            (it.searchTitle || '').toLowerCase().includes(k);

        const matchType =
            activeFilter.value === 'all' || it.type === activeFilter.value;

        return matchText && matchType;
    });
});

function labelType(t) {
    if (t === 'artikel') return 'Artikel';
    if (t === 'video') return 'Video';
    return 'Berita';
}

function ctaText(t) {
    if (t === 'artikel') return 'Baca Artikel';
    if (t === 'video') return 'Lihat Video';
    return 'Lihat Berita';
}

function goBack() {
    window.history.back();
}

/* optional: biar style Limitless page lain aman */
onMounted(() => document.body.classList.add('esip-edukasi-body'));
onBeforeUnmount(() => document.body.classList.remove('esip-edukasi-body'));
</script>

<style scoped>
/* =========================
   PAGE BASE
   ========================= */
.esip-edukasi-page {
    min-height: 100vh;
    padding: 25px 0 70px;

    background: linear-gradient(135deg,#cfe7ff,#e9f4ff);

    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* =========================
   BACK BUTTON
   ========================= */
.btn-back{
    margin:20px 25px;
}

.btn-back a{
    font-size:14px;
    text-decoration:none;
    background:#ffffff;
    padding:8px 18px;
    border-radius:50px;
    color:#444;
    font-weight:700;

    box-shadow:0 6px 14px rgba(0,0,0,0.12);
    transition:all .25s;
}

.btn-back a:hover{
    transform:translateY(-2px);
}

/* =========================
   HEADER
   ========================= */
.judul-section{
    padding:10px 16px 0;
}

.judul-page{
    font-size:42px;
    font-weight:900;
    margin:0;
    color:#1c2b4a;
}

.subjudul{
    font-size:17px;
    margin-top:6px;
    color:#5b6a8a;
}

/* =========================
   SEARCH
   ========================= */
.search-container{
    display:flex;
    justify-content:center;
    margin:28px auto;
    gap:10px;
    padding:0 16px;
}

.search-container input{
    width:min(420px,100%);
    padding:13px 15px;

    border-radius:12px;
    border:none;
    outline:none;

    background:#fff;

    box-shadow:0 6px 14px rgba(0,0,0,0.12);
}

.search-container input:focus{
    box-shadow:
        0 0 0 3px rgba(120,150,255,.3),
        0 6px 14px rgba(0,0,0,0.12);
}

.search-container button{
    padding:13px 18px;
    border-radius:12px;
    background:#ffd95b;
    border:none;
    cursor:pointer;

    font-weight:900;

    box-shadow:0 6px 14px rgba(0,0,0,0.14);
    transition:.2s;
}

.search-container button:hover{
    transform:translateY(-2px);
}

/* =========================
   FILTER KATEGORI
   ========================= */
.kategori-wrapper{
    display:flex;
    justify-content:center;
    gap:14px;
    flex-wrap:wrap;
    padding:0 16px;
}

.btn-kategori{
    background:#ffffff;
    padding:9px 18px;
    border-radius:30px;
    font-weight:700;
    font-size:14px;

    text-decoration:none;
    color:#3d3d3d;

    box-shadow:0 5px 12px rgba(0,0,0,0.12);

    transition:all .25s;
}

.btn-kategori:hover{
    transform:translateY(-2px);
}

.btn-kategori.active{
    background:#ffd95b;
}

/* =========================
   GRID CONTENT
   ========================= */
.konten-edukasi{
    width:min(1200px,100%);
    margin:35px auto;
    padding:0 16px;

    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:26px;
}

/* =========================
   CARD EDUKASI
   ========================= */
.card-edukasi{

    background:#ffffff;

    border-radius:16px;

    padding:22px;

    text-align:center;

    box-shadow:0 12px 25px rgba(0,0,0,0.12);

    transition:all .25s;

    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
}

.card-edukasi:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 35px rgba(0,0,0,0.18);
}

.card-edukasi h3{
    font-size:16px;
    font-weight:800;
    line-height:1.4;
}

/* =========================
   IMAGE
   ========================= */
.card-edukasi img{
    width:85%;
    height:150px;
    object-fit:contain;
}

/* =========================
   BADGE
   ========================= */
.badge{
    font-size:11px;
    padding:6px 12px;
    border-radius:20px;
    font-weight:800;
    color:#fff;
    align-self:flex-start;
}

.badge-video{
    background:#ff5b5b;
}

.badge-artikel{
    background:#3a86ff;
}

.badge-berita{
    background:#2dbd63;
}

/* =========================
   BUTTON AKSI
   ========================= */
.btn-aksi{
    width:100%;
    text-align:center;

    background:#ffd95b;

    padding:10px 16px;

    border-radius:10px;

    text-decoration:none;

    color:#333;

    font-weight:800;

    transition:all .25s;

    box-shadow:0 6px 14px rgba(0,0,0,0.14);
}

.btn-aksi:hover{
    transform:translateY(-2px);
}

/* =========================
   EMPTY
   ========================= */
.empty{
    grid-column:1/-1;

    background:#fff;

    padding:20px;

    border-radius:12px;

    text-align:center;

    font-weight:700;

    box-shadow:0 10px 20px rgba(0,0,0,0.12);
}

/* =========================
   WA BOX
   ========================= */
.wa-box{

    width:min(1200px,100%);
    margin:40px auto 0;

    padding:18px 24px;

    border-radius:14px;

    background:#ffe7c8;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;

    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}

.btn-wa{

    display:inline-flex;
    align-items:center;
    gap:8px;

    background:#25d366;

    padding:10px 18px;

    border-radius:30px;

    color:#fff;

    font-weight:800;

    text-decoration:none;

    transition:.25s;

    box-shadow:0 8px 18px rgba(0,0,0,0.15);
}

.btn-wa:hover{
    transform:translateY(-2px);
}

/* =========================
   RESPONSIVE
   ========================= */

@media(max-width:992px){

.konten-edukasi{
grid-template-columns:repeat(2,1fr);
}

.judul-page{
font-size:32px;
}

}

@media(max-width:600px){

.konten-edukasi{
grid-template-columns:1fr;
}

.judul-page{
font-size:26px;
}

.subjudul{
font-size:14px;
}

.wa-box{
flex-direction:column;
text-align:center;
}

}
</style>
