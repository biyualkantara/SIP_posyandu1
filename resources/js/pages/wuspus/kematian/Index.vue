<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed } from 'vue'

const props = defineProps({
  data: Object
})

const rows = computed(() => props.data?.data ?? [])

const columns = [
  { key: 'id_wuspus_wafat', label: 'ID', sortable: true },
  { key: 'nik_wuspus', label: 'NIK', sortable: true },
  { key: 'nama_wuspus', label: 'Nama WUS/PUS', sortable: true },
  { key: 'tgl_wafat', label: 'Tanggal Wafat', sortable: true },
  { key: 'penyebab', label: 'Penyebab', sortable: true },
  { key: 'ket', label: 'Keterangan', sortable: false },
  { key: 'actions', label: 'Aksi', sortable: false },
]

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
  router.delete(`/posyandu/wuspus-wafat/${selected.value.id_wuspus_wafat}`,{
    preserveScroll:true,
    onSuccess:()=>{
      closeModal()
      router.reload({ only:['data'] })
    }
  })
}
</script>

<template>
  <AdminLayout>
    <div class="p-4 bg-white main-container">
      <div class="header-flex mb-3">
        <h2>Kematian WUS/PUS</h2>
        <Link href="/posyandu/wuspus-wafat/create" class="btn btn-primary">
          + Tambah Data
        </Link>
      </div>

      <hr>

      <DataTable :columns="columns" :rows="rows" :perPage="10">
        <template #col-actions="{ row }">
          <Link :href="`/posyandu/wuspus-wafat/${row.id_wuspus_wafat}`">
            <span class="bg-info p-3 rounded-circle text-white me-2" style="cursor:pointer;">
              <i class="icon-eye"></i>
            </span>
          </Link>

          <Link :href="`/posyandu/wuspus-wafat/${row.id_wuspus_wafat}/edit`">
            <span class="bg-primary p-3 rounded-circle text-white me-2" style="cursor:pointer;">
              <i class="icon-pencil"></i>
            </span>
          </Link>

          <span class="bg-danger p-3 rounded-circle text-white"
                style="cursor:pointer"
                @click="askDelete(row)">
            <i class="icon-trash"></i>
          </span>
        </template>
      </DataTable>

      <!-- PAGINATION -->
      <div class="mt-3 d-flex justify-content-end" v-if="props.data?.links?.length">
        <ul class="pagination">
          <li v-for="(l,i) in props.data.links"
              :key="i"
              class="page-item"
              :class="{active:l.active,disabled:!l.url}">
            <a class="page-link"
               href="#"
               v-html="l.label"
               @click.prevent="l.url && router.visit(l.url,{preserveScroll:true})">
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- MODAL DELETE -->
    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
      <div class="modal-card">
        <h4 class="text-center">Hapus Data Kematian?</h4>
        <hr>

        <div class="text-center">
          <p class="mb-1"><b>{{ selected.nama_wuspus }}</b></p>
          <div class="text-muted">{{ selected.nik_wuspus }}</div>
          <div class="mt-2">Tanggal: <b>{{ selected.tgl_wafat }}</b></div>
        </div>

        <div class="d-flex justify-content-center mt-3">
          <button class="btn btn-secondary me-2" @click="closeModal">Batal</button>
          <button class="btn btn-danger" @click="confirmDelete">Hapus</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.main-container{min-height:100vh}
.header-flex{display:flex;justify-content:space-between;align-items:center}
.overlay-blur{
  position:fixed;inset:0;
  background:rgba(0,0,0,.35);
  backdrop-filter:blur(6px);
  display:flex;align-items:center;justify-content:center;
  z-index:9999;
}
.modal-card{
  width:420px;
  background:#fff;
  border-radius:14px;
  padding:18px;
  box-shadow:0 20px 60px rgba(0,0,0,.2);
}
</style>