<template>
  <NavbarLanding />

  <HeroLanding />

  <AdminLayout>
    <div class="esip-news-page">
      <div class="content-inner">
        <h2 class="news-heading">Berita Utama</h2>

        <div class="news-grid">
          <!-- CARD dari DATABASE -->
          <div
            v-for="item in top3"
            :key="item.id_berita"
            class="news-card panel panel-body"
          >
            <div class="news-image"></div>

            <div class="news-content">
              <!-- Judul -->
              <div class="news-category">{{ item.judul }}</div>

              <!-- Nama penulis + tanggal -->
              <h3 class="news-title">{{ item.penulis }}, {{ formatDate(item.tanggal_waktu) }}</h3>

              <!-- Isi berita: ringkasan -->
              <div class="news-date">{{ item.ringkasan }}</div>

              <a :href="`/berita/${item.id_berita}`" class="view-detail" aria-label="Lihat detail"></a>
            </div>
          </div>

          <!-- Kalau belum ada berita -->
          <div v-if="berita.length === 0" class="panel panel-body">
            Belum ada berita.
          </div>
        </div>

        <div class="view-all-container">
          <a href="/halamanberita" class="view-all-btn">Lihat semua berita</a>
        </div>
      </div>
    </div>
  </AdminLayout>

  <Kontakesip />
  <AppFooterImpl />
</template>

<script setup>
import { onMounted, onBeforeUnmount, computed } from "vue";
import NavbarLanding from "../../components/SIPVue/NavbarLanding.vue";
import AppFooterImpl from "@/layouts/AppFooterImpl.vue";

/**
 * Ambil berita dari DB via Inertia props
 * (tidak perlu import axios/fetch)
 */
const props = defineProps({
  berita: { type: Array, default: () => [] },
});

const berita = computed(() => props.berita || []);
const top3 = computed(() => berita.value.slice(0, 3));

function formatDate(dt) {
  if (!dt) return "";
  const d = new Date(dt);
  // kalau format dt dari DB aneh, minimal tetap tampil string mentah
  if (isNaN(d.getTime())) return String(dt);
  return d.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" });
}

onMounted(() => document.body.classList.add("esip-news-body"));
onBeforeUnmount(() => document.body.classList.remove("esip-news-body"));
</script>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE (khusus page berita)
   ========================= */
:global(body.esip-news-body .content) {
  padding: 0 !important;
}

:global(body.esip-news-body .page-container),
:global(body.esip-news-body .page-content),
:global(body.esip-news-body .content-wrapper),
:global(body.esip-news-body .content) {
  background: transparent !important;
  background-image: none !important;
}

/* =========================
   PAGE WRAP + BACKGROUND (AMAN, KHUSUS HALAMAN INI)
   ========================= */
.esip-news-page {
  position: relative;
  min-height: 100vh;
  padding: 34px 0 60px;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate; /* biar z-index layer aman */
}

/* background ikut scroll (bukan fixed) dan gak bocor */
.esip-news-page::before {
  content: "";
  position: absolute; /* ✅ ikut scroll */
  inset: 0;
  z-index: -1;

  background-image: url("/storage/tentangesip_page/bg-kotak-kotak.png");
  background-repeat: repeat;
  background-size: auto;
  background-position: center -12px;
}

/* konten di atas background */
.content-inner {
  position: relative;
  z-index: 1;

  width: min(1200px, 100%);
  margin: 0 auto;
  padding: 0 20px;
}

/* =========================
   HEADING
   ========================= */
.news-heading {
  text-align: center;
  color: #00a6d6;
  font-size: 32px;
  font-weight: 700;
  margin: 10px 0 30px;
}

/* =========================
   GRID
   ========================= */
.news-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 22px;
}

/* =========================
   CARD (Limitless feel)
   ========================= */
.news-card {
  border-radius: 8px;
  overflow: hidden;
  border: 0;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.news-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}

.news-image {
  width: 100%;
  height: 200px;
  background: linear-gradient(135deg, #e6e6e6 0%, #f4f4f4 100%);
}

.news-content {
  padding-top: 16px;
}

/* teks */
.news-category {
  color: #999;
  font-size: 12px;
  text-transform: uppercase;
  margin-bottom: 8px;
  letter-spacing: 0.5px;
}

.news-title {
  color: #333;
  font-size: 16px;
  font-weight: 700;
  margin: 0 0 8px;
  line-height: 1.4;
}

.news-date {
  color: #999;
  font-size: 12px;
  margin-bottom: 14px;
}

/* tombol detail bulat */
.view-detail {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 34px;
  height: 34px;
  border: 2px solid #333;
  border-radius: 50%;
  background: #fff;
  text-decoration: none;
  transition: all 0.2s ease;
}

.view-detail::after {
  content: "→";
  font-size: 18px;
  font-weight: 900;
  color: #333;
}

.view-detail:hover {
  background: #333;
  transform: scale(1.06);
}

.view-detail:hover::after {
  color: #fff;
}

/* =========================
   BUTTON LIHAT SEMUA
   ========================= */
.view-all-container {
  display: flex;
  justify-content: center;
  margin-top: 26px;
}

.view-all-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 12px 30px;
  background: #fff;
  color: #333;
  text-decoration: none;
  border-radius: 25px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  font-size: 14px;
  font-weight: 600;
  transition: all 0.2s ease;
}

.view-all-btn:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

.view-all-btn::after {
  content: "→";
  font-size: 16px;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
  .news-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
  .news-heading {
    font-size: 26px;
  }
}

@media (max-width: 576px) {
  .news-grid {
    grid-template-columns: 1fr;
  }
}
</style>