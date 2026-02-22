<template>
  <header class="app-bar">
    <div class="app-bar-container">
      <!-- Logo -->
      <div class="logo">
        <img src="/storage/landing_page/logo-navbar.png" alt="Logo Cimahi" height="40">
      </div>

      <!-- Menu + Login -->
      <div class="menu-and-login" v-if="!isMobile">
        <nav class="menu-links">
          <a href="/" class="menu-link">Beranda</a>
          <a href="/berita-posyandu" class="menu-link">Berita</a>
          <a href="/halaman-posyandu" class="menu-link">Daftar Posyandu</a>
        </nav>
        <a href="/login" class="btn-login">Login</a>
      </div>

      <!-- Hamburger for mobile -->
      <div class="action-buttons" v-if="isMobile">
        <button @click="drawerOpen = !drawerOpen" class="menu-toggle">
          <span class="hamburger"></span>
        </button>
      </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <transition name="fade">
      <div class="mobile-drawer" v-if="drawerOpen">
        <a href="#" class="menu-link">Beranda</a>
        <a href="#" class="menu-link">Berita</a>
        <a href="#" class="menu-link">Daftar Posyandu</a>
        <a href="login" class="btn-login mt-2">Login</a>
      </div>
    </transition>
  </header>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const drawerOpen = ref(false);
const isMobile = ref(false);

const updateScreen = () => {
  isMobile.value = window.innerWidth <= 991;
};

onMounted(() => {
  updateScreen();
  window.addEventListener('resize', updateScreen);
});

onUnmounted(() => {
  window.removeEventListener('resize', updateScreen);
});
</script>
