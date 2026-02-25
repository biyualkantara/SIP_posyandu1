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
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;

    display: flex;
    justify-content: space-between;
    align-items: center;

    /* Gunakan padding dengan unit rem agar proporsional terhadap ukuran font */
    padding: 0.8rem 1.2rem;   /* contoh, sesuaikan */
    
    border-top: 1px solid gainsboro;
    background: #fff;

    /* Hindari height tetap, gunakan min-height */
    min-height: 70px;
    
    box-sizing: border-box;
    
    /* Agar konten tidak menempel ke tepi saat zoom sangat besar */
    gap: 1rem;
    flex-wrap: wrap;          /* jika layar sempit, item turun ke bawah */
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