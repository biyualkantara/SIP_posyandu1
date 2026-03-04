<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
  data: Object,
  filter: Object
})

// State untuk menyimpan posisi scroll
const scrollPosition = ref(0)

// Simpan posisi scroll sebelum pindah halaman
const saveScrollPosition = () => {
    scrollPosition.value = window.scrollY
    sessionStorage.setItem('scrollPosition_operator', scrollPosition.value)
}

// Restore posisi scroll setelah kembali
const restoreScrollPosition = () => {
    const savedPosition = sessionStorage.getItem('scrollPosition_operator')
    if (savedPosition) {
        setTimeout(() => {
            window.scrollTo({
                top: parseInt(savedPosition),
                behavior: 'smooth'
            })
            sessionStorage.removeItem('scrollPosition_operator')
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
})

const rows = computed(() => props.data?.data ?? [])

const columns = [
  { key: 'id_operator', label: 'ID', sortable: true },
  { key: 'nama', label: 'Nama Operator', sortable: true },
  { key: 'username', label: 'Username', sortable: true },
  { key: 'role', label: 'Role', sortable: true },
  { key: 'nama_posyandu', label: 'Posyandu', sortable: true },
  { key: 'actions', label: 'Aksi', sortable: false },
]

const searchText = ref(props.filter?.q ?? '')

function applyFilter() {
  saveScrollPosition()
  router.get('/operator', {
    q: searchText.value || ''
  }, { 
    preserveState: true, 
    preserveScroll: true,
    onSuccess: () => {
      restoreScrollPosition()
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

// Format role badge
const getRoleClass = (role) => {
  switch(role?.toLowerCase()) {
    case 'admin':
      return 'role-badge role-admin'
    case 'operator':
      return 'role-badge role-operator'
    default:
      return 'role-badge role-other'
  }
}

// Format role display
const formatRole = (role) => {
  if (!role) return '-'
  return role.charAt(0).toUpperCase() + role.slice(1).toLowerCase()
}

/* MODAL HAPUS */
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
  router.delete(`/operator/${selected.value.id_operator}`, {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      router.reload({ only: ['data'] })
    }
  })
}
</script>

<template>
<AdminLayout>
  <div class="data-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="header-left">
        <h1 class="page-title">Data Operator</h1>
        <p class="page-subtitle">Kelola data operator sistem</p>
      </div>
      <div class="header-right">
        <Link 
          href="/operator/create" 
          class="btn-create"
          @click="handleLinkClick"
        >
          <span>+</span>
          <span>Tambah Operator</span>
        </Link>
      </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
      <!-- Tampilkan pesan jika tidak ada data -->
      <div v-if="rows.length === 0" class="empty-state">
        <div class="empty-icon">
          <span>👤</span>
        </div>
        <h3 class="empty-title">Belum Ada Data</h3>
        <p class="empty-description">Data operator belum tersedia. Silakan tambah data baru.</p>
        <Link href="/operator/create" class="btn-create empty-btn" @click="handleLinkClick">
          <span>+</span>
          <span>Tambah Data Pertama</span>
        </Link>
      </div>

      <!-- Tampilkan tabel jika ada data -->
      <DataTable v-else :columns="columns" :rows="rows" :perPage="10">
        <!-- Custom Column Templates -->
        <template #col-id_operator="{ row }">
          <span class="id-badge">#{{ row.id_operator }}</span>
        </template>

        <template #col-nama="{ row }">
          <div class="nama-info">
            <span class="nama-text">{{ formatValue(row.nama) }}</span>
            <span class="nik-text">{{ row.username || '-' }}</span>
          </div>
        </template>

        <template #col-username="{ row }">
          <span class="username-text">{{ row.username || '-' }}</span>
        </template>

        <template #col-role="{ row }">
          <span :class="getRoleClass(row.role)">
            {{ formatRole(row.role) }}
          </span>
        </template>

        <template #col-nama_posyandu="{ row }">
          <span class="posyandu-badge">
            {{ row.nama_posyandu || 'Semua Posyandu' }}
          </span>
        </template>

        <template #col-actions="{ row }">
          <div class="action-group">
            <Link 
              :href="`/operator/${row.id_operator}`"
              @click="handleLinkClick"
            >
              <span :class="getButtonClass('show')" title="Lihat Detail">
                <i class="icon-eye"></i>
              </span>
            </Link>

            <Link 
              :href="`/operator/${row.id_operator}/edit`"
              @click="handleLinkClick"
            >
              <span :class="getButtonClass('edit')" title="Edit Data">
                <i class="icon-pencil"></i>
              </span>
            </Link>

            <span 
              :class="getButtonClass('delete')" 
              title="Hapus Data"
              @click="deleteRow(row)"
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
        <i class="icon-bin modal-icon"></i>
      </div>
      <h3 class="modal-title">Hapus Data Operator?</h3>
      <p class="modal-text">Anda akan menghapus data:</p>
      
      <div class="modal-highlight">
        <div class="modal-info-item">
          <span class="modal-info-label">Nama Operator</span>
          <div class="modal-info-value">
            <strong>{{ selected.nama || 'Tidak diketahui' }}</strong>
          </div>
        </div>

        <div class="modal-info-item">
          <span class="modal-info-label">Username</span>
          <div class="modal-info-value">
            {{ selected.username || '-' }}
          </div>
        </div>

        <div class="modal-info-item">
          <span class="modal-info-label">Role</span>
          <div>
            <span :class="getRoleClass(selected.role)">
              {{ formatRole(selected.role) }}
            </span>
          </div>
        </div>

        <div class="modal-info-item">
          <span class="modal-info-label">Posyandu</span>
          <div class="modal-info-value">
            {{ selected.nama_posyandu || 'Semua Posyandu' }}
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
/* Container Utama - Sama dengan WUSPUS */
.data-container {
  padding: 24px;
  background: #f8fafc;
  min-height: 100vh;
}

/* Header Section - Sama dengan WUSPUS */
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

/* Button Create - Sama dengan WUSPUS */
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

/* Filter Section - Sama dengan WUSPUS */
.filter-section {
  background: white;
  border-radius: 16px;
  padding: 20px 24px;
  margin-bottom: 24px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.filter-grid {
  display: grid;
  grid-template-columns: 1fr;
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

/* Search Item - Sama dengan WUSPUS */
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

/* Table Section - Sama dengan WUSPUS */
.table-section {
  background: white;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
  overflow-x: auto;
}

/* ID Badge - Sama dengan WUSPUS */
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

/* Nama Info - Sama dengan WUSPUS */
.nama-info {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.nama-text {
  font-weight: 500;
  color: #1e293b;
}

.nik-text {
  font-size: 11px;
  color: #64748b;
}

/* Username Text */
.username-text {
  font-size: 13px;
  color: #475569;
  font-family: monospace;
}

/* Role Badge - Custom untuk operator */
.role-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  white-space: nowrap;
  text-transform: uppercase;
}

.role-admin {
  background: #fee2e2;
  color: #991b1b;
}

.role-operator {
  background: #dbeafe;
  color: #1e40af;
}

.role-other {
  background: #f1f5f9;
  color: #475569;
}

/* Posyandu Badge - Sama dengan WUSPUS */
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

/* Action Buttons - Sama dengan WUSPUS */
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

/* Empty State - Sama dengan WUSPUS */
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

/* Pagination Section - Sama dengan WUSPUS */
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

/* Modal - Sama dengan WUSPUS */
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

/* Responsive - Sama dengan WUSPUS */
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