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
            <a href="#daftar-posyandu" class="fitur-card card-1">
              <h4>415 Jumlah Posyandu</h4>
              <p>Saat ini terdapat 415 Posyandu aktif di Kota Cimahi yang terhubung dengan sistem eSIP</p>
            </a>

            <a href="#diagram-stunting" class="fitur-card card-2">
              <h4>Diagram anak berpotensi Stunting</h4>
              <p>Pantau perkembangan status gizi anak secara keseluruhan melalui diagram interaktif di eSIP</p>
            </a>

            <a href="/jelajah-edukasi" class="fitur-card card-3">
              <h4>Edukasi Kesehatan</h4>
              <p>Temukan berbagai informasi dan panduan kesehatan untuk ibu dan anak.</p>
            </a>

            <a
              href="https://wa.me/6281234567890"
              target="_blank"
              rel="noopener"
              class="fitur-card card-4"
            >
              <h4>WA MANTAP</h4>
              <p>
                Fitur WA MANTAP akan mengirimkan pesan otomatis edukasi stunting dan
                rekomendasi menu kepada orang tua bayi yang berpotensi stunting.
              </p>
              <div class="wa-btn">
                <svg viewBox="0 0 24 24">
                  <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94
                    1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059
                    -.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05
                    -.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57
                    -.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149
                    .198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085
                    1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"
                  />
                </svg>
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
  const top = Math.max(0, r.top);
  const bottom = Math.max(0, window.innerHeight - r.bottom);

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
   LIMITLESS OVERRIDE
   ========================================================= */
:global(body.esip-tentang-page-body .content) {
  padding: 0 !important;
}

:global(body.esip-tentang-page-body .page-container),
:global(body.esip-tentang-page-body .page-content),
:global(body.esip-tentang-page-body .content-wrapper),
:global(body.esip-tentang-page-body .content) {
  background-color: transparent !important;
  background-image: none !important;
}

/* =========================================================
   BACKGROUND DENGAN VARIASI BIRU
   ========================================================= */
.esip-tentang-page {
  position: relative;
  min-height: 100vh;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(145deg, #e6f0fa 0%, #b8d9f0 50%, #7fb4d9 100%);
  isolation: isolate;
}

.esip-tentang-page::before {
  content: "";
  position: absolute;
  inset: 0;
  background-image: url("/storage/tentangesip_page/background_biru.png");
  background-repeat: repeat;
  background-size: 300px;
  background-position: center;
  opacity: 0.4;
  mix-blend-mode: overlay;
  pointer-events: none;
}

/* =========================================================
   SECTION TENTANG
   ========================================================= */
.tentang-section {
  padding: 80px 0;
  position: relative;
  z-index: 1;
}

.tentang-container {
  width: min(1300px, 100%);
  margin: 0 auto;
  padding: 0 30px;
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 50px;
  align-items: stretch;
}

/* ---- Teks kiri dengan efek kaca ---- */
.tentang-text {
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(8px);
  padding: 45px;
  border-radius: 30px;
  height: 100%;
  display: flex;
  flex-direction: column;
  box-shadow: 
    20px 20px 40px rgba(0, 50, 100, 0.3),
    inset 0 0 20px rgba(255, 255, 255, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.5);
}

.judul-tentang {
  font-size: 52px;
  font-weight: 800;
  margin: 0 0 25px;
  background: linear-gradient(135deg, #0a4c7a, #2c7fb8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 3px 3px 6px rgba(255, 255, 255, 0.5);
  position: relative;
  padding-bottom: 15px;
}

.judul-tentang::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100px;
  height: 4px;
  background: linear-gradient(90deg, #0a4c7a, #7fb4d9);
  border-radius: 2px;
}

.tentang-text p {
  font-size: 17px;
  font-weight: 500;
  color: #1a3b4e;
  line-height: 1.7;
  margin: 0 0 20px;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
}

/* ---- Grid card kanan dengan variasi warna ---- */
.fitur-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}

/* Variasi warna card */
.fitur-card {
  padding: 30px 25px;
  border-radius: 24px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 260px;
  transition: all 0.3s ease;
  text-decoration: none;
  color: inherit;
  box-shadow: 
    15px 15px 30px rgba(0, 40, 80, 0.2),
    inset 0 0 20px rgba(255, 255, 255, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.4);
}

.fitur-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 
    20px 20px 40px rgba(0, 40, 80, 0.3),
    inset 0 0 30px rgba(255, 255, 255, 0.7);
}

/* Card 1 - Biru Muda */
.card-1 {
  background: linear-gradient(145deg, #d4e8ff, #b4d4f0);
}

/* Card 2 - Biru Langit */
.card-2 {
  background: linear-gradient(145deg, #c3dcf5, #9cc0e8);
}

/* Card 3 - Biru Laut */
.card-3 {
  background: linear-gradient(145deg, #b8d2ee, #87b4dd);
}

/* Card 4 - Biru Senja */
.card-4 {
  background: linear-gradient(145deg, #a7c8ec, #77a8d4);
}

.fitur-card h4 {
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 15px;
  color: #0a3b5c;
  text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
}

.fitur-card p {
  font-size: 15px;
  line-height: 1.6;
  margin: 0;
  flex-grow: 1;
  color: #1e405b;
  font-weight: 500;
}

/* tombol whatsapp */
.wa-btn {
  width: 55px;
  height: 55px;
  background: linear-gradient(145deg, #25D366, #128C7E);
  border-radius: 18px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 20px 0 0 auto;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  transition: 0.3s;
}

.wa-btn svg {
  width: 30px;
  height: 30px;
  fill: white;
}

.wa-btn:hover {
  transform: scale(1.1) rotate(5deg);
}

/* responsive */
@media (max-width: 1100px) {
  .tentang-container {
    grid-template-columns: 1fr;
    gap: 30px;
  }
  
  .judul-tentang {
    font-size: 42px;
  }
}

@media (max-width: 768px) {
  .fitur-grid {
    grid-template-columns: 1fr;
  }
  
  .tentang-text {
    padding: 30px;
  }
}

@media (max-width: 576px) {
  .judul-tentang {
    font-size: 36px;
  }
}
</style>