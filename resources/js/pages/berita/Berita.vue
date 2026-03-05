<script setup>
import { Link, router } from '@inertiajs/vue3';
import DataTable from '@/components/ui/DataTable.vue';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    berita: Array,
    filter: Object
})

// State untuk menyimpan posisi scroll
const scrollPosition = ref(0)

const saveScrollPosition = () => {
    scrollPosition.value = window.scrollY
    sessionStorage.setItem('scrollPosition_berita', scrollPosition.value)
}

const restoreScrollPosition = () => {
    const savedPosition = sessionStorage.getItem('scrollPosition_berita')
    if (savedPosition) {
        setTimeout(() => {
            window.scrollTo({
                top: parseInt(savedPosition),
                behavior: 'smooth'
            })
            sessionStorage.removeItem('scrollPosition_berita')
        }, 100)
    }
}

const handleLinkClick = () => {
    saveScrollPosition()
}

onMounted(() => {
    restoreScrollPosition()
})

const rows = computed(() => props.berita ?? [])

const columns = [
    { key: "id_berita", label: "ID", sortable: true },
    { key: "judul", label: "Judul", sortable: true },
    { key: "ringkasan", label: "Ringkasan", sortable: true },
    { key: "penulis", label: "Penulis", sortable: true },
    { key: "tanggal_waktu", label: "Tanggal", sortable: true },
    { key: "actions", label: "Aksi", sortable: false }
];

// Modal delete
const modalOpen = ref(false);
const selected = ref({});

function deleteRow(row) {
    selected.value = row;
    modalOpen.value = true;
}

function closeModal() {
    modalOpen.value = false;
    selected.value = {};
}

function confirmDelete() {
    if (!selected.value?.id_berita) {
        return;
    }

    saveScrollPosition();
    
    router.delete(`/berita/${selected.value.id_berita}`, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            router.reload({ only: ['berita'] });
            restoreScrollPosition();
        }
    });
}

// Format tanggal
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

// Fungsi untuk mendapatkan kelas button
const getButtonClass = (type) => {
    const baseClass = 'action-btn'
    switch(type) {
        case 'edit':
            return `${baseClass} btn-edit`
        case 'delete':
            return `${baseClass} btn-delete`
        default:
            return baseClass
    }
}
</script>

<template>
    <AdminLayout>
        <div class="data-container">
            <!-- Header Section -->
            <div class="header-section">
                <div class="header-left">
                    <h1 class="page-title">Manajemen Berita</h1>
                    <p class="page-subtitle">Kelola berita dan informasi</p>
                </div>
                <div class="header-right">
                    <Link 
                        href="/berita/create" 
                        class="btn-create"
                        @click="handleLinkClick"
                    >
                        <span>+</span>
                        <span>Tambah Berita</span>
                    </Link>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <!-- Empty State -->
                <div v-if="rows.length === 0" class="empty-state">
                    <div class="empty-icon">
                        <span>📰</span>
                    </div>
                    <h3 class="empty-title">Belum Ada Berita</h3>
                    <p class="empty-description">Belum ada berita yang ditambahkan. Silakan tambah berita baru.</p>
                    <Link href="/berita/create" class="btn-create empty-btn" @click="handleLinkClick">
                        <span>+</span>
                        <span>Tambah Berita Pertama</span>
                    </Link>
                </div>

                <!-- Data Table -->
                <DataTable v-else :columns="columns" :rows="rows" :perPage="10">
                    <template #col-id_berita="{ row }">
                        <span class="id-badge">#{{ row.id_berita }}</span>
                    </template>

                    <template #col-judul="{ row }">
                        <div class="judul-info">
                            <span class="judul-text">{{ row.judul || '-' }}</span>
                        </div>
                    </template>

                    <template #col-ringkasan="{ row }">
                        <span class="ringkasan-text">{{ row.ringkasan?.substring(0, 50) }}{{ row.ringkasan?.length > 50 ? '...' : '' }}</span>
                    </template>

                    <template #col-penulis="{ row }">
                        <span class="penulis-badge">{{ row.penulis || '-' }}</span>
                    </template>

                    <template #col-tanggal_waktu="{ row }">
                        <span class="tanggal-badge">{{ formatDate(row.tanggal_waktu) }}</span>
                    </template>

                    <template #col-actions="{ row }">
                        <div class="action-group">
                            <Link 
                                :href="`/berita/${row.id_berita}/edit`"
                                @click="handleLinkClick"
                            >
                                <span :class="getButtonClass('edit')" title="Edit Berita">
                                    <i class="icon-pencil"></i>
                                </span>
                            </Link>

                            <span 
                                :class="getButtonClass('delete')" 
                                title="Hapus Berita"
                                @click="deleteRow(row)"
                            >
                                <i class="icon-trash"></i>
                            </span>
                        </div>
                    </template>
                </DataTable>

                <!-- Pagination -->
                <div class="pagination-section" v-if="props.berita?.links?.length && rows.length > 0">
                    <div class="pagination-info">
                        Menampilkan {{ props.berita.from || 0 }} - {{ props.berita.to || 0 }} 
                        dari {{ props.berita.total || 0 }} data
                    </div>
                    <nav class="pagination-nav">
                        <ul class="pagination-list">
                            <li v-for="(l, idx) in props.berita.links" :key="idx" 
                                class="pagination-item" 
                                :class="{ 
                                    active: l.active, 
                                    disabled: !l.url 
                                }"
                            >
                                <a 
                                    class="pagination-link" 
                                    href="#" 
                                    @click.prevent="l.url && router.visit(l.url, { preserveScroll: true, onStart: saveScrollPosition })"
                                    v-html="l.label"
                                ></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div v-if="modalOpen" class="modal-overlay" @click.self="closeModal">
            <div class="modal-content">
                <div class="modal-icon-wrapper">
                    <i class="icon-bin modal-icon"></i>
                </div>
                <h3 class="modal-title">Hapus Berita?</h3>
                <p class="modal-text">Anda akan menghapus berita:</p>
                
                <div class="modal-highlight">
                    <div class="modal-info-item">
                        <span class="modal-info-label">Judul</span>
                        <div class="modal-info-value">
                            <strong>{{ selected.judul || 'Tidak diketahui' }}</strong>
                        </div>
                    </div>

                    <div class="modal-info-item">
                        <span class="modal-info-label">Penulis</span>
                        <div class="modal-info-value">
                            {{ selected.penulis || '-' }}
                        </div>
                    </div>

                    <div class="modal-info-item">
                        <span class="modal-info-label">Tanggal</span>
                        <div class="modal-info-value">
                            {{ formatDate(selected.tanggal_waktu) }}
                        </div>
                    </div>
                </div>

                <p class="modal-warning">
                    <i class="icon-exclamation-triangle"></i>
                    Data yang dihapus tidak dapat dikembalikan
                </p>

                <div class="modal-actions">
                    <button class="modal-btn modal-btn-cancel" @click="closeModal">
                        <i class="icon-close"></i>
                        Batal
                    </button>
                    <button class="modal-btn modal-btn-delete" @click="confirmDelete">
                        <i class="icon-trash"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
/* Container Utama */
.data-container {
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

/* Button Create */
.btn-create {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #1e293b;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(30, 41, 59, 0.1);
}

.btn-create:hover {
    background: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(30, 41, 59, 0.2);
}

/* Table Section */
.table-section {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    overflow-x: auto;
}

/* ID Badge */
.id-badge {
    display: inline-block;
    padding: 4px 8px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

/* Judul Info */
.judul-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.judul-text {
    font-weight: 500;
    color: #1e293b;
}

/* Ringkasan Text */
.ringkasan-text {
    font-size: 13px;
    color: #475569;
}

/* Penulis Badge */
.penulis-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #e8f0fe;
    color: #1e293b;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
}

/* Tanggal Badge */
.tanggal-badge {
    display: inline-block;
    padding: 4px 8px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
}

/* Action Buttons */
.action-group {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    font-size: 16px;
}

.btn-edit {
    background: #dbeafe;
    color: #1e40af;
}

.btn-edit:hover {
    background: #bfdbfe;
    color: #1e3a8a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(30, 64, 175, 0.2);
}

.btn-delete {
    background: #fee2e2;
    color: #991b1b;
}

.btn-delete:hover {
    background: #fecaca;
    color: #7f1d1d;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(153, 27, 27, 0.2);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 24px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    font-size: 40px;
}

.empty-title {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 8px 0;
}

.empty-description {
    color: #64748b;
    margin: 0 0 24px 0;
}

/* Pagination Section */
.pagination-section {
    margin-top: 24px;
    padding-top: 20px;
    border-top: 2px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.pagination-info {
    font-size: 14px;
    color: #64748b;
}

.pagination-list {
    display: flex;
    gap: 4px;
    list-style: none;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.pagination-item.active .pagination-link {
    background: #1e293b;
    color: white;
    border-color: #1e293b;
}

.pagination-item.disabled .pagination-link {
    background: #f1f5f9;
    color: #94a3b8;
    border-color: #e2e8f0;
    cursor: not-allowed;
}

.pagination-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 8px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination-link:hover:not(.disabled .pagination-link) {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #1e293b;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.2s ease;
}

.modal-content {
    width: 420px;
    background: white;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: slideUp 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-icon-wrapper {
    width: 80px;
    height: 80px;
    background: #fee2e2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.modal-icon {
    font-size: 40px;
    color: #dc2626;
}

.modal-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
    margin: 0 0 8px 0;
}

.modal-text {
    text-align: center;
    color: #64748b;
    margin: 0 0 16px 0;
}

.modal-highlight {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
}

.modal-info-item {
    margin-bottom: 16px;
    text-align: center;
}

.modal-info-item:last-child {
    margin-bottom: 0;
}

.modal-info-label {
    display: block;
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 4px;
    text-align: center;
}

.modal-info-value {
    font-size: 14px;
    color: #1e293b;
    word-break: break-word;
    text-align: center;
}

.modal-warning {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #b45309;
    background: #fffbeb;
    padding: 10px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 24px;
    text-align: center;
}

.modal-actions {
    display: flex;
    gap: 12px;
}

.modal-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}

.modal-btn-cancel {
    background: #f1f5f9;
    color: #475569;
}

.modal-btn-cancel:hover {
    background: #e2e8f0;
    color: #1e293b;
}

.modal-btn-delete {
    background: #dc2626;
    color: white;
}

.modal-btn-delete:hover {
    background: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .data-container {
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
    
    .btn-create {
        width: 100%;
        justify-content: center;
    }
    
    .pagination-section {
        flex-direction: column;
        align-items: start;
    }
    
    .modal-content {
        width: 90%;
        margin: 0 16px;
        padding: 24px;
    }
}
</style>