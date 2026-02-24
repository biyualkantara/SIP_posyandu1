<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed } from 'vue'

const props = defineProps({ data: Object })
const rows = computed(() => props.data?.data ?? [])

const columns = [
  { key: 'id_wkp', label: 'ID', sortable: true },
  { key: 'nama_wuspus', label: 'Nama WUS/PUS', sortable: true },
  { key: 'jns_kontrasepsi', label: 'Jenis Kontrasepsi', sortable: true },
  { key: 'tgl_ganti', label: 'Tgl Ganti', sortable: true },
  { key: 'kontrasepsi_baru', label: 'KB Baru', sortable: true },
  { key: 'actions', label: 'Aksi', sortable: false },
]

const modalOpen = ref(false)
const selected = ref({})

function askDelete(row){ selected.value=row; modalOpen.value=true }
function closeModal(){ modalOpen.value=false; selected.value={} }

function confirmDelete(){
  router.delete(`/posyandu/wuspus-kontrasepsi/${selected.value.id_wkp}`, {
    preserveScroll: true,
    onSuccess: () => {
      closeModal()
      router.reload({ only: ['data'] })
    }
  })
}
</script>

<template>
<div class="mt-3 p-4 bg-white main-container">

  <div class="header-flex mb-3">
    <h1>Kontrasepsi WUS/PUS</h1>
    <Link href="/posyandu/wuspus-kontrasepsi/create" class="btn btn-primary">
      + Tambah
    </Link>
  </div>

  <DataTable :columns="columns" :rows="rows" :perPage="10">
    <template #col-actions="{ row }">
      <Link :href="`/posyandu/wuspus-kontrasepsi/${row.id_wkp}`">
        <span class="bg-info p-3 mr-2 rounded-circle text-white">
          <i class="icon-eye"></i>
        </span>
      </Link>

      <Link :href="`/posyandu/wuspus-kontrasepsi/${row.id_wkp}/edit`">
        <span class="bg-primary p-3 mr-2 rounded-circle text-white">
          <i class="icon-pencil"></i>
        </span>
      </Link>

      <span class="bg-danger p-3 rounded-circle text-white" @click="askDelete(row)">
        <i class="icon-trash"></i>
      </span>
    </template>
  </DataTable>

</div>
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