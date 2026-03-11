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
        <!-- BACK -->
        <div class="btn-back">
            <a href="javascript:void(0)" @click="goBack">← Kembali</a>
        </div>

        <!-- CARD -->
        <div class="detail-container panel panel-body">
            <h1 class="detail-title">
                {{ artikel.title }}
            </h1>

            <!-- jika ada video -->
            <div v-if="artikel.video" class="video-container">
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
/* PAGE */
.detail-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #cfe7ff, #e9f4ff);
    padding: 40px 16px 60px;
}

/* BACK BUTTON */
.btn-back {
    margin: 0 auto 20px;
    max-width: 800px;
}

.btn-back a {
    text-decoration: none;
    background: #f1f1f1;
    padding: 8px 18px;
    border-radius: 999px;
    font-weight: 600;
    color: #333;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
}

/* CONTAINER */
.detail-container {
    max-width: 800px;
    margin: auto;
    background: #fff;
    padding: 35px;
    border-radius: 14px;
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
}
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}

.video-container iframe {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
}

/* TITLE */
.detail-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #222;
    line-height: 1.4;
}

/* IMAGE */
.detail-image {
    width: 100%;
    height: auto;
    max-height: 380px;
    object-fit: contain; /* supaya tidak terpotong */
    border-radius: 10px;
    margin-bottom: 20px;
    background: white;
}

/* CONTENT */
.detail-content {
    font-size: 16px;
    line-height: 1.8;
    color: #444;
    text-align: justify;
}

/* RESPONSIVE */

@media (max-width: 768px) {
    .detail-container {
        padding: 25px;
    }

    .detail-title {
        font-size: 22px;
    }

    .detail-content {
        font-size: 15px;
    }

    .detail-image {
        max-height: 260px;
    }
}

/* RESPONSIVE */

@media (max-width: 768px) {
    .detail-title {
        font-size: 26px;
    }

    .detail-container {
        padding: 25px;
    }

    .detail-content {
        font-size: 15px;
    }
}
</style>
