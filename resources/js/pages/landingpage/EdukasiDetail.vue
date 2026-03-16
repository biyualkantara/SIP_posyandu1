<script setup>
import PublicLayout from '@/layouts/PublicLayout.vue';
import { usePage } from '@inertiajs/vue3';

defineOptions({
    layout: PublicLayout,
});

const page = usePage();
const id = page.props.id;

/* semua data edukasi */
const items = [
    {
        id: 1,
        title: 'Pentingnya Imunisasi Dasar Untuk Anak',
        img: '/storage/edukasi_page/periksa2.png',
        content: `Imunisasi merupakan salah satu cara paling efektif untuk melindungi anak dari berbagai penyakit berbahaya seperti campak, polio, dan difteri.

        Dengan imunisasi yang lengkap, tubuh anak akan memiliki kekebalan yang lebih baik terhadap infeksi penyakit. Orang tua dianjurkan untuk mengikuti jadwal imunisasi yang telah ditetapkan oleh tenaga kesehatan di Posyandu.

        Selain itu, imunisasi juga membantu menciptakan kekebalan kelompok sehingga dapat melindungi anak-anak lain di lingkungan sekitar.`,
    },

    {
        id: 2,
        title: 'Rekomendasi Menu untuk MP-ASI',
        img: '/storage/edukasi_page/makanan2.png',
        content: `MP-ASI (Makanan Pendamping ASI) diberikan setelah bayi berusia 6 bulan untuk memenuhi kebutuhan gizi tambahan.

        Beberapa contoh menu sehat:
        <ul>
        <li>- Bubur sayur</li>
        <li>- Pure buah</li>
        <li>- Nasi tim ayam</li>
        </ul>`,
    },

    {
        id: 3,
        title: 'Cara memberikan MP-ASI Pertama kali',
        // img: '/storage/edukasi_page/bayi2.png',
        video: 'https://www.youtube.com/embed/L0qYZT6tmnk',
        content: `Memberikan MPASI pertama kali harus dilakukan secara bertahap.

        Mulai dari makanan yang halus, kemudian tingkatkan tekstur sesuai usia bayi.`,
    },

    {
        id: 4,
        title: 'Cegah stunting dengan pola makan seimbang',
        // img: '/storage/edukasi_page/makanan2.png',
        video: 'https://www.youtube.com/embed/4hWnbHXVYko?si=0DxNnMuo5HWtHCzM',
        content: `Stunting dapat dicegah dengan pola makan bergizi seimbang.

        Pastikan anak mendapatkan protein, vitamin, mineral, dan karbohidrat yang cukup.`,
    },

    {
        id: 5,
        title: 'Panduan Pencegahan Stunting Anak usia 0 sampai 5 tahun',
        img: '/storage/edukasi_page/imunisasi2.png',
        content: `Stunting adalah kondisi gagal tumbuh akibat kekurangan gizi kronis.

        Pencegahan dapat dilakukan dengan pemantauan tumbuh kembang anak secara rutin di Posyandu.`,
    },

    {
        id: 6,
        title: 'Pencegahan Stunting pada Ibu Hamil untuk Janin',
        img: '/storage/edukasi_page/bumil2.png',
        content: `Ibu hamil perlu menjaga asupan nutrisi seperti zat besi, asam folat, dan protein untuk mendukung perkembangan janin.`,
    },
];

/* mencari artikel sesuai id */
const artikel = items.find((item) => item.id == id);

function goBack() {
    window.history.back();
}
</script>

<template>
    <div class="detail-page">
        <!-- BACK BUTTON -->
        <div class="btn-back">
            <a href="javascript:void(0)" @click="goBack">← Kembali</a>
        </div>

        <!-- CARD UTAMA DENGAN EFEK KACA -->
        <div class="detail-container">
            <h1 class="detail-title">
                {{ artikel.title }}
            </h1>

            <!-- jika ada video -->
            <div v-if="artikel.video" class="video-wrapper">
                <iframe
                    width="100%"
                    height="400"
                    :src="artikel.video"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>

            <!-- jika tidak ada video tampilkan gambar -->
            <img
                v-else
                :src="artikel.img"
                :alt="artikel.title"
                class="detail-image"
            />

            <div class="detail-content" v-html="artikel.content"></div>
        </div>
    </div>
</template>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE
   ========================= */
:global(body .content) {
    padding: 0 !important;
}

:global(body .page-container),
:global(body .page-content),
:global(body .content-wrapper),
:global(body .content) {
    background: transparent !important;
    background-image: none !important;
}

/* =========================
   PAGE BASE - BACKGROUND BIRU GRADIENT
   ========================= */
.detail-page {
    min-height: 100vh;
    padding: 40px 16px 60px;
    background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    isolation: isolate;
}

.detail-page::before {
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
.btn-back {
    max-width: 800px;
    margin: 0 auto 20px;
    position: relative;
    z-index: 1;
}

.btn-back a {
    display: inline-block;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    padding: 10px 22px;
    border-radius: 50px;
    font-weight: 600;
    color: #0a4c7a;
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.15);
    transition: all 0.3s ease;
    font-size: 15px;
}

.btn-back a:hover {
    transform: translateX(-5px);
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.25);
}

/* =========================
   CONTAINER UTAMA - EFEK KACA
   ========================= */
.detail-container {
    max-width: 800px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    padding: 45px;
    border-radius: 40px;
    box-shadow: 20px 20px 40px rgba(0, 40, 80, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.5);
    position: relative;
    z-index: 1;
}

/* =========================
   TITLE - GRADIENT BIRU
   ========================= */
.detail-title {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 30px;
    background: linear-gradient(135deg, #0a4c7a, #2c7fb8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
    line-height: 1.3;
    position: relative;
    padding-bottom: 15px;
}

.detail-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, #0a4c7a, #7fb4d9);
    border-radius: 2px;
}

/* =========================
   VIDEO WRAPPER
   ========================= */
.video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    border-radius: 24px;
    margin-bottom: 30px;
    box-shadow: 10px 10px 25px rgba(0, 40, 80, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.video-wrapper iframe {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    border-radius: 24px;
}

/* =========================
   IMAGE
   ========================= */
.detail-image {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    border-radius: 24px;
    margin-bottom: 30px;
    background: rgba(255, 255, 255, 0.5);
    padding: 20px;
    box-shadow: 10px 10px 25px rgba(0, 40, 80, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* =========================
   CONTENT
   ========================= */
.detail-content {
    font-size: 17px;
    line-height: 1.8;
    color: #1e405b;
    text-align: justify;
}

.detail-content :deep(p) {
    margin-bottom: 20px;
}

.detail-content :deep(ul) {
    margin: 15px 0;
    padding-left: 25px;
}

.detail-content :deep(li) {
    margin-bottom: 8px;
    color: #1e405b;
}

.detail-content :deep(li::marker) {
    color: #0a4c7a;
}

.detail-content :deep(strong) {
    color: #0a3b5c;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
    .detail-title {
        font-size: 32px;
    }
    
    .detail-container {
        padding: 35px;
    }
}

@media (max-width: 768px) {
    .detail-container {
        padding: 30px;
        border-radius: 30px;
    }

    .detail-title {
        font-size: 28px;
    }

    .detail-content {
        font-size: 16px;
    }

    .detail-image {
        max-height: 300px;
        padding: 15px;
    }
    
    .video-wrapper {
        border-radius: 20px;
    }
    
    .video-wrapper iframe {
        border-radius: 20px;
    }
}

@media (max-width: 576px) {
    .detail-container {
        padding: 25px 20px;
        border-radius: 25px;
    }
    
    .detail-title {
        font-size: 24px;
    }

    .detail-content {
        font-size: 15px;
    }

    .detail-image {
        max-height: 250px;
        padding: 10px;
    }
    
    .btn-back a {
        padding: 8px 18px;
        font-size: 14px;
    }
}
</style>