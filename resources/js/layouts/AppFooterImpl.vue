<script setup>
import logoCimahi from '../../images/logo-cimahi.png'
import logoeSIP from '../../images/eSIP.png'
</script>

<template>
    <footer class="footer-layout">
        <div class="footer-left">
            <img :src="logoCimahi" class="footer-logo">
            <span class="footer-text">DP3AP2KB</span>
        </div>

        <img :src="logoeSIP" class="footer-esip">
    </footer>
</template>

<style scoped>
.footer-layout {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-top: 1px solid gainsboro;
    background: #fff;
    height: 70px;
}

.footer-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.footer-logo {
    height: 45px;
}

.footer-esip {
    height: 45px;
}

.footer-text {
    font-size: 20px;
    font-weight: 600;
}
</style>