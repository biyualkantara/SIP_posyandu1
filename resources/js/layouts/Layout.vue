<script setup>
import AppNavbarImpl from '@/layouts/AppNavbarImpl.vue'
import AppSidebarImpl from '@/layouts/AppSidebarImpl.vue'
import AppFooterImpl from '@/layouts/AppFooterImpl.vue'
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
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.admin-body {
    flex: 1;
    display: flex;
}

.admin-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #f5f5f5;
}

.content-area {
    flex: 1;
    padding: 20px;
}
</style>