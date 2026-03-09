<template>
    <div class="dash-container">
      <div class="dashboard-wrapper">
        <!-- LEFT SECTION -->
        <section class="dashboard-left">
          <div class="dashboard-welcome">
            <div class="welcome-image-wrapper">
              <img src="/storage/dashboard/bayi.png" class="welcome-img" alt="Ibu dan Anak" />
            </div>

            <div class="welcome-text">
              <h1>Selamat Datang,<br />Admin eSIP!</h1>
              <p class="welcome-desc">
                Sistem Informasi Posyandu (SIP) membantu menghasilkan informasi yang akurat dan tepat waktu bagi pengelola Posyandu.
              </p>
              <p class="welcome-desc">
                Dengan data yang lengkap dan aktual, pembinaan Posyandu dapat berjalan lebih terarah demi peningkatan pelayanan ibu dan anak di masyarakat.
              </p>
            </div>
          </div>
        </section>

        <!-- RIGHT SECTION -->
        <aside class="dashboard-right">
          <!-- Stats Cards Grid -->
          <div class="stats-grid">
            <!-- Card Posyandu dengan Link -->
            <Link href="/posyandu/data-umum" class="dashboard-card stats-card">
              <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 2v20M17 5H9.5M17 12h-5M17 19h-5" stroke-linecap="round" />
                  <rect x="3" y="3" width="18" height="18" rx="2" />
                </svg>
              </div>
              <h3>Posyandu Aktif</h3>
              <div class="card-number">{{ jumlahPosyandu }}</div>
              <p class="card-sub">
                <span class="trend-badge" :class="{ 'trend-up': trendPersentase > 0, 'trend-down': trendPersentase < 0 }">
                  {{ trendPersentase > 0 ? '↑' : '↓' }} {{ Math.abs(trendPersentase) }}%
                </span>
                dari bulan lalu
              </p>
            </Link>

            <!-- Card Berita dengan Link -->
            <Link href="/berita" class="dashboard-card stats-card">
              <div class="card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" />
                  <rect x="2" y="3" width="20" height="18" rx="2" />
                </svg>
              </div>
              <h3>Total Berita</h3>
              <div class="card-number">{{ jumlahBerita }}</div>
              <p class="card-sub">
                <span v-if="trendBerita !== undefined" class="trend-badge" :class="{ 'trend-up': trendBerita > 0, 'trend-down': trendBerita < 0 }">
                  {{ trendBerita > 0 ? '↑' : '↓' }} {{ Math.abs(trendBerita) }}%
                </span>
                <span v-else class="trend-badge">📊</span>
                total publikasi
              </p>
            </Link>
          </div>

          <!-- Section Berita -->
          <div class="dashboard-berita">
            <div class="berita-header">
              <h3>Berita Terbaru</h3>
              <Link href="/berita" class="lihat-semua">
                Lihat semua →
              </Link>
            </div>
            
            <div class="berita-list">
              <div v-for="item in beritaTerbaru" :key="item.id" class="berita-item">
                <div class="berita-badge" :class="getBadgeClass(item.kategori)">
                  {{ item.kategori }}
                </div>
                <h4>{{ item.judul }}</h4>
                <div class="berita-meta">
                  <span class="penulis">{{ item.penulis }}</span>
                  <span class="tanggal">{{ item.tanggal }}</span>
                </div>
                <p class="berita-excerpt">{{ item.ringkasan }}</p>
              </div>

              <!-- Empty State -->
              <div v-if="beritaTerbaru.length === 0" class="berita-empty">
                <div class="empty-icon">📰</div>
                <p>Belum ada berita</p>
                <Link href="/berita/create" class="btn-tambah-berita">
                  + Tambah Berita
                </Link>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>
</template>

<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from "vue";

// Props dari controller
defineProps({
  jumlahPosyandu: {
    type: Number,
    default: 0
  },
  trendPersentase: {
    type: Number,
    default: 0
  },
  jumlahBerita: {  // Tambahkan ini
    type: Number,
    default: 0
  },
  trendBerita: {   // Tambahkan ini (opsional)
    type: Number,
    default: 0
  },
  beritaTerbaru: {
    type: Array,
    default: () => []
  }
})

// Fungsi untuk mendapatkan class badge berdasarkan kategori
const getBadgeClass = (kategori) => {
  switch(kategori?.toLowerCase()) {
    case 'penting':
      return 'badge-penting'
    case 'kegiatan':
      return 'badge-kegiatan'
    case 'kesehatan':
      return 'badge-kesehatan'
    default:
      return 'badge-info'
  }
}

onMounted(() => document.body.classList.add("esip-dashboard-page"));
onBeforeUnmount(() => document.body.classList.remove("esip-dashboard-page"));
</script>

<style scoped>
/* =========================
   PAGE OVERRIDE (Limitless)
========================= */
:global(body.esip-dashboard-page .content){
  padding: 0 !important;
}
:global(body.esip-dashboard-page .content-wrapper),
:global(body.esip-dashboard-page .content){
  background: #f8fafd !important;
}

:global(body.esip-dashboard-page),
:global(body.esip-dashboard-page .content),
:global(body.esip-dashboard-page .content-wrapper){
  overflow-x: hidden !important;
  overflow-y: auto !important;
  height: 100%;
}

:global(body.esip-dashboard-page *){
  box-sizing: border-box;
}

:global(.sidebar),
:global(.sidebar.sidebar-main),
:global(aside.sidebar){
  flex-shrink: 0 !important;
}

:global(body:not(.sidebar-xs) .sidebar-main){
  min-width: 260px;
}

:global(.main-content),
:global(.admin-content),
:global(.content-area),
:global(.admin-content .content-area){
  min-width: 0 !important;
  height: 100%;
  overflow-y: auto;
}

/* =========================
   TOKENS - Warna baru yang lebih segar
========================= */
:global(:root){
  --primary-soft: #e3f2fd;
  --primary-light: #bbdefb;
  --primary-main: #2196f3;
  --primary-dark: #1976d2;
  
  --accent-soft: #fff3e0;
  --accent-light: #ffe0b2;
  --accent-main: #ff9800;
  
  --success-soft: #e8f5e8;
  --success-light: #c8e6c9;
  --success-main: #4caf50;
  
  --danger-soft: #fee2e2;
  --danger-light: #fecaca;
  --danger-main: #dc2626;
  
  --info-soft: #e1f5fe;
  --warning-soft: #fff9c4;
  
  --text-primary: #1a237e;
  --text-secondary: #455a64;
  --text-muted: #78909c;
  
  --bg-gradient: linear-gradient(145deg, #ffffff 0%, #f8fafd 100%);
  --shadow-sm: 0 4px 12px rgba(33, 150, 243, 0.08);
  --shadow-md: 0 8px 24px rgba(33, 150, 243, 0.12);
  --shadow-lg: 0 16px 32px rgba(33, 150, 243, 0.16);
  
  --radius-md: 20px;
  --radius-lg: 28px;
  --radius-full: 9999px;
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* =========================
   DASHBOARD LAYOUT
========================= */
.dash-container{
  width: 100%;
  max-width: 1440px;
  margin: 0 auto;
  padding: 28px 32px;
  height: 100%;
  overflow-y: auto;
}

.dashboard-wrapper{
  display: grid;
  grid-template-columns: 1fr minmax(360px, 420px);
  gap: 28px;
  align-items: start;
  min-height: min-content;
}

.dashboard-left,
.dashboard-right{
  min-width: 0;
  height: 100%;
}

/* Stats Grid - untuk menampung 2 card */
.stats-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 24px;
}

/* =========================
   WELCOME CARD
========================= */
.dashboard-welcome{
  background: linear-gradient(135deg, #e8f4fd 0%, #d4e9fa 100%);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  padding: 36px 40px;
  display: flex;
  gap: 36px;
  align-items: center;
  position: relative;
  overflow: hidden;
  height: 100%;
  min-height: 380px;
}

.dashboard-welcome::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(33,150,243,0.08) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}

.welcome-image-wrapper {
  flex: 0 0 auto;
  width: 280px;
  height: 280px;
  border-radius: 50%;
  overflow: hidden;
  background: linear-gradient(135deg, var(--primary-light), var(--primary-soft));
  box-shadow: 0 20px 32px rgba(33, 150, 243, 0.25);
  border: 4px solid rgba(255, 255, 255, 0.6);
  position: relative;
  z-index: 2;
  transition: var(--transition);
}

.welcome-image-wrapper:hover {
  transform: scale(1.02) rotate(2deg);
  border-color: white;
  box-shadow: 0 28px 40px rgba(33, 150, 243, 0.35);
}

.welcome-img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
}

.welcome-text{
  min-width: 0;
  max-width: 680px;
  position: relative;
  z-index: 2;
  flex: 1;
}

.welcome-text h1{
  margin: 0 0 16px;
  font-weight: 800;
  color: var(--text-primary);
  line-height: 1.1;
  font-size: clamp(36px, 4vw, 52px);
  letter-spacing: -0.02em;
}

.welcome-text h1::after {
  content: '';
  display: block;
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, var(--primary-main), var(--accent-main));
  border-radius: 4px;
  margin-top: 16px;
}

.welcome-desc{
  margin: 0 0 16px;
  font-size: 17px;
  line-height: 1.8;
  color: var(--text-secondary);
}

.welcome-desc:last-child {
  margin-bottom: 0;
}

/* =========================
   RIGHT CARDS
========================= */
.dashboard-right{
  display: flex;
  flex-direction: column;
  gap: 24px;
  height: 100%;
  max-height: calc(100vh - 120px);
  overflow-y: auto;
  padding-right: 4px;
}

/* Custom scrollbar */
.dashboard-right::-webkit-scrollbar {
  width: 6px;
}

.dashboard-right::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.dashboard-right::-webkit-scrollbar-thumb {
  background: var(--primary-light);
  border-radius: 10px;
}

.dashboard-right::-webkit-scrollbar-thumb:hover {
  background: var(--primary-main);
}

/* Card Stats */
.dashboard-card {
  background: linear-gradient(135deg, #ffffff, #fff9f0);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-md);
  padding: 24px 20px;
  position: relative;
  overflow: hidden;
  transition: var(--transition);
  border: 1px solid rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(4px);
  flex-shrink: 0;
  text-decoration: none;
  cursor: pointer;
  display: block;
}

.dashboard-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}

.dashboard-card::after {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 200px;
  height: 200px;
  background: radial-gradient(circle, rgba(255,152,0,0.08) 0%, transparent 70%);
  border-radius: 50%;
}

.card-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, var(--primary-soft), var(--primary-light));
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 16px;
  color: var(--primary-dark);
  box-shadow: 0 6px 12px rgba(33,150,243,0.2);
}

.card-icon svg {
  width: 24px;
  height: 24px;
}

.dashboard-card h3 {
  margin: 0 0 4px;
  font-size: 14px;
  font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.card-number {
  margin: 4px 0 8px;
  font-size: 40px;
  font-weight: 800;
  line-height: 1;
  color: var(--text-primary);
  letter-spacing: -1px;
}

.card-sub {
  margin: 0;
  color: var(--text-secondary);
  font-size: 13px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.trend-badge {
  padding: 4px 8px;
  border-radius: 20px;
  font-weight: 600;
  font-size: 12px;
}

.trend-up {
  background: var(--success-soft);
  color: var(--success-main);
}

.trend-down {
  background: var(--danger-soft);
  color: var(--danger-main);
}

/* =========================
   BERITA SECTION
========================= */
.dashboard-berita {
  background: white;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-md);
  padding: 28px;
  border: 1px solid rgba(33, 150, 243, 0.08);
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  max-height: 500px;
}

.berita-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  flex-shrink: 0;
}

.berita-header h3 {
  margin: 0;
  font-size: 20px;
  font-weight: 700;
  color: var(--text-primary);
}

.lihat-semua {
  color: var(--primary-main);
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: var(--transition);
  padding: 6px 12px;
  border-radius: 20px;
  background: var(--primary-soft);
}

.lihat-semua:hover {
  background: var(--primary-light);
  transform: translateX(4px);
}

.berita-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
  overflow-y: auto;
  padding-right: 8px;
}

/* Custom scroll untuk berita list */
.berita-list::-webkit-scrollbar {
  width: 4px;
}

.berita-list::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.berita-list::-webkit-scrollbar-thumb {
  background: var(--primary-light);
  border-radius: 10px;
}

.berita-item {
  background: var(--bg-gradient);
  border-radius: 18px;
  padding: 20px;
  transition: var(--transition);
  border: 1px solid rgba(33, 150, 243, 0.06);
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}

.berita-item:hover {
  transform: translateX(6px);
  border-color: var(--primary-light);
  box-shadow: var(--shadow-sm);
}

.berita-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 30px;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 12px;
  letter-spacing: 0.3px;
}

.badge-info {
  background: var(--primary-soft);
  color: var(--primary-dark);
}

.badge-penting {
  background: var(--danger-soft);
  color: var(--danger-main);
}

.badge-kegiatan {
  background: #e0f2fe;
  color: #0369a1;
}

.badge-kesehatan {
  background: #dcfce7;
  color: #166534;
}

.berita-item h4 {
  margin: 0 0 8px;
  font-size: 16px;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1.4;
}

.berita-meta {
  display: flex;
  gap: 16px;
  margin-bottom: 10px;
  font-size: 13px;
  color: var(--text-muted);
}

.penulis, .tanggal {
  display: flex;
  align-items: center;
  gap: 4px;
}

.penulis::before {
  content: '✎';
  opacity: 0.6;
}

.tanggal::before {
  content: '🕒';
  opacity: 0.6;
}

.berita-excerpt {
  margin: 0;
  font-size: 14px;
  line-height: 1.6;
  color: var(--text-secondary);
}

/* Empty State */
.berita-empty {
  text-align: center;
  padding: 40px 20px;
  background: #f8fafc;
  border-radius: 18px;
  color: var(--text-muted);
}

.empty-icon {
  font-size: 48px;
  margin-bottom: 16px;
  opacity: 0.5;
}

.berita-empty p {
  margin: 0 0 16px 0;
  font-size: 15px;
}

.btn-tambah-berita {
  display: inline-block;
  padding: 10px 20px;
  background: var(--primary-main);
  color: white;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 500;
  text-decoration: none;
  transition: var(--transition);
}

.btn-tambah-berita:hover {
  background: var(--primary-dark);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

/* =========================
   RESPONSIVE BREAKPOINTS
========================= */

/* Large Desktop */
@media (max-width: 1400px) {
  .dash-container {
    padding: 24px;
  }
  
  .welcome-image-wrapper {
    width: 240px;
    height: 240px;
  }
}

/* Desktop & Tablet Landscape */
@media (max-width: 1200px) {
  .dashboard-wrapper {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  
  .dashboard-right {
    display: grid;
    grid-template-columns: minmax(300px, 1fr) 2fr;
    gap: 24px;
    max-height: none;
    overflow-y: visible;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  
  .dashboard-berita {
    max-height: 450px;
  }
  
  .welcome-image-wrapper {
    width: 220px;
    height: 220px;
  }
}

/* Tablet Portrait */
@media (max-width: 992px) {
  .dashboard-welcome {
    flex-direction: column;
    text-align: center;
    padding: 32px 24px;
    min-height: auto;
  }
  
  .welcome-image-wrapper {
    width: 200px;
    height: 200px;
    margin: 0 auto;
  }
  
  .welcome-text h1::after {
    margin-left: auto;
    margin-right: auto;
  }
  
  .dashboard-right {
    grid-template-columns: 1fr;
  }
  
  .card-number {
    font-size: 48px;
  }
  
  .dashboard-berita {
    max-height: 400px;
  }
}

/* Mobile Landscape */
@media (max-width: 768px) {
  .dash-container {
    padding: 16px;
    height: auto;
    overflow-y: visible;
  }
  
  .dashboard-welcome {
    padding: 24px 20px;
    gap: 20px;
  }
  
  .welcome-image-wrapper {
    width: 160px;
    height: 160px;
    border-width: 3px;
  }
  
  .welcome-text h1 {
    font-size: 32px;
  }
  
  .welcome-desc {
    font-size: 15px;
  }
  
  .dashboard-card {
    padding: 20px;
  }
  
  .card-number {
    font-size: 36px;
  }
  
  .stats-grid {
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  
  .dashboard-berita {
    padding: 20px;
    max-height: 380px;
  }
  
  .berita-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 12px;
  }
  
  .berita-item {
    padding: 16px;
  }
  
  .berita-meta {
    flex-direction: column;
    gap: 6px;
  }
}

/* Mobile Portrait */
@media (max-width: 480px) {
  .dash-container {
    padding: 12px;
  }
  
  .dashboard-wrapper {
    gap: 16px;
  }
  
  .dashboard-welcome {
    padding: 20px 16px;
  }
  
  .welcome-image-wrapper {
    width: 140px;
    height: 140px;
    border-width: 3px;
  }
  
  .welcome-text h1 {
    font-size: 28px;
  }
  
  .card-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
  }
  
  .card-icon svg {
    width: 20px;
    height: 20px;
  }
  
  .card-number {
    font-size: 32px;
  }
  
  .dashboard-card h3 {
    font-size: 13px;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  
  .dashboard-berita {
    max-height: 350px;
    padding: 16px;
  }
  
  .berita-list {
    gap: 12px;
  }
}

/* Small Mobile */
@media (max-width: 360px) {
  .welcome-image-wrapper {
    width: 120px;
    height: 120px;
  }
  
  .welcome-text h1 {
    font-size: 24px;
  }
  
  .card-number {
    font-size: 28px;
  }
  
  .dashboard-berita {
    max-height: 320px;
  }
}

/* Height-based adjustments */
@media (max-height: 700px) {
  .dashboard-right {
    max-height: calc(100vh - 100px);
  }
  
  .dashboard-berita {
    max-height: 350px;
  }
}

/* Touch-friendly improvements */
@media (hover: none) and (pointer: coarse) {
  .dashboard-card:hover,
  .berita-item:hover,
  .lihat-semua:hover,
  .welcome-image-wrapper:hover,
  .btn-tambah-berita:hover {
    transform: none;
  }
  
  .lihat-semua {
    padding: 8px 16px;
  }
}
</style>