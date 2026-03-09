<script setup>
import logoCimahi from '../../images/logo-cimahi.png'
import logoeSIP from '../../images/eSIP.png'
</script>

<template>
    <footer class="footer-layout">
        <div class="footer-left">
            <img :src="logoCimahi" class="footer-logo" alt="Logo Cimahi">
            <span class="footer-text">DP3AP2KB</span>
        </div>

        <img :src="logoeSIP" class="footer-esip" alt="eSIP Logo">
    </footer>
</template>

<style scoped>
.footer-layout {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 1.5rem;
    border-top: 1px solid #e0e0e0;
    background: #fff;
    min-height: 60px;
    box-sizing: border-box;
    flex-wrap: wrap;
    gap: 1rem;
}

.footer-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.footer-logo {
    height: 40px;
    width: auto;
    object-fit: contain;
}

.footer-esip {
    height: 40px;
    width: auto;
    object-fit: contain;
}

.footer-text {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-layout {
        padding: 0.8rem 1rem;
        flex-direction: column;
        text-align: center;
    }
    
    .footer-left {
        justify-content: center;
        width: 100%;
    }
    
    .footer-esip {
        margin: 0 auto;
    }
}

@media (max-width: 480px) {
    .footer-layout {
        min-height: 50px;
        padding: 0.6rem;
    }
    
    .footer-logo,
    .footer-esip {
        height: 30px;
    }
    
    .footer-text {
        font-size: 0.9rem;
    }
}

/* Untuk layar sangat kecil */
@media (max-width: 360px) {
    .footer-left {
        flex-direction: column;
        gap: 5px;
    }
    
    .footer-text {
        font-size: 0.8rem;
    }
}
</style>