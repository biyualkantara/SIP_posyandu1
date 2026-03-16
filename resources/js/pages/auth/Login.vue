<template>
  <div class="login-page">
    <Head title="Login" />

    <div class="page-background">
      <img
        src="/storage/landing_page/bg-landing-page.png"
        class="background-img"
        alt="Background"
      />
      <div class="background-overlay"></div>
    </div>

    <div class="wrapper">
      <!-- Left: gambar eSIP dengan efek glassmorphism -->
      <div class="left-panel">
        <div class="left-content">
          <div class="logo-wrapper">
            <img :src="'/storage/landing_page/esip-cimahi.png'" class="logo" />
          </div>
          <h2 class="left-title">Sistem Informasi Posyandu</h2>
          <p class="left-subtitle">Kota Cimahi</p>
          <div class="feature-list">
            <div class="feature-item">
              <i class="fas fa-check-circle"></i>
              <span>Manajemen Data Posyandu</span>
            </div>
            <div class="feature-item">
              <i class="fas fa-check-circle"></i>
              <span>Monitoring Kader</span>
            </div>
            <div class="feature-item">
              <i class="fas fa-check-circle"></i>
              <span>Laporan Digital</span>
            </div>
            <div class="feature-item">
              <i class="fas fa-check-circle"></i>
              <span>Informasi Real-time</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: form login dengan efek glassmorphism -->
      <div class="right-panel">
        <div class="form-container">
          <div class="form-header">
            <img src="/storage/footerlanding_page/esip.png" alt="eSIP Logo" class="form-logo" />
            <h1 class="title">
              Selamat Datang<br />
              di eSIP Kota Cimahi
            </h1>
          </div>

          <p class="subtitle">
            Masuk untuk melanjutkan ke dashboard
          </p>

          <!-- Status pesan (misal: "Password di-reset", dll) -->
          <div v-if="status" class="status-message">
            <i class="fas fa-info-circle"></i>
            {{ status }}
          </div>

          <form class="login-form" @submit.prevent="submit">
            <div class="form-group">
              <label for="username">
                <i class="fas fa-user"></i> Username
              </label>
              <input
                id="username"
                type="text"
                v-model="form.username"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan Username"
              />
              <div v-if="form.errors.username" class="error">
                <i class="fas fa-exclamation-circle"></i>
                {{ form.errors.username }}
              </div>
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="password">
                <i class="fas fa-lock"></i> Password
              </label>
              <input
                id="password"
                type="password"
                v-model="form.password"
                required
                autocomplete="current-password"
                placeholder="Masukkan Password"
              />
              <div v-if="form.errors.password" class="error">
                <i class="fas fa-exclamation-circle"></i>
                {{ form.errors.password }}
              </div>
            </div>

            <!-- Tombol Login -->
            <button
              type="submit"
              class="btn-login"
              :disabled="form.processing"
            >
              <i v-if="form.processing" class="fas fa-spinner fa-spin"></i>
              <span v-if="form.processing">Loading...</span>
              <span v-else>LOGIN <i class="fas fa-arrow-right"></i></span>
            </button>

            <!-- Kembali ke landing -->
            <a href="/" class="back-link">
              <i class="fas fa-arrow-left"></i> Kembali ke halaman utama
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from 'vue';

const page = usePage();

const status = page.props.status ?? null;

const form = useForm({
  username: '',
  password: '',
});

const submit = () => {
  form.post('/login');
};

// Tambahkan class ke body untuk styling
onMounted(() => {
  document.body.classList.add('login-page-body');
});

onBeforeUnmount(() => {
  document.body.classList.remove('login-page-body');
});
</script>

<style scoped>
:global(:root) {
  --primary-soft: #e3f2fd;
  --primary-light: #bbdefb;
  --primary-main: #2196f3;
  --primary-dark: #1976d2;
  --primary-deep: #0a4c7a;
  --accent-soft: #fff3e0;
  --accent-main: #ff9800;
  --shadow-sm: 0 4px 12px rgba(33, 150, 243, 0.08);
  --shadow-md: 0 8px 24px rgba(33, 150, 243, 0.12);
  --shadow-lg: 0 16px 32px rgba(33, 150, 243, 0.16);
  --radius-md: 20px;
  --radius-lg: 28px;
}

/* ===== RESET BODY ===== */
:global(body.login-page-body) {
  margin: 0;
  padding: 0;
  overflow-x: hidden;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* ===== BACKGROUND SAMA SEPERTI HERO ===== */
.page-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;
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

/* ===== LOGIN PAGE LAYOUT ===== */
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  isolation: isolate;
  padding: 20px;
}

.wrapper {
  display: flex;
  width: min(1100px, 100%);
  min-height: 560px;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(10px);
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-lg);
  border: 1px solid rgba(255, 255, 255, 0.5);
  position: relative;
  z-index: 2;
}

/* ===== LEFT PANEL ===== */
.left-panel {
  flex: 1;
  background: linear-gradient(135deg, var(--primary-deep), var(--primary-dark));
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px;
  position: relative;
  overflow: hidden;
}

.left-panel::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: url("/storage/tentangesip_page/background_biru.png");
  background-repeat: repeat;
  background-size: 200px;
  opacity: 0.1;
  pointer-events: none;
}

.left-content {
  color: white;
  text-align: center;
  position: relative;
  z-index: 2;
  max-width: 400px;
  margin: 0 auto;
}

.logo-wrapper {
  margin-bottom: 30px;
  align-items: center;
  display: flex;
  justify-content: center;
  width: 100%;
}

.logo {
  width: 450px;
  height: auto;
  display: block;
  border-radius: 20px;
}

.left-title {
  font-size: 28px;
  font-weight: 700;
  margin: 0 0 10px;
  line-height: 1.3;
}

.left-subtitle {
  font-size: 18px;
  font-weight: 500;
  margin: 0 0 40px;
  opacity: 0.9;
}

.feature-list {
  text-align: left;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(5px);
  border-radius: 20px;
  padding: 25px;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
  font-size: 16px;
}

.feature-item:last-child {
  margin-bottom: 0;
}

.feature-item i {
  color: var(--accent-main);
  font-size: 20px;
  flex-shrink: 0;
}

/* ===== RIGHT PANEL ===== */
.right-panel {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px;
  background: rgba(255, 255, 255, 0.95);
}

.form-container {
  width: 100%;
  max-width: 400px;
}

.form-header {
  text-align: center;
  margin-bottom: 30px;
}

.form-logo {
  width: 160px;
  height: auto;
  margin: 0 auto 20px auto;
  display: block;
}

.title {
  font-size: 24px;
  font-weight: 700;
  color: var(--primary-deep);
  margin: 0 0 10px;
  line-height: 1.3;
}

.subtitle {
  font-size: 14px;
  color: #64748b;
  margin: 0 0 25px;
  text-align: center;
}

/* Status Message */
.status-message {
  background: var(--primary-soft);
  color: var(--primary-dark);
  padding: 12px 16px;
  border-radius: 12px;
  margin-bottom: 20px;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 10px;
  border: 1px solid var(--primary-light);
}

.status-message i {
  font-size: 18px;
  color: var(--primary-main);
}

/* Form */
.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
  display: flex;
  align-items: center;
  gap: 6px;
}

.form-group label i {
  color: var(--primary-main);
  font-size: 16px;
}

.form-group input {
  height: 48px;
  padding: 0 16px;
  border: 2px solid var(--primary-soft);
  border-radius: 12px;
  font-size: 14px;
  transition: all 0.2s ease;
  background: white;
}

.form-group input:focus {
  outline: none;
  border-color: var(--primary-main);
  box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
}

.form-group input::placeholder {
  color: #94a3b8;
}

.error {
  font-size: 12px;
  color: #ef4444;
  display: flex;
  align-items: center;
  gap: 4px;
  margin-top: 4px;
}

.error i {
  font-size: 14px;
}

/* Button Login */
.btn-login {
  height: 52px;
  background: linear-gradient(145deg, var(--primary-main), var(--primary-dark));
  color: white;
  border: none;
  border-radius: 40px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: var(--shadow-md);
  margin-top: 10px;
}

.btn-login:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
  background: linear-gradient(145deg, var(--primary-dark), var(--primary-deep));
}

.btn-login:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-login i {
  font-size: 18px;
}

/* Back Link */
.back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: var(--primary-dark);
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  margin-top: 5px;
  transition: all 0.2s ease;
  align-self: flex-start;
}

.back-link:hover {
  color: var(--primary-deep);
  gap: 10px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 992px) {

.wrapper{
  flex-direction: column;
  max-width: 520px;
  min-height: auto;
}

.left-panel{
  padding: 30px 20px;
}

.logo{
  width:300px;
}

.left-title{
  font-size:22px;
}

.left-subtitle{
  font-size:16px;
}

.feature-list{
  max-width:320px;
  margin:0 auto;
}

}

@media (max-width:768px){

.login-page{
  padding:15px;
}

.wrapper{
  border-radius:18px;
}

.right-panel{
  padding:28px 20px;
}

.form-logo{
  width:120px;
}

.title{
  font-size:20px;
}

.subtitle{
  font-size:13px;
}

.form-group input{
  height:46px;
}

.btn-login{
  height:48px;
  font-size:15px;
}

}

@media (max-width:480px){

.left-panel{
  display:none;
}

.wrapper{
  max-width:380px;
}

.form-container{
  max-width:100%;
}

.form-logo{
  width:110px;
}

.title{
  font-size:18px;
}

.subtitle{
  font-size:12px;
}

}

/* ===== ANIMASI ===== */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form-container {
  animation: fadeIn 0.5s ease-out;
}

:global(.fa),
:global(.fas),
:global(.far) {
  font-family: 'Font Awesome 6 Free';
  font-weight: 900;
}
</style>