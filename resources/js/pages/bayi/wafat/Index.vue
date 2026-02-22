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
    <div class="mt-3 p-4 bg-white main-container">
      <div class="header-flex mb-3">
        <h1>Data Kematian Bayi</h1>
        <Link href="/posyandu/bayi-wafat/create" class="btn btn-primary">+ Tambah</Link>
      </div>

      <hr>

      <!-- TABEL -->
      <DataTable :columns="columns" :rows="rows" :perPage="10">
        <template #col-actions="{ row }">
          <Link :href="`/posyandu/bayi-wafat/${row.id_wafat}`">
            <span class="bg-info p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-eye"></i>
            </span>
          </Link>

          <Link :href="`/posyandu/bayi-wafat/${row.id_wafat}/edit`">
            <span class="bg-primary p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-pencil"></i>
            </span>
          </Link>

          <span class="bg-danger p-3 rounded-circle text-white" style="cursor:pointer;" @click="deleteRow(row)">
            <i class="icon-trash"></i>
          </span>
        </template>
      </DataTable>

      <!-- PAGINATION -->
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
        <h3 class="w-100 text-center">Hapus Data Kematian Bayi?</h3>
        <hr>
        <div class="text-center">
          <i class="icon-bin" style="font-size:55px;color:#bbb"></i>
          <p class="mt-3 mb-1">Anda akan menghapus data:</p>
          <b>{{ selected.nama_bayi }}</b>
          <div class="text-muted mt-1">{{ selected.tgl_kematian }}</div>
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
  width: 420px; background: #fff;
  border-radius: 14px; padding: 18px;
  box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
</style>