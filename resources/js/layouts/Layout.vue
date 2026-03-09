<script setup>
import AppNavbarImpl from '@/layouts/AppNavbarImpl.vue'
import AppSidebarImpl from '@/layouts/AppSidebarImpl.vue'
import AppFooterImpl from '@/layouts/AppFooterImpl.vue'
import { onMounted } from 'vue'

// Fungsi untuk mengecek state sidebar dari localStorage
onMounted(() => {
  const sidebarState = localStorage.getItem('sidebarCollapsed')
  if (sidebarState === 'true') {
    document.body.classList.add('sidebar-xs')
  }
})
</script>

<template>
    <div class="admin-layout">
        <AppNavbarImpl />

        <div class="admin-body">
            <AppSidebarImpl />

            <div class="admin-content">
                <main class="content-area">
                    <slot />
                </main>

                <AppFooterImpl />
            </div>
        </div>
    </div>
</template>

<style scoped>
.admin-layout {
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f5f5f5;
}

.admin-body {
    flex: 1;
    display: flex;
    overflow: hidden;
    position: relative;
}

/* Admin content area */
.admin-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #f5f5f5;
    overflow: hidden;
    min-width: 0; /* Penting untuk flex child */
    transition: all 0.3s ease;
}

.content-area {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    background: #f5f5f5;
}

/* Responsive padding */
@media (max-width: 768px) {
    .content-area {
        padding: 15px;
    }
}

@media (max-width: 480px) {
    .content-area {
        padding: 10px;
    }
}
</style>

<style>
/* Global styles untuk sidebar collapsed */
body.sidebar-xs .sidebar-main {
    width: 56px !important;
}

body.sidebar-xs .sidebar-main .sidebar-content .media-body,
body.sidebar-xs .sidebar-main .sidebar-menu-label,
body.sidebar-xs .sidebar-main .navigation > li > a span:not(.arrow) {
    display: none !important;
}

body.sidebar-xs .sidebar-main .navigation > li > a {
    justify-content: center;
    padding: 15px 0 !important;
}

body.sidebar-xs .sidebar-main .navigation > li > a i {
    margin: 0 !important;
    font-size: 18px;
}

body.sidebar-xs .sidebar-main .navigation > li > a .arrow {
    display: none !important;
}

body.sidebar-xs .sidebar-main .sidebar-user .media-left {
    margin: 0 auto;
}

body.sidebar-xs .sidebar-main .sidebar-user {
    padding: 15px 0;
    text-align: center;
}

body.sidebar-xs .sidebar-main .navigation-level-2 {
    display: none !important;
}

/* Animasi transisi */
.sidebar-transition {
    transition: all 0.3s ease;
}
</style>