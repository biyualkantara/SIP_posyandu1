<template>
  <AdminLayout>
    <!-- WRAPPER KHUSUS HALAMAN EDUKASI -->
    <div ref="wrap" class="esip-edukasi-page">
      <section class="edukasi-section">
        <div class="edukasi-wrapper">
          <!-- KIRI - Panel Utama -->
          <div class="edukasi-left">
            <h1 class="judul-edukasi">Edukasi Kesehatan</h1>

            <p class="deskripsi">
              Temukan artikel, video, dan panduan singkat tentang kesehatan ibu dan anak
              untuk membantu tumbuh kembang anak yang sehat dan optimal.
            </p>

            <div class="btn-row">
              <a href="/berita-posyandu" class="btn-edukasi btn-primary">DP3APPKB</a>
              <a href="/halaman-posyandu" class="btn-edukasi btn-secondary">Lihat jumlah posyandu</a>
            </div>

            <!-- Card Berita dan Artikel (pindah ke kiri) -->
            <div class="card-edukasi card-berita">
              <h3>Berita dan Artikel</h3>
              <ul>
                <li>Gizi anak</li>
                <li>Imunisasi</li>
                <li>ASI dan MP-ASI</li>
                <li>Kebersihan dan Cuci tangan</li>
              </ul>
            </div>
          </div>

          <!-- KANAN - Grid Card -->
          <div class="edukasi-right">
            <!-- Card Video dan Edukasi -->
            <div class="card-edukasi card-video">
              <h3>Video dan Edukasi</h3>
              <ul>
                <li>Video Imunisasi</li>
                <li>Infografis Tanda Stunting</li>
                <li>Cara persiapan imunisasi anak</li>
              </ul>
            </div>

            <!-- Card Topik Lain -->
            <div class="card-edukasi card-topik">
              <h3>Topik Lain</h3>
              <ul>
                <li>Gizi dan Kesehatan anak</li>
                <li>Imunisasi</li>
                <li>Kesehatan Ibu Hamil</li>
                <li>Stimulasi perkembangan anak</li>
                <li>Pencegahan stunting pada anak</li>
              </ul>
            </div>

            <!-- Tombol Jelajahi -->
            <a href="/jelajah-edukasi" class="btn-jelajah">Jelajahi materi →</a>
          </div>
        </div>
      </section>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from "vue";

const wrap = ref(null);

function updateBg() {
  const el = wrap.value;
  if (!el) return;

  const r = el.getBoundingClientRect();
  const isActive = r.top <= 0 && r.bottom >= 0;

  el.classList.toggle("bg-fixed", isActive);

  if (isActive) {
    const top = Math.max(0, r.top);
    const bottom = Math.max(0, window.innerHeight - r.bottom);
    el.style.setProperty("--clip-top", `${top}px`);
    el.style.setProperty("--clip-bottom", `${bottom}px`);
  } else {
    el.style.setProperty("--clip-top", "0px");
    el.style.setProperty("--clip-bottom", "0px");
  }
}

onMounted(async () => {
  document.body.classList.add("esip-edukasi-body");
  await nextTick();
  updateBg();

  window.addEventListener("scroll", updateBg, { passive: true });
  window.addEventListener("resize", updateBg);
});

onBeforeUnmount(() => {
  document.body.classList.remove("esip-edukasi-body");
  window.removeEventListener("scroll", updateBg);
  window.removeEventListener("resize", updateBg);
});
</script>

<style scoped>
/* =========================================================
   LIMITLESS OVERRIDE
   ========================================================= */
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

/* =========================================================
   BACKGROUND DENGAN VARIASI BIRU
   ========================================================= */
.esip-edukasi-page {
  position: relative;
  min-height: 100vh;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
  isolation: isolate;
}

.esip-edukasi-page::before {
  content: "";
  position: absolute;
  inset: 0;
  background-image: url("/storage/tentangesip_page/background_biru.png");
  background-repeat: repeat;
  background-size: 250px;
  background-position: center;
  opacity: 0.3;
  mix-blend-mode: soft-light;
  pointer-events: none;
}

/* ====================================================== */
/* ======================= EDUKASI ======================= */
/* ====================================================== */

.edukasi-section {
  padding: 60px 0;
  position: relative;
  z-index: 1;
}

.edukasi-wrapper {
  width: min(1300px, 100%);
  margin: 0 auto;
  padding: 0 30px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  align-items: start;
}

/* ==================== PANEL KIRI ==================== */
.edukasi-left {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(10px);
  padding: 40px;
  border-radius: 40px;
  box-shadow: 
    25px 25px 50px rgba(0, 50, 100, 0.25),
    inset 0 0 30px rgba(255, 255, 255, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.5);
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.judul-edukasi {
  font-size: 48px;
  font-weight: 800;
  margin: 0;
  background: linear-gradient(135deg, #0a4c7a, #3a7ca5);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 3px 3px 6px rgba(255, 255, 255, 0.7);
  line-height: 1.2;
  position: relative;
  padding-bottom: 15px;
}

.judul-edukasi::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 120px;
  height: 4px;
  background: linear-gradient(90deg, #0a4c7a, #7fb4d9);
  border-radius: 2px;
}

.deskripsi {
  font-size: 18px;
  color: #1e3e57;
  line-height: 1.6;
  margin: 0;
  font-weight: 500;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
}

/* Tombol */
.btn-row {
  display: flex;
  gap: 20px;
  margin: 10px 0;
}

.btn-edukasi {
  flex: 1;
  height: 55px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 18px;
  font-size: 16px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  border: none;
  cursor: pointer;
  box-shadow: 10px 10px 20px rgba(0, 40, 80, 0.2);
}

.btn-primary {
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary {
  background: linear-gradient(145deg, #b8d9f0, #8fc1e8);
  color: #0a4c7a;
  border: 1px solid rgba(255, 255, 255, 0.5);
}

.btn-edukasi:hover {
  transform: translateY(-5px);
  box-shadow: 15px 15px 25px rgba(0, 40, 80, 0.3);
}

/* ==================== CARD ==================== */
.card-edukasi {
  background: rgba(255, 255, 255, 0.75);
  backdrop-filter: blur(8px);
  border-radius: 30px;
  padding: 30px;
  box-shadow: 
    15px 15px 30px rgba(0, 40, 80, 0.15),
    inset 0 0 20px rgba(255, 255, 255, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.4);
  transition: all 0.3s ease;
}

.card-edukasi:hover {
  transform: translateY(-5px);
  box-shadow: 20px 20px 40px rgba(0, 40, 80, 0.2);
}

/* Variasi warna card */
.card-berita {
  background: linear-gradient(145deg, rgba(212, 232, 255, 0.8), rgba(175, 212, 240, 0.8));
}

.card-video {
  background: linear-gradient(145deg, rgba(195, 220, 245, 0.8), rgba(156, 192, 232, 0.8));
}

.card-topik {
  background: linear-gradient(145deg, rgba(184, 210, 238, 0.8), rgba(135, 180, 221, 0.8));
}

.card-edukasi h3 {
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 20px;
  color: #0a3b5c;
  text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
  position: relative;
  padding-bottom: 10px;
}

.card-edukasi h3::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #0a4c7a, #7fb4d9);
  border-radius: 2px;
}

.card-edukasi ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.card-edukasi li {
  margin: 12px 0;
  padding-left: 25px;
  position: relative;
  color: #1e405b;
  font-size: 16px;
  font-weight: 500;
}

.card-edukasi li::before {
  content: "•";
  color: #0a4c7a;
  font-weight: bold;
  position: absolute;
  left: 5px;
  font-size: 22px;
}

/* ==================== PANEL KANAN ==================== */
.edukasi-right {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

/* Tombol Jelajahi */
.btn-jelajah {
  width: 100%;
  height: 70px;
  background: linear-gradient(145deg, #0a4c7a, #2b74a5);
  font-size: 24px;
  font-weight: 700;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  border-radius: 40px;
  text-decoration: none;
  margin-top: 10px;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 20px 20px 40px rgba(0, 40, 80, 0.3);
  letter-spacing: 1px;
}

.btn-jelajah:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 25px 25px 50px rgba(0, 40, 80, 0.4);
  background: linear-gradient(145deg, #0d5588, #3280b5);
}

/* responsive */
@media (max-width: 1100px) {
  .edukasi-wrapper {
    grid-template-columns: 1fr;
    max-width: 700px;
  }
  
  .judul-edukasi {
    font-size: 42px;
  }
}

@media (max-width: 768px) {
  .btn-row {
    flex-direction: column;
  }
  
  .btn-edukasi {
    width: 100%;
  }
  
  .edukasi-left {
    padding: 30px;
  }
}

@media (max-width: 576px) {
  .judul-edukasi {
    font-size: 36px;
  }
  
  .btn-jelajah {
    font-size: 20px;
    height: 60px;
  }
}
</style>