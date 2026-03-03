<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed, watch } from 'vue'

const props = defineProps({
  data: Object,
  kecamatan: Array,
  kelurahan: Object,
  posyandu: Object,
  filter: Object
})

const rows = computed(() => props.data?.data ?? [])

const columns = [
  { key: 'id_wafat', label: 'ID', sortable: true },
  { key: 'nama_bayi', label: 'Nama Bayi', sortable: true },
  { key: 'nama_posyandu', label: 'Posyandu', sortable: true },
  { key: 'tgl_kematian', label: 'Tgl Kematian', sortable: true },
  { key: 'ket', label: 'Ket', sortable: false },
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
const kelurahanOptions = computed(() => {
  if (!selectedKec.value) return []

  const key = String(selectedKec.value)

  if (!props.kelurahan || !props.kelurahan[key]) return []

  return props.kelurahan[key].map(k => ({
    label: k.nama_kel,
    value: String(k.id_kel)
  }))
})
const posyanduList = computed(() => {
  if (!selectedKel.value) return []
  return props.posyandu?.[selectedKel.value] ?? []
})

watch(selectedKec, () => {
  selectedKel.value = ''
  selectedPos.value = ''
})
watch(selectedKel, () => {
  selectedPos.value = ''
})

function applyFilter() {
  router.get('/posyandu/bayi-wafat', {
    kec: selectedKec.value || '',
    kel: selectedKel.value || '',
    pos: selectedPos.value || '',
    q:   searchText.value || '',
  }, { preserveState: true, preserveScroll: true, replace: true })
}

// modal hapus blur
const modalOpen = ref(false)
const selected = ref({})

function deleteRow(row) {
  selected.value = row
  modalOpen.value = true
}
function closeModal() {
  modalOpen.value = false
  selected.value = {}
}
function confirmDelete() {
  router.delete(`/posyandu/bayi-wafat/${selected.value.id_wafat}`, {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      router.reload({ only: ['data'] })
      window.dispatchEvent(new CustomEvent("toast", {
        detail: { type: "success", message: "Data kematian bayi berhasil dihapus!" }
      }))
    },
    onError: () => {
      window.dispatchEvent(new CustomEvent("toast", {
        detail: { type: "error", message: "Gagal menghapus data." }
      }))
    }
  })
}
</script>

<template>
<AdminLayout>

  <div class="data-container">

    <!-- Header -->
    <div class="header-section">
      <div>
        <h1 class="page-title">Kematian Bayi</h1>
        <p class="page-subtitle">Kelola data kematian bayi posyandu</p>
      </div>

      <Link href="/posyandu/bayi-wafat/create" class="btn-create">
        + Tambah Data
      </Link>
    </div>

    <!-- FILTER -->
    <div class="filter-section">
      <div class="filter-grid">

        <div class="filter-item">
          <label>Kecamatan</label>
          <select class="filter-select"
                  v-model="selectedKec"
                  @change="applyFilter">
            <option value="">Semua Kecamatan</option>
            <option v-for="k in kecamatan"
                    :key="k.id_kec"
                    :value="k.id_kec">
              {{ k.nama_kec }}
            </option>
          </select>
        </div>

        <div class="filter-item">
          <label>Kelurahan</label>
          <select class="filter-select"
                  v-model="selectedKel"
                  :disabled="!selectedKec"
                  @change="applyFilter">
            <option value="">Semua Kelurahan</option>
            <option v-for="k in kelurahanOptions"
                    :key="k.value"
                    :value="k.value">
              {{ k.label }}
            </option>
          </select>
        </div>

               <div class="filter-item search-item">
                    <label class="filter-label">Pencarian</label>
                    <div class="search-wrapper">
                        <i class="icon-search search-icon"></i>
                        <input 
                            type="text" 
                            class="search-input" 
                            v-model="searchText" 
                            placeholder="Cari nama bayi..."
                            @keyup.enter="applyFilter"
                        >
                        <button class="search-btn" @click="applyFilter">
                            Cari
                        </button>
                    </div>
                </div>
          </div>
    </div>

    <!-- TABLE -->
    <div class="table-section">
      <div v-if="rows.length === 0" class="empty-state">
                <i class="icon-database empty-icon"></i>
                <h3>Belum Ada Data Bayi</h3>
                <p>Silakan tambahkan data bayi terlebih dahulu.</p>
                <Link href="/posyandu/bayi-wafat/create" class="btn-create">
                    Tambah Data Pertama
                </Link>
            </div>

      <DataTable :columns="columns"
                 :rows="rows"
                 :perPage="10">

        <template #col-actions="{ row }">
          <div class="action-group">

            <Link :href="`/posyandu/bayi-wafat/${row.id_wafat}`">
              <span class="action-btn btn-show">
                <i class="icon-eye"></i>
              </span>
            </Link>

            <Link :href="`/posyandu/bayi-wafat/${row.id_wafat}/edit`">
              <span class="action-btn btn-edit">
                <i class="icon-pencil"></i>
              </span>
            </Link>

            <span class="action-btn btn-delete"
                  @click="deleteRow(row)">
              <i class="icon-trash"></i>
            </span>

          </div>
        </template>

      </DataTable>

    </div>

    <!-- PAGINATION -->
    <div class="pagination-section"
         v-if="props.data?.links?.length">

      <div class="pagination-info">
        Menampilkan {{ props.data.from }}
        - {{ props.data.to }}
        dari {{ props.data.total }} data
      </div>

      <ul class="pagination-list">
        <li v-for="(l, idx) in props.data.links"
            :key="idx"
            :class="{ active: l.active, disabled: !l.url }">
          <a href="#"
             @click.prevent="l.url && router.visit(l.url, { preserveScroll:true })"
             v-html="l.label">
          </a>
        </li>
      </ul>
    </div>

  </div>

  <!-- MODAL DELETE MODERN -->
  <div v-if="modalOpen" class="modal-overlay" @click.self="closeModal">
    <div class="modal-content">

      <div class="modal-icon-wrapper">
        <i class="icon-bin modal-icon"></i>
      </div>

      <h3 class="modal-title">Hapus Data Kematian Bayi?</h3>

      <p class="modal-text">  
        Anda akan menghapus data berikut:
      </p>

      <div class="modal-highlight">
        <strong>Nama Bayi: {{ selected.nama_bayi }}</strong>
      </div>
      <p class="modal-warning">
        <i class="icon-exclamation-triangle"></i>
           Data yang dihapus tidak dapat dikembalikan
      </p>
      <div class="modal-actions">
        <button class="modal-btn modal-btn-cancel" @click="closeModal">
          Batal
        </button>
        <button class="modal-btn modal-btn-delete" @click="confirmDelete">
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

.btn-create i {
    font-size: 18px;
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
    grid-template-columns: 1fr 1fr 1.5fr;
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
.filter-btn {
    padding: 10px 16px;
    border-radius: 8px;
    border: none;
    background: #f1f5f9;
    color: #475569;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s;
}

.filter-btn:hover {
    background: #1e40af;
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
    font-size: 14px;
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

/* Nama Posyandu */
.nama-posyandu {
    font-weight: 500;
    color: #1e293b;
}

/* Alamat Text */
.alamat-text {
    display: inline-block;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #475569;
}

/* Strata Badge */
.strata-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
    white-space: nowrap;
}

.strata-pratama {
    background: #fee2e2;
    color: #991b1b;
}

.strata-madya {
    background: #fff3cd;
    color: #856404;
}

.strata-purnama {
    background: #d1e7dd;
    color: #0f5132;
}

.strata-mandiri {
    background: #cfe2ff;
    color: #084298;
}

/* Kader Badge */
.kader-badge {
    display: inline-block;
    padding: 4px 12px;
    background: #e8f0fe;
    color: #1e293b;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
}

/* Text Muted */
.text-muted {
    color: #94a3b8;
    font-style: italic;
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
}

.empty-icon i {
    font-size: 40px;
    color: #94a3b8;
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
    margin: 0 0 12px 0;
}

.modal-highlight {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    margin-bottom: 16px;
}

.modal-highlight strong {
    font-size: 16px;
    color: #1e293b;
    word-break: break-word;
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

.toast-content i {
    font-size: 20px;
}

.toast-notification.success i {
    color: #10b981;
}

.toast-notification.error i {
    color: #ef4444;
}

.toast-notification.info i {
    color: #3b82f6;
}

.toast-notification.warning i {
    color: #f59e0b;
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
    transition: color 0.2s;
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
@media (max-width: 1024px) {
    .filter-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .search-item {
        grid-column: span 2;
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
    
    .search-item {
        grid-column: span 1;
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