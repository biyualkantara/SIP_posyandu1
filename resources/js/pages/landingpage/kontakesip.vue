<template>
  <AdminLayout>
    <section class="esip-contact-wrap">
      <div class="esip-contact-inner">
        <!-- KIRI -->
        <div class="left">
          <div class="brand-row">
            <img
              class="brand-logo"
              src="/storage/footerlanding_page/logo-cimahi.png"
              alt="Logo Cimahi"
            />
            <span class="brand-text">eSIP Kota Cimahi</span>
          </div>

          <div class="subtitle">Mendukung Pelayanan Posyandu Digital</div>

          <div class="department">
            Dinas Sosial, Pengendali Penduduk<br />
            dan Keluarga Berencana,<br />
            Pemberdayaan Perempuan<br />
            dan Perlindungan Anak
          </div>
        </div>

        <!-- KANAN -->
        <div class="right">
          <div class="box">
            <div class="label">Alamat</div>
            <div class="box-body">
              Jl. Demang Hardjakusuma,<br />
              Cimahi Gedung<br />
              C Lantai 3
            </div>
          </div>

          <div class="box">
            <div class="label">Kontak</div>
            <div class="box-body">
              Tlp.<br />
              022-6632<br />
              338
            </div>
          </div>
        </div>
      </div>
    </section>
  </AdminLayout>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from "vue";

onMounted(() => document.body.classList.add("esip-contact-page"));
onBeforeUnmount(() => document.body.classList.remove("esip-contact-page"));
</script>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE
   ========================= */
:global(body.esip-contact-page .content) {
  padding: 0 !important;
}

:global(body.esip-contact-page .page-container),
:global(body.esip-contact-page .page-content),
:global(body.esip-contact-page .content-wrapper),
:global(body.esip-contact-page .content) {
  background: transparent !important;
  background-image: none !important;
}

:global(body.esip-contact-page .page-content) {
  padding-left: 0 !important;
  padding-right: 0 !important;
}

:global(body.esip-contact-page .content-wrapper) {
  overflow: visible !important;
}

/* =========================
   STRIP KONTAK DENGAN VARIASI BIRU
   ========================= */
.esip-contact-wrap {
  background: linear-gradient(145deg, #d4e8ff 0%, #9fc5e8 50%, #6ba5d9 100%);
  position: relative;
  width: 100vw;
  margin-left: calc(50% - 50vw);
  margin-right: calc(50% - 50vw);
  padding: 60px 0;
}

.esip-contact-wrap::before {
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

.esip-contact-inner {
  width: min(1200px, 100%);
  margin: 0 auto;
  padding: 0 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 60px;
  position: relative;
  z-index: 1;
}

/* =========================
   KIRI
   ========================= */
.left {
  flex: 1;
}

.brand-row {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 20px;
}

.brand-logo {
  width: 50px;
  height: 50px;
  object-fit: contain;
  filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
}

.brand-text {
  font-weight: 800;
  font-size: 32px;
  background: linear-gradient(135deg, #0a4c7a, #ffffff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
  line-height: 1.2;
}

.subtitle {
  font-weight: 600;
  font-size: 18px;
  margin: 0 0 15px;
  color: #0a3b5c;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
}

.department {
  font-weight: 500;
  font-size: 16px;
  line-height: 1.5;
  color: #1e405b;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
}

/* =========================
   KANAN
   ========================= */
.right {
  display: flex;
  gap: 30px;
}

.box {
  width: 220px;
  background: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border-radius: 30px;
  padding: 35px 20px 25px;
  position: relative;
  text-align: center;
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 
    15px 15px 30px rgba(0, 40, 80, 0.15),
    inset 0 0 20px rgba(255, 255, 255, 0.5);
}

.label {
  background: linear-gradient(145deg, #f9e88a, #ffeaa5);
  color: #0a4c7a;
  font-weight: 700;
  font-size: 16px;
  padding: 8px 25px;
  border-radius: 30px;
  position: absolute;
  top: -15px;
  left: 50%;
  transform: translateX(-50%);
  white-space: nowrap;
  box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.5);
}

.box-body {
  font-size: 16px;
  font-weight: 500;
  line-height: 1.6;
  color: #0a3b5c;
  margin-top: 5px;
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
  .esip-contact-inner {
    flex-direction: column;
    text-align: center;
    padding: 0 20px;
    gap: 40px;
  }

  .brand-row {
    justify-content: center;
  }

  .right {
    width: 100%;
    justify-content: center;
    flex-wrap: wrap;
  }

  .box {
    width: 260px;
  }
}

@media (max-width: 576px) {
  .esip-contact-wrap {
    padding: 40px 0;
  }

  .brand-text {
    font-size: 24px;
  }

  .box {
    width: 100%;
    max-width: 280px;
  }

  .subtitle {
    font-size: 16px;
  }

  .department {
    font-size: 14px;
  }
}
</style>