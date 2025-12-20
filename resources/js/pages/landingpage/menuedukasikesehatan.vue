<template>
  <AdminLayout>
    <!-- WRAPPER KHUSUS HALAMAN EDUKASI -->
    <div ref="wrap" class="esip-edukasi-page">
      <section class="edukasi-section">
        <!-- KIRI -->
        <div class="edukasi-left">
          <h1 class="judul-edukasi">Edukasi<br />Kesehatan</h1>

          <p class="deskripsi">
            Temukan artikel, video, dan panduan singkat tentang kesehatan ibu dan anak
            untuk membantu tumbuh kembang anak yang sehat dan optimal.
          </p>

          <div class="btn-row">
            <a href="#" class="btn-edukasi">DP3APPKB</a>
            <a href="#" class="btn-edukasi">Lihat jumlah posyandu</a>
          </div>
        </div>

        <!-- KANAN -->
        <div class="edukasi-right">
          <div class="card-edukasi">
            <h3 class="judul-kategori">Berita dan Artikel</h3>
            <ul>
              <li>Gizi anak</li>
              <li>Imunisasi</li>
              <li>ASI dan MP-ASI</li>
              <li>Kebersihan dan Cuci tangan</li>
            </ul>
          </div>

          <div class="card-edukasi">
            <h3 class="judul-kategori">Video dan Edukasi</h3>
            <ul>
              <li>Video Imunisasi</li>
              <li>Infografis Tanda Stunting</li>
              <li>Cara persiapan imunisasi anak</li>
            </ul>
          </div>

          <div class="card-edukasi">
            <h3 class="judul-kategori">Topik Lain</h3>
            <ul>
              <li>Gizi dan Kesehatan anak</li>
              <li>Imunisasi</li>
              <li>Kesehatan Ibu Hamil</li>
              <li>Stimulasi perkembangan anak</li>
              <li>Pencegahan stunting pada anak</li>
            </ul>
          </div>

          <a href="/jelajah-edukasi" class="btn-jelajah">Jelajahi materi</a>
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

  // kondisi: section sedang terlihat
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
   LIMITLESS OVERRIDE - HANYA SAAT PAGE INI AKTIF
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
   WRAPPER + BACKGROUND FIXED (cuma di EDUKASI)
   ========================================================= */
.esip-edukasi-page {
  position: relative;
  min-height: 100vh;
  isolation: isolate;

  --clip-top: 0px;
  --clip-bottom: 0px;

  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
/* background fixed tapi dipotong supaya hanya muncul di wrapper ini */
.esip-edukasi-page::before {
  content: "";
  position: absolute; /* ✅ DEFAULT: scroll */
  inset: 0;
  z-index: -1;

  background-image: url("/storage/tentangesip_page/bg-kotak-kotak.png");
  background-repeat: repeat;
  background-size: auto;
  background-position: center -12px;
}

/* ====================================================== */
/* ======================= EDUKASI ======================= */
/* ====================================================== */

.edukasi-section {
  padding: 80px 0;
  display: grid;
  grid-template-columns: auto auto;
  gap: 40px;
  justify-content: center;
  align-items: flex-start;
}

/* Panel kiri */
.edukasi-left {
  background: #ffffff;
  width: 500px;
  padding: 35px 40px;
  border-radius: 10px;
  box-shadow: -18px 18px 0px rgba(238, 140, 46, 0.75);
}

/* Judul */
.judul-edukasi {
  font-weight: 900;
  font-size: 50px;
  line-height: 1.1;
  color: #23a6da;
  text-shadow: 3px 4px 0px rgba(0, 0, 0, 0.20);
  margin: 0;
}

/* Deskripsi */
.deskripsi {
  margin-top: 20px;
  color: #2a2a2a;
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 0;
}

/* Tombol kiri */
.btn-row {
  display: flex;
  gap: 20px;
  margin-top: 38px;
}

.btn-edukasi {
  width: 200px;
  height: 50px;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  background: #f9e88a;
  border-radius: 12px;
  font-size: 17px;
  font-weight: 800;
  text-decoration: none;
  color: #4b3f23;
  box-shadow: 4px 4px 0px #e4b44a;
  transition: .2s;
}

.btn-edukasi:hover {
  transform: translateY(-3px);
}

/* Panel kanan */
.edukasi-right {
  width: 500px;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

/* Card kategori */
.card-edukasi {
  background: #ffffff;
  border-radius: 6px;
  padding: 22px 28px;
  box-shadow: 6px 6px 0px rgba(0,0,0,0.25);
}

.card-edukasi h3 {
  font-size: 22px;
  color: #23a6da;
  font-weight: 800;
  margin: 0 0 10px;
}

/* ✅ bullet hitam muncul */
.card-edukasi ul {
  list-style: disc;
  padding-left: 22px;
  margin: 0;
}
.card-edukasi li {
  margin: 6px 0;
  list-style-position: outside;
}
.card-edukasi li::marker {
  color: #000;
  font-size: 14px;
}

/* Tombol Jelajahi */
.btn-jelajah {
  width: 100%;
  height: 60px;
  background: #f9e88a;
  font-size: 28px;
  font-weight: 900;
  text-align: center;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  color: #23a6da;
  border-radius: 12px;
  text-decoration: none;
  box-shadow: 5px 5px 0px #e4b44a;
  margin-top: 10px;
  transition: .2s;
}

.btn-jelajah:hover {
  transform: translateY(-4px);
}

@media (max-width: 992px) {
  .edukasi-section {
    grid-template-columns: 1fr;
    padding: 40px 20px;
  }

  .edukasi-left,
  .edukasi-right {
    width: 100%;
  }

  .judul-edukasi {
    font-size: 40px;
  }
}
</style>