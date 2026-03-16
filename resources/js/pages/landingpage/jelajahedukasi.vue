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
                    class="card-edukasi"
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
                    class="empty"
                >
                    Tidak ada hasil untuk “{{ keyword }}”
                </div>
            </section>

            <!-- WA BOX -->
            <div class="wa-box">
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
   LIMITLESS OVERRIDE
   ========================= */
:global(body.esip-edukasi-body .content) {
    padding: 0 !important;
}

:global(body.esip-edukasi-body .page-container),
:global(body.esip-edukasi-body .page-content),
:global(body.esip-edukasi-body .content-wrapper),
:global(body.esip-edukasi-body .content) {
    background: transparent !important;
    background-image: none !important;
}

/* =========================
   PAGE BASE - BACKGROUND BIRU GRADIENT
   ========================= */
.esip-edukasi-page {
    min-height: 100vh;
    padding: 25px 0 70px;
    background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    isolation: isolate;
}

.esip-edukasi-page::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url("/storage/tentangesip_page/background_biru.png");
    background-repeat: repeat;
    background-size: 300px;
    background-position: center;
    opacity: 0.15;
    mix-blend-mode: overlay;
    pointer-events: none;
    z-index: 0;
}

/* =========================
   BACK BUTTON - BIRU
   ========================= */
.btn-back{
    margin:20px 25px;
    position: relative;
    z-index: 1;
}

.btn-back a{
    font-size:14px;
    text-decoration:none;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    padding:8px 18px;
    border-radius:50px;
    color: #0a4c7a;
    font-weight:700;
    box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.4);
    transition:all .25s;
    display: inline-block;
}

.btn-back a:hover{
    transform:translateY(-2px);
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.25);
}

/* =========================
   HEADER
   ========================= */
.judul-section{
    padding:10px 16px 0;
    position: relative;
    z-index: 1;
    text-align: center;
}

.judul-page{
    font-size:48px;
    font-weight:800;
    margin:0;
    background: linear-gradient(135deg, #0a4c7a, #2c7fb8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 3px 3px 6px rgba(255, 255, 255, 0.5);
    position: relative;
    padding-bottom: 15px;
    display: inline-block;
}

.judul-page::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 4px;
    background: linear-gradient(90deg, #0a4c7a, #7fb4d9);
    border-radius: 2px;
}

.subjudul{
    font-size:18px;
    margin-top:10px;
    color: #1e405b;
    text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

/* =========================
   SEARCH - BIRU
   ========================= */
.search-container{
    display:flex;
    justify-content:center;
    margin:28px auto;
    gap:10px;
    padding:0 16px;
    position: relative;
    z-index: 1;
}

.search-container input{
    width:min(420px,100%);
    padding:13px 15px;
    border-radius:30px;
    border: 1px solid rgba(255, 255, 255, 0.4);
    outline:none;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.1);
    color: #0a3b5c;
}

.search-container input:focus{
    box-shadow: 0 0 0 3px rgba(10, 76, 122, 0.2), 5px 5px 15px rgba(0, 40, 80, 0.1);
    background: rgba(255, 255, 255, 0.95);
    border-color: #0a4c7a;
}

.search-container input::placeholder {
    color: #1e405b;
    opacity: 0.6;
}

.search-container button{
    padding:13px 18px;
    border-radius:30px;
    background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
    border: 1px solid rgba(255, 255, 255, 0.2);
    cursor:pointer;
    font-weight:900;
    color: white;
    box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.2);
    transition:.2s;
}

.search-container button:hover{
    transform:translateY(-2px);
    background: linear-gradient(145deg, #0d5588, #2b74a5);
    box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.3);
}

/* =========================
   FILTER KATEGORI - BIRU
   ========================= */
.kategori-wrapper{
    display:flex;
    justify-content:center;
    gap:14px;
    flex-wrap:wrap;
    padding:0 16px;
    position: relative;
    z-index: 1;
}

.btn-kategori{
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    padding:9px 18px;
    border-radius:30px;
    font-weight:700;
    font-size:14px;
    text-decoration:none;
    color: #0a3b5c;
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 3px 3px 10px rgba(0, 40, 80, 0.1);
    transition:all .25s;
}

.btn-kategori:hover{
    transform:translateY(-2px);
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.15);
}

.btn-kategori.active{
    background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
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
    position: relative;
    z-index: 1;
}

/* =========================
   CARD EDUKASI - EFEK KACA
   ========================= */
.card-edukasi{
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    padding:22px;
    text-align:center;
    box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.4);
    transition:all .25s;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:10px;
}

.card-edukasi:hover{
    transform:translateY(-8px) scale(1.02);
    box-shadow: 20px 20px 40px rgba(0, 40, 80, 0.25);
    background: rgba(255, 255, 255, 0.9);
}

.card-edukasi h3{
    font-size:18px;
    font-weight:700;
    line-height:1.4;
    color: #0a3b5c;
    margin: 10px 0;
}

/* =========================
   IMAGE
   ========================= */
.card-edukasi img{
    width:85%;
    height:150px;
    object-fit:contain;
    filter: drop-shadow(5px 5px 15px rgba(0, 40, 80, 0.2));
}

/* =========================
   BADGE - BIRU
   ========================= */
.badge{
    font-size:12px;
    padding:6px 15px;
    border-radius:20px;
    font-weight:700;
    color:#fff;
    align-self:flex-start;
    box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.1);
}

.badge-video{
    background: #ff6b6b;
}

.badge-artikel{
    background: #0a4c7a;
}

.badge-berita{
    background: #2c7fb8;
}

/* =========================
   BUTTON AKSI - BIRU
   ========================= */
.btn-aksi{
    width:100%;
    text-align:center;
    background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
    padding:12px 16px;
    border-radius:30px;
    text-decoration:none;
    color:white;
    font-weight:600;
    transition:all .25s;
    box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-aksi:hover{
    transform:translateY(-3px);
    background: linear-gradient(145deg, #0d5588, #2b74a5);
    box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.3);
}

/* =========================
   EMPTY - BIRU
   ========================= */
.empty{
    grid-column:1/-1;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    padding:30px;
    border-radius:30px;
    text-align:center;
    font-weight:700;
    color: #0a3b5c;
    box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.4);
}

/* =========================
   WA BOX - BIRU
   ========================= */
.wa-box{
    width:min(1200px,100%);
    margin:40px auto 0;
    padding:18px 24px;
    border-radius:30px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.4);
    position: relative;
    z-index: 1;
}

.wa-text{
    font-size:16px;
    font-weight:500;
    color: #0a3b5c;
    margin:0;
}

.btn-wa{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background: linear-gradient(145deg, #25D366, #128C7E);
    padding:12px 24px;
    border-radius:40px;
    color:#fff;
    font-weight:600;
    text-decoration:none;
    transition:.25s;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-wa:hover{
    transform:translateY(-3px);
    box-shadow: 8px 8px 20px rgba(0, 0, 0, 0.2);
}

/* =========================
   RESPONSIVE
   ========================= */
@media(max-width:992px){
    .konten-edukasi{
        grid-template-columns:repeat(2,1fr);
    }
    .judul-page{
        font-size:42px;
    }
    .subjudul{
        font-size:16px;
    }
}

@media(max-width:768px){
    .konten-edukasi{
        grid-template-columns:repeat(2,1fr);
        gap:20px;
    }
    .judul-page{
        font-size:36px;
    }
}

@media(max-width:600px){
    .konten-edukasi{
        grid-template-columns:1fr;
    }
    .judul-page{
        font-size:28px;
    }
    .subjudul{
        font-size:14px;
    }
    .wa-box{
        flex-direction:column;
        text-align:center;
        padding:20px;
    }
    .btn-wa{
        width:100%;
        justify-content:center;
    }
    .kategori-wrapper{
        gap:8px;
    }
    .btn-kategori{
        padding:7px 14px;
        font-size:13px;
    }
}
</style>