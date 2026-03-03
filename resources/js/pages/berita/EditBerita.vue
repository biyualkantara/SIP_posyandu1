<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import TipTapEditor from '@/components/TipTapEditor.vue';

const props = defineProps({
    berita: Object
})

const form = useForm({
    judul: props.berita.judul || '',
    ringkasan: props.berita.ringkasan || '',
    isi: props.berita.isi || '',
    penulis: props.berita.penulis || '',
})

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

onMounted(() => {
    window.addEventListener('beforeunload', handleBeforeUnload)
})

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', handleBeforeUnload)
})

function handleBeforeUnload(event) {
    event.preventDefault()
    event.returnValue = ''
}

function submitForm() {
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

    form.put(`/berita/${props.berita.id_berita}`, {
        preserveScroll: true,
        onSuccess: () => {
            openSuccess('Data berita berhasil diperbarui')
            setTimeout(() => {
                window.location.href = '/berita'
            }, 1000)
        },
        onError: (errors) => {
            console.error('Error:', errors)
            openError('Gagal menyimpan data')
        }
    })
}
</script>

<template>  
        <div class="page-wrapper">
            <!-- Header -->
            <div class="page-header">
                <div>
                    <h2 class="mb-1">Edit Berita</h2>
                    <p class="text-muted">Edit data berita</p>
                </div>
                <Link href="/berita" class="btn btn-outline-secondary">
                    <i class="icon-arrow-left me-2"></i>Kembali
                </Link>
            </div>

            <div class="main-card">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <!-- Form Data -->
                        <div class="data-card">
                            <div class="data-header">
                                <div>
                                    <span class="badge bg-primary me-2">1</span>
                                    <strong>Data Berita</strong>
                                </div>
                            </div>

                            <div class="grid-2">
                                <div class="field">
                                    <label>Judul Berita <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        v-model="form.judul"
                                        placeholder="Masukkan judul berita"
                                    />
                                    <span v-if="form.errors.judul" class="error-text">{{ form.errors.judul }}</span>
                                </div>

                                <div class="field">
                                    <label>Penulis <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        v-model="form.penulis"
                                        placeholder="Masukkan nama penulis"
                                    />
                                    <span v-if="form.errors.penulis" class="error-text">{{ form.errors.penulis }}</span>
                                </div>
                            </div>

                            <div class="field mt-3">
                                <label>Ringkasan <span class="text-danger">*</span></label>
                                <textarea 
                                    class="form-control" 
                                    v-model="form.ringkasan"
                                    rows="3"
                                    placeholder="Masukkan ringkasan berita"
                                ></textarea>
                                <span v-if="form.errors.ringkasan" class="error-text">{{ form.errors.ringkasan }}</span>
                            </div>

                            <div class="field mt-3">
                                <label>Isi Berita <span class="text-danger">*</span></label>
                                <TipTapEditor v-model="form.isi" />
                                <span v-if="form.errors.isi" class="error-text">{{ form.errors.isi }}</span>
                            </div>
                        </div>

                        <div class="form-footer">
                            <Link href="/berita" class="btn btn-outline-secondary">
                                <i class="icon-close me-2"></i>Batal
                            </Link>
                            <button type="submit" class="btn btn-primary" :disabled="form.processing">
                                <i class="icon-check me-2"></i>
                                {{ form.processing ? 'Menyimpan...' : 'Ubah Data' }}
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
                    <i 
                        class="icon" 
                        :class="{
                            'icon-check-circle text-success': modalType === 'success',
                            'icon-exclamation-circle text-danger': modalType === 'error'
                        }"
                        style="font-size: 48px;"
                    ></i>
                    <h4 class="mt-3">{{ modalType === 'success' ? 'Berhasil!' : 'Gagal!' }}</h4>
                    <p class="text-muted">{{ modalMessage }}</p>
                    <button class="btn btn-primary mt-3" @click="showModal = false">Tutup</button>
                </div>
            </div>
        </div>
</template>

<style scoped>
.page-wrapper {
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px 16px 40px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-header h2 {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.page-header p {
    color: #64748b;
    margin: 4px 0 0 0;
}

.main-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    overflow: hidden;
}

.card-body {
    padding: 28px;
}

.data-card {
    border: 1px solid #eef1f4;
    border-radius: 12px;
    padding: 20px;
    background: white;
    transition: all 0.2s;
}

.data-card:hover {
    border-color: #cbd5e0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}

.data-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eef1f4;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.field label {
    font-weight: 500;
    font-size: 14px;
    color: #4a5568;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 16px;
}

.form-control {
    height: 42px;
    border-radius: 8px;
    border: 1.5px solid #e5e7eb;
    padding: 0 12px;
    font-size: 14px;
    transition: all 0.2s;
    width: 100%;
}

.form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    outline: none;
}

textarea.form-control {
    height: auto;
    padding: 10px 12px;
    resize: vertical;
}

.error-text {
    color: #f56565;
    font-size: 12px;
    margin-top: 4px;
}

.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 2px solid #f0f2f5;
}

.btn {
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: #4299e1;
    color: white;
}

.btn-primary:hover:not(:disabled) {
    background: #3182ce;
    transform: translateY(-1px);
}

.btn-primary:disabled {
    background: #a0aec0;
    cursor: not-allowed;
}

.btn-outline-secondary {
    background: transparent;
    border: 1.5px solid #718096;
    color: #718096;
}

.btn-outline-secondary:hover {
    background: #718096;
    color: white;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
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
}

@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        flex-direction: column;
        gap: 12px;
        align-items: start;
    }
    
    .form-footer {
        flex-direction: column-reverse;
    }
    
    .form-footer .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>