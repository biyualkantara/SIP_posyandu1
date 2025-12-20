<template>
  <AdminLayout>
    <!-- WRAPPER KHUSUS HALAMAN -->
 <div ref="wrap" class="esip-tentang-page">
      <section class="tentang-section">
        <div class="tentang-container">
          <!-- Kiri: Teks -->
          <div class="tentang-text">
            <h1 class="judul-tentang">Tentang eSIP</h1>

            <p>
              eSIP (Elektronik Sistem Informasi Posyandu) platform digital untuk mempermudah pengelolaan data Posyandu
              dan memantau pertumbuhan anak secara terpadu.
            </p>

            <p>
              Melalui eSIP, tenaga kesehatan, kader, dan masyarakat dapat bekerja sama dalam mencegah stunting,
              memperkuat edukasi kesehatan, serta memastikan setiap anak di Kota Cimahi tumbuh sehat, cerdas, dan sejahtera.
            </p>

            <p>
              Sistem ini mengintegrasikan berbagai fitur seperti pendataan Posyandu, pemetaan anak berpotensi stunting,
              edukasi kesehatan keluarga, serta layanan WA MANTAP chatbot pintar yang memberikan rekomendasi menu gizi
              dan informasi pencegahan stunting langsung melalui WhatsApp.
            </p>

            <p>
              Dengan eSIP, Cimahi bergerak menuju transformasi digital pelayanan kesehatan masyarakat yang lebih responsif,
              transparan, dan partisipatif.
            </p>
          </div>

          <!-- Kanan: Grid Card -->
          <div class="fitur-grid">
            <a href="#daftar-posyandu" class="fitur-card link-card">
              <h4>415 Jumlah Posyandu</h4>
              <p>Saat ini terdapat 415 Posyandu aktif di Kota Cimahi yang terhubung dengan sistem eSIP</p>
            </a>

            <a href="#diagram-stunting" class="fitur-card link-card">
              <h4>Diagram anak berpotensi Stunting</h4>
              <p>Pantau perkembangan status gizi anak secara keseluruhan melalui diagram interaktif di eSIP</p>
            </a>

            <a href="/jelajah-edukasi" class="fitur-card link-card">
              <h4>Edukasi Kesehatan</h4>
              <p>Temukan berbagai informasi dan panduan kesehatan untuk ibu dan anak.</p>
            </a>

            <a
              href="https://wa.me/6281234567890"
              target="_blank"
              rel="noopener"
              class="fitur-card link-card"
            >
              <h4>WA MANTAP</h4>
              <p>
                Fitur WA MANTAP akan mengirimkan pesan otomatis edukasi stunting dan rekomendasi menu kepada orang tua bayi
                yang berpotensi stunting.
              </p>

              <div class="wa-btn">
                <i class="fa-brands fa-whatsapp"></i>
              </div>
            </a>
          </div>
        </div>
      </section>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from "vue";

const wrap = ref(null);

function updateClip() {
  const el = wrap.value;
  if (!el) return;

  const r = el.getBoundingClientRect();

  // posisi wrapper relatif ke viewport
  const top = Math.max(0, r.top);
  const bottom = Math.max(0, window.innerHeight - r.bottom);

  // potong atas/bawah: background fixed cuma keliatan di area wrapper
  el.style.setProperty("--clip-top", `${top}px`);
  el.style.setProperty("--clip-bottom", `${bottom}px`);
}

onMounted(async () => {
  document.body.classList.add("esip-tentang-page-body");
  await nextTick();
  updateClip();

  window.addEventListener("scroll", updateClip, { passive: true });
  window.addEventListener("resize", updateClip);
});

onBeforeUnmount(() => {
  document.body.classList.remove("esip-tentang-page-body");
  window.removeEventListener("scroll", updateClip);
  window.removeEventListener("resize", updateClip);
});
</script>

<style scoped>
/* =========================================================
   LIMITLESS OVERRIDE (HANYA SAAT DI HALAMAN INI)
   ========================================================= */

/* Hilangkan padding bawaan Limitless (khusus halaman ini) */
:global(body.esip-tentang-page-body .content) {
  padding: 0 !important;
}

/* Transparankan wrapper Limitless yang nutupin background */
:global(body.esip-tentang-page-body .page-container),
:global(body.esip-tentang-page-body .page-content),
:global(body.esip-tentang-page-body .content-wrapper),
:global(body.esip-tentang-page-body .content) {
  background-color: transparent !important;
  background-image: none !important;
}

/* =========================================================
   BACKGROUND KHUSUS HALAMAN INI (NEMPEL DI WRAPPER, BUKAN BODY)
   ========================================================= */
.esip-tentang-page {
  position: relative;
  min-height: 100vh;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  isolation: isolate; /* biar layer z-index aman */
}

/* INI YANG TADI KURANG: content + position + inset + z-index */
.esip-tentang-page::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;

  background-image: url("/storage/tentangesip_page/bg-kotak-kotak.png");
  background-repeat: repeat;
  background-size: auto;
  background-position: center -2px;
}

/* =========================================================
   SECTION TENTANG
   ========================================================= */
.tentang-section {
  padding: 80px 0;
}

.tentang-container {
  width: min(1200px, 100%);
  margin: 0 auto;
  padding: 0 24px;

  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 40px;
  align-items: stretch;
}

/* ---- Teks kiri ---- */
.tentang-text {
  background: rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(2px);
  padding: 30px;
  border-radius: 10px;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.judul-tentang {
  font-size: 48px;
  font-weight: 800;
  text-shadow: 2px 3px 3px rgba(0, 0, 0, 0.2);
  margin: 0 0 14px;
}

.tentang-text p {
  font-size: 17px;
  font-weight: 500;
  color: #333;
  line-height: 1.6;
  margin: 0 0 14px;
}

/* ---- Grid card kanan ---- */
.fitur-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}

/* ---- Card fitur ---- */
.fitur-card {
  background: #e8d1b7;
  padding: 25px;
  border-radius: 10px;

  box-shadow: 8px 8px 0px #e26b1f, 0px 0px 6px rgba(0, 0, 0, 0.2);

  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 240px;
}

.fitur-card h4 {
  font-size: 20px;
  font-weight: 700;
  margin: 0 0 10px;
}

.fitur-card p {
  font-size: 15px;
  line-height: 1.5;
  margin: 0;
  flex-grow: 1;
}

/* klik seluruh card */
.link-card {
  text-decoration: none;
  color: inherit;
  display: block;
  transform: translateY(0);
  transition: 0.2s ease;
}

.link-card:hover {
  transform: translateY(-3px);
  box-shadow: 10px 10px 0px #d6651c, 0px 0px 8px rgba(0, 0, 0, 0.25);
}

/* tombol whatsapp */
.wa-btn {
  width: 60px;
  height: 60px;
  background-color: #1faf38;
  border-radius: 12px;

  display: flex;
  justify-content: center;
  align-items: center;

  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.25);
  transition: 0.2s ease;

  margin-top: 20px;
  margin-left: auto;
  margin-right: auto;
}

.wa-btn i {
  font-size: 28px;
  color: white;
}

.wa-btn:hover {
  background-color: #15922c;
  transform: scale(1.05);
}

/* responsive */
@media (max-width: 992px) {
  .tentang-container {
    grid-template-columns: 1fr;
  }
  .fitur-grid {
    grid-template-columns: 1fr;
  }
  .judul-tentang {
    font-size: 36px;
  }
}

@media (max-width: 576px) {
  .judul-tentang {
    font-size: 28px;
  }
  .tentang-text {
    padding: 20px;
  }
  .fitur-card {
    padding: 20px;
    min-height: 200px;
  }
}
</style>