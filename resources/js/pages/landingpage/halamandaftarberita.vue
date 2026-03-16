<template>
  <NavbarLanding />
  
  <AdminLayout>
    <div class="esip-news-page">
      <div class="content-inner">
        <div class="page-header">
          <div class="back-button-container">
            <Link href="/berita-posyandu" class="back-button">
              <span class="back-arrow">←</span>
              <span>Kembali</span>
            </Link>
          </div>
          <h2 class="news-heading">Semua Berita</h2>
        </div>

        <!-- Search Bar -->
        <div class="search-container">  
          <div class="search-wrapper">
            <input 
              type="text" 
              v-model="searchQuery" 
              placeholder="Cari judul atau penulis berita..." 
              class="search-input"
              @input="filterBerita"
            />
            <span class="search-icon">🔍</span>
          </div>
        </div>

        <!-- Info jumlah berita -->
        <div class="news-info">
          Menampilkan {{ filteredBerita.length }} dari {{ berita.length }} berita
        </div>

        <!-- Grid Berita -->
        <div v-if="filteredBerita.length > 0" class="news-grid">
          <div
            v-for="item in filteredBerita"
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
                {{ truncateText(item.ringkasan, 150) }}
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
          <h3 class="empty-title">Tidak Ada Berita</h3>
          <p class="empty-description">Belum ada berita yang ditemukan dengan kata kunci "{{ searchQuery }}"</p>
          <button @click="resetSearch" class="reset-btn">Reset Pencarian</button>
        </div>

        <!-- Back to Top Button -->
        <button 
          v-show="showBackToTop" 
          @click="scrollToTop" 
          class="back-to-top"
          title="Kembali ke atas"
        >
          ↑
        </button>
      </div>

      <!-- Footer -->
      <AppFooterImpl />
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";
import NavbarLanding from "../../components/SIPVue/NavbarLanding.vue";
import AppFooterImpl from "@/layouts/AppFooterImpl.vue";

const props = defineProps({
  berita: { type: Array, default: () => [] },
});

// State untuk pencarian
const searchQuery = ref("");
const filteredBerita = ref([]);

// State untuk back to top
const showBackToTop = ref(false);

// Filter berita berdasarkan pencarian
const filterBerita = () => {
  const query = searchQuery.value.toLowerCase().trim();
  
  if (query === "") {
    filteredBerita.value = props.berita;
  } else {
    filteredBerita.value = props.berita.filter(item => 
      item.judul.toLowerCase().includes(query) ||
      item.penulis.toLowerCase().includes(query) ||
      (item.ringkasan && item.ringkasan.toLowerCase().includes(query))
    );
  }
};

// Reset pencarian
const resetSearch = () => {
  searchQuery.value = "";
  filterBerita();
};

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

// Handle scroll untuk back to top
const handleScroll = () => {
  showBackToTop.value = window.scrollY > 300;
};

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
};

onMounted(() => {
  document.body.classList.add("esip-news-body");
  window.addEventListener("scroll", handleScroll);
  
  // Inisialisasi filtered berita
  filterBerita();
});

onBeforeUnmount(() => {
  document.body.classList.remove("esip-news-body");
  window.removeEventListener("scroll", handleScroll);
});
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
  position: relative;
}

.back-button-container {
  position: absolute;
  left: 0;
  top: 60px;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  color: #0a4c7a;
  text-decoration: none;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 600;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.5);
  box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.1);
}

.back-button:hover {
  background: rgba(255, 255, 255, 0.95);
  transform: translateX(-5px);
  box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.2);
}

.back-arrow {
  font-size: 18px;
  line-height: 1;
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
   SEARCH BAR
   ========================= */
.search-container {
  max-width: 500px;
  margin: 0 auto 20px;
}

.search-wrapper {
  position: relative;
  width: 100%;
}

.search-input {
  width: 100%;
  height: 50px;
  padding: 0 20px 0 50px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 30px;
  font-size: 15px;
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  color: #0a3b5c;
}

.search-input:focus {
  outline: none;
  border-color: #0a4c7a;
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 0 0 3px rgba(10, 76, 122, 0.1);
}

.search-input::placeholder {
  color: #1e405b;
  opacity: 0.6;
}

.search-icon {
  position: absolute;
  left: 18px;
  top: 50%;
  transform: translateY(-50%);
  color: #0a4c7a;
  font-size: 18px;
  opacity: 0.7;
}

/* =========================
   NEWS INFO
   ========================= */
.news-info {
  text-align: right;
  color: #0a3b5c;
  font-size: 14px;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 2px solid rgba(255, 255, 255, 0.3);
  font-weight: 500;
}

/* =========================
   NEWS GRID
   ========================= */
.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
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
  max-width: 400px;
  margin-left: auto;
  margin-right: auto;
}

.reset-btn {
  padding: 12px 30px;
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.2);
}

.reset-btn:hover {
  background: linear-gradient(145deg, #0d5588, #2b74a5);
  transform: translateY(-3px);
  box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.3);
}

/* =========================
   BACK TO TOP BUTTON
   ========================= */
.back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 50px;
  height: 50px;
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  border: none;
  border-radius: 50%;
  font-size: 24px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  box-shadow: 5px 5px 15px rgba(0, 40, 80, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.2);
  z-index: 1000;
}

.back-to-top:hover {
  background: linear-gradient(145deg, #0d5588, #2b74a5);
  transform: translateY(-5px);
  box-shadow: 8px 8px 20px rgba(0, 40, 80, 0.4);
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
  
  .back-button-container {
    position: static;
    margin-bottom: 20px;
    text-align: left;
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
  
  .search-container {
    max-width: 100%;
  }
  
  .back-to-top {
    bottom: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    font-size: 20px;
  }
}

@media (max-width: 576px) {
  .news-heading {
    font-size: 28px;
  }
  
  .content-inner {
    padding: 0 15px;
  }
  
  .back-button {
    padding: 8px 16px;
    font-size: 13px;
  }
  
  .news-info {
    font-size: 13px;
  }
}
</style>