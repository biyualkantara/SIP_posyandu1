<script setup>
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';

const form = useForm({
    judul: '',
    ringkasan: '',
    isi: '',
    penulis: '',
    kategori: 'Info' // Tambah default kategori
})

const editorInstance = ref(null)

// State untuk menyimpan posisi scroll
const scrollPosition = ref(0)

const saveScrollPosition = () => {
    scrollPosition.value = window.scrollY
    sessionStorage.setItem('scrollPosition_berita', scrollPosition.value)
}

// Modal notifikasi
const showModal = ref(false)
const modalType = ref('success')
const modalMessage = ref('')

function openError(msg) {
    modalType.value = 'error'
    modalMessage.value = msg
    showModal.value = true
}

function openSuccess(msg) {
    modalType.value = 'success'
    modalMessage.value = msg
    showModal.value = true
}

onMounted(async () => {
    window.addEventListener('beforeunload', handleBeforeUnload)
    
    await nextTick()

    const CKEDITOR = window.CKEDITOR
    if (!CKEDITOR) {
        console.error('CKEDITOR belum kebaca. Pastikan file ckeditor.js sudah dimuat di app.blade.php')
        return
    }

    const textarea = document.getElementById('editor-full')
    if (!textarea) {
        console.error('Textarea #editor-full tidak ditemukan')
        return
    }

    editorInstance.value = CKEDITOR.replace('editor-full', {
        height: 420,
        allowedContent: true,
        toolbar: [
            { name: 'document', items: ['Source', '-', 'Maximize', 'ShowBlocks'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
            { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },

            '/',
            { name: 'styles', items: ['Styles', 'Format'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
            {
                name: 'paragraph',
                items: [
                    'NumberedList',
                    'BulletedList',
                    '-',
                    'Outdent',
                    'Indent',
                    '-',
                    'Blockquote',
                    '-',
                    'JustifyLeft',
                    'JustifyCenter',
                    'JustifyRight',
                    'JustifyBlock',
                ],
            },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
        ],
    })

    editorInstance.value.on('change', () => {
        form.isi = editorInstance.value.getData()
    })
})

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', handleBeforeUnload)
    if (editorInstance.value) {
        editorInstance.value.destroy()
        editorInstance.value = null
    }
})

function handleBeforeUnload(event) {
    if (form.isDirty) {
        event.preventDefault()
        event.returnValue = ''
    }
}

function submitForm() {
    // Validasi form
    if (!form.judul) {
        openError('Judul berita wajib diisi')
        return
    }
    if (!form.ringkasan) {
        openError('Ringkasan berita wajib diisi')
        return
    }
    if (!form.isi) {
        openError('Isi berita wajib diisi')
        return
    }
    if (!form.penulis) {
        openError('Penulis wajib diisi')
        return
    }

    // Pastikan isi terupdate dari editor
    if (editorInstance.value) {
        form.isi = editorInstance.value.getData()
    }

    saveScrollPosition()
    
    // Kirim data ke server
   form.post('/berita', {
    preserveScroll: true
})
}
</script>

<template>
    <AdminLayout>
        <div class="form-container">
            <!-- Header Section -->
            <div class="header-section">
                <div class="header-left">
                    <h1 class="page-title">Tambah Berita</h1>
                    <p class="page-subtitle">Tambahkan berita baru ke dalam sistem</p>
                </div>
                <div class="header-right">
                    <Link href="/berita" class="btn-back">
                        <span>←</span>
                        <span>Kembali</span>
                    </Link>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <form @submit.prevent="submitForm" class="custom-form">
                    <div class="form-grid">
                        <!-- Kolom Kiri -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.judul }"
                                    v-model="form.judul"
                                    placeholder="Masukkan judul berita"
                                />
                                <div v-if="form.errors.judul" class="invalid-feedback">{{ form.errors.judul }}</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.penulis }"
                                    v-model="form.penulis"
                                    placeholder="Masukkan nama penulis"
                                />
                                <div v-if="form.errors.penulis" class="invalid-feedback">{{ form.errors.penulis }}</div>
                            </div>

                            <!-- Tambahan Field Kategori -->
                            <div class="form-group">
                                <label class="form-label">Kategori <span class="text-muted">(opsional)</span></label>
                                <select 
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.kategori }"
                                    v-model="form.kategori"
                                >
                                    <option value="Info">Info</option>
                                    <option value="Penting">Penting</option>
                                    <option value="Kegiatan">Kegiatan</option>
                                    <option value="Kesehatan">Kesehatan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div v-if="form.errors.kategori" class="invalid-feedback">{{ form.errors.kategori }}</div>
                                <small class="text-muted">Kategori akan terdeteksi otomatis jika tidak dipilih</small>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="form-column">
                            <div class="form-group">
                                <label class="form-label">Ringkasan <span class="text-danger">*</span></label>
                                <textarea 
                                    class="form-control" 
                                    :class="{ 'is-invalid': form.errors.ringkasan }"
                                    v-model="form.ringkasan"
                                    rows="4"
                                    placeholder="Masukkan ringkasan berita (maks 500 karakter)"
                                ></textarea>
                                <div v-if="form.errors.ringkasan" class="invalid-feedback">{{ form.errors.ringkasan }}</div>
                                <small class="text-muted">{{ form.ringkasan.length }}/500 karakter</small>
                            </div>
                        </div>
                    </div>

                    <!-- Isi Berita (Full Width) -->
                    <div class="form-group full-width mt-4">
                        <label class="form-label">Isi Berita <span class="text-danger">*</span></label>
                        <textarea name="editor-full" id="editor-full" rows="4" cols="4"></textarea>
                        <div v-if="form.errors.isi" class="invalid-feedback">{{ form.errors.isi }}</div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" @click="router.visit('/berita')">
                            Batal
                        </button>
                        <button type="submit" class="btn-submit" :disabled="form.processing">
                            <span v-if="form.processing">⏳</span>
                            <span v-else>✓</span>
                            <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Berita' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Notifikasi -->
        <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
            <div class="modal-card">
                <div class="text-center">
                    <div :class="modalType === 'success' ? 'success-icon' : 'error-icon'">
                        {{ modalType === 'success' ? '✓' : '✗' }}
                    </div>
                    <h4 class="mt-3">{{ modalType === 'success' ? 'Berhasil!' : 'Gagal!' }}</h4>
                    <p class="text-muted">{{ modalMessage }}</p>
                    <button class="btn-modal-close" @click="showModal = false">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.form-container {
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

/* Form Section */
.form-section {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.custom-form {
    width: 100%;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 32px;
}

.form-column {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-group.full-width {
    width: 100%;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.form-control {
    width: 100%;
    height: 42px;
    padding: 0 16px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #1e293b;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #1e293b;
    background: white;
    box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
}

.form-control.is-invalid {
    border-color: #dc2626;
    background: #fef2f2;
}

textarea.form-control {
    height: auto;
    padding: 12px 16px;
    resize: vertical;
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 16px;
    padding-right: 48px;
}

.invalid-feedback {
    font-size: 12px;
    color: #dc2626;
    margin-top: 4px;
}

.text-danger {
    color: #dc2626;
}

.text-muted {
    color: #64748b;
    font-size: 12px;
    margin-top: 4px;
}

.mt-4 {
    margin-top: 24px;
}

.mt-3 {
    margin-top: 16px;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 16px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 2px solid #f1f5f9;
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #f1f5f9;
    color: #475569;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #1e293b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 32px;
    background: #1e293b;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    min-width: 150px;
    justify-content: center;
}

.btn-submit:hover:not(:disabled) {
    background: #0f172a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.3);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal-card {
    background: white;
    padding: 32px;
    border-radius: 20px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.success-icon {
    width: 60px;
    height: 60px;
    background: #10b981;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto;
}

.error-icon {
    width: 60px;
    height: 60px;
    background: #dc2626;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto;
}

.btn-modal-close {
    padding: 10px 32px;
    background: #1e293b;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 16px;
}

.btn-modal-close:hover {
    background: #0f172a;
    transform: translateY(-2px);
}

/* CKEditor */
:global(.cke) {
    width: 100% !important;
    border-radius: 10px !important;
    overflow: hidden !important;
}

:global(.cke_inner) {
    border-radius: 10px !important;
}

:global(.cke_top) {
    background: #f8fafc !important;
    border-bottom: 2px solid #e2e8f0 !important;
    padding: 8px !important;
}

:global(.cke_bottom) {
    background: #f8fafc !important;
    border-top: 2px solid #e2e8f0 !important;
    padding: 8px !important;
}
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    background: white;
    border-radius: 8px;
    padding: 14px 18px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.toast-notification.success {
    border-left: 5px solid #22c55e;
}

.toast-notification.error {
    border-left: 5px solid #ef4444;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.toast-close {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}
/*animasi nya */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all .3s ease;
}

.slide-fade-enter-from {
  opacity: 0;
  transform: translateX(40px);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(40px);
}
/* Responsive */
@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .form-container {
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
    
    .form-section {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column-reverse;
    }
    
    .btn-cancel, .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>