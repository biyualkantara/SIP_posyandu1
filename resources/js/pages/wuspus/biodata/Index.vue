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
  { key: 'id_wuspus', label: 'ID', sortable: true },
  { key: 'nama_wuspus', label: 'Nama WUS/PUS', sortable: true },
  { key: 'nama_posyandu', label: 'Posyandu', sortable: true },
  { key: 'umur', label: 'Umur', sortable: true },
  { key: 'status', label: 'Status', sortable: true },
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

watch(selectedKec, () => { selectedKel.value = ''; selectedPos.value = '' })
watch(selectedKel, () => { selectedPos.value = '' })

function applyFilter() {
  router.get('/posyandu/wuspus', {
    kec: selectedKec.value || '',
    kel: selectedKel.value || '',
    pos: selectedPos.value || '',
    q:   searchText.value || '',
  }, { preserveState: true, preserveScroll: true, replace: true })
}

// modal delete blur
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
  router.delete(`/posyandu/wuspus/${selected.value.id_wuspus}`, {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      router.reload({ only: ['data'] })
      window.dispatchEvent(new CustomEvent("toast", {
        detail: { type: "success", message: "Data WUS/PUS berhasil dihapus!" }
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
        <h1>WUS/PUS - Biodata</h1>
        <Link href="/posyandu/wuspus/create" class="btn btn-primary">+ Tambah</Link>
      </div>

      <hr>  

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

        <div class="col-lg-3 mb-2">
          <label>Posyandu</label>
          <select class="form-control" v-model="selectedPos" :disabled="!selectedKel" @change="applyFilter">
            <option value="">-- Semua --</option>
            <option v-for="p in posyanduList" :key="p.id_posyandu" :value="p.id_posyandu">{{ p.nama_posyandu }}</option>
          </select>
        </div>

        <div class="col-lg-3 mb-2">
          <label>Cari</label>
          <input class="form-control" v-model="searchText"
                 placeholder="Nama / NIK / Suami / Status / Posyandu..."
                 @keyup.enter="applyFilter">
        </div>
      </div>

      <DataTable :columns="columns" :rows="rows" :perPage="10">
        <template #col-nama_wuspus="{ row }">
          <span>{{ row.nik_wuspus }} - {{ row.nama_wuspus }}</span>
        </template>

        <template #col-actions="{ row }">
          <Link :href="`/posyandu/wuspus/${row.id_wuspus}`">
            <span class="bg-info p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-eye"></i>
            </span>
          </Link>

          <Link :href="`/posyandu/wuspus/${row.id_wuspus}/edit`">
            <span class="bg-primary p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-pencil"></i>
            </span>
          </Link>

          <span class="bg-danger p-3 rounded-circle text-white" style="cursor:pointer;" @click="askDelete(row)">
            <i class="icon-trash"></i>
          </span>
        </template>
      </DataTable>

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

    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
      <div class="modal-card">
        <h3 class="w-100 text-center">Hapus Data WUS/PUS?</h3>
        <hr>
        <div class="text-center">
          <p class="mb-1"><b>{{ selected.nama_wuspus }}</b></p>
          <div class="text-muted">{{ selected.nik_wuspus }}</div>
          <div class="text-muted mt-1">{{ selected.nama_posyandu }}</div>
          <div class="mt-2">Status: <b>{{ selected.status }}</b></div>
        </div>
        <div class="d-flex justify-content-center mt-4">
          <button class="btn btn-light px-4" @click="closeModal">Batal</button>
          <button class="btn btn-danger px-4 ms-2" @click="confirmDelete">Hapus</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.overlay-blur{
  position: fixed; inset: 0;
  background: rgba(0,0,0,.35);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  display:flex; align-items:center; justify-content:center;
  z-index: 9999;
}
.modal-card{
  width: 420px; background:#fff;
  border-radius: 14px; padding: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
</style>