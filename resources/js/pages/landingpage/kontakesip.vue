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
   LIMITLESS OVERRIDE (khusus page ini)
   ========================= */
:global(body.esip-contact-page .content) {
  padding: 0 !important;
}

/* hilangkan background wrapper Limitless biar strip bersih */
:global(body.esip-contact-page .page-container),
:global(body.esip-contact-page .page-content),
:global(body.esip-contact-page .content-wrapper),
:global(body.esip-contact-page .content) {
  background: transparent !important;
  background-image: none !important;
}

/* penting: biar section bisa full width (nembus container Limitless) */
:global(body.esip-contact-page .page-content) {
  padding-left: 0 !important;
  padding-right: 0 !important;
}
:global(body.esip-contact-page .content-wrapper) {
  overflow: visible !important;
}

/* =========================
   STRIP KONTAK (FULL WIDTH)
   ========================= */
.esip-contact-wrap {
  background: #fbe69b;

  /* full-bleed */
  width: 100vw;
  margin-left: calc(50% - 50vw);
  margin-right: calc(50% - 50vw);

  padding: 48px 0;
}

/* isi strip (dibuat lebar biar kiri & kanan “kepencar” kayak gambar 2) */
.esip-contact-inner {
  width: min(1320px, 100%);
  margin: 0 auto;
  padding: 0 70px;

  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 60px;
}

/* =========================
   KIRI
   ========================= */
.left {
  flex: 1 1 auto;
  min-width: 0;
}

.brand-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
}

.brand-logo {
  width: 44px;
  height: 44px;
  object-fit: contain;
  filter: drop-shadow(3px 3px 6px rgba(49, 38, 38, 0.25));
}

.brand-text {
  font-weight: 900;
  font-size: 30px;
  color: #2aa7d6;
  text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.15);
  line-height: 1;
}

.subtitle {
  font-weight: 900;
  font-size: 20px;
  margin: 0 0 14px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.department {
  font-weight: 800;
  font-size: 18px;
  line-height: 1.35;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.18);
}

/* =========================
   KANAN (BOX)
   ========================= */
.right {
  flex: 0 0 auto;
  display: flex;
  gap: 34px;
  justify-content: flex-end;
}

.box {
  width: 250px;
  height: 190px;
  background: #efe6c9;
  box-shadow: 7px 7px 10px rgba(0, 0, 0, 0.25);
  position: relative;
  text-align: center;

  display: flex;
  justify-content: center;
  align-items: center;

  padding-top: 22px; /* ruang label */
}

.label {
  background: #ffe47a;
  color: #000000;             
  font-weight: 900;
  width: 120px;
  padding: 6px 0;

  position: absolute;
  top: 12px;
  left: 50%;
  transform: translateX(-50%);
}

/* kalau mau label tetep kebaca, kasih shadow tipis */
.label {
  text-shadow: 0 1px 1px rgba(0,0,0,.35);
}

.box-body {
  font-size: 18px;
  font-weight: 500;
  line-height: 1.35;
  color: #111;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
  .esip-contact-inner {
    flex-direction: column;
    padding: 0 22px;
    gap: 28px;
  }

  .right {
    width: 100%;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 18px;
  }

  .box {
    width: min(260px, 100%);
  }
}

@media (max-width: 576px) {
  .brand-text {
    font-size: 22px;
  }
  .subtitle {
    font-size: 18px;
  }
  .department {
    font-size: 16px;
  }
  .box {
    width: 100%;
  }
}
</style>