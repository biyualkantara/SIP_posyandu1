<template>
  <section class="esip-hero-page">
    <!-- Background dengan efek overlay pattern -->
    <div class="hero-background">
      <img
        src="/storage/landing_page/bg-landing-page.png"
        class="background-img"
        alt="Background"
      />
      <div class="background-overlay"></div>
    </div>

    <div class="hero-container">
      <!-- Kiri: Konten dengan Card -->
      <div class="hero-content-card">
        <h1 class="judul-hero">Sistem Informasi Posyandu<br />Kota Cimahi (eSIP)</h1>
        
        <p class="deskripsi-hero">
          Mendukung Pelayanan Posyandu Digital yang Cepat, Akurat dan Transparan
        </p>
        
        <a href="/login" class="btn-hero">
          Masuk ke Dashboard
          <svg class="btn-icon" viewBox="0 0 24 24" width="20" height="20">
            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" fill="currentColor"/>
          </svg>
        </a>
      </div>

      <!-- Kanan: Ilustrasi -->
      <div class="hero-illustration">
        <img
          src="/storage/landing_page/posyandu.png"
          class="family-img"
          alt="Ilustrasi Keluarga"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from "vue";

onMounted(() => document.body.classList.add("esip-landing-page"));
onBeforeUnmount(() => document.body.classList.remove("esip-landing-page"));
</script>

<style scoped>
/* =========================================================
   LIMITLESS OVERRIDE (KHUSUS LANDING)
   ========================================================= */
:global(body.esip-landing-page .content) {
  padding: 0 !important;
}

:global(body.esip-landing-page .page-container),
:global(body.esip-landing-page .page-content),
:global(body.esip-landing-page .content-wrapper),
:global(body.esip-landing-page .content) {
  background: transparent !important;
  background-image: none !important;
}

:global(body.esip-landing-page .container),
:global(body.esip-landing-page .container-fluid) {
  max-width: 100% !important;
  width: 100% !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

:global(body.esip-landing-page) {
  overflow-x: hidden;
}

/* =========================================================
   HERO PAGE DENGAN VARIASI BIRU
   ========================================================= */
.esip-hero-page {
  position: relative;
  min-height: 100vh;
  width: 100vw;
  left: 50%;
  transform: translateX(-50%);
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
  display: flex;
  align-items: center;
  overflow: hidden;
}

/* Background image dengan overlay */
.hero-background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
}

.background-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.25;
}

.background-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("/storage/tentangesip_page/background_biru.png");
  background-repeat: repeat;
  background-size: 300px;
  background-position: center;
  opacity: 0.15;
  pointer-events: none;
}

/* =========================================================
   HERO CONTAINER
   ========================================================= */
.hero-container {
  width: 100%;
  max-width: 1300px;
  margin: 0 auto;
  padding: 0 50px;
  position: relative;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100vh;
}

/* =========================================================
   HERO CONTENT CARD (KIRI)
   ========================================================= */
.hero-content-card {
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  padding: 50px;
  border-radius: 40px;
  box-shadow: 
    25px 25px 50px rgba(0, 50, 100, 0.3),
    inset 0 0 30px rgba(255, 255, 255, 0.7);
  border: 1px solid rgba(255, 255, 255, 0.5);
  max-width: 600px;
  width: 100%;
  position: relative;
  z-index: 3;
}

.judul-hero {
  font-size: 48px;
  font-weight: 800;
  margin: 0 0 20px;
  background: linear-gradient(135deg, #0a4c7a, #2c7fb8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
  line-height: 1.2;
  position: relative;
  padding-bottom: 20px;
}

.judul-hero::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 120px;
  height: 4px;
  background: linear-gradient(90deg, #0a4c7a, #7fb4d9);
  border-radius: 2px;
}

.deskripsi-hero {
  font-size: 20px;
  font-weight: 500;
  color: #1e405b;
  line-height: 1.6;
  margin: 0 0 35px;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
}

/* Tombol */
.btn-hero {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 16px 36px;
  background: linear-gradient(145deg, #0a4c7a, #1e6a9f);
  color: white;
  font-size: 18px;
  font-weight: 600;
  text-decoration: none;
  border-radius: 50px;
  box-shadow: 10px 10px 20px rgba(0, 40, 80, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.3s ease;
  width: fit-content;
}

.btn-hero:hover {
  transform: translateY(-3px);
  box-shadow: 15px 15px 30px rgba(0, 40, 80, 0.4);
  background: linear-gradient(145deg, #0d5588, #2b74a5);
}

.btn-icon {
  transition: transform 0.3s ease;
}

.btn-hero:hover .btn-icon {
  transform: translateX(5px);
}

/* =========================================================
   HERO ILLUSTRATION (KANAN)
   ========================================================= */
.hero-illustration {
  flex: 1;
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
  height: 100%;
  padding-bottom: 50px;
  position: relative;
  z-index: 3;
}

.family-img {
  width: 100%;
  max-width: 550px;
  height: auto;
  filter: drop-shadow(30px 30px 60px rgba(0, 40, 80, 0.4));
  animation: float 6s ease-in-out infinite;
  display: block;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-15px);
  }
}

/* =========================================================
   RESPONSIVE
   ========================================================= */
@media (max-width: 1200px) {
  .hero-container {
    padding: 0 40px;
  }
  
  .hero-content-card {
    max-width: 500px;
    padding: 40px;
  }
  
  .judul-hero {
    font-size: 42px;
  }
  
  .family-img {
    max-width: 450px;
  }
}

@media (max-width: 992px) {
  .hero-container {
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 80px 30px;
    height: auto;
    min-height: 100vh;
    gap: 40px;
  }

  .hero-content-card {
    max-width: 100%;
    text-align: center;
  }

  .judul-hero::after {
    left: 50%;
    transform: translateX(-50%);
  }

  .btn-hero {
    margin: 0 auto;
  }

  .hero-illustration {
    justify-content: center;
    align-items: center;
    padding-bottom: 0;
    width: 100%;
  }

  .family-img {
    max-width: 400px;
  }
}

@media (max-width: 768px) {
  .hero-content-card {
    padding: 35px 25px;
  }

  .judul-hero {
    font-size: 36px;
  }

  .deskripsi-hero {
    font-size: 18px;
  }

  .btn-hero {
    padding: 14px 32px;
    font-size: 16px;
  }

  .family-img {
    max-width: 350px;
  }
}

@media (max-width: 576px) {
  .hero-container {
    padding: 60px 20px;
  }

  .hero-content-card {
    padding: 30px 20px;
  }

  .judul-hero {
    font-size: 28px;
  }

  .deskripsi-hero {
    font-size: 16px;
    margin-bottom: 25px;
  }

  .family-img {
    max-width: 280px;
  }
}
</style>