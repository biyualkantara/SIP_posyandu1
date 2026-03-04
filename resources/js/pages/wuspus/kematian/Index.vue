<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import { ref, computed, watch, onMounted } from 'vue'

const props = defineProps({
  data: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  filter: Object
})

// Debug: lihat data yang diterima
console.log('Data Kematian WUS/PUS:', props.data)
console.log('Rows:', props.data?.data)

// Ambil flash message dari Inertia
const page = usePage()
const flash = computed(() => page.props.flash)

// State untuk notifikasi toast
const toast = ref({
  show: false,
  type: 'success',
  message: '',
  timeout: null
})

// State untuk menyimpan posisi scroll
const scrollPosition = ref(0)

// Simpan posisi scroll sebelum pindah halaman
const saveScrollPosition = () => {
  scrollPosition.value = window.scrollY
  sessionStorage.setItem('scrollPosition_wuspus_kematian', scrollPosition.value)
}

// Restore posisi scroll setelah kembali
const restoreScrollPosition = () => {
  const savedPosition = sessionStorage.getItem('scrollPosition_wuspus_kematian')
  if (savedPosition) {
    setTimeout(() => {
      window.scrollTo({
        top: parseInt(savedPosition),
        behavior: 'smooth'
      })
      sessionStorage.removeItem('scrollPosition_wuspus_kematian')
    }, 100)
  }
}

// Simpan scroll saat link diklik
const handleLinkClick = () => {
  saveScrollPosition()
}

// Restore scroll saat halaman dimuat
onMounted(() => {
  restoreScrollPosition()
  
  // Tampilkan flash message jika ada
  if (flash.value?.success) {
    showToast('success', flash.value.success)
  } else if (flash.value?.error) {
    showToast('error', flash.value.error)
  } else if (flash.value?.info) {
    showToast('info', flash.value.info)
  }
  
  // Listener untuk custom event toast
  window.addEventListener('toast', handleCustomToast)
  
  // Cleanup
  return () => {
    window.removeEventListener('toast', handleCustomToast)
    if (toast.value.timeout) {
      clearTimeout(toast.value.timeout)
    }
  }
})

// Watch untuk flash message changes
watch(flash, (newFlash) => {
  if (newFlash?.success) {
    showToast('success', newFlash.success)
  } else if (newFlash?.error) {
    showToast('error', newFlash.error)
  } else if (newFlash?.info) {
    showToast('info', newFlash.info)
  }
}, { deep: true })

function handleCustomToast(event) {
  showToast(event.detail.type, event.detail.message)
}

function showToast(type, message, duration = 3000) {
  // Clear existing timeout
  if (toast.value.timeout) {
    clearTimeout(toast.value.timeout)
  }
  
  toast.value.show = true
  toast.value.type = type
  toast.value.message = message
  
  // Auto hide after duration
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

// Pastikan rows adalah array
const rows = computed(() => {
  if (!props.data) return []
  if (Array.isArray(props.data)) return props.data
  if (props.data.data && Array.isArray(props.data.data)) return props.data.data
  return []
})

// Debug rows
console.log('Rows setelah diproses:', rows.value)

const columns = [
  { key: 'id', label: 'ID', sortable: true },
  { key: 'nama_wuspus', label: 'Nama WUS/PUS', sortable: true },
  { key: 'posyandu', label: 'Posyandu', sortable: true },
  { key: 'tgl_wafat', label: 'Tanggal Wafat', sortable: true },
  { key: 'penyebab', label: 'Penyebab', sortable: true },
  { key: 'ket', label: 'Keterangan', sortable: false },
  { key: 'actions', label: 'Aksi', sortable: false },
]

const selectedKec = ref(props.filter?.kec ?? '')
const selectedKel = ref(props.filter?.kel ?? '')
const selectedPos = ref(props.filter?.pos ?? '')
const searchText  = ref(props.filter?.q ?? '')

const kelurahanList = computed(() => {
  if (!selectedKec.value) return []
  return props.kelurahan?.[selectedKec.value] ?? []
})

const posyanduList = computed(() => {
  if (!selectedKel.value) return []
  return props.posyandu?.[selectedKel.value] ?? []
})

watch(selectedKec, () => { 
  selectedKel.value = ''; 
  selectedPos.value = '' 
})

watch(selectedKel, () => { 
  selectedPos.value = '' 
})

function applyFilter() {
  saveScrollPosition()
  router.get('/posyandu/wuspus-kematian', {
    kec: selectedKec.value || '',
    kel: selectedKel.value || '',
    pos: selectedPos.value || '',
    q:   searchText.value || '',
  }, { 
    preserveState: true, 
    preserveScroll: true, 
    replace: true,
    onSuccess: () => {
      showToast('info', 'Filter diterapkan')
      restoreScrollPosition()
    }
  })
}

// Fungsi untuk mendapatkan nama posyandu dari berbagai kemungkinan struktur data
const getNamaPosyandu = (row) => {
  // Cek langsung dari row
  if (row.nama_posyandu) return row.nama_posyandu
  
  // Cek dari relasi posyandu
  if (row.posyandu?.nama_posyandu) return row.posyandu.nama_posyandu
  
  // Cek dari relasi duspy
  if (row.duspy?.nama_posyandu) return row.duspy.nama_posyandu
  
  // Fallback
  return '-'
}

// Format tanggal
const formatTanggal = (tgl) => {
  if (!tgl) return '-'
  const date = new Date(tgl)
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}

// Modal delete
const modalOpen = ref(false)
const selected = ref({})

function askDelete(row) {
  selected.value = row
  modalOpen.value = true
}

function closeModal() {
  modalOpen.value = false
  selected.value = {}
}

function confirmDelete() {
  if (!selected.value?.id) {
    showToast('error', 'Data tidak valid')
    closeModal()
    return
  }

  const namaWuspus = selected.value.nama_wuspus || 'Data kematian'
  saveScrollPosition()
  
  router.delete(`/posyandu/wuspus-kematian/${selected.value.id}`, {
    preserveScroll: true,
    onSuccess: (page) => {
      closeModal()
      
      // Cek flash message dari response
      if (page.props.flash?.success) {
        showToast('success', page.props.flash.success)
      } else {
        // Fallback message
        showToast('success', `Data kematian "${namaWuspus}" berhasil dihapus!`)
      }
      
      // Reload data
      router.reload({ only: ['data'] })
      restoreScrollPosition()
    },
    onError: (errors) => {
      closeModal()
      
      // Tampilkan notifikasi error
      let errorMsg = 'Gagal menghapus data.'
      if (errors.message) {
        errorMsg = errors.message
      } else if (typeof errors === 'object') {
        errorMsg = Object.values(errors).join(', ')
      }
      
      showToast('error', errorMsg)
      restoreScrollPosition()
      
      // Cek flash error dari response
      if (page.props.flash?.error) {
        showToast('error', page.props.flash.error)
      }
    }
  })
}

// Fungsi untuk mendapatkan kelas button berdasarkan tipe
const getButtonClass = (type) => {
  const baseClass = 'action-btn'
  switch(type) {
    case 'show':
      return `${baseClass} btn-show`
    case 'edit':
      return `${baseClass} btn-edit`
    case 'delete':
      return `${baseClass} btn-delete`
    default:
      return baseClass
  }
}

// Fungsi untuk format nilai null/undefined
const formatValue = (value) => {
  if (value === null || value === undefined || value === '') {
    return '-'
  }
  return value
}
</script>

<template>
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

  <div class="data-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="header-left">
        <h1 class="page-title">Kematian WUS/PUS</h1>
        <p class="page-subtitle">Kelola data kematian WUS/PUS (Wanita Usia Subur / Pasangan Usia Subur)</p>
      </div>
      <div class="header-right">
        <Link 
          href="/posyandu/wuspus-kematian/create" 
          class="btn-create"
          @click="handleLinkClick"
        >
          <span>+</span>
          <span>Tambah Data</span>
        </Link>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-grid">
        <div class="filter-item">
          <label class="filter-label">Kecamatan</label>
          <div class="select-wrapper">
            <select class="filter-select" v-model="selectedKec" @change="applyFilter">
              <option value="">Semua Kecamatan</option>
              <option v-for="k in kecamatan" :key="k.id_kec" :value="k.id_kec">
                {{ k.nama_kec }}
              </option>
            </select>
            <span class="select-icon">▼</span>
          </div>
        </div>

        <div class="filter-item">
          <label class="filter-label">Kelurahan</label>
          <div class="select-wrapper">
            <select class="filter-select" v-model="selectedKel" :disabled="!selectedKec" @change="applyFilter">
              <option value="">Semua Kelurahan</option>
              <option v-for="k in kelurahanList" :key="k.id_kel" :value="k.id_kel">
                {{ k.nama_kel }}
              </option>
            </select>
            <span class="select-icon">▼</span>
          </div>
        </div>

        <div class="filter-item">
          <label class="filter-label">Posyandu</label>
          <div class="select-wrapper">
            <select class="filter-select" v-model="selectedPos" :disabled="!selectedKel" @change="applyFilter">
              <option value="">Semua Posyandu</option>
              <option v-for="p in posyanduList" :key="p.id_posyandu" :value="p.id_posyandu">
                {{ p.nama_posyandu }}
              </option>
            </select>
            <span class="select-icon">▼</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Debug Info (Hapus setelah selesai) -->
    <div v-if="false" class="debug-info mb-3">
      <pre>Total Data: {{ props.data?.total || 0 }}</pre>
      <pre>Jumlah Rows: {{ rows.length }}</pre>
    </div>

    <!-- Table Section -->
    <div class="table-section">
      <!-- Tampilkan pesan jika tidak ada data -->
      <div v-if="rows.length === 0" class="empty-state">
        <div class="empty-icon">
          <span>📊</span>
        </div>
        <h3 class="empty-title">Belum Ada Data</h3>
        <p class="empty-description">Data kematian WUS/PUS belum tersedia. Silakan tambah data baru.</p>
        <Link href="/posyandu/wuspus-kematian/create" class="btn-create empty-btn" @click="handleLinkClick">
          <span>+</span>
          <span>Tambah Data Pertama</span>
        </Link>
      </div>

      <!-- Tampilkan tabel jika ada data -->
      <DataTable v-else :columns="columns" :rows="rows" :perPage="10">
        <!-- Custom Column Templates -->
        <template #col-id="{ row }">
          <span class="id-badge">#{{ row.id }}</span>
        </template>

        <template #col-nama_wuspus="{ row }">
          <div class="nama-info">
            <span class="nik-text">{{ row.nik_wuspus || '-' }}</span>
            <span class="nama-text">{{ formatValue(row.nama_wuspus) }}</span>
          </div>
        </template>

        <template #col-posyandu="{ row }">
          <span class="posyandu-badge">
            {{ getNamaPosyandu(row) }}
          </span>
        </template>

        <template #col-tgl_wafat="{ row }">
          <span class="tanggal-text">{{ formatTanggal(row.tgl_wafat) }}</span>
        </template>

        <template #col-penyebab="{ row }">
          <span class="penyebab-badge">{{ row.penyebab || '-' }}</span>
        </template>

        <template #col-ket="{ row }">
          <span class="keterangan-text">{{ row.ket || '-' }}</span>
        </template>

        <template #col-actions="{ row }">
          <div class="action-group">
            <Link 
              :href="`/posyandu/wuspus-kematian/${row.id}`"
              @click="handleLinkClick"
            >
              <span :class="getButtonClass('show')" title="Lihat Detail">
                <i class="icon-eye"></i>
              </span>
            </Link>

            <Link 
              :href="`/posyandu/wuspus-kematian/${row.id}/edit`"
              @click="handleLinkClick"
            >
              <span :class="getButtonClass('edit')" title="Edit Data">
                <i class="icon-pencil"></i>
              </span>
            </Link>

            <span 
              :class="getButtonClass('delete')" 
              title="Hapus Data"
              @click="askDelete(row)"
            >
              <i class="icon-trash"></i>
            </span>
          </div>
        </template>
      </DataTable>

      <!-- Pagination -->
      <div class="pagination-section" v-if="props.data?.links?.length && rows.length > 0">
        <div class="pagination-info">
          Menampilkan {{ props.data.from || 0 }} - {{ props.data.to || 0 }} 
          dari {{ props.data.total || 0 }} data
        </div>
        <nav class="pagination-nav">
          <ul class="pagination-list">
            <li v-for="(l, idx) in props.data.links" :key="idx" 
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
        <span class="modal-icon">🗑️</span>
      </div>
      <h3 class="modal-title">Hapus Data Kematian?</h3>
      <p class="modal-text">Anda akan menghapus data:</p>
      
      <div class="modal-highlight">
        <div class="modal-info-item">
          <span class="modal-info-label">NIK / Nama</span>
          <div class="modal-info-value">
            <strong>{{ selected.nik_wuspus || '-' }}</strong> - {{ selected.nama_wuspus || 'Tidak diketahui' }}
          </div>
        </div>

        <div class="modal-info-item">
          <span class="modal-info-label">Posyandu</span>
          <div class="modal-info-value">
            {{ getNamaPosyandu(selected) }}
          </div>
        </div>

        <div class="modal-info-item">
          <span class="modal-info-label">Tanggal Wafat</span>
          <div class="modal-info-value">
            {{ formatTanggal(selected.tgl_wafat) }}
          </div>
        </div>

        <div class="modal-info-item">
          <span class="modal-info-label">Penyebab</span>
          <div class="modal-info-value">
            {{ selected.penyebab || '-' }}
          </div>
        </div>
      </div>

      <p class="modal-warning">
        <span>⚠️</span>
        <span>Data yang dihapus tidak dapat dikembalikan</span>
      </p>

      <div class="modal-actions">
        <button class="modal-btn modal-btn-cancel" @click="closeModal">
          <span>✕</span>
          <span>Batal</span>
        </button>
        <button class="modal-btn modal-btn-delete" @click="confirmDelete">
          <span>🗑️</span>
          <span>Hapus</span>
        </button>
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

/* Button Create (Biru Tua) */
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

.btn-create:active {
  background: #1e293b;
  transform: translateY(0);
  box-shadow: 0 2px 4px rgba(30, 41, 59, 0.1);
}

/* Filter Section */
.filter-section {
  background: white;
  border-radius: 16px;
  padding: 20px 24px;
  margin-bottom: 24px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.filter-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.filter-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.filter-label {
  font-size: 13px;
  font-weight: 600;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

/* Select Wrapper */
.select-wrapper {
  position: relative;
  width: 100%;
}

.filter-select {
  width: 100%;
  height: 42px;
  padding: 0 16px;
  padding-right: 40px;
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  font-size: 14px;
  color: #1e293b;
  appearance: none;
  cursor: pointer;
  transition: all 0.2s;
}

.filter-select:hover:not(:disabled) {
  border-color: #94a3b8;
  background: white;
}

.filter-select:focus {
  outline: none;
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
}

.filter-select:disabled {
  background: #f1f5f9;
  border-color: #e2e8f0;
  color: #94a3b8;
  cursor: not-allowed;
}

.select-icon {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 12px;
  pointer-events: none;
}

/* Search Item */
.search-item {
  flex: 1;
}

.search-wrapper {
  display: flex;
  align-items: center;
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  transition: all 0.2s;
}

.search-wrapper:focus-within {
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
}

.search-icon {
  padding: 0 12px;
  color: #94a3b8;
  font-size: 16px;
}

.search-input {
  flex: 1;
  height: 42px;
  border: none;
  background: transparent;
  font-size: 14px;
  color: #1e293b;
  padding: 0;
}

.search-input:focus {
  outline: none;
}

.search-input::placeholder {
  color: #94a3b8;
}

.search-btn {
  height: 42px;
  padding: 0 20px;
  background: #f1f5f9;
  border: none;
  border-left: 2px solid #e2e8f0;
  border-radius: 0 8px 8px 0;
  color: #475569;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
}

.search-btn:hover {
  background: #e2e8f0;
  color: #1e293b;
}

.search-btn:active {
  background: #cbd5e1;
}

/* Debug Info */
.debug-info {
  background: #1e293b;
  color: #e2e8f0;
  padding: 12px;
  border-radius: 8px;
  font-family: monospace;
  font-size: 12px;
  margin-bottom: 16px;
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

/* Nama Info */
.nama-info {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.nik-text {
  font-size: 11px;
  color: #64748b;
}

.nama-text {
  font-weight: 500;
  color: #1e293b;
}

/* Posyandu Badge */
.posyandu-badge {
  display: inline-block;
  padding: 4px 12px;
  background: #e8f0fe;
  color: #1e293b;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
}

/* Penyebab Badge */
.penyebab-badge {
  display: inline-block;
  padding: 4px 12px;
  background: #fff3cd;
  color: #856404;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
}

/* Tanggal Text */
.tanggal-text {
  font-size: 13px;
  color: #475569;
  white-space: nowrap;
}

/* Keterangan Text */
.keterangan-text {
  font-size: 13px;
  color: #64748b;
  max-width: 200px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  display: inline-block;
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

/* Button Show */
.btn-show {
  background: #e2e8f0;
  color: #475569;
}

.btn-show:hover {
  background: #cbd5e1;
  color: #1e293b;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-show:active {
  background: #94a3b8;
  color: white;
  transform: translateY(0);
}

/* Button Edit */
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

.btn-edit:active {
  background: #93c5fd;
  color: #1e3a8a;
  transform: translateY(0);
}

/* Button Delete */
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

.btn-delete:active {
  background: #fca5a5;
  color: #7f1d1d;
  transform: translateY(0);
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

.empty-btn {
  display: inline-flex;
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

.pagination-item {
  margin: 0;
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
  font-size: 40px;
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
  margin-bottom: 12px;
  text-align: left;
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
  margin-bottom: 2px;
  text-align: center;
}

.modal-info-value {
  font-size: 14px;
  color: #1e293b;
  word-break: break-word;
  text-align: center;
}

.modal-info-value strong {
  font-weight: 600;
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

.modal-btn-cancel:active {
  background: #cbd5e1;
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

.modal-btn-delete:active {
  background: #991b1b;
  transform: translateY(0);
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
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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

/* Responsive */
@media (max-width: 1200px) {
  .filter-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

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
  
  .filter-grid {
    grid-template-columns: 1fr;
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