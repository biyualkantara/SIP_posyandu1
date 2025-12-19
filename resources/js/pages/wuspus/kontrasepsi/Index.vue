<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed } from 'vue'

const props = defineProps({
  data: Object,
})

const rows = computed(() => props.data?.data ?? [])

const columns = [
  { key: 'id_wkp', label: 'ID', sortable: true },
  { key: 'nama_wuspus', label: 'Nama WUS/PUS', sortable: true },
  { key: 'jns_kontrasepsi', label: 'Jenis Kontrasepsi', sortable: true },
  { key: 'tgl_ganti', label: 'Tgl Ganti', sortable: true },
  { key: 'kontrasepsi_baru', label: 'KB Baru', sortable: true },
  { key: 'actions', label: 'Aksi', sortable: false },
]

// modal delete blur
const modalOpen = ref(false)
const selected = ref({})

function askDelete(row){
  selected.value = row
  modalOpen.value = true
}
function closeModal(){
  modalOpen.value = false
  selected.value = {}
}
function confirmDelete(){
  router.delete(`/posyandu/wuspus-kontrasepsi/${selected.value.id_wkp}`, {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      router.reload({ only: ['data'] })
      window.dispatchEvent(new CustomEvent("toast", {
        detail: { type: "success", message: "Data kontrasepsi berhasil dihapus!" }
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
        <h1>Kontrasepsi WUS/PUS</h1>
        <Link href="/posyandu//wuspus-kontrasepsi/create" class="btn btn-primary">+ Tambah</Link>
      </div>

      <hr>

      <DataTable :columns="columns" :rows="rows" :perPage="10">
        <template #col-actions="{ row }">
          <Link :href="`/posyandu/wuspus-kontrasepsi/${row.id_wkp}`">
            <span class="bg-info p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-eye"></i>
            </span>
          </Link>

          <Link :href="`/posyandu/wuspus-kontrasepsi/${row.id_wkp}/edit`">
            <span class="bg-primary p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
              <i class="icon-pencil"></i>
            </span>
          </Link>

          <span class="bg-danger p-3 rounded-circle text-white" style="cursor:pointer;" @click="askDelete(row)">
            <i class="icon-trash"></i>
          </span>
        </template>
      </DataTable>

      <!-- pagination links inertia -->
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

    <!-- modal delete -->
    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
      <div class="modal-card">
        <h3 class="w-100 text-center">Hapus Data Kontrasepsi?</h3>
        <hr>
        <div class="text-center">
          <p class="mb-1"><b>{{ selected.nama_wuspus }}</b></p>
          <div class="mt-2">Jenis: <b>{{ selected.jns_kontrasepsi }}</b></div>
          <div class="mt-1">Tanggal ganti: <b>{{ selected.tgl_ganti }}</b></div>
          <div class="mt-1">KB baru: <b>{{ selected.kontrasepsi_baru }}</b></div>
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