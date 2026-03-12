<template>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <NavbarLanding/>
  <AdminLayout>
    <!-- Toast Notification -->
    <Transition name="slide-fade">
      <div v-if="toast.show" class="toast-notification" :class="toast.type">
        <div class="toast-content">
          <i v-if="toast.type === 'success'" class="fas fa-check-circle toast-icon"></i>
          <i v-else-if="toast.type === 'error'" class="fas fa-exclamation-circle toast-icon"></i>
          <i v-else-if="toast.type === 'info'" class="fas fa-info-circle toast-icon"></i>
          <span class="toast-message">{{ toast.message }}</span>
          <button class="toast-close" @click="hideToast">×</button>
        </div>
      </div>
    </Transition>

    <div class="esip-posyandu-page">
      <div class="posyandu-inner">
        <!-- KIRI - Panel Utama -->
        <div class="panel-main">
          <!-- Header dengan judul dan pagination -->
          <div class="panel-header">
            <div class="header-left">
              <h3 class="panel-title">Daftar Posyandu</h3>
              <span class="total-badge">Total {{ totalPosyandu }} Posyandu</span>
            </div>
            <div class="pager-wrapper">
              <button 
                class="btn-pager" 
                type="button" 
                :disabled="page === 1" 
                @click="prevPage"
              >
                <i class="fas fa-chevron-left"></i> Prev
              </button>
              <span class="page-info">Hal {{ page }} dari {{ totalPages }}</span>
              <button 
                class="btn-pager" 
                type="button" 
                :disabled="page === totalPages" 
                @click="nextPage"
              >
                Next <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>

          <!-- SEARCH & FILTER -->
          <div class="filter-section">
            <div class="search-wrapper">
              <i class="fas fa-search search-icon"></i>
              <input 
                v-model="filters.search" 
                type="text" 
                placeholder="Cari nama posyandu, alamat, atau status..." 
                class="search-input"
                @keyup.enter="applyFilter"
              />
              <button v-if="filters.search" class="search-clear" @click="clearSearch">×</button>
            </div>

            <div class="filter-grid">
              <div class="filter-item">
                <label class="filter-label">Status</label>
                <select v-model="filters.status" class="filter-select" @change="applyFilter">
                  <option value="">Semua Status</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Pasif">Pasif</option>
                </select>
              </div>

              <div class="filter-item">
                <label class="filter-label">Kecamatan</label>
                <select v-model="filters.kecamatan" class="filter-select" @change="applyFilter">
                  <option value="">Semua Kecamatan</option>
                  <option value="Cimahi Tengah">Cimahi Tengah</option>
                  <option value="Cimahi Utara">Cimahi Utara</option>
                  <option value="Cimahi Selatan">Cimahi Selatan</option>
                </select>
              </div>

              <div class="filter-actions">
                <button class="btn-filter btn-primary" @click="applyFilter">
                  <i class="fas fa-filter"></i> Terapkan
                </button>
                <button class="btn-filter btn-ghost" @click="resetFilter">
                  <i class="fas fa-sync-alt"></i> Reset
                </button>
              </div>
            </div>
          </div>

          <!-- TABLE -->
          <div class="table-container">
            <div class="table-responsive">
              <table class="modern-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Posyandu</th>
                    <th>Status</th>
                    <th>Alamat</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <!-- Loading State -->
                  <tr v-if="isLoading">
                    <td colspan="7" class="text-center loading-cell">
                      <div class="loading-spinner"></div>
                      <span>Memuat data...</span>
                    </td>
                  </tr>

                  <!-- Empty State -->
                  <tr v-else-if="pagedRows.length === 0">
                    <td colspan="7" class="empty-cell">
                      <div class="empty-state">
                        <i class="fas fa-building empty-icon"></i>
                        <h4>Tidak Ada Data Posyandu</h4>
                        <p>Belum ada data posyandu yang tersedia atau filter terlalu ketat.</p>
                        <button v-if="isFiltered" class="btn-reset-empty" @click="resetFilter">
                          <i class="fas fa-sync-alt"></i> Reset Filter
                        </button>
                      </div>
                    </td>
                  </tr>

                  <!-- Data Rows -->
                  <tr v-for="(row, index) in pagedRows" :key="row.id" class="data-row">
                    <td class="text-muted">#{{ (page - 1) * perPage + index + 1 }}</td>
                    <td>
                      <span class="nama-posyandu">{{ row.nama }}</span>
                      <span v-if="row.strata" class="strata-label">({{ row.strata }})</span>
                    </td>
                    <td>
                      <span class="status-badge" :class="row.status?.toLowerCase()">
                        {{ row.status }}
                      </span>
                    </td>
                    <td>
                      <span class="alamat-text" :title="row.alamat">
                        {{ row.alamat }}
                      </span>
                    </td>
                    <td>
                      <span class="kecamatan-badge">{{ row.kecamatan }}</span>
                    </td>
                    <td>
                      <span class="kelurahan-text">{{ row.kelurahan }}</span>
                    </td>
                    <td class="text-center">
                      <div class="action-group">
                        <button 
                          class="action-btn btn-show" 
                          @click="openModal(row)"
                          title="Lihat Detail"
                        >
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Pagination Bottom -->
          <div class="pagination-bottom">
            <div class="pagination-info">
              Menampilkan 
              <strong>{{ (page - 1) * perPage + 1 }}</strong> - 
              <strong>{{ Math.min(page * perPage, filteredRows.length) }}</strong> 
              dari <strong>{{ filteredRows.length }}</strong> data
            </div>
            <div class="pagination-controls">
              <button 
                class="btn-page" 
                :disabled="page === 1"
                @click="page = 1"
              >
                <i class="fas fa-angle-double-left"></i>
              </button>
              <button 
                class="btn-page" 
                :disabled="page === 1"
                @click="prevPage"
              >
                <i class="fas fa-chevron-left"></i>
              </button>
              
              <span class="page-indicator">{{ page }} / {{ totalPages }}</span>
              
              <button 
                class="btn-page" 
                :disabled="page === totalPages"
                @click="nextPage"
              >
                <i class="fas fa-chevron-right"></i>
              </button>
              <button 
                class="btn-page" 
                :disabled="page === totalPages"
                @click="page = totalPages"
              >
                <i class="fas fa-angle-double-right"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- KANAN - Sidebar Stats -->
        <div class="panel-side">
          <div class="stats-card total-card">
            <div class="stats-icon">
              <i class="fas fa-building"></i>
            </div>
            <div class="stats-content">
              <div class="stats-label">Total Posyandu</div>
              <div class="stats-value">{{ totalPosyandu }}</div>
            </div>
          </div>

          <div class="stats-card kecamatan-card">
            <div class="stats-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stats-content">
              <div class="stats-label">Total Kecamatan</div>
              <div class="stats-value">{{ totalKecamatan }}</div>
            </div>
          </div>

          <div class="stats-card active-card">
            <div class="stats-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-content">
              <div class="stats-label">Posyandu Aktif</div>
              <div class="stats-value">{{ totalAktif }}</div>
            </div>
          </div>

          <div class="stats-card pasif-card">
            <div class="stats-icon">
              <i class="fas fa-times-circle"></i>
            </div>
            <div class="stats-content">
              <div class="stats-label">Posyandu Pasif</div>
              <div class="stats-value">{{ totalPasif }}</div>
            </div>
          </div>

          <!-- Quick Info -->
          <div class="info-card">
            <h4 class="info-title">
              <i class="fas fa-info-circle"></i> Informasi
            </h4>
            <div class="info-item">
              <i class="fas fa-sync-alt"></i>
              <span>Data diperbarui setiap hari</span>
            </div>
            <div class="info-item">
              <i class="fas fa-calendar-alt"></i>
              <span>Terakhir: {{ lastUpdate }}</span>
            </div>
            <div class="info-item">
              <i class="fas fa-users"></i>
              <span>Total Kader: {{ totalKader }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- MODAL DETAIL -->
      <div v-if="modal.open" class="modal-overlay" @click.self="closeModal">
        <div class="modal-card">
          <div class="modal-header">
            <div class="modal-title-wrapper">
              <i class="fas fa-building modal-title-icon"></i>
              <h3 class="modal-title">Detail Posyandu</h3>
            </div>
            <button class="modal-close" @click="closeModal" aria-label="Close">
              <i class="fas fa-times"></i>
            </button>
          </div>

          <div class="modal-body">
            <div class="detail-grid">
              <div class="detail-item full-width">
                <span class="detail-label">Nama Posyandu</span>
                <span class="detail-value">{{ modal.data?.nama }}</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                  <span class="status-badge" :class="modal.data?.status?.toLowerCase()">
                    {{ modal.data?.status }}
                  </span>
                </span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Strata</span>
                <span class="detail-value">{{ modal.data?.strata || '-' }}</span>
              </div>
              
              <div class="detail-item full-width">
                <span class="detail-label">Alamat Lengkap</span>
                <span class="detail-value">{{ modal.data?.alamat }}</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Kecamatan</span>
                <span class="detail-value">
                  <span class="kecamatan-badge">{{ modal.data?.kecamatan }}</span>
                </span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Kelurahan</span>
                <span class="detail-value">{{ modal.data?.kelurahan }}</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Penanggung Jawab</span>
                <span class="detail-value">{{ modal.data?.pj_umum || '-' }}</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">Kader Aktif</span>
                <span class="detail-value">{{ modal.data?.kader_aktif || 0 }} orang</span>
              </div>
              
              <div class="detail-item">
                <span class="detail-label">ID Posyandu</span>
                <span class="detail-value">
                  <code class="id-code">#{{ modal.data?.id }}</code>
                </span>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button class="btn-modal btn-secondary" @click="closeModal">
              <i class="fas fa-times"></i> Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
  <AppFooterImpl />
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, reactive, ref, watch } from "vue";
import NavbarLanding from "../../components/SIPVue/NavbarLanding.vue";
import AppFooterImpl from "@/layouts/AppFooterImpl.vue";

// Props - terima data dari server
const props = defineProps({
  posyandu: {
    type: Array,
    default: () => []
  }
})

// Data state - PAKAI DATA DARI SERVER (TANPA HARDCODED)
const rows = ref(props.posyandu)

// Body class untuk styling
onMounted(() => {
  document.body.classList.add("esip-posyandu-body");
  restoreScrollPosition();
});

onBeforeUnmount(() => {
  document.body.classList.remove("esip-posyandu-body");
  if (toast.value.timeout) clearTimeout(toast.value.timeout)
});

// Toast notification
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

// Scroll position
const scrollPosition = ref(0)

function saveScrollPosition() {
  scrollPosition.value = window.scrollY
  sessionStorage.setItem('scrollPosition', scrollPosition.value)
}

function restoreScrollPosition() {
  const savedPosition = sessionStorage.getItem('scrollPosition')
  if (savedPosition) {
    setTimeout(() => {
      window.scrollTo({
        top: parseInt(savedPosition),
        behavior: 'smooth'
      })
      sessionStorage.removeItem('scrollPosition')
    }, 100)
  }
}

// Loading state
const isLoading = ref(false)

// Filter
const filters = reactive({
  search: "",
  status: "",
  kecamatan: ""
})

// Pagination
const page = ref(1)
const perPage = 5

// Computed: filtered rows
const filteredRows = computed(() => {
  let result = [...rows.value]
  
  // Filter by search (nama atau alamat)
  if (filters.search) {
    const searchLower = filters.search.toLowerCase()
    result = result.filter(r => 
      r.nama?.toLowerCase().includes(searchLower) ||
      r.alamat?.toLowerCase().includes(searchLower) ||
      r.status?.toLowerCase().includes(searchLower)
    )
  }
  
  // Filter by status
  if (filters.status) {
    result = result.filter(r => 
      r.status?.toLowerCase() === filters.status.toLowerCase()
    )
  }
  
  // Filter by kecamatan
  if (filters.kecamatan) {
    result = result.filter(r => 
      r.kecamatan === filters.kecamatan
    )
  }
  
  return result
})

// Computed: total pages
const totalPages = computed(() => 
  Math.max(1, Math.ceil(filteredRows.value.length / perPage))
)

// Computed: paged rows
const pagedRows = computed(() => {
  const start = (page.value - 1) * perPage
  return filteredRows.value.slice(start, start + perPage)
})

// Watch page to ensure it's valid when filtered data changes
watch(filteredRows, () => {
  if (page.value > totalPages.value) {
    page.value = totalPages.value
  }
})

// Computed: is filtered active
const isFiltered = computed(() => 
  filters.search || filters.status || filters.kecamatan
)

// Computed: stats
const totalPosyandu = computed(() => rows.value.length)
const totalKecamatan = computed(() => {
  const kec = new Set(rows.value.map(r => r.kecamatan).filter(Boolean))
  return kec.size
})
const totalAktif = computed(() => 
  rows.value.filter(r => r.status?.toLowerCase() === 'aktif').length
)
const totalPasif = computed(() => 
  rows.value.filter(r => r.status?.toLowerCase() === 'pasif').length
)
const totalKader = computed(() => {
  return rows.value.reduce((sum, r) => sum + (r.kader_aktif || 0), 0)
})

// Last update
const lastUpdate = computed(() => {
  const now = new Date()
  return now.toLocaleDateString('id-ID', { 
    day: 'numeric', 
    month: 'long', 
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
})

// Methods
function applyFilter() {
  page.value = 1
  saveScrollPosition()
  showToast('info', 'Filter diterapkan')
}

function resetFilter() {
  filters.search = ""
  filters.status = ""
  filters.kecamatan = ""
  page.value = 1
  showToast('info', 'Filter direset')
}

function clearSearch() {
  filters.search = ""
  applyFilter()
}

function prevPage() {
  page.value = Math.max(1, page.value - 1)
  saveScrollPosition()
  setTimeout(restoreScrollPosition, 100)
}

function nextPage() {
  page.value = Math.min(totalPages.value, page.value + 1)
  saveScrollPosition()
  setTimeout(restoreScrollPosition, 100)
}

// Modal
const modal = reactive({ open: false, data: null })

function openModal(row) {
  modal.data = row
  modal.open = true
  document.body.style.overflow = "hidden"
}

function closeModal() {
  modal.open = false
  modal.data = null
  document.body.style.overflow = ""
}
</script>

<style scoped>
/* Limitless override */
:global(body.esip-posyandu-body .content) { 
  padding: 0 !important; 
}
:global(body.esip-posyandu-body .page-container),
:global(body.esip-posyandu-body .page-content),
:global(body.esip-posyandu-body .content-wrapper),
:global(body.esip-posyandu-body .content) {
  background: transparent !important;
  background-image: none !important;
}

/* ===== PAGE LAYOUT ===== */
.esip-posyandu-page {
  position: relative;
  min-height: 91vh;
  padding: 36px 0 70px;
  isolation: isolate;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.esip-posyandu-page::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  background-image: url("/storage/tentangesip_page/bg-kotak-kotak.png");
  background-repeat: repeat;
  background-size: auto;
  background-position: center -12px;
  opacity: 0.6;
}

/* ===== MAIN GRID ===== */
.posyandu-inner {
  width: min(1280px, 100%);
  margin: 0 auto;
  padding: 0 24px;
  padding-top: 80px;
  padding-bottom: 30px;
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 24px;
  align-items: start;
}

/* ===== PANEL UTAMA ===== */
.panel-main {
  background: #ffffff;
  border-radius: 24px;
  padding: 24px;
  box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(226, 232, 240, 0.6);
}

/* Panel Header */
.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.panel-title {
  font-size: 20px;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
  position: relative;
}

.panel-title::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 40px;
  height: 3px;
  background: linear-gradient(90deg, #1e3c72, #4a90e2);
  border-radius: 4px;
}

.total-badge {
  background: #f1f5f9;
  color: #475569;
  font-size: 12px;
  font-weight: 600;
  padding: 4px 12px;
  border-radius: 30px;
  white-space: nowrap;
}

/* Pager */
.pager-wrapper {
  display: flex;
  align-items: center;
  gap: 16px;
  background: #f8fafc;
  padding: 4px 8px;
  border-radius: 40px;
  border: 1px solid #e2e8f0;
}

.btn-pager {
  padding: 6px 14px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 30px;
  font-size: 13px;
  font-weight: 600;
  color: #334155;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.btn-pager:hover:not(:disabled) {
  background: #1e3c72;
  border-color: #1e3c72;
  color: white;
  transform: translateY(-2px);
}

.btn-pager:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  background: #f1f5f9;
}

.page-info {
  font-size: 13px;
  color: #475569;
  font-weight: 500;
}

/* ===== FILTER SECTION ===== */
.filter-section {
  background: #f8fafc;
  border-radius: 20px;
  padding: 20px;
  margin-bottom: 24px;
  border: 1px solid #e2e8f0;
}

.search-wrapper {
  display: flex;
  align-items: center;
  background: white;
  border: 2px solid #e2e8f0;
  border-radius: 40px;
  padding: 0 16px;
  margin-bottom: 16px;
  transition: all 0.2s ease;
}

.search-wrapper:focus-within {
  border-color: #1e3c72;
  box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
}

.search-icon {
  color: #94a3b8;
  margin-right: 8px;
  font-size: 14px;
}

.search-input {
  flex: 1;
  height: 44px;
  border: none;
  font-size: 14px;
  color: #1e293b;
  background: transparent;
  padding: 0;
}

.search-input:focus {
  outline: none;
}

.search-input::placeholder {
  color: #94a3b8;
}

.search-clear {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: #e2e8f0;
  border: none;
  color: #64748b;
  font-size: 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.search-clear:hover {
  background: #cbd5e1;
  color: #334155;
}

.filter-grid {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 16px;
}

.filter-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.filter-label {
  font-size: 12px;
  font-weight: 600;
  color: #475569;
  text-transform: uppercase;
}

.filter-select {
  width: 100%;
  height: 40px;
  padding: 0 14px;
  background: white;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 14px;
  color: #1e293b;
  cursor: pointer;
}

.filter-select:focus {
  outline: none;
  border-color: #1e3c72;
}

.filter-actions {
  display: flex;
  gap: 8px;
  align-items: flex-end;
}

.btn-filter {
  height: 40px;
  padding: 0 20px;
  border: none;
  border-radius: 40px;
  font-size: 13px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  transition: all 0.2s ease;
  white-space: nowrap;
}

.btn-primary {
  background: #1e3c72;
  color: white;
}

.btn-primary:hover {
  background: #0f2b4f;
  transform: translateY(-2px);
}

.btn-ghost {
  background: white;
  color: #475569;
  border: 2px solid #e2e8f0;
}

.btn-ghost:hover {
  background: #f8fafc;
  transform: translateY(-2px);
}

/* ===== TABLE ===== */
.table-container {
  border-radius: 18px;
  overflow: hidden;
  border: 1px solid #edf2f7;
  background: white;
  margin-bottom: 20px;
}

.table-responsive {
  overflow-x: auto;
  max-height: 380px;
  overflow-y: auto;
}

.modern-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.modern-table thead th {
  position: sticky;
  top: 0;
  background: #f8fafc;
  color: #1e293b;
  font-weight: 600;
  font-size: 13px;
  padding: 16px;
  border-bottom: 2px solid #e2e8f0;
  z-index: 5;
}

.modern-table tbody td {
  padding: 16px;
  color: #334155;
  border-bottom: 1px solid #f1f5f9;
}

.modern-table tbody tr:hover {
  background: #f8fafc;
}

.text-muted {
  color: #94a3b8;
  font-weight: 500;
}

.text-center {
  text-align: center;
}

.nama-posyandu {
  font-weight: 600;
  color: #0f172a;
}

.strata-label {
  font-size: 11px;
  color: #64748b;
  margin-left: 4px;
}

.status-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 30px;
  font-size: 12px;
  font-weight: 600;
}

.status-badge.aktif {
  background: #dcfce7;
  color: #166534;
  border: 1px solid #bbf7d0;
}

.status-badge.pasif {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fecaca;
}

.alamat-text {
  display: inline-block;
  max-width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: #475569;
}

.kecamatan-badge {
  display: inline-block;
  padding: 4px 12px;
  background: #e2e8f0;
  color: #334155;
  border-radius: 30px;
  font-size: 12px;
}

.kelurahan-text {
  color: #475569;
  font-size: 13px;
}

/* Action Buttons - Sama seperti di penimbangan */
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

/* Loading State */
.loading-cell {
  padding: 48px !important;
}

.loading-spinner {
  width: 36px;
  height: 36px;
  border: 3px solid #e2e8f0;
  border-top-color: #1e3c72;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  margin: 0 auto 12px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Empty State */
.empty-cell {
  padding: 48px !important;
}

.empty-state {
  text-align: center;
  max-width: 280px;
  margin: 0 auto;
}

.empty-icon {
  font-size: 48px;
  color: #cbd5e1;
  margin-bottom: 16px;
}

.empty-state h4 {
  font-size: 18px;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 8px;
}

.empty-state p {
  font-size: 14px;
  color: #64748b;
  margin: 0 0 20px;
}

.btn-reset-empty {
  background: #1e3c72;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 40px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-reset-empty:hover {
  background: #0f2b4f;
  transform: translateY(-2px);
}

/* ===== PAGINATION ===== */
.pagination-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  margin-top: 16px;
  padding-top: 16px;
  border-top: 1px solid #edf2f7;
}

.pagination-info {
  font-size: 13px;
  color: #64748b;
}

.pagination-controls {
  display: flex;
  align-items: center;
  gap: 6px;
}

.btn-page {
  width: 38px;
  height: 38px;
  border: 1px solid #e2e8f0;
  background: white;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s;
  color: #475569;
  font-size: 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-page:hover:not(:disabled) {
  background: #1e3c72;
  border-color: #1e3c72;
  color: white;
  transform: translateY(-2px);
}

.btn-page:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.page-indicator {
  font-size: 14px;
  font-weight: 600;
  color: #1e293b;
  padding: 0 8px;
  min-width: 60px;
  text-align: center;
}

/* ===== PANEL SIDE ===== */
.panel-side {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.stats-card {
  background: white;
  border-radius: 20px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.06);
  border: 1px solid #e2e8f0;
}

.stats-card:hover {
  transform: translateY(-4px);
}

.stats-icon {
  width: 56px;
  height: 56px;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  background: #f1f5f9;
  color: #334155;
}

.total-card .stats-icon {
  background: #e2e8f0;
}

.kecamatan-card .stats-icon {
  background: #dbeafe;
  color: #1e40af;
}

.active-card .stats-icon {
  background: #dcfce7;
  color: #166534;
}

.pasif-card .stats-icon {
  background: #fee2e2;
  color: #991b1b;
}

.stats-content {
  flex: 1;
}

.stats-label {
  font-size: 13px;
  font-weight: 600;
  color: #64748b;
  margin-bottom: 4px;
}

.stats-value {
  font-size: 32px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
}

.info-card {
  background: white;
  border-radius: 20px;
  padding: 20px;
  border: 1px solid #e2e8f0;
  margin-top: 8px;
}

.info-title {
  font-size: 14px;
  font-weight: 700;
  color: #334155;
  margin: 0 0 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 0;
  border-bottom: 1px solid #f1f5f9;
  font-size: 13px;
  color: #475569;
}

.info-item:last-child {
  border-bottom: none;
}

.info-item i {
  width: 16px;
  color: #1e3c72;
}

/* ===== MODAL ===== */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(6px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.modal-card {
  width: min(500px, 100%);
  background: white;
  border-radius: 28px;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
  overflow: hidden;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from {
    transform: translateY(30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.modal-header {
  padding: 20px 24px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modal-title-wrapper {
  display: flex;
  align-items: center;
  gap: 12px;
}

.modal-title-icon {
  font-size: 20px;
  color: #1e3c72;
  background: #e2e8f0;
  padding: 10px;
  border-radius: 14px;
}

.modal-title {
  font-size: 18px;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.modal-close {
  width: 38px;
  height: 38px;
  border-radius: 12px;
  border: none;
  background: #f1f5f9;
  color: #64748b;
  font-size: 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-close:hover {
  background: #fee2e2;
  color: #991b1b;
}

.modal-body {
  padding: 24px;
}

.detail-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.detail-item.full-width {
  grid-column: 1 / -1;
}

.detail-label {
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
}

.detail-value {
  font-size: 16px;
  color: #1e293b;
  font-weight: 500;
}

.id-code {
  background: #f1f5f9;
  padding: 4px 10px;
  border-radius: 8px;
  font-size: 14px;
  font-family: monospace;
  color: #1e3c72;
}

.modal-footer {
  padding: 16px 24px 24px;
  display: flex;
  justify-content: flex-end;
}

.btn-modal {
  padding: 10px 24px;
  border-radius: 40px;
  border: none;
  font-size: 14px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.btn-secondary {
  background: #f1f5f9;
  color: #475569;
}

.btn-secondary:hover {
  background: #e2e8f0;
  transform: translateY(-2px);
}

/* ===== TOAST ===== */
.toast-notification {
  position: fixed;
  top: 24px;
  right: 24px;
  z-index: 10000;
  min-width: 320px;
  background: white;
  border-radius: 16px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  border-left: 4px solid;
  overflow: hidden;
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

.toast-content {
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.toast-icon {
  font-size: 18px;
}

.toast-notification.success .toast-icon {
  color: #10b981;
}

.toast-notification.error .toast-icon {
  color: #ef4444;
}

.toast-notification.info .toast-icon {
  color: #3b82f6;
}

.toast-message {
  flex: 1;
  font-size: 14px;
  color: #1e293b;
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

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(30px);
  opacity: 0;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .posyandu-inner {
    grid-template-columns: 1fr;
  }
  
  .filter-grid {
    grid-template-columns: 1fr 1fr;
  }
  
  .filter-actions {
    grid-column: 1 / -1;
    justify-content: flex-end;
  }
  
  .panel-side {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (max-width: 768px) {
  .panel-header {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .filter-grid {
    grid-template-columns: 1fr;
  }
  
  .filter-actions {
    grid-column: 1 / -1;
  }
  
  .panel-side {
    grid-template-columns: 1fr 1fr;
  }
  
  .detail-grid {
    grid-template-columns: 1fr;
  }
  
  .modern-table thead th {
    font-size: 12px;
    padding: 12px 8px;
  }
  
  .modern-table tbody td {
    padding: 12px 8px;
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .panel-side {
    grid-template-columns: 1fr;
  }
  
  .pagination-bottom {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .pagination-controls {
    width: 100%;
    justify-content: center;
  }
  
  .filter-actions {
    flex-direction: column;
    width: 100%;
  }
  
  .btn-filter {
    width: 100%;
    justify-content: center;
  }
  
  .btn-pager span {
    display: none;
  }
  
  .btn-pager i {
    margin: 0;
  }
}
</style>