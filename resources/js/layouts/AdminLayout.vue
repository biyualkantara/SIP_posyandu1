<script setup>
import AppNavbarImpl from '@/layouts/AppNavbarImpl.vue'
import AppSidebarImpl from '@/layouts/AppSidebarImpl.vue'
import AppFooterImpl from '@/layouts/AppFooterImpl.vue'
</script>

<template>
    <div class="admin-layout">
        <AppNavbarImpl />

        <div class="page-container d-flex">

            <AppSidebarImpl />

            <main class="content-area flex-fill p-3">
                <slot/>
            </main>

        </div>

        <AppFooterImpl />

    </div>
    <div id="toast-container"
     class="position-fixed"
     style="top:20px; right:20px; z-index:99999;">
</div>

<script>
window.addEventListener('toast', (e) => {
    const { type, message } = e.detail;

    const box = document.createElement('div');
    box.className = `toast-box alert alert-${type === 'success' ? 'success' : 'danger'}`;
    box.style.marginTop = '10px';
    box.textContent = message;

    document.getElementById('toast-container').appendChild(box);

    setTimeout(() => box.remove(), 3000);
});
</script>
</template>

<style scoped>
.page-container {
    display: flex;
}

.content-area {
    min-height: calc(100vh - 70px);
}
.sidebar {
    flex: 0 0 260px !important;
    width: 260px !important;
    min-width: 260px !important;
    max-width: 260px !important;
}

.content-wrapper {
    flex: 1;
    overflow-x: auto;
}
</style>