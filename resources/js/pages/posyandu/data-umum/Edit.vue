<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, useForm } from "@inertiajs/vue3"
import { ref, computed } from "vue"

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

function submitForm() {
    if (!selectedKec.value) {
        openError('Kecamatan wajib dipilih')
        return
    }
    if (!selectedKel.value) {
        openError('Kelurahan wajib dipilih')
        return
    }

    form.put(`/posyandu/data-umum/${props.duspy.id_posyandu}`, {
        preserveScroll: true,
        onSuccess: () => {
            openSuccess('Data posyandu berhasil diperbarui')
            setTimeout(() => {
                window.location.href = '/posyandu/data-umum'
            }, 1000)
        },
        onError: (errors) => {
            console.error('Error:', errors)
            openError('Gagal memperbarui data')
        }
    })
}
</script>

<template>
    <div class="page-wrapper">
        <!-- Header -->
        <div class="page-header">
            <div>
                <h2 class="mb-1">Edit Data Posyandu</h2>
                <p class="text-muted">Edit data umum posyandu</p>
            </div>
            <Link href="/posyandu/data-umum" class="btn btn-outline-secondary">
                <i class="icon-arrow-left me-2"></i>Kembali
            </Link>
        </div>

        <div class="main-card">
            <div class="card-body">
                <form @submit.prevent="submitForm">
                    <!-- Filter Lokasi (bisa diedit) -->
                    <div class="filter-box">
                        <h6 class="mb-3">Pilih Lokasi</h6>
                        <div class="grid-2">
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
                        </div>
                    </div>

                    <!-- Form Data Posyandu -->
                    <div class="data-card mt-4">
                        <div class="data-header">
                            <div>
                                <span class="badge bg-primary me-2">1</span>
                                <strong>Edit Data Posyandu</strong>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="field">
                                <label>Nama Posyandu <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.nama_posyandu"
                                    placeholder="Masukkan nama posyandu"
                                />
                            </div>

                            <div class="field">
                                <label>Strata <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="form.strata_psy">
                                    <option value="">-- Pilih Strata --</option>
                                    <option value="Pratama">Pratama</option>
                                    <option value="Madya">Madya</option>
                                    <option value="Purnama">Purnama</option>
                                    <option value="Mandiri">Mandiri</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid-2 mt-3">
                            <div class="field">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.alamat_posyandu"
                                    placeholder="Masukkan alamat"
                                />
                            </div>

                            <div class="field">
                                <label>PJ Umum <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.pj_umum"
                                    placeholder="Nama penanggung jawab umum"
                                />
                            </div>
                        </div>

                        <div class="grid-2 mt-3">
                            <div class="field">
                                <label>PJ Operasional <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.pj_operasional"
                                    placeholder="Nama penanggung jawab operasional"
                                />
                            </div>

                            <div class="field">
                                <label>Ketua Pelaksana <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.ketuplak"
                                    placeholder="Nama ketua pelaksana"
                                />
                            </div>
                        </div>

                        <div class="grid-2 mt-3">
                            <div class="field">
                                <label>Sekretaris <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.sekretaris"
                                    placeholder="Nama sekretaris"
                                />
                            </div>

                            <div class="field">
                                <label>Integrasi PAUD <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="form.int_paud">
                                    <option :value="null">-- Pilih --</option>
                                    <option :value="1">Ya</option>
                                    <option :value="0">Tidak</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid-3 mt-3">
                            <div class="field">
                                <label>Integrasi BKD <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="form.int_bkd">
                                    <option :value="null">-- Pilih --</option>
                                    <option :value="1">Ya</option>
                                    <option :value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="field">
                                <label>Integrasi Terpadu <span class="text-danger">*</span></label>
                                <select class="form-control" v-model="form.int_terpadu">
                                    <option :value="null">-- Pilih --</option>
                                    <option :value="1">Ya</option>
                                    <option :value="0">Tidak</option>
                                </select>
                            </div>

                            <div class="field">
                                <label>Kader Aktif <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    v-model="form.kader_aktif"
                                    placeholder="Jumlah"
                                />
                            </div>
                        </div>

                        <div class="grid-3 mt-3">
                            <div class="field">
                                <label>Kader Tidak Aktif <span class="text-danger">*</span></label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    v-model="form.kader_taktif"
                                    placeholder="Jumlah"
                                />
                            </div>

                            <div class="field">
                                <label>Petugas KB <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.ptgs_kb"
                                    placeholder="Nama petugas KB"
                                />
                            </div>

                            <div class="field">
                                <label>Petugas Medis <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.ptgs_medis"
                                    placeholder="Nama petugas medis"
                                />
                            </div>
                        </div>

                        <div class="grid-2 mt-3">
                            <div class="field">
                                <label>Petugas Bidan <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    v-model="form.ptgs_bidan"
                                    placeholder="Nama petugas bidan"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <Link href="/posyandu/data-umum" class="btn btn-outline-secondary">
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

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 16px;
}

.grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
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

@media (max-width: 768px) {
    .grid-2,
    .grid-3 {
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