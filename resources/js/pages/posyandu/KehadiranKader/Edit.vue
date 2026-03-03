<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from "@inertiajs/vue3"
import { ref, computed, watch } from "vue"

const props = defineProps({
    kdrhdr: Object,
    kecamatan: Array,
    kelurahan: Object,
    posyandu: Object
})

// Debug: lihat data yang diterima
console.log('Data dari server:', props.kdrhdr)
console.log('Bulan:', props.kdrhdr?.bulan)
console.log('PKK:', props.kdrhdr?.pkk)
console.log('PLKB:', props.kdrhdr?.plkb)
console.log('Medis:', props.kdrhdr?.medis)

// Inisialisasi form dengan data dari props
const form = useForm({
    id_posyandu: props.kdrhdr?.id_posyandu ?? null,
    bulan: props.kdrhdr?.bulan ?? '',
    pkk: props.kdrhdr?.pkk?.toString() ?? '0',
    plkb: props.kdrhdr?.plkb?.toString() ?? '0',
    medis: props.kdrhdr?.medis?.toString() ?? '0',
})

// Debug: lihat form setelah inisialisasi
console.log('Form setelah inisialisasi:', form)

// State untuk select
const selectedKec = ref(props.kdrhdr?.id_kec ? String(props.kdrhdr.id_kec) : '')
const selectedKel = ref(props.kdrhdr?.id_kel ? String(props.kdrhdr.id_kel) : '')
const selectedPos = ref(props.kdrhdr?.id_posyandu ? String(props.kdrhdr.id_posyandu) : '')

// Debug: lihat selected values
console.log('Selected Kec:', selectedKec.value)
console.log('Selected Kel:', selectedKel.value)
console.log('Selected Pos:', selectedPos.value)

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

const posyanduOptions = computed(() => {
    if (!selectedKel.value) return []
    const key = String(selectedKel.value)
    const arr = props.posyandu?.[key]
    if (!Array.isArray(arr)) return []
    return arr.map(p => ({ label: p.nama_posyandu, value: String(p.id_posyandu) }))
})

// Watch untuk update form.id_posyandu ketika selectedPos berubah
watch(selectedPos, (newVal) => {
    if (newVal) {
        form.id_posyandu = newVal
    }
})

// Watch untuk memastikan selectedPos sesuai dengan form.id_posyandu
watch(() => form.id_posyandu, (newVal) => {
    if (newVal && newVal !== selectedPos.value) {
        selectedPos.value = String(newVal)
    }
}, { immediate: true })

function submitForm() {
    if (!selectedKec.value) {
        openError('Kecamatan wajib dipilih')
        return
    }
    if (!selectedKel.value) {
        openError('Kelurahan wajib dipilih')
        return
    }
    if (!selectedPos.value) {
        openError('Posyandu wajib dipilih')
        return
    }
    if (!form.bulan) {
        openError('Bulan wajib diisi')
        return
    }

    // Debug: lihat data yang akan dikirim
    console.log('Data yang akan dikirim:', {
        id_posyandu: selectedPos.value,
        bulan: form.bulan,
        pkk: form.pkk,
        plkb: form.plkb,
        medis: form.medis
    })

    // Update form.id_posyandu dengan selectedPos
    form.id_posyandu = selectedPos.value

    form.put(`/posyandu/kehadiran-kader/${props.kdrhdr.id_kdrhdr}`, {
        preserveScroll: true,
        onSuccess: () => {
            openSuccess('Data kehadiran kader berhasil diperbarui')
            setTimeout(() => {
                window.location.href = '/posyandu/kehadiran-kader'
            }, 1000)
        },
        onError: (errors) => {
            console.error('Error:', errors)
            openError('Gagal memperbarui data: ' + JSON.stringify(errors))
        },
    })
}
</script>

<template>
    <div class="page-wrapper">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h2 class="mb-1">Edit Kehadiran Kader</h2>
                <p class="text-muted">Edit data kehadiran kader posyandu</p>
            </div>
            <Link href="/posyandu/kehadiran-kader" class="btn btn-outline-secondary">
                <i class="icon-arrow-left me-2"></i>Kembali
            </Link>
        </div>

        <div class="main-card">
            <div class="card-body">
                <!-- Debug info (sembunyikan dengan mengubah v-if="false" jika sudah tidak diperlukan) -->
                <div v-if="false" class="debug-info mb-3 p-3 bg-light">
                    <pre>Data: {{ props.kdrhdr }}</pre>
                    <pre>Bulan: {{ form.bulan }}</pre>
                    <pre>PKK: {{ form.pkk }}</pre>
                    <pre>PLKB: {{ form.plkb }}</pre>
                    <pre>Medis: {{ form.medis }}</pre>
                </div>

                <form @submit.prevent="submitForm">
                    <!-- Filter Lokasi -->
                    <div class="filter-box">
                        <h6 class="mb-3">Pilih Lokasi</h6>
                        <div class="grid-3">
                            <div class="field">
                                <label>Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="selectedKec">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <option v-for="k in kecamatan" :key="k.id_kec" :value="String(k.id_kec)">
                                        {{ k.nama_kec }}
                                    </option>
                                </select>
                            </div>

                            <div class="field">
                                <label>Kelurahan <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="selectedKel" :disabled="!selectedKec">
                                    <option value="">-- Pilih Kelurahan --</option>
                                    <option v-for="k in kelurahanOptions" :key="k.value" :value="k.value">
                                        {{ k.label }}
                                    </option>
                                </select>
                            </div>

                            <div class="field">
                                <label>Posyandu <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="selectedPos" :disabled="!selectedKel">
                                    <option value="">-- Pilih Posyandu --</option>
                                    <option v-for="p in posyanduOptions" :key="p.value" :value="p.value">
                                        {{ p.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Form Data Kehadiran -->
                    <div class="data-card mt-4">
                        <div class="data-header">
                            <div>
                                <span class="badge bg-primary me-2">1</span>
                                <strong>Edit Data Kehadiran</strong>
                            </div>
                        </div>

                        <div class="grid-4">
                            <div class="field">
                                <label>Bulan <span class="text-danger">*</span></label>
                                <input 
                                    type="month" 
                                    class="form-control" 
                                    v-model="form.bulan"
                                />
                                <small v-if="!form.bulan" class="text-danger">Bulan harus diisi</small>
                            </div>

                            <div class="field">
                                <label>PKK</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    v-model="form.pkk"
                                    placeholder="Jumlah PKK"
                                    min="0"
                                />
                            </div>

                            <div class="field">
                                <label>PLKB</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    v-model="form.plkb"
                                    placeholder="Jumlah PLKB"
                                    min="0"
                                />
                            </div>

                            <div class="field">
                                <label>Medis</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    v-model="form.medis"
                                    placeholder="Jumlah Medis"
                                    min="0"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <Link href="/posyandu/kehadiran-kader" class="btn btn-outline-secondary">
                            <i class="icon-close me-2"></i>Batal
                        </Link>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">
                            <i class="icon-check me-2"></i>
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
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

.filter-box {
    background: #f8fafc;
    padding: 24px;
    border-radius: 12px;
    margin-bottom: 24px;
    border: 1px solid #eef2f6;
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

.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 16px;
}

.grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 16px;
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
    padding: 10px 12px;
    border-radius: 20px;
    font-weight: 500;
    margin-left: 10px;
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

.debug-info {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 10px;
    font-size: 12px;
    overflow: auto;
}

@media (max-width: 768px) {
    .grid-3,
    .grid-4 {
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