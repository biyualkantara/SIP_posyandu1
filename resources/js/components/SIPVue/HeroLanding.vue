<template>
  <section class="hero">
    <img
      src="/storage/landing_page/bg-landing-page.png"
      class="background"
      alt="Background"
    />

    <div class="hero-content">
      <h1>Sistem Informasi Posyandu Kota Cimahi (eSIP)</h1>
      <p>Mendukung Pelayanan Posyandu Digital yang Cepat, Akurat dan Transparan</p>
      <a href="/login" class="btn-hero">Masuk ke Dashboard</a>
    </div>

    <img
      src="/storage/landing_page/posyandu.png"
      class="family-img"
      alt="Ilustrasi Keluarga"
    />
  </section>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from "vue";

onMounted(() => document.body.classList.add("esip-landing-page"));
onBeforeUnmount(() => document.body.classList.remove("esip-landing-page"));
</script>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE (KHUSUS LANDING)
   - matikan padding & max-width wrapper Limitless
========================= */
:global(body.esip-landing-page .page-container),
:global(body.esip-landing-page .page-container .page-content),
:global(body.esip-landing-page .content-wrapper),
:global(body.esip-landing-page .content),
:global(body.esip-landing-page .content-area){
  padding: 0 !important;
  margin: 0 !important;
  background: transparent !important;
}

/* kalau ada container bootstrap yang ngunci lebar */
:global(body.esip-landing-page .container),
:global(body.esip-landing-page .container-fluid){
  max-width: 100% !important;
  width: 100% !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

/* cegah horizontal scroll karena full-bleed */
:global(body.esip-landing-page){
  overflow-x: hidden;
}

/* =========================
   HERO (FULL BLEED)
========================= */
.hero{
  position: relative;

  /* full-bleed walau dibungkus wrapper Limitless */
  width: 100vw;
  left: 50%;
  transform: translateX(-50%);

  height: 100vh;
  padding: 0 80px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  overflow: hidden;
  margin: 0;
}

.background{
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
  opacity: 0.9;
}

.hero-content{
  position: relative;
  z-index: 2;
  max-width: 50%;
}

.hero-content h1{
  font-size: 40px !important; 
  font-weight: 700;
  color: #222;
  text-shadow: 0px 3px 8px rgba(0,0,0,0.25);
  margin: 0;
}

.hero-content p{
  font-size: 19.2px !important; 
  margin-top: 10px;
  margin-bottom: 0;
  text-shadow: 0px 3px 6px rgba(0,0,0,0.15);
}

.btn-hero{
  display: inline-block;
  margin-top: 20px;
  padding: 12px 28px;
  background-color: #eadbf4;
  color: #333;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  transition: 0.3s ease;
}

.btn-hero:hover{
  box-shadow: 0 6px 14px rgba(0,0,0,0.28);
}

.family-img{
  position: absolute;
  bottom: 0;
  right: 80px;
  width: 480px;
  max-width: 40vw;
  z-index: 1;
  filter: drop-shadow(0px 8px 18px rgba(0,0,0,0.35));
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width: 991px){
  .hero{
    flex-direction: column;
    justify-content: center;
    text-align: center;
    padding: 0 20px;
  }

  .hero-content{
    max-width: 680px;
  }

  .family-img{
    position: relative;
    right: auto;
    bottom: auto;
    width: min(520px, 86%);
    max-width: 86%;
    margin-top: 24px;
  }
}

@media (max-width: 480px){
  .hero-content h1{ font-size: 2rem; }
  .hero-content p{ font-size: 1.05rem; }
}
</style>