<template>
    <div class="rekapitulasi-container">
        <h1>Rekapitulasi Data Posyandu</h1>
        
        <div class="filter-card">
            <h3>Filter Laporan (Opsional)</h3>
            <p class="filter-subtitle">Kosongkan jika ingin semua data</p>
            
            <div class="filter-grid">
                <!-- Kecamatan (OPSIONAL) -->
                <div class="filter-item">
                    <label>Kecamatan</label>
                    <select v-model="form.id_kecamatan">
                        <option value="">-- Semua Kecamatan --</option>
                        <option v-for="k in kecamatan" :key="k.id_kec" :value="k.id_kec">
                            {{ k.nama_kec }}
                        </option>
                    </select>
                </div>
                
                <!-- Kelurahan (OPSIONAL) -->
                <div class="filter-item">
                    <label>Kelurahan</label>
                    <select v-model="form.id_kelurahan" :disabled="!form.id_kecamatan">
                        <option value="">-- Semua Kelurahan --</option>
                        <option v-for="k in kelurahanOptions" :key="k.id_kel" :value="k.id_kel">
                            {{ k.nama_kel }}
                        </option>
                    </select>
                </div>
                
                <!-- Posyandu (OPSIONAL) -->
                <div class="filter-item">
                    <label>Posyandu</label>
                    <select v-model="form.id_posyandu" :disabled="!form.id_kelurahan">
                        <option value="">-- Semua Posyandu --</option>
                        <option v-for="p in posyanduOptions" :key="p.id_posyandu" :value="p.id_posyandu">
                            {{ p.nama_posyandu }}
                        </option>
                    </select>
                </div>
                
                <!-- Tahun (OPSIONAL) -->
                <div class="filter-item">
                    <label>Tahun</label>
                    <select v-model="form.tahun">
                        <option value="">-- Semua Tahun --</option>
                        <option v-for="tahun in tahunOptions" :key="tahun" :value="tahun">
                            {{ tahun }}
                        </option>
                    </select>
                    <small class="info-text">*Kosongkan untuk semua tahun</small>
                </div>

                <!-- Format Output -->
                <div class="filter-item">
                    <label>Format Output</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" v-model="form.output" value="pdf" />
                            <span>PDF</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" v-model="form.output" value="excel" />
                            <span>Excel (XLSX)</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORMAT CARDS - TAMPILKAN SEMUA FORMAT 1-6 DENGAN DESKRIPSI YANG BENAR -->
        <div class="format-grid">
            <!-- Format 1 -->
            <div class="format-card">
                <div class="format-header">
                    <span class="format-number">1</span>
                    <h4>Catatan Ibu Hamil, Kelahiran & Kematian</h4>
                </div>
                <p class="format-desc">
                    <strong>Data:</strong> Nama ibu, nama bayi, tanggal lahir, 
                    tanggal meninggal bayi, tanggal meninggal ibu, keterangan
                </p>
                <div class="format-actions">
                    <button @click="exportFormat('f1')" class="btn-export" :class="form.output">
                        <span>{{ form.output === 'pdf' ? '📄' : '📊' }}</span>
                        Download {{ form.output.toUpperCase() }}
                    </button>
                </div>
            </div>

            <!-- Format 2 -->
            <div class="format-card">
                <div class="format-header">
                    <span class="format-number">2</span>
                    <h4>Register Bayi (0-12 bulan)</h4>
                </div>
                <p class="format-desc">
                    <strong>Data:</strong> Nama bayi, tgl lahir, BB lahir, nama orang tua,
                    hasil penimbangan per bulan, imunisasi (BCG, DPT, POLIO, CAMPAK, HEP),
                    vitamin A, kematian bayi
                </p>
                <div class="format-actions">
                    <button @click="exportFormat('f2')" class="btn-export" :class="form.output">
                        <span>{{ form.output === 'pdf' ? '📄' : '📊' }}</span>
                        Download {{ form.output.toUpperCase() }}
                    </button>
                </div>
            </div>

            <!-- Format 3 -->
            <div class="format-card">
                <div class="format-header">
                    <span class="format-number">3</span>
                    <h4>Register WUS & PUS (KB & Imunisasi TT)</h4>
                </div>
                <p class="format-desc">
                    <strong>Data:</strong> Nama WUS/PUS, umur, nama suami, tahapan KS,
                    kelompok dasawisma, jumlah anak (hidup/meninggal), LILA, kapsul yodium,
                    imunisasi TT, jenis kontrasepsi, riwayat pergantian KB
                </p>
                <div class="format-actions">
                    <button @click="exportFormat('f3')" class="btn-export" :class="form.output">
                        <span>{{ form.output === 'pdf' ? '📄' : '📊' }}</span>
                        Download {{ form.output.toUpperCase() }}
                    </button>
                </div>
            </div>

            <!-- Format 4 -->
            <div class="format-card">
                <div class="format-header">
                    <span class="format-number">4</span>
                    <h4>Register Ibu Hamil</h4>
                </div>
                <p class="format-desc">
                    <strong>Data:</strong> Nama ibu hamil, umur, kelompok dasawisma,
                    tgl daftar, UK, hamil ke, pil tambah darah, imunisasi TT, kapsul yodium,
                    hasil penimbangan per bulan, risiko, riwayat melahirkan, kondisi bayi
                </p>
                <div class="format-actions">
                    <button @click="exportFormat('f4')" class="btn-export" :class="form.output">
                        <span>{{ form.output === 'pdf' ? '📄' : '📊' }}</span>
                        Download {{ form.output.toUpperCase() }}
                    </button>
                </div>
            </div>

            <!-- Format 5 -->
            <div class="format-card">
                <div class="format-header">
                    <span class="format-number">5</span>
                    <h4>Data Pengunjung & Petugas</h4>
                </div>
                <p class="format-desc">
                    <strong>Data:</strong> Jumlah pengunjung (balita, WUS, PUS, ibu hamil, ibu menyusui),
                    jumlah petugas (kader, PLKB, medis), jumlah bayi lahir (L/P),
                    jumlah bayi meninggal (L/P) per bulan
                </p>
                <div class="format-actions">
                    <button @click="exportFormat('f5')" class="btn-export" :class="form.output">
                        <span>{{ form.output === 'pdf' ? '📄' : '📊' }}</span>
                        Download {{ form.output.toUpperCase() }}
                    </button>
                </div>
            </div>

            <!-- Format 6 -->
            <div class="format-card">
                <div class="format-header">
                    <span class="format-number">6</span>
                    <h4>Data Kegiatan Posyandu</h4>
                </div>
                <p class="format-desc">
                    <strong>Data:</strong> Jumlah ibu hamil, yang diperiksa, FE tablet,
                    ibu menyusui, akseptor KB per jenis, balita (L/P), kepemilikan KMS,
                    balita ditimbang, naik BB, vitamin A, PMT, imunisasi TT per bulan
                </p>
                <div class="format-actions">
                    <button @click="exportFormat('f6')" class="btn-export" :class="form.output">
                        <span>{{ form.output === 'pdf' ? '📄' : '📊' }}</span>
                        Download {{ form.output.toUpperCase() }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Pesan error -->
        <div v-if="$page.props.flash.error" class="alert-error">
            {{ $page.props.flash.error }}
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
    kecamatan: Array,
    kelurahan: Object,
    posyandu: Object,
    wuspus: Object
})

// Filter form - semua OPSIONAL
const form = ref({
    id_kecamatan: '',
    id_kelurahan: '',
    id_posyandu: '',
    tahun: '',
    output: 'pdf'
})

// Tahun sekarang
const tahunSekarang = new Date().getFullYear()

// Opsi tahun
const tahunOptions = computed(() => {
    const tahun = []
    for (let i = tahunSekarang; i >= 2020; i--) {
        tahun.push(i)
    }
    return tahun
})

// Options kelurahan
const kelurahanOptions = computed(() => {
    if (!form.value.id_kecamatan) return []
    return props.kelurahan[form.value.id_kecamatan] || []
})

// Options posyandu
const posyanduOptions = computed(() => {
    if (!form.value.id_kelurahan) return []
    return props.posyandu[form.value.id_kelurahan] || []
})

// Reset saat kecamatan berubah
watch(() => form.value.id_kecamatan, () => {
    form.value.id_kelurahan = ''
    form.value.id_posyandu = ''
})

// Reset saat kelurahan berubah
watch(() => form.value.id_kelurahan, () => {
    form.value.id_posyandu = ''
})

// Fungsi export
function exportFormat(format) {
    // Validasi tahun
    if (form.value.tahun && form.value.tahun > tahunSekarang) {
        alert(`Tahun ${form.value.tahun} belum tersedia. Maksimal tahun ${tahunSekarang}`)
        return
    }
    
    const params = new URLSearchParams({
        id_kecamatan: form.value.id_kecamatan || '',
        id_kelurahan: form.value.id_kelurahan || '',
        id_posyandu: form.value.id_posyandu || '',
        tahun: form.value.tahun || 'All',
        output: form.value.output
    })
    
    window.open(`/rekapitulasi/export/${format}?${params.toString()}`, '_blank')
}
</script>

<style scoped>
.rekapitulasi-container {
    padding: 24px;
    max-width: 1400px;
    margin: 0 auto;
}

h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 24px;
}

.filter-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 32px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.filter-card h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 4px 0;
}

.filter-subtitle {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 20px;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.filter-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-item label {
    font-weight: 600;
    font-size: 13px;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.filter-item select {
    height: 42px;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    padding: 0 12px;
    font-size: 14px;
    background: #f8fafc;
}

.filter-item select:focus {
    border-color: #3498db;
    outline: none;
}

.filter-item select:disabled {
    background: #f1f5f9;
    cursor: not-allowed;
}

.info-text {
    color: #64748b;
    font-size: 11px;
    margin-top: 4px;
}

.radio-group {
    display: flex;
    gap: 20px;
    margin-top: 8px;
}

.radio-label {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    font-size: 14px;
}

.radio-label input[type="radio"] {
    width: 16px;
    height: 16px;
}

/* Format Grid */
.format-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 20px;
}

.format-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}

.format-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border-color: #3498db;
}

.format-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.format-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: #3498db;
    color: white;
    border-radius: 8px;
    font-weight: 700;
    font-size: 16px;
}

.format-header h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.format-desc {
    font-size: 12px;
    color: #475569;
    margin-bottom: 16px;
    line-height: 1.5;
    min-height: 60px;
}

.format-desc strong {
    color: #1e293b;
}

.format-actions {
    display: flex;
    justify-content: flex-end;
}

.btn-export {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

/* 🔥 FIX: Warna button download biru muda ketuaan */
.btn-export.pdf {
    background: #3498db;  /* Biru muda ketuaan */
    color: white;
}

.btn-export.excel {
    background: #2ecc71;  /* Hijau untuk Excel */
    color: white;
}

.btn-export.pdf:hover {
    background: #2980b9;  /* Biru lebih tua saat hover */
    transform: translateY(-1px);
}

.btn-export.excel:hover {
    background: #27ae60;  /* Hijau lebih tua saat hover */
    transform: translateY(-1px);
}

.alert-error {
    background: #fee2e2;
    color: #b91c1c;
    padding: 16px;
    border-radius: 8px;
    margin-top: 24px;
    border-left: 4px solid #ef4444;
}

@media (max-width: 768px) {
    .rekapitulasi-container {
        padding: 16px;
    }
    
    .format-grid {
        grid-template-columns: 1fr;
    }
}
</style>