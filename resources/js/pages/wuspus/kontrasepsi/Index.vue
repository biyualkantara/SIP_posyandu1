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
  <hr>
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

   <!-- MODAL DELETE -->
    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
      <div class="modal-card">
        <h3 class="modal-title">Hapus Data Kontrasepsi?</h3>
        <hr>

        <div class="text-center">
          <i class="icon-bin" style="font-size:55px;color:#f44336"></i>
          <h6 class="mt-3 ">Anda akan menghapus data :</h6>
          <div class="data-preview mt-2">
                <div>
                    <span class="label">NIK / Nama</span>
                    <div class="value">
                        {{ selected.nik_wuspus }} - {{ selected.nama_wuspus }}
                    </div>
                </div>
                <div class="mt-2">
                    <span class="label">Jenis Kontrasepsi</span>
                    <div class="value">
                        {{ selected.jns_kontrasepsi }}
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

</div>
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