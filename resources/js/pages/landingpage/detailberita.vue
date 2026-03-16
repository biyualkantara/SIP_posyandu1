<template>
  <NavbarLanding />
  
  <AdminLayout>
    <div class="esip-news-detail-page">
      <div class="content-inner">
        <!-- Header dengan button back -->
        <div class="page-header">
          <div class="back-button-container">
            <button class="btn-back" @click="goBack">
              <span class="back-arrow">←</span>
              <span>Kembali</span>
            </button>
          </div>
          <h2 class="news-heading">Detail Berita</h2>
        </div>

        <!-- Detail Berita -->
        <div v-if="berita" class="detail-card">
          <!-- Judul Berita -->
          <h1 class="detail-title">{{ berita.judul }}</h1>

          <!-- Meta Info -->
          <div class="detail-meta">
            <span class="meta-item">
              <i class="icon-user"></i> {{ berita.penulis }}
            </span>
            <span class="meta-item">
              <i class="icon-calendar"></i> {{ formatDate(berita.tanggal_waktu) }}
            </span>
          </div>

          <!-- Ringkasan -->
          <div class="detail-ringkasan">
            <strong>Ringkasan:</strong>
            <p class="ringkasan-text">{{ berita.ringkasan }}</p>
          </div>

          <!-- Isi Berita -->
          <div class="detail-content">
            <strong>Isi Berita:</strong>
            <div class="content-body" v-html="berita.isi"></div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-else class="empty-state">
          <div class="empty-icon">📰</div>
          <h3 class="empty-title">Berita Tidak Ditemukan</h3>
          <p class="empty-description">Maaf, berita yang Anda cari tidak ditemukan.</p>
          <Link href="/halamanberita" class="reset-btn">
            Kembali ke Daftar Berita
          </Link>
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
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Link } from "@inertiajs/vue3";
import NavbarLanding from "../../components/SIPVue/NavbarLanding.vue";
import AppFooterImpl from "@/layouts/AppFooterImpl.vue";

const props = defineProps({
  berita: { type: Object, default: null },
});

const goBack = () => {
  window.history.back()
};

// State untuk back to top
const showBackToTop = ref(false);

// Format tanggal
function formatDate(dt) {
  if (!dt) return "";
  const d = new Date(dt);
  if (isNaN(d.getTime())) return String(dt);
  return d.toLocaleDateString("id-ID", { 
    day: "2-digit", 
    month: "long", 
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit"
  });
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
  document.body.classList.add("esip-news-detail-body");
  window.addEventListener("scroll", handleScroll);
});

onBeforeUnmount(() => {
  document.body.classList.remove("esip-news-detail-body");
  window.removeEventListener("scroll", handleScroll);
});
</script>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE
   ========================= */
:global(body.esip-news-detail-body .content) {
  padding: 0 !important;
}

:global(body.esip-news-detail-body .page-container),
:global(body.esip-news-detail-body .page-content),
:global(body.esip-news-detail-body .content-wrapper),
:global(body.esip-news-detail-body .content) {
  background: transparent !important;
  background-image: none !important;
}

/* =========================
   PAGE WRAP + BACKGROUND DENGAN VARIASI BIRU
   ========================= */
.esip-news-detail-page {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  padding: 34px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate;
  position: relative;
  background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
}

.esip-news-detail-page::before {
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
  width: min(900px, 100%);
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

.btn-back {
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
  cursor: pointer;
  font-family: inherit;
}

.btn-back:hover {
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
   DETAIL CARD
   ========================= */
.detail-card {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border-radius: 30px;
  padding: 40px;
  box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.2);
  border: 1px solid rgba(255, 255, 255, 0.4);
  margin-top: 20px;
  margin-bottom: 40px;
}

.detail-title {
  font-size: 32px;
  font-weight: 700;
  color: #0a3b5c;
  margin: 0 0 20px;
  line-height: 1.3;
  padding-bottom: 15px;
  border-bottom: 2px solid rgba(10, 76, 122, 0.2);
}

.detail-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 1px solid rgba(10, 76, 122, 0.1);
  color: #1e405b;
  font-size: 14px;
  flex-wrap: wrap;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 5px;
}

.meta-item i {
  color: #0a4c7a;
  font-size: 16px;
}

.detail-ringkasan {
  margin-bottom: 30px;
  padding: 20px;
  background: rgba(255, 255, 255, 0.5);
  border-radius: 16px;
  border-left: 4px solid #0a4c7a;
}

.detail-ringkasan strong {
  display: block;
  margin-bottom: 10px;
  color: #0a3b5c;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.ringkasan-text {
  color: #1e405b;
  line-height: 1.6;
  margin: 0;
  font-size: 15px;
}

.detail-content {
  margin-top: 20px;
}

.detail-content strong {
  display: block;
  margin-bottom: 15px;
  color: #0a3b5c;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.content-body {
  font-size: 16px;
  line-height: 1.8;
  color: #1e405b;
}

.content-body :deep(p) {
  margin-bottom: 20px;
}

.content-body :deep(h1),
.content-body :deep(h2),
.content-body :deep(h3),
.content-body :deep(h4) {
  color: #0a3b5c;
  margin-top: 25px;
  margin-bottom: 15px;
}

.content-body :deep(ul),
.content-body :deep(ol) {
  margin-bottom: 20px;
  padding-left: 25px;
}

.content-body :deep(li) {
  margin-bottom: 5px;
}

.content-body :deep(blockquote) {
  border-left: 4px solid #0a4c7a;
  padding: 15px 25px;
  margin: 20px 0;
  background: rgba(255, 255, 255, 0.5);
  border-radius: 8px;
  font-style: italic;
  color: #1e405b;
}

.content-body :deep(a) {
  color: #0a4c7a;
  text-decoration: none;
  font-weight: 500;
}

.content-body :deep(a:hover) {
  text-decoration: underline;
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
  margin-bottom: 25px;
}

.reset-btn {
  display: inline-block;
  padding: 12px 30px;
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
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
  
  .back-button-container {
    position: static;
    margin-bottom: 20px;
    text-align: left;
  }
  
  .detail-title {
    font-size: 28px;
  }
  
  .detail-card {
    padding: 30px;
  }
}

@media (max-width: 768px) {
  .content-inner {
    padding: 0 15px;
  }
  
  .detail-card {
    padding: 25px;
  }
  
  .detail-title {
    font-size: 24px;
  }
  
  .detail-meta {
    flex-direction: column;
    gap: 8px;
  }
  
  .back-to-top {
    bottom: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    font-size: 20px;
  }
  
  .detail-ringkasan {
    padding: 15px;
  }
}

@media (max-width: 576px) {
  .news-heading {
    font-size: 28px;
  }
  
  .detail-title {
    font-size: 22px;
  }
  
  .content-body {
    font-size: 14px;
  }
  
  .detail-card {
    padding: 20px;
  }
}
</style>