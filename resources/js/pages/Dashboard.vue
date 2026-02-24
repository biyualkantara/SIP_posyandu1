<template>
  <AdminLayout>
    <div class="dash-container">
      <div class="dashboard-wrapper">
        <!-- LEFT -->
        <section class="dashboard-left">
          <div class="dashboard-welcome">
            <img src="/storage/dashboard/ibu.png" class="welcome-img" alt="Ibu dan Anak" />

            <div class="welcome-text">
              <h1>Selamat Datang,<br />Admin eSIP!</h1>
              <p class="welcome-desc">
                Sistem Informasi Posyandu (SIP) membantu menghasilkan informasi yang akurat dan tepat waktu bagi pengelola Posyandu.<br /><br />
                Dengan data yang lengkap dan aktual, pembinaan Posyandu dapat berjalan lebih terarah demi peningkatan pelayanan ibu dan anak di masyarakat.
              </p>
            </div>
          </div>
        </section>

        <!-- RIGHT -->
        <aside class="dashboard-right">
          <div class="dashboard-card">
            <h3>Jumlah Posyandu Aktif</h3>
            <div class="card-number">100</div>
            <p class="card-sub">8 Hari lalu</p>
          </div>

          <div class="dashboard-berita">
            <h3>Berita</h3>
            <div class="berita-item">
              <strong>Judul</strong>
              <span>Nama Penulis, tanggal</span>
              <p>Isi berita</p>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from "vue";

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
  background: #fff !important;
}

:global(body.esip-dashboard-page),
:global(body.esip-dashboard-page .content),
:global(body.esip-dashboard-page .content-wrapper){
  overflow-x: hidden !important;
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
}

/* =========================
   TOKENS
========================= */
:global(:root){
  --r: 22px;
  --shadow: 0 18px 40px rgba(17,24,39,.14);
  --shadow2: 0 12px 26px rgba(17,24,39,.12);
  --welcome: #d9efff;
  --yellow: #fff2a6;
  --cream:  #f3dfbf;
  --text: #111827;
}

/* =========================
   DASHBOARD LAYOUT
========================= */
.dash-container{
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 34px 44px 10px;
}

/* ✅ Desktop: jangan pakai min 720 yang keras → bikin overflow */
.dashboard-wrapper{
  display: grid;
  grid-template-columns: minmax(0, 1fr) clamp(320px, 30vw, 420px);
  gap: 26px;
  align-items: start;
}

.dashboard-left,
.dashboard-right{
  min-width: 0;
}

/* =========================
   WELCOME CARD
========================= */
.dashboard-welcome{
  background: var(--welcome);
  border-radius: var(--r);
  box-shadow: var(--shadow2);
  padding: 34px 36px;
  display: flex;
  gap: 28px;
  align-items: center;
  min-height: 330px;
}

.welcome-img{
  height: 255px;
  width: auto;
  flex: 0 0 auto;
  filter: drop-shadow(0 16px 28px rgba(0,0,0,.18));
}

.welcome-text{
  min-width: 0;
  max-width: 720px;
}

.welcome-text h1{
  margin: 0 0 12px;
  font-weight: 900;
  color: var(--text);
  line-height: 1.05;
  font-size: clamp(32px, 3.2vw, 48px);
}

.welcome-desc{
  margin: 0;
  font-size: 18px;
  line-height: 1.8;
  color: rgba(17,24,39,.88);
}

/* =========================
   RIGHT CARDS
========================= */
.dashboard-right{
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.dashboard-card{
  background: var(--yellow);
  border-radius: var(--r);
  box-shadow: var(--shadow);
  padding: 28px 26px;
  text-align: center;
}

.dashboard-card h3{
  margin: 0 0 12px;
  font-size: 24px;
  font-weight: 900;
  color: var(--text);
  line-height: 1.2;
}

.card-number{
  margin: 6px 0 10px;
  font-size: 64px;
  font-weight: 900;
  line-height: 1;
  color: var(--text);
}

.card-sub{
  margin: 0;
  color: rgba(17,24,39,.75);
}

.dashboard-berita{
  background: var(--cream);
  border-radius: var(--r);
  box-shadow: var(--shadow);
  padding: 22px;
}

.dashboard-berita h3{
  margin: 0 0 14px;
  font-size: 24px;
  font-weight: 900;
  color: var(--text);
}

.berita-item{
  background: rgba(255,255,255,.22);
  border-radius: 16px;
  padding: 16px;
  box-shadow: inset 0 0 0 1px rgba(0,0,0,.06);
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.berita-item span{
  color: rgba(17,24,39,.72);
  font-size: 13px;
}

.berita-item p{
  margin: 4px 0 0;
}

/* ================
   RESPONSIVE 
===================*/

@media (max-width: 1200px){
  .dash-container{ padding: 24px 20px 10px; }
  .dashboard-welcome{
    flex-direction: column;
    align-items: center;   
    text-align: center;    
  }

  .dashboard-wrapper{
    grid-template-columns: 1fr;
  }

  .dashboard-right{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
  }

  .dashboard-berita{ height: 100%; }
}

@media (max-width: 768px){
  .dash-container{ padding: 18px 16px 10px; }

  .dashboard-welcome{
    flex-direction: column;
    align-items: center;   
    text-align: center;    
  }

  .welcome-img{ height: 210px; }

  .dashboard-right{
    grid-template-columns: 1fr;
  }

  .dashboard-card h3,
  .dashboard-berita h3{
    font-size: 22px;
  }

  .card-number{ font-size: 56px; }
}
</style>