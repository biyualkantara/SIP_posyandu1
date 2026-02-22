<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed } from 'vue'

const props = defineProps({
  data: Object,
  filter: Object
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
  router.get('/operator', {
    q: searchText.value || ''
  }, { preserveState: true, preserveScroll: true })
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
  <div class="mt-3 p-4 bg-white main-container">
    <div class="header-flex mb-3">
      <h1>Data Operator</h1>
      <Link href="/operator/create" class="btn btn-primary">+ Tambah Operator</Link>
    </div>

    <DataTable :columns="columns" :rows="rows" :perPage="10">
      <template #col-role="{ row }">
        <span class="badge bg-info text-uppercase">{{ row.role }}</span>
      </template>

      <template #col-actions="{ row }">
        <Link :href="`/operator/${row.id_operator}`">
          <span class="bg-info p-3 mr-2 rounded-circle text-white">
            <i class="icon-eye"></i>
          </span>
        </Link>

        <Link :href="`/operator/${row.id_operator}/edit`">
          <span class="bg-primary p-3 mr-2 rounded-circle text-white">
            <i class="icon-pencil"></i>
          </span>
        </Link>

        <span class="bg-danger p-3 rounded-circle text-white" @click="deleteRow(row)">
          <i class="icon-trash"></i>
        </span>
      </template>
    </DataTable>

    <!-- PAGINATION -->
    <div class="mt-3 d-flex justify-content-end" v-if="props.data?.links?.length">
      <ul class="pagination mb-0">
        <li v-for="(l, i) in props.data.links" :key="i"
            class="page-item" :class="{ active: l.active, disabled: !l.url }">
          <a class="page-link" href="#"
             @click.prevent="l.url && router.visit(l.url, { preserveScroll:true })"
             v-html="l.label"></a>
        </li>
      </ul>
    </div>
  </div>

  <!-- MODAL HAPUS -->
  <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
    <div class="modal-card">
      <h3 class="text-center">Hapus Operator?</h3>
      <hr>
      <p class="text-center"><b>{{ selected.nama }}</b></p>
      <div class="d-flex justify-content-center mt-4">
        <button class="btn btn-light" @click="closeModal">Batal</button>
        <button class="btn btn-danger ms-2" @click="confirmDelete">Hapus</button>
      </div>
    </div>
  </div>
</AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.overlay-blur{position:fixed;inset:0;background:rgba(0,0,0,.35);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center}
.modal-card{width:420px;background:#fff;border-radius:14px;padding:18px}
</style>