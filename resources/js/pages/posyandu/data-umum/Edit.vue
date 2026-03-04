<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from "@inertiajs/vue3"
import { ref, computed, watch } from "vue"

const props = defineProps({
    duspy: Object,
    kecamatan: Array,
    kelurahan: Object
})

const form = useForm({
    id_kel: props.duspy.id_kel,
    nama_posyandu: props.duspy.nama_posyandu ?? '',
    strata_psy: props.duspy.strata_psy ?? '',
    alamat_posyandu: props.duspy.alamat_posyandu ?? '',
    pj_umum: props.duspy.pj_umum ?? '',
    pj_operasional: props.duspy.pj_operasional ?? '',
    ketuplak: props.duspy.ketuplak ?? '',
    sekretaris: props.duspy.sekretaris ?? '',
    int_paud: props.duspy.int_paud ?? null,
    int_bkd: props.duspy.int_bkd ?? null,
    int_terpadu: props.duspy.int_terpadu ?? null,
    kader_aktif: props.duspy.kader_aktif ?? '',
    kader_taktif: props.duspy.kader_taktif ?? '',
    ptgs_kb: props.duspy.ptgs_kb ?? '',
    ptgs_medis: props.duspy.ptgs_medis ?? '',
    ptgs_bidan: props.duspy.ptgs_bidan ?? ''
})

// State untuk select
const selectedKec = ref(props.duspy?.kelurahan?.kecamatan?.id_kec ? String(props.duspy.kelurahan.kecamatan.id_kec) : '')
const selectedKel = ref(props.duspy?.id_kel ? String(props.duspy.id_kel) : '')

// State untuk notifikasi
const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')
const modalTitle = ref('')
const validationErrors = ref([])

// Notifikasi toast
const toast = ref({
    show: false,
    type: 'success',
    message: '',
    timeout: null
})

function showToast(type, message, duration = 3000) {
    if (toast.value.timeout) clearTimeout(toast.value.timeout)
    
    toast.value.show = true
    toast.value.type = type
    toast.value.message = message
    
    toast.value.timeout = setTimeout(() => {
        toast.value.show = false
        toast.value.timeout = null
    }, duration)
}

function hideToast() {
    toast.value.show = false
    if (toast.value.timeout) {
        clearTimeout(toast.value.timeout)
        toast.value.timeout = null
    }
}

function openError(msg, errors = []) {
    modalType.value = 'error'
    modalTitle.value = 'Gagal!'
    modalMessage.value = msg
    validationErrors.value = errors
    showModal.value = true
    showToast('error', msg, 4000)
}

function openSuccess(msg) {
    modalType.value = 'success'
    modalTitle.value = 'Berhasil!'
    modalMessage.value = msg
    validationErrors.value = []
    showModal.value = true
    showToast('success', msg, 3000)
}

const kecamatanOptions = computed(() =>
    (props.kecamatan || []).map(k => ({ label: k.nama_kec, value: String(k.id_kec) }))
)

const kelurahanOptions = computed(() => {
    if (!selectedKec.value) return []
    const key = String(selectedKec.value)
    const arr = props.kelurahan?.[key]
    if (!Array.isArray(arr)) return []
    return arr.map(k => ({ label: k.nama_kel, value: String(k.id_kel) }))
})

// WATCH PENTING: Update form.id_kel ketika selectedKel berubah
watch(selectedKel, (newVal) => {
    if (newVal) {
        form.id_kel = newVal
    } else {
        form.id_kel = null
    }
})

function submitForm() {
    if (!selectedKec.value) {
        openError('Kecamatan wajib dipilih')
        return
    }
    if (!selectedKel.value) {
        openError('Kelurahan wajib dipilih')
        return
    }

    // Pastikan form.id_kel terupdate dengan nilai terbaru
    form.id_kel = selectedKel.value

    showToast('info', 'Menyimpan data...', 0)

    form.put(`/posyandu/data-umum/${props.duspy.id_posyandu}`, {
        preserveScroll: true,
        onSuccess: () => {
            hideToast()
            openSuccess('Data posyandu berhasil diperbarui')
            setTimeout(() => {
                window.location.href = '/posyandu/data-umum'
            }, 1000)
        },
        onError: (errors) => {
            hideToast()
            console.error('Error:', errors)
            
            let errorMsg = 'Gagal menyimpan data'
            if (errors.message) {
                errorMsg = errors.message
            } else if (typeof errors === 'object') {
                errorMsg = Object.values(errors).join(', ')
            }
            
            openError(errorMsg)
        }
    })
}
</script>

<template>
        <div class="data-container">
            <!-- Toast Notification -->
            <Transition name="slide-fade">
                <div v-if="toast.show" class="toast-notification" :class="toast.type">
                    <div class="toast-content">
                        <span v-if="toast.type === 'success'" class="toast-icon">✅</span>
                        <span v-else-if="toast.type === 'error'" class="toast-icon">❌</span>
                        <span v-else-if="toast.type === 'info'" class="toast-icon">ℹ️</span>
                        <span v-else-if="toast.type === 'warning'" class="toast-icon">⚠️</span>
                        <span class="toast-message">{{ toast.message }}</span>
                        <button class="toast-close" @click="hideToast">×</button>
                    </div>
                </div>
            </Transition>

            <!-- Header Section -->
            <div class="header-section">
                <div class="header-left">
                    <h1 class="page-title">Edit Data Posyandu</h1>
                    <p class="page-subtitle">Edit data umum posyandu</p>
                </div>
                <div class="header-right">
                    <Link href="/posyandu/data-umum" class="btn-back">
                        <span>←</span>
                        <span>Kembali</span>
                    </Link>
                </div>
            </div>

            <!-- Main Card -->
            <div class="main-card">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <!-- Filter Lokasi (bisa diedit) -->
                        <div class="filter-section">
                            <h6 class="filter-section-title">Pilih Lokasi</h6>
                            <div class="filter-grid-2">
                                <div class="filter-item">
                                    <label class="filter-label">Kecamatan <span class="text-danger">*</span></label>
                                    <div class="select-wrapper">
                                        <select class="form-input" v-model="selectedKec">
                                            <option value="">-- Pilih Kecamatan --</option>
                                            <option v-for="k in kecamatan" :key="k.id_kec" :value="String(k.id_kec)">
                                                {{ k.nama_kec }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="filter-item">
                                    <label class="filter-label">Kelurahan <span class="text-danger">*</span></label>
                                    <div class="select-wrapper">
                                        <select class="form-input" v-model="selectedKel" :disabled="!selectedKec">
                                            <option value="">-- Pilih Kelurahan --</option>
                                            <option v-for="k in kelurahanOptions" :key="k.value" :value="k.value">
                                                {{ k.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Data Posyandu -->
                        <div class="data-card">
                            <div class="data-card-header">
                                <div class="card-title">
                                    <span class="card-number">1</span>
                                    <strong>Edit Data Posyandu</strong>
                                </div>
                            </div>

                            <div class="form-grid-2">
                                <div class="form-field">
                                    <label>Nama Posyandu <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.nama_posyandu"
                                        placeholder="Masukkan nama posyandu"
                                    />
                                </div>

                                <div class="form-field">
                                    <label>Strata <span class="text-danger">*</span></label>
                                    <select class="form-input" v-model="form.strata_psy">
                                        <option value="">-- Pilih Strata --</option>
                                        <option value="Pratama">Pratama</option>
                                        <option value="Madya">Madya</option>
                                        <option value="Purnama">Purnama</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-2 mt-3">
                                <div class="form-field">
                                    <label>Alamat <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.alamat_posyandu"
                                        placeholder="Masukkan alamat"
                                    />
                                </div>

                                <div class="form-field">
                                    <label>PJ Umum <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.pj_umum"
                                        placeholder="Nama penanggung jawab umum"
                                    />
                                </div>
                            </div>

                            <div class="form-grid-2 mt-3">
                                <div class="form-field">
                                    <label>PJ Operasional <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.pj_operasional"
                                        placeholder="Nama penanggung jawab operasional"
                                    />
                                </div>

                                <div class="form-field">
                                    <label>Ketua Pelaksana <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.ketuplak"
                                        placeholder="Nama ketua pelaksana"
                                    />
                                </div>
                            </div>

                            <div class="form-grid-2 mt-3">
                                <div class="form-field">
                                    <label>Sekretaris <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.sekretaris"
                                        placeholder="Nama sekretaris"
                                    />
                                </div>

                                <div class="form-field">
                                    <label>Integrasi PAUD <span class="text-danger">*</span></label>
                                    <select class="form-input" v-model="form.int_paud">
                                        <option :value="null">-- Pilih --</option>
                                        <option :value="1">Ya</option>
                                        <option :value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-grid-3 mt-3">
                                <div class="form-field">
                                    <label>Integrasi BKD <span class="text-danger">*</span></label>
                                    <select class="form-input" v-model="form.int_bkd">
                                        <option :value="null">-- Pilih --</option>
                                        <option :value="1">Ya</option>
                                        <option :value="0">Tidak</option>
                                    </select>
                                </div>

                                <div class="form-field">
                                    <label>Integrasi Terpadu <span class="text-danger">*</span></label>
                                    <select class="form-input" v-model="form.int_terpadu">
                                        <option :value="null">-- Pilih --</option>
                                        <option :value="1">Ya</option>
                                        <option :value="0">Tidak</option>
                                    </select>
                                </div>

                                <div class="form-field">
                                    <label>Kader Aktif <span class="text-danger">*</span></label>
                                    <input 
                                        type="number" 
                                        class="form-input" 
                                        v-model="form.kader_aktif"
                                        placeholder="Jumlah"
                                    />
                                </div>
                            </div>

                            <div class="form-grid-3 mt-3">
                                <div class="form-field">
                                    <label>Kader Tidak Aktif <span class="text-danger">*</span></label>
                                    <input 
                                        type="number" 
                                        class="form-input" 
                                        v-model="form.kader_taktif"
                                        placeholder="Jumlah"
                                    />
                                </div>

                                <div class="form-field">
                                    <label>Petugas KB <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.ptgs_kb"
                                        placeholder="Nama petugas KB"
                                    />
                                </div>

                                <div class="form-field">
                                    <label>Petugas Medis <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.ptgs_medis"
                                        placeholder="Nama petugas medis"
                                    />
                                </div>
                            </div>

                            <div class="form-grid-2 mt-3">
                                <div class="form-field">
                                    <label>Petugas Bidan <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-input" 
                                        v-model="form.ptgs_bidan"
                                        placeholder="Nama petugas bidan"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <Link href="/posyandu/data-umum" class="btn-cancel">
                                <span>✕</span>
                                <span>Batal</span>
                            </Link>
                            <button type="submit" class="btn-save" :disabled="form.processing">
                                <span>✓</span>
                                <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Notifikasi -->
        <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
            <div class="modal-card">
                <div class="text-center">
                    <span v-if="modalType === 'success'" class="modal-icon">✅</span>
                    <span v-else-if="modalType === 'error'" class="modal-icon">❌</span>
                    <h4 class="modal-title-text">{{ modalTitle }}</h4>
                    <p class="modal-message">{{ modalMessage }}</p>
                    
                    <!-- Tampilkan detail error jika ada -->
                    <div v-if="validationErrors.length > 0" class="error-details">
                        <div v-for="(error, idx) in validationErrors" :key="idx" class="error-item">
                            <strong>Baris {{ error.row }}:</strong>
                            <ul>
                                <li v-for="(err, errIdx) in error.errors" :key="errIdx">{{ err }}</li>
                            </ul>
                        </div>
                    </div>
                    
                    <button class="btn-modal-close" @click="showModal = false">Tutup</button>
                </div>
            </div>
        </div>
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
}

.btn-back:active {
    background: #cbd5e1;
    transform: translateY(0);
}

/* Button Cancel */
.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: #f1f5f9;
    color: #475569;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #1e293b;
    transform: translateY(-2px);
}

.btn-cancel:active {
    background: #cbd5e1;
    transform: translateY(0);
}

/* Main Card */
.main-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-body {
    padding: 28px;
}

/* Filter Section */
.filter-section {
    background: #f8fafc;
    padding: 24px;
    border-radius: 16px;
    margin-bottom: 24px;
    border: 1px solid #e2e8f0;
}

.filter-section-title {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 16px 0;
}

.filter-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-label {
    font-weight: 600;
    font-size: 13px;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.select-wrapper {
    width: 100%;
}

/* Data Card */
.data-card {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 24px;
    background: white;
    transition: all 0.2s;
    margin-bottom: 20px;
}

.data-card:hover {
    border-color: #94a3b8;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.data-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f1f5f9;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: #1e293b;
    color: white;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
}

/* Form Grid */
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
}

.form-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-field label {
    font-weight: 500;
    font-size: 13px;
    color: #475569;
}

/* Form Input */
.form-input {
    height: 42px;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 0 12px;
    font-size: 14px;
    transition: all 0.2s;
    background: #f8fafc;
    width: 100%;
}

.form-input:hover {
    border-color: #94a3b8;
    background: white;
}

.form-input:focus {
    border-color: #1e293b;
    background: white;
    box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
    outline: none;
}

.form-input::placeholder {
    color: #94a3b8;
}

/* Text Danger */
.text-danger {
    color: #ef4444;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 2px solid #f1f5f9;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 28px;
    background: #1e293b;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(30, 41, 59, 0.1);
}

.btn-save:hover:not(:disabled) {
    background: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(30, 41, 59, 0.2);
}

.btn-save:active:not(:disabled) {
    background: #1e293b;
    transform: translateY(0);
}

.btn-save:disabled {
    background: #94a3b8;
    cursor: not-allowed;
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

.modal-card {
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

.modal-icon {
    font-size: 48px;
    line-height: 1;
}

.modal-title-text {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 16px 0 8px 0;
}

.modal-message {
    color: #64748b;
    margin: 0 0 16px 0;
}

.btn-modal-close {
    padding: 10px 28px;
    background: #1e293b;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 16px;
}

.btn-modal-close:hover {
    background: #0f172a;
    transform: translateY(-2px);
}

/* Error Details */
.error-details {
    text-align: left;
    background: #fef2f2;
    border-radius: 12px;
    padding: 16px;
    max-height: 300px;
    overflow-y: auto;
}

.error-item {
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #fecaca;
}

.error-item:last-child {
    border-bottom: none;
}

.error-item strong {
    color: #991b1b;
    font-size: 14px;
}

.error-item ul {
    margin: 8px 0 0 0;
    padding-left: 20px;
}

.error-item li {
    color: #b91c1c;
    font-size: 13px;
    margin: 4px 0;
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 10000;
    min-width: 320px;
    max-width: 400px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    overflow: hidden;
    animation: slideInRight 0.3s ease;
    border-left: 4px solid;
}

.toast-notification.success {
    border-left-color: #10b981;
}

.toast-notification.error {
    border-left-color: #ef4444;
}

.toast-notification.info {
    border-left-color: #3b82f6;
}

.toast-notification.warning {
    border-left-color: #f59e0b;
}

.toast-content {
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.toast-icon {
    font-size: 20px;
}

.toast-message {
    flex: 1;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #94a3b8;
    padding: 0 4px;
    line-height: 1;
}

.toast-close:hover {
    color: #475569;
}

/* Animations */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(30px);
    opacity: 0;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Margin */
.mt-3 {
    margin-top: 12px;
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
    
    .btn-back,
    .btn-cancel,
    .btn-save {
        width: 100%;
        justify-content: center;
    }
    
    .filter-grid-2,
    .form-grid-2,
    .form-grid-3 {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 12px;
    }
    
    .toast-notification {
        top: 16px;
        right: 16px;
        left: 16px;
        max-width: none;
    }
    
    .modal-card {
        width: 90%;
        margin: 0 16px;
        padding: 24px;
    }
}
</style>