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
  { key: 'id_bumil', label: 'ID', sortable: true },
  { key: 'nama_wuspus', label: 'Nama WUS', sortable: true },
  { key: 'nama_posyandu', label: 'Posyandu', sortable: true },
  { key: 'tgl_daftar', label: 'Tgl Daftar', sortable: true },
  { key: 'umur_kehamilan', label: 'Umur Hamil', sortable: true },
  { key: 'hamil_ke', label: 'Hamil Ke', sortable: true },
  { key: 'lila', label: 'LILA', sortable: true },
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
  selectedKel.value = ''
  selectedPos.value = ''
})
watch(selectedKel, () => {
  selectedPos.value = ''
})

function applyFilter() {
  router.get('/posyandu/bumil', {
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
  router.delete(`/posyandu/bumil/${selected.value.id_bumil}`, {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      router.reload({ only: ['data'] })
      window.dispatchEvent(new CustomEvent("toast", {
        detail: { type: "success", message: "Data bumil berhasil dihapus!" }
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
    <div class="mt-3 p-4 bg-white main-container">
      <div class="header-flex mb-3">
        <h1>Data Ibu Hamil (BUMIL) - Biodata</h1>
        <Link href="/posyandu/bumil/create" class="btn btn-primary">+ Tambah</Link>
      </div>

      <hr>

      <!-- FILTER -->
      <div class="row mb-3">
        <div class="col-lg-3 mb-2">
          <label>Kecamatan</label>
          <select class="form-control" v-model="selectedKec" @change="applyFilter">
            <option value="">-- Semua --</option>
            <option v-for="k in kecamatan" :key="k.id_kec" :value="k.id_kec">{{ k.nama_kec }}</option>
          </select>
        </div>

        <div class="col-lg-3 mb-2">
          <label>Kelurahan</label>
          <select class="form-control" v-model="selectedKel" :disabled="!selectedKec" @change="applyFilter">
            <option value="">-- Semua --</option>
            <option v-for="k in kelurahanList" :key="k.id_kel" :value="k.id_kel">{{ k.nama_kel }}</option>
          </select>
        </div>
      </div>

      <!-- TABEL -->
      <DataTable :columns="columns" :rows="rows" :perPage="10">
        <template #col-nama_wuspus="{ row }">
          <span>{{ row.nik_wuspus }} - {{ row.nama_wuspus }}</span>
        </template>


        <template #col-actions="{ row }">
          <Link :href="`/posyandu/bumil/${row.id_bumil}`">
            <span class="bg-info p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-eye"></i>
            </span>
          </Link>

          <Link :href="`/posyandu/bumil/${row.id_bumil}/edit`">
            <span class="bg-primary p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-pencil"></i>
            </span>
          </Link>

          <span class="bg-danger p-3 rounded-circle text-white" style="cursor:pointer;" @click="deleteRow(row)">
            <i class="icon-trash"></i>
          </span>
        </template>
      </DataTable>

      <!-- PAGINATION (LINKS) -->
      <div class="mt-3 d-flex justify-content-end" v-if="props.data?.links?.length">
        <nav>
          <ul class="pagination mb-0">
            <li v-for="(l, idx) in props.data.links" :key="idx"
                class="page-item" :class="{ active: l.active, disabled: !l.url }">
              <a class="page-link" href="#"
                 @click.prevent="l.url && router.visit(l.url, { preserveScroll:true })"
                 v-html="l.label"></a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <!-- MODAL DELETE -->
    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
      <div class="modal-card">
        <h3 class="modal-title">Hapus Data Bumil?</h3>
        <hr>
        <div class="text-center">
          <i class="icon-bin" style="font-size:55px;color:#f44336"></i>
          <h6 class="mt-3 mb-1">Anda akan menghapus data:</h6>
          <div class="data-preview mt-2">
                <div>
                    <span class="label">NIK / Nama</span>
                    <div class="value">
                        {{ selected.nik_wuspus }} - {{ selected.nama_wuspus }}
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-area">
          <button class="btn btn-light px-4" @click="closeModal">Batal</button>
          <button class="btn btn-danger px-4 ms-2" @click="confirmDelete">Hapus</button>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<style scoped>
/* Overlay */
.overlay-blur {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Modal */
.modal-card {
    width: 420px;
    background: #ffffff;
    border-radius: 18px;
    padding: 28px 24px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.18);
    text-align: center;
    animation: fadeScale 0.2s ease;
}

/* Title */
.modal-card h3 {
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
}

/* Garis */
.modal-card hr {
    border: none;
    height: 1px;
    background: #eee;
    margin: 15px 0 20px 0;
}

/* Icon */
.icon-bin {
    font-size: 55px;
    color: #f44336;
    display: inline-block;
    line-height: 1;
    margin-bottom: 10px;
}

/* Nama Posyandu */
.modal-card b {
    display: block;
    font-size: 17px;
    margin-top: 5px;
    color: #222;
}

/* Tombol */
.modal-card .btn {
    border-radius: 8px;
    padding: 8px 22px;
    transition: 0.2s ease;
}

.modal-card .btn-light {
    background: #f1f1f1;
    border: none;
}

.modal-card .btn-light:hover {
    background: #e0e0e0;
}

.modal-card .btn-danger {
    background: #f44336;
    border: none;
}

.modal-card .btn-danger:hover {
    background: #d32f2f;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(244, 67, 54, 0.3);
}
.btn-area {
    margin-top: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
}
/* Animasi */
@keyframes fadeScale {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.data-preview {
    text-align: center;
    font-size: 14px;
}

.label {
    display: block;
    font-size: 12px;
    color: #888;
}

.value {
    font-weight: 600;
    font-size: 15px;
    color: #222;
}

.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}
</style>