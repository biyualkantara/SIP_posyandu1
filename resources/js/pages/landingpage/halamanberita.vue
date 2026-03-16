<template>
  <NavbarLanding />

  <HeroLanding />

  <AdminLayout>
    <!-- Background dengan efek overlay pattern (sama seperti hero dan daftar posyandu) -->
    <div class="page-background">
      <img
        src="/storage/landing_page/bg-landing-page.png"
        class="background-img"
        alt="Background"
      />
      <div class="background-overlay"></div>
    </div>

    <div class="esip-news-page">
      <div class="content-inner">
        <!-- Header dengan judul -->
        <div class="page-header">
          <h2 class="news-heading">Berita Utama</h2>
        </div>

        <!-- Grid Berita -->
        <div v-if="berita.length > 0" class="news-grid">
          <div
            v-for="item in top3"
            :key="item.id_berita"
            class="news-card"
          >
            <div class="news-image">
              <!-- Jika ada gambar, tampilkan -->
              <img v-if="item.gambar" :src="`/storage/${item.gambar}`" :alt="item.judul" />
              <div v-else class="image-placeholder">
                <span>📰</span>
              </div>
            </div>

            <div class="news-content">
              <!-- Judul -->
              <h3 class="news-title">{{ item.judul }}</h3>

              <!-- Meta info -->
              <div class="news-meta">
                <span class="news-author">
                  <i class="icon-user"></i> {{ item.penulis }}
                </span>
                <span class="news-date">
                  <i class="icon-calendar"></i> {{ formatDate(item.tanggal_waktu) }}
                </span>
              </div>

              <!-- Ringkasan -->
              <div class="news-summary">
                {{ truncateText(item.ringkasan, 100) }}
              </div>

              <!-- Tombol Baca Selengkapnya -->
              <Link :href="`/berita-detail/${item.id_berita}`" class="read-more-btn">
                Baca Selengkapnya
                <span class="arrow">→</span>
              </Link>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="empty-state">
          <div class="empty-icon">📰</div>
          <h3 class="empty-title">Belum Ada Berita</h3>
          <p class="empty-description">Belum ada berita yang tersedia.</p>
        </div>

        <!-- Tombol Lihat Semua Berita -->
        <div class="view-all-container">
          <Link href="/halamanberita" class="view-all-btn">
            Lihat semua berita
            <span class="arrow">→</span>
          </Link>
        </div>
      </div>
      
      <Kontakesip />
      <AppFooterImpl />
    </div>
  </AdminLayout>
</template>

<script setup>
import { onMounted, onBeforeUnmount, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import NavbarLanding from "../../components/SIPVue/NavbarLanding.vue";
import AppFooterImpl from "@/layouts/AppFooterImpl.vue";

const props = defineProps({
  berita: { type: Array, default: () => [] },
});

const berita = computed(() => props.berita || []);
const top3 = computed(() => berita.value.slice(0, 3));

// Format tanggal
function formatDate(dt) {
  if (!dt) return "";
  const d = new Date(dt);
  if (isNaN(d.getTime())) return String(dt);
  return d.toLocaleDateString("id-ID", { 
    day: "2-digit", 
    month: "long", 
    year: "numeric" 
  });
}

// Truncate teks
function truncateText(text, maxLength) {
  if (!text) return "";
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + "...";
}

onMounted(() => document.body.classList.add("esip-news-body"));
onBeforeUnmount(() => document.body.classList.remove("esip-news-body"));
</script>

<style scoped>
/* =========================
   VARIABEL WARNA (SAMA DENGAN DAFTAR POSYANDU)
   ========================= */
:global(:root){
  --primary-soft: #e3f2fd;
  --primary-light: #bbdefb;
  --primary-main: #2196f3;
  --primary-dark: #1976d2;
  --accent-soft: #fff3e0;
  --accent-main: #ff9800;
  --shadow-sm: 0 4px 12px rgba(33, 150, 243, 0.08);
  --shadow-md: 0 8px 24px rgba(33, 150, 243, 0.12);
  --shadow-lg: 0 16px 32px rgba(33, 150, 243, 0.16);
  --radius-md: 20px;
  --radius-lg: 28px;
}

/* =========================
   LIMITLESS OVERRIDE
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
   BACKGROUND SAMA SEPERTI HERO DAN DAFTAR POSYANDU
   ========================= */
.page-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;
}

.background-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.25;
}

.background-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("/storage/tentangesip_page/background_biru.png");
  background-repeat: repeat;
  background-size: 300px;
  background-position: center;
  opacity: 0.15;
  pointer-events: none;
}

/* =========================
   PAGE WRAP
   ========================= */
.esip-news-page {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  padding: 34px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate;
  position: relative;
  background: transparent; /* Background transparan karena sudah ada page-background */
}

.content-inner {
  flex: 1;
  width: min(1200px, 100%);
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
  z-index: 2;
}

/* =========================
   PAGE HEADER
   ========================= */
.page-header {
  text-align: center;
  margin-bottom: 30px;
}

.news-heading {
  color: var(--primary-dark);
  font-size: 32px;
  font-weight: 700;
  padding-top: 50px;
  margin: 10px 0 10px;
  text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
}

/* =========================
   NEWS GRID
   ========================= */
.news-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
  margin-bottom: 40px;
}

/* =========================
   NEWS CARD dengan efek glassmorphism
   ========================= */
.news-card {
  border-radius: var(--radius-lg);
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.5);
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: var(--shadow-md);
}

.news-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
  border-color: rgba(255, 255, 255, 0.8);
  background: rgba(255, 255, 255, 0.95);
}

.news-image {
  width: 100%;
  height: 200px;
  overflow: hidden;
  position: relative;
}

.news-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.news-card:hover .news-image img {
  transform: scale(1.05);
}

.image-placeholder {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(230, 230, 230, 0.5) 0%, rgba(244, 244, 244, 0.5) 100%);
  backdrop-filter: blur(5px);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 48px;
}

.news-content {
  padding: 20px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.news-title {
  color: #1e293b;
  font-size: 18px;
  font-weight: 700;
  margin: 0 0 12px;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.news-meta {
  display: flex;
  gap: 15px;
  margin-bottom: 12px;
  font-size: 13px;
  color: #64748b;
  flex-wrap: wrap;
}

.news-author, .news-date {
  display: flex;
  align-items: center;
  gap: 5px;
}

.news-author i, .news-date i {
  font-size: 14px;
  color: var(--primary-light);
}

.news-summary {
  color: #475569;
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 16px;
  flex: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.read-more-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  background: var(--primary-main);
  color: white;
  text-decoration: none;
  border-radius: 25px;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
  align-self: flex-start;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.read-more-btn:hover {
  background: var(--primary-dark);
  transform: translateX(5px) translateY(-2px);
  box-shadow: var(--shadow-sm);
}

.arrow {
  font-size: 16px;
  transition: transform 0.2s;
}

.read-more-btn:hover .arrow {
  transform: translateX(3px);
}

/* =========================
   VIEW ALL BUTTON
   ========================= */
.view-all-container {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  margin-bottom: 40px;
}

.view-all-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 12px 30px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  color: var(--primary-dark);
  text-decoration: none;
  border-radius: 40px;
  box-shadow: var(--shadow-sm);
  font-size: 14px;
  font-weight: 600;
  transition: all 0.2s ease;
  border: 1px solid rgba(255, 255, 255, 0.5);
}

.view-all-btn:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-2px);
  background: rgba(255, 255, 255, 0.95);
  border-color: rgba(255, 255, 255, 0.8);
}

.view-all-btn .arrow {
  font-size: 16px;
}

/* =========================
   EMPTY STATE
   ========================= */
.empty-state {
  text-align: center;
  padding: 60px 20px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border-radius: var(--radius-lg);
  margin: 40px 0;
  box-shadow: var(--shadow-md);
  border: 1px solid rgba(255, 255, 255, 0.5);
}

.empty-icon {
  font-size: 64px;
  margin-bottom: 20px;
  opacity: 0.5;
}

.empty-title {
  font-size: 20px;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 10px;
}

.empty-description {
  color: #64748b;
  margin-bottom: 20px;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
  .news-heading {
    font-size: 28px;
    padding-top: 30px;
  }
  
  .news-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .view-all-container {
    margin-top: 20px;
  }
  
  .view-all-btn {
    padding: 10px 24px;
    font-size: 13px;
  }
}

@media (max-width: 768px) {
  .news-grid {
    grid-template-columns: 1fr;
  }
  
  .news-meta {
    flex-direction: column;
    gap: 5px;
  }
}

@media (max-width: 576px) {
  .news-heading {
    font-size: 24px;
  }
  
  .content-inner {
    padding: 0 15px;
  }
  
  .news-card {
    border-radius: 20px;
  }
  
  .news-image {
    height: 180px;
  }
  
  .news-content {
    padding: 16px;
  }
  
  .news-title {
    font-size: 16px;
  }
}
</style>