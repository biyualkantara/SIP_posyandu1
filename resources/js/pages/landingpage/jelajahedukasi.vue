<template>
 <PublicLayout>
    <div class="esip-edukasi-page">
      <!-- BACK BUTTON -->
      <div class="btn-back">
        <a href="javascript:void(0)" @click.prevent="goBack">← Kembali</a>
      </div>

      <!-- HEADER -->
      <header class="judul-section text-center">
        <h1 class="judul-page">Edukasi Kesehatan Ibu dan Anak</h1>
        <p class="subjudul">
          Temukan panduan kesehatan, gizi, dan tumbuh kembang anak dari Posyandu Kota Cimahi
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
        <button type="button" @click="/* auto reactive */ null">🔍</button>
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
              'badge-berita': item.type === 'berita'
            }"
          >
            {{ labelType(item.type) }}
          </span>

          <h3>{{ item.title }}</h3>

          <img :src="item.img" :alt="item.title" />

          <a :href="item.href" class="btn-aksi">
            {{ ctaText(item.type) }}
          </a>
        </div>

        <!-- empty state -->
        <div v-if="filteredItems.length === 0" class="empty panel panel-body">
          Tidak ada hasil untuk “{{ keyword }}”
        </div>
      </section>

      <!-- WA BOX -->
      <div class="wa-box panel panel-body">
        <p class="wa-text">Ingin tahu informasi terbaru dari Posyandu Kota Cimahi?</p>
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
import { computed, ref, onMounted, onBeforeUnmount } from "vue";

const keyword = ref("");
const activeFilter = ref("all");

/* dummy data (tinggal ganti dari API nanti) */
const items = ref([
  {
    id: 1,
    title: "Pentingnya Imunisasi Dasar Untuk Anak",
    searchTitle: "imunisasi anak",
    type: "artikel",
    img: "/assets/periksa.png",
    href: "#",
  },
  {
    id: 2,
    title: "Rekomendasi Menu untuk MP-ASI",
    searchTitle: "mpasi menu",
    type: "berita",
    img: "/assets/makanan.png",
    href: "#",
  },
  {
    id: 3,
    title: "Cara memberikan MP-ASI Pertama kali",
    searchTitle: "cara mpasi video",
    type: "video",
    img: "/assets/bayi.png",
    href: "#",
  },
  {
    id: 4,
    title: "Cegah stunting dengan pola makan seimbang",
    searchTitle: "stunting pola makan",
    type: "video",
    img: "/assets/makanan.png",
    href: "#",
  },
  {
    id: 5,
    title: "Panduan Pencegahan Stunting Anak usia 0 sampai 5 tahun",
    searchTitle: "panduan stunting anak",
    type: "artikel",
    img: "/assets/imunisasi.png",
    href: "#",
  },
  {
    id: 6,
    title: "Pencegahan Stunting pada Ibu Hamil untuk Janin",
    searchTitle: "pencegahan stunting ibu hamil",
    type: "artikel",
    img: "/assets/bumil.png",
    href: "#",
  },
]);

const filteredItems = computed(() => {
  const k = keyword.value.toLowerCase().trim();
  return items.value.filter((it) => {
    const matchText =
      !k ||
      it.title.toLowerCase().includes(k) ||
      (it.searchTitle || "").toLowerCase().includes(k);

    const matchType =
      activeFilter.value === "all" || it.type === activeFilter.value;

    return matchText && matchType;
  });
});

function labelType(t) {
  if (t === "artikel") return "Artikel";
  if (t === "video") return "Video";
  return "Berita";
}

function ctaText(t) {
  if (t === "artikel") return "Baca Artikel";
  if (t === "video") return "Lihat Video";
  return "Lihat Berita";
}

function goBack() {
  window.history.back();
}

/* optional: biar style Limitless page lain aman */
onMounted(() => document.body.classList.add("esip-edukasi-body"));
onBeforeUnmount(() => document.body.classList.remove("esip-edukasi-body"));
</script>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE (aman)
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
   PAGE BASE (tetap mirip)
   ========================= */
.esip-edukasi-page {
  min-height: 100vh;
  background: #bdd7ec;
  padding: 18px 0 60px;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

/* back */
.btn-back {
  margin: 18px 25px;
}
.btn-back a {
  font-size: 14px;
  text-decoration: none;
  background: #f1f1f1;
  padding: 7px 18px;
  border-radius: 999px;
  color: #3d3d3d;
  font-weight: 700;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.14); /* Limitless feel */
  border: 1px solid rgba(0, 0, 0, 0.06);
}

/* title */
.judul-section {
  padding: 8px 16px 0;
}
.judul-page {
  font-size: 44px;
  font-weight: 900;
  text-shadow: 3px 4px rgba(0, 0, 0, 0.25);
  margin: 0;
}
.subjudul {
  font-size: 18px;
  margin-top: 6px;
  font-weight: 600;
  color: rgba(0, 0, 0, 0.72);
}

/* search */
.search-container {
  display: flex;
  justify-content: center;
  margin: 20px auto;
  gap: 12px;
  padding: 0 16px;
}
.search-container input {
  width: min(420px, 100%);
  padding: 12px 14px;
  border-radius: 10px;
  border: 1px solid rgba(0, 0, 0, 0.08);
  outline: none;
  background: #fff;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}
.search-container input:focus {
  border-color: rgba(140, 154, 210, 0.9);
  box-shadow: 0 0 0 3px rgba(140, 154, 210, 0.22), 0 8px 16px rgba(0, 0, 0, 0.12);
}
.search-container button {
  padding: 12px 16px;
  border-radius: 10px;
  background: #f8e889;
  border: 1px solid rgba(0, 0, 0, 0.08);
  font-weight: 900;
  cursor: pointer;
  box-shadow: 0 10px 18px rgba(0, 0, 0, 0.16);
  font-size: 14px;
}

/* kategori */
.kategori-wrapper {
  display: flex;
  justify-content: center;
  gap: 18px;
  margin-top: 16px;
  flex-wrap: wrap;
  padding: 0 16px;
}
.btn-kategori {
  background: #f9e88a;
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 900;
  font-size: 15px;
  box-shadow: 0 10px 18px rgba(0, 0, 0, 0.14);
  text-decoration: none;
  color: #3f3f3f;
  border: 1px solid rgba(0, 0, 0, 0.06);
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.btn-kategori:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 22px rgba(0, 0, 0, 0.18);
}
.btn-kategori.active {
  background: #ffe15b;
  outline: 2px solid rgba(0, 0, 0, 0.08);
}

/* grid cards */
.konten-edukasi {
  width: min(1200px, 100%);
  margin: 30px auto;
  padding: 0 16px;

  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 26px;
}

/* card: Limitless panel feel */
.card-edukasi {
  background: #fff;
  border-radius: 12px;
  padding: 22px;
  box-shadow: 0 12px 26px rgba(0, 0, 0, 0.16);
  border: 1px solid rgba(0, 0, 0, 0.06);

  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  text-align: center;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-edukasi:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 34px rgba(0, 0, 0, 0.20);
}

.card-edukasi h3 {
  font-size: 16px;
  font-weight: 900;
  color: #222;
  margin: 4px 0 6px;
  line-height: 1.35;
}

.card-edukasi img {
  width: 80%;
  height: 140px;
  object-fit: contain;
}

/* badge */
.badge {
  font-size: 12px;
  padding: 6px 12px;
  border-radius: 10px;
  font-weight: 900;
  color: #fff;
  align-self: flex-start;
}
.badge-video {
  background: #ff6c4e;
}
.badge-artikel {
  background: #3a8be7;
}
.badge-berita {
  background: #2fb430;
}

/* button aksi */
.btn-aksi {
  width: 100%;
  text-align: center;
  background: #f8e889;
  padding: 10px 18px;
  border-radius: 10px;
  text-decoration: none;
  color: #3f3f3f;
  font-weight: 900;
  border: 1px solid rgba(0, 0, 0, 0.06);
  box-shadow: 0 10px 18px rgba(0, 0, 0, 0.14);
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.btn-aksi:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 22px rgba(0, 0, 0, 0.18);
}

/* empty */
.empty {
  grid-column: 1 / -1;
  text-align: center;
  font-weight: 800;
  color: rgba(0, 0, 0, 0.65);
  border-radius: 12px;
  padding: 18px;
  background: #fff;
  box-shadow: 0 12px 26px rgba(0, 0, 0, 0.16);
  border: 1px solid rgba(0, 0, 0, 0.06);
}

/* WA box */
.wa-box {
  width: min(1200px, 100%);
  margin: 38px auto 0;
  padding: 18px 22px;
  border-radius: 12px;
  background: #f0b87a;
  font-weight: 700;

  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;

  box-shadow: 0 12px 26px rgba(0, 0, 0, 0.16);
  border: 1px solid rgba(0, 0, 0, 0.06);
}
.wa-text {
  margin: 0;
}
.btn-wa {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: #25d366;
  padding: 10px 18px;
  border-radius: 999px;
  text-decoration: none;
  color: #fff;
  font-weight: 900;
  transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
  box-shadow: 0 10px 18px rgba(0, 0, 0, 0.16);
}
.btn-wa:hover {
  transform: translateY(-2px);
  box-shadow: 0 14px 22px rgba(0, 0, 0, 0.18);
}

/* responsive */
@media (max-width: 992px) {
  .konten-edukasi {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
  .judul-page {
    font-size: 34px;
  }
}

@media (max-width: 600px) {
  .konten-edukasi {
    grid-template-columns: 1fr;
  }
  .judul-page {
    font-size: 28px;
  }
  .subjudul {
    font-size: 14px;
  }
  .wa-box {
    flex-direction: column;
    text-align: center;
  }
}
</style>