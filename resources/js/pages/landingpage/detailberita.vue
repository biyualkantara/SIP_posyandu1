<template>
  <NavbarLanding />
  
  <AdminLayout>
    <div class="esip-news-detail-page">
      <div class="content-inner">
        <!-- Header dengan button back (style sama seperti halamandaftarberita) -->
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
   LIMITLESS OVERRIDE (sama seperti halamandaftarberita)
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
   PAGE WRAP + BACKGROUND (sama seperti halamandaftarberita)
   ========================= */
.esip-news-detail-page {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  padding: 34px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate;
  position: relative;
}

.esip-news-detail-page::before {
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
  width: min(900px, 100%);
  margin: 0 auto;
  padding: 0 20px;
}

/* =========================
   PAGE HEADER (sama persis dengan halamandaftarberita)
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
  padding: 8px 16px;
  background: #f1f5f9;
  color: #475569;
  text-decoration: none;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 500;
  transition: all 0.3s ease;
  border: 1px solid #e2e8f0;
  cursor: pointer;
  font-family: inherit;
}

.btn-back:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateX(-3px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.back-arrow {
  font-size: 18px;
  line-height: 1;
}

.news-heading {
  color: #00a6d6;
  font-size: 32px;
  font-weight: 700;
  padding-top: 50px;
  margin: 10px 0 10px;
}

.detail-card {
  background: white;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-top: 20px;
}

.detail-title {
  font-size: 28px;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 15px;
  line-height: 1.3;
}

.detail-meta {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eef1f4;
  color: #64748b;
  font-size: 14px;
  flex-wrap: wrap;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 5px;
}

.meta-item i {
  color: #00a6d6;
}

.detail-ringkasan {
  margin-bottom: 25px;
  padding: 15px;
  background: #f8fafc;
  border-radius: 8px;
  border-left: 3px solid #00a6d6;
}

.detail-ringkasan strong {
  display: block;
  margin-bottom: 8px;
  color: #1e293b;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.ringkasan-text {
  color: #475569;
  line-height: 1.6;
  margin: 0;
}

.detail-content {
  margin-top: 20px;
}

.detail-content strong {
  display: block;
  margin-bottom: 15px;
  color: #1e293b;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.content-body {
  font-size: 16px;
  line-height: 1.8;
  color: #334155;
}

.content-body :deep(p) {
  margin-bottom: 20px;
}

.content-body :deep(h1),
.content-body :deep(h2),
.content-body :deep(h3),
.content-body :deep(h4) {
  margin-top: 25px;
  margin-bottom: 15px;
  color: #1e293b;
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
  border-left: 3px solid #00a6d6;
  padding: 10px 20px;
  margin: 20px 0;
  background: #f8fafc;
  font-style: italic;
  color: #475569;
}

.content-body :deep(a) {
  color: #00a6d6;
  text-decoration: none;
}

.content-body :deep(a:hover) {
  text-decoration: underline;
}

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

.reset-btn {
  display: inline-block;
  padding: 10px 30px;
  background: #f0f0f0;
  color: #333;
  border: none;
  border-radius: 25px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
}

.reset-btn:hover {
  background: #e0e0e0;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 50px;
  height: 50px;
  background: #00a6d6;
  color: white;
  border: none;
  border-radius: 50%;
  font-size: 24px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(0, 166, 214, 0.3);
  z-index: 1000;
}

.back-to-top:hover {
  background: #008bb5;
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 166, 214, 0.4);
}

@media (max-width: 992px) {
  .news-heading {
    font-size: 28px;
    padding-top: 30px;
  }
  
  .back-button-container {
    position: static;
    margin-bottom: 20px;
    text-align: left;
  }
  
  .detail-title {
    font-size: 24px;
  }
}

@media (max-width: 768px) {
  .content-inner {
    padding: 0 15px;
  }
  
  .detail-card {
    padding: 20px;
  }
  
  .detail-title {
    font-size: 22px;
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
}

@media (max-width: 576px) {
  .news-heading {
    font-size: 24px;
  }
  
  .detail-title {
    font-size: 20px;
  }
  
  .content-body {
    font-size: 14px;
  }
}
</style>