<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    berita: Object
})

const formatDate = (date) => {
    if (!date) return '-'
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>

<template>
    <AdminLayout>
        <div class="detail-container">
            <!-- Header Section -->
            <div class="header-section">
                <div class="header-left">
                    <h1 class="page-title">Detail Berita</h1>
                    <p class="page-subtitle">Informasi lengkap berita</p>
                </div>
                <div class="header-right">
                    <Link href="/berita" class="btn-back">
                        <span>←</span>
                        <span>Kembali</span>
                    </Link>
                </div>
            </div>

            <!-- Detail Card -->
            <div class="detail-card">
                <!-- Informasi Berita -->
                <div class="detail-section">
                    <h4 class="section-title">Informasi Berita</h4>
                    <div class="detail-grid">
                        <div class="detail-item full-width">
                            <span class="detail-label">Judul Berita</span>
                            <span class="detail-value">{{ berita.judul || '-' }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Penulis</span>
                            <span class="detail-value">{{ berita.penulis || '-' }}</span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Tanggal Waktu</span>
                            <span class="detail-value">{{ formatDate(berita.tanggal_waktu) }}</span>
                        </div>
                    </div>
                </div>

                <hr class="separator">

                <!-- Ringkasan -->
                <div class="detail-section">
                    <h4 class="section-title">Ringkasan</h4>
                    <div class="detail-grid">
                        <div class="detail-item full-width">
                            <span class="detail-label">Ringkasan Berita</span>
                            <span class="detail-value ringkasan-text">{{ berita.ringkasan || '-' }}</span>
                        </div>
                    </div>
                </div>

                <hr class="separator">

                <!-- Gambar -->
                <div v-if="berita.gambar" class="detail-section">
                    <h4 class="section-title">Gambar</h4>
                    <div class="detail-grid">
                        <div class="detail-item full-width">
                            <div class="image-container">
                                <img :src="`/storage/${berita.gambar}`" class="detail-image" />
                            </div>
                        </div>
                    </div>
                </div>

                <hr v-if="berita.gambar" class="separator">

                <!-- Isi Berita -->
                <div class="detail-section">
                    <h4 class="section-title">Isi Berita</h4>
                    <div class="detail-grid">
                        <div class="detail-item full-width">
                            <div class="detail-content" v-html="berita.isi || '-'"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.detail-container {
    padding: 24px;
    background: #f8fafc;
    min-height: 100vh;
}

/* Header Section */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    background: white;
    padding: 20px 24px;
    border-radius: 16px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.header-left {
    flex: 1;
}

.page-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
}

.header-right {
    display: flex;
    gap: 12px;
}

/* Button Back */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #f1f5f9;
    color: #475569;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #1e293b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Detail Card */
.detail-card {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.detail-section {
    margin-bottom: 20px;
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f0f2f5;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px 24px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-label {
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.detail-value {
    font-size: 15px;
    font-weight: 500;
    color: #1e293b;
    background: #f8fafc;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #eef1f4;
    word-break: break-word;
}

.ringkasan-text {
    line-height: 1.6;
    white-space: pre-wrap;
}

/* Image Container */
.image-container {
    background: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid #eef1f4;
    text-align: center;
}

.detail-image {
    max-width: 100%;
    max-height: 400px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Detail Content */
.detail-content {
    background: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid #eef1f4;
    font-size: 15px;
    line-height: 1.8;
    color: #334155;
}

.detail-content :deep(p) {
    margin-bottom: 16px;
}

.detail-content :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 16px 0;
}

.detail-content :deep(h1),
.detail-content :deep(h2),
.detail-content :deep(h3),
.detail-content :deep(h4) {
    margin-top: 24px;
    margin-bottom: 16px;
    color: #1e293b;
}

.detail-content :deep(ul),
.detail-content :deep(ol) {
    margin-bottom: 16px;
    padding-left: 24px;
}

.detail-content :deep(li) {
    margin-bottom: 4px;
}

.detail-content :deep(blockquote) {
    border-left: 4px solid #cbd5e1;
    padding-left: 16px;
    margin: 16px 0;
    color: #475569;
    font-style: italic;
}

.detail-content :deep(a) {
    color: #2563eb;
    text-decoration: none;
}

.detail-content :deep(a:hover) {
    text-decoration: underline;
}

/* Separator */
.separator {
    margin: 24px 0;
    border: 0;
    border-top: 1px solid #eef1f4;
}

/* Responsive */
@media (max-width: 768px) {
    .detail-container {
        padding: 16px;
    }

    .header-section {
        flex-direction: column;
        gap: 16px;
        align-items: start;
        padding: 16px;
    }

    .header-right {
        width: 100%;
    }

    .btn-back {
        width: 100%;
        justify-content: center;
    }

    .detail-card {
        padding: 20px;
    }

    .detail-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
}
</style>