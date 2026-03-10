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
   PAGE WRAP + BACKGROUND
   ========================= */
.esip-news-page {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  padding: 34px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate;
  position: relative;
}

.esip-news-page::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  background-image: url("/storage/tentangesip_page/bg-kotak-kotak.png");
  background-repeat: repeat;
  background-size: auto;
  background-position: center -12px;
}

.content-inner {
  flex: 1;
  width: min(1200px, 100%);
  margin: 0 auto;
  padding: 0 20px;
}

/* =========================
   PAGE HEADER
   ========================= */
.page-header {
  text-align: center;
  margin-bottom: 30px;
}

.news-heading {
  color: #00a6d6;
  font-size: 32px;
  font-weight: 700;
  padding-top: 50px;
  margin: 10px 0 10px;
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
   NEWS CARD (sama seperti halamandaftarberita)
   ========================= */
.news-card {
  border-radius: 12px;
  overflow: hidden;
  border: 0;
  transition: all 0.3s ease;
  background: white;
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.news-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
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
  background: linear-gradient(135deg, #e6e6e6 0%, #f4f4f4 100%);
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
  color: #333;
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
  color: #666;
  flex-wrap: wrap;
}

.news-author, .news-date {
  display: flex;
  align-items: center;
  gap: 5px;
}

.news-author i, .news-date i {
  font-size: 14px;
  color: #999;
}

.news-summary {
  color: #555;
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
  background: #00a6d6;
  color: white;
  text-decoration: none;
  border-radius: 25px;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
  align-self: flex-start;
}

.read-more-btn:hover {
  background: #008bb5;
  transform: translateX(5px);
  box-shadow: 0 5px 15px rgba(0, 166, 214, 0.3);
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
  background: #f8f9fa;
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
  background: white;
  border-radius: 16px;
  margin: 40px 0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.empty-icon {
  font-size: 64px;
  margin-bottom: 20px;
  opacity: 0.5;
}

.empty-title {
  font-size: 20px;
  font-weight: 600;
  color: #333;
  margin-bottom: 10px;
}

.empty-description {
  color: #666;
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
}
</style>