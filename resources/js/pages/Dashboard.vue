<template>
  <div class="sb-app d-flex">
    <!-- Main Area-->
    <div class="sb-main flex-grow-1 d-flex flex-column">
      <main class="sb-content flex-grow-1">
        <div class="container-fluid">
          <div class="row g-4">
            <!-- LEFT: Welcome card -->
            <div class="col-lg-8">
              <div class="sb-welcome-card d-flex align-items-center">
                <div class="sb-welcome-illustration me-4">
                  <img
                    src="/storage/navbarsidebar_page/ibu.png"
                    alt="Ibu & Anak"
                    class="img-fluid"
                  />
                </div>
                <div class="sb-welcome-text">
                  <h2 class="fw-bold mb-3">
                    Selamat Datang,<br />
                    {{ auth.user.nama }}
                  </h2>
                  <p class="mb-2">
                    Sistem Informasi Posyandu (SIP) membantu menghasilkan informasi yang
                    akurat dan tepat waktu bagi pengelola Posyandu.
                  </p>
                  <p class="mb-0">
                    Dengan data yang lengkap dan aktual, pembinaan Posyandu dapat berjalan
                    lebih terarah demi peningkatan pelayanan ibu dan anak di masyarakat.
                  </p>
                </div>
              </div>
            </div>

            <!-- RIGHT: cards -->
            <div class="col-lg-4 d-flex flex-column gap-4">
              <div class="sb-card-yellow text-center">
                <h5 class="fw-semibold mb-2">Jumlah Posyandu Aktif</h5>
                <div class="sb-number">{{ jumlahPosyandu }}</div>
                <div class="sb-subtext mt-1">Data terkini</div>
              </div>

              <div class="sb-card-news">
                <h5 class="fw-semibold mb-3">Berita</h5>
                <div class="sb-news-inner text-muted small">
                  Belum ada berita yang dipublikasikan.
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>


<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const auth = page.props.auth
const jumlahPosyandu = page.props.jumlahPosyandu
</script>


<style scoped>
/* ==== BASE ==== */
.sb-app {
  background: #f4f5f7;
  min-height: 100vh;
  font-family: "Inter", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI",
    sans-serif;
}

/* ==== SIDEBAR ==== */
.sb-sidebar {
  width: 260px;
  background: linear-gradient(180deg, #0b1620, #0f1b24);
  color: #e6f2f7;
  padding: 18px 16px;
  display: flex;
  flex-direction: column;
  position: fixed;
  inset-block: 0;
  left: 0;
  overflow-y: auto;
  z-index: 1000;
  transition: transform 0.25s ease;
}

.sb-sidebar-closed {
  transform: translateX(-100%);
}

.sb-logo img {
  width: 34px;
  height: 34px;
}
.sb-logo-text {
  font-size: 15px;
  font-weight: 600;
}

.sb-profile {
  padding: 12px 4px;
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}
.sb-avatar {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  overflow: hidden;
}
.sb-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.sb-profile-name {
  font-size: 13px;
}
.sb-profile-role {
  font-size: 12px;
  color: #9aa6b0;
}

/* menu */
.sb-menu {
  margin-top: 10px;
  font-size: 14px;
}
.sb-nav-item {
  padding: 9px 6px;
  border-radius: 6px;
  cursor: pointer;
  color: #e6f2f7;
}
.sb-nav-item:hover {
  background: rgba(255, 255, 255, 0.05);
}
.sb-nav-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.sb-submenu {
  padding-left: 16px;
  display: flex;
  flex-direction: column;
  gap: 4px;
  margin-bottom: 6px;
}
.sb-submenu a {
  color: #9aa6b0;
  text-decoration: none;
  font-size: 13px;
  padding: 4px 4px;
  border-radius: 4px;
}
.sb-submenu a:hover {
  background: rgba(255, 255, 255, 0.06);
  color: #ffffff;
}

/* caret */
.sb-caret {
  width: 12px;
  height: 12px;
  background: #9aa6b0;
  mask-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='3' viewBox='0 0 10 6'><path d='M1 1l4 4 4-4' stroke='white' stroke-width='1.6' fill='none' stroke-linecap='round'/></svg>");
  mask-repeat: no-repeat;
  mask-size: contain;
  transition: transform 0.25s ease;
}
.sb-caret.open {
  transform: rotate(180deg);
}


/* TOPBAR */
.sb-topbar {
  height: 60px;
  padding: 0 32px;
  border-bottom: 1px solid #e5e5e5;
  background: #f4f5f7;
  position: sticky;
  top: 0;
  z-index: 500;
}

.sb-status-icon img {
  width: 24px;
  height: 24px;
}
.sb-badge {
  position: absolute;
  top: -6px;
  right: -6px;
  background: #ff6b6b;
  color: #fff;
  font-size: 11px;
  border-radius: 999px;
  padding: 0 5px;
  line-height: 16px;
}
.sb-online-badge {
  background: #32c759;
  color: #fff;
  font-size: 12px;
  padding: 3px 10px;
  border-radius: 4px;
}
.sb-flag {
  width: 22px;
}
.sb-user-circle {
  width: 30px;
  height: 30px;
  border-radius: 999px;
  background: #9bd8a5;
}

/* CONTENT */
.sb-content {
  padding: 24px 32px 40px;
}

/* Welcome card */
.sb-welcome-card {
  background: #dbeefe;
  border-radius: 26px;
  padding: 40px 48px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

.sb-welcome-illustration img {
  max-width: 220px;
  filter: drop-shadow(0 6px 18px rgba(0, 0, 0, 0.25));
}

.sb-welcome-text h2 {
  font-size: 32px;
}
.sb-welcome-text p {
  font-size: 15px;
  line-height: 1.6;
}

/* Right cards */
.sb-card-yellow {
  background: #fff2a8;
  border-radius: 22px;
  padding: 24px 22px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
}
.sb-number {
  font-size: 48px;
  font-weight: 800;
}
.sb-subtext {
  font-size: 13px;
}

.sb-card-news {
  background: #f4e0c4;
  border-radius: 22px;
  padding: 22px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.18);
}
.sb-news-inner {
  background: #f4e2c5;
  border-radius: 18px;
  padding: 16px 14px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
}

@media (max-width: 991.98px) {
  .sb-main {
    margin-left: 0;
  }

  .sb-topbar {
    padding-inline: 16px;
  }

  .sb-content {
    padding-inline: 16px;
  }
}

@media (max-width: 767.98px) {
  .sb-welcome-card {
    flex-direction: column;
    text-align: center;
    padding: 28px 20px;
  }
  .sb-welcome-illustration {
    margin-bottom: 12px;
  }
  .sb-footer {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }
}
</style>