<template>
  <NavbarLanding />

  <HeroLanding />

  <AdminLayout>
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
   PAGE WRAP + BACKGROUND DENGAN VARIASI BIRU
   ========================= */
.esip-news-page {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  padding: 34px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate;
  position: relative;
  background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
}

.esip-news-page::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: 0;
  background-image: url("/storage/tentangesip_page/background_biru.png");
  background-repeat: repeat;
  background-size: 300px;
  background-position: center;
  opacity: 0.15;
  mix-blend-mode: overlay;
  pointer-events: none;
}

.content-inner {
  flex: 1;
  width: min(1200px, 100%);
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
  z-index: 1;
}

/* =========================
   PAGE HEADER
   ========================= */
.page-header {
  text-align: center;
  margin-bottom: 30px;
}

.news-heading {
  font-size: 48px;
  font-weight: 800;
  margin: 50px 0 20px;
  background: linear-gradient(135deg, #0a4c7a, #2c7fb8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 3px 3px 6px rgba(255, 255, 255, 0.5);
  position: relative;
  padding-bottom: 15px;
  display: inline-block;
}

.news-heading::after {
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
   NEWS CARD dengan efek kaca
   ========================= */
.news-card {
  border-radius: 24px;
  overflow: hidden;
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.4);
}

.news-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 20px 20px 40px rgba(0, 40, 80, 0.25);
  background: rgba(255, 255, 255, 0.9);
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
  background: linear-gradient(145deg, rgba(212, 232, 255, 0.5), rgba(175, 212, 240, 0.5));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 48px;
}

.news-content {
  padding: 25px;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.news-title {
  color: #0a3b5c;
  font-size: 20px;
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
  color: #1e405b;
  flex-wrap: wrap;
}

.news-author, .news-date {
  display: flex;
  align-items: center;
  gap: 5px;
}

.news-author i, .news-date i {
  font-size: 14px;
  color: #0a4c7a;
}

.news-summary {
  color: #1e405b;
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 20px;
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
  padding: 10px 20px;
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  text-decoration: none;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
  align-self: flex-start;
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.2);
}

.read-more-btn:hover {
  background: linear-gradient(145deg, #0d5588, #2b74a5);
  transform: translateX(5px);
  box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.3);
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
  margin-top: 30px;
  margin-bottom: 50px;
}

.view-all-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 15px 40px;
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  text-decoration: none;
  border-radius: 50px;
  font-size: 18px;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.25);
}

.view-all-btn:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 20px 20px 40px rgba(0, 40, 80, 0.35);
  background: linear-gradient(145deg, #0d5588, #2b74a5);
}

.view-all-btn .arrow {
  font-size: 20px;
}

/* =========================
   EMPTY STATE
   ========================= */
.empty-state {
  text-align: center;
  padding: 60px 20px;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  border-radius: 30px;
  margin: 40px 0;
  box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.4);
}

.empty-icon {
  font-size: 64px;
  margin-bottom: 20px;
  opacity: 0.7;
}

.empty-title {
  font-size: 24px;
  font-weight: 700;
  color: #0a3b5c;
  margin-bottom: 10px;
}

.empty-description {
  color: #1e405b;
  margin-bottom: 20px;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
  .news-heading {
    font-size: 42px;
    margin: 40px 0 20px;
  }
  
  .news-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .view-all-btn {
    padding: 12px 30px;
    font-size: 16px;
  }
}

@media (max-width: 768px) {
  .news-grid {
    grid-template-columns: 1fr;
  }
  
  .news-heading {
    font-size: 36px;
  }
  
  .news-meta {
    flex-direction: column;
    gap: 5px;
  }
  
  .news-content {
    padding: 20px;
  }
}

@media (max-width: 576px) {
  .news-heading {
    font-size: 28px;
  }
  
  .content-inner {
    padding: 0 15px;
  }
  
  .view-all-btn {
    padding: 10px 25px;
    font-size: 15px;
  }
}
</style>