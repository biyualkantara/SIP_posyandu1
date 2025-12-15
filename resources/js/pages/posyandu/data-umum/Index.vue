<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import { ref, computed, watch } from 'vue'

const props = defineProps({
    data: Object,
    kecamatan: Array,
    kelurahanGrouped: Object,
    filter: Object
})
const downloadPdf = () => {
  window.location.href = route('posyandu.data-umum.exportPdf')
}
const rows = computed(() => props.data?.data ?? [])

const columns = [
    { key: "id_posyandu", label: "ID", sortable: true },
    { key: "nama_posyandu", label: "Nama Posyandu", sortable: true },
    { key: "strata_psy", label: "Strata", sortable: true },
    { key: "alamat_posyandu", label: "Alamat", sortable: true },
    { key: "pj_umum", label: "PJ Umum", sortable: true },
    { key: "kader_aktif", label: "Kader Aktif", sortable: true },
    { key: "actions", label: "Aksi", sortable: false },
]

const selectedKec = ref(props.filter?.kec ?? '')
const selectedKel = ref(props.filter?.kel ?? '')
const searchText  = ref(props.filter?.q ?? '')

const kelurahanList = computed(() => {
    if (!selectedKec.value) return []
    return props.kelurahanGrouped?.[selectedKec.value] ?? []
})

watch(selectedKec, () => {
    selectedKel.value = ''
})

function applyFilter() {
    router.get('/posyandu/data-umum', {
        kec: selectedKec.value || '',
        kel: selectedKel.value || '',
        q:   searchText.value || '',
    }, { preserveState: true, preserveScroll: true, replace: true })
}

// Blurkan kalau hapus
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
    router.delete(`/posyandu/data-umum/${selected.value.id_posyandu}`, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()

            router.reload({ only: ['data'] })

            window.dispatchEvent(new CustomEvent("toast", {
                detail: { type: "success", message: "Data posyandu berhasil dihapus!" }
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
    <div class="mt-3 p-4 bg-white" style="min-height: 100vh;">
        <h1>Data Umum Posyandu</h1>
        <hr>

        <div class="d-flex justify-end mb-3">
            <Link href="/posyandu/data-umum/create" class="btn btn-primary">
                + Tambah Posyandu
            </Link>
           <!-- <button
            @click="downloadPdf"
            class="px-4 py-2 bg-red-600 text-white rounded"
            >
            Export PDF
            </button>-->
        </div>

        <hr />

        <div class="row mb-3">
            <div class="col-lg-3">
                <label>Kecamatan</label>
                <select class="form-control" v-model="selectedKec" @change="applyFilter">
                    <option value="">-- Semua --</option>
                    <option v-for="k in kecamatan" :key="k.id_kec" :value="k.id_kec">
                        {{ k.nama_kec }}
                    </option>
                </select>
            </div>

            <div class="col-lg-3">
                <label>Kelurahan</label>
                <select class="form-control" v-model="selectedKel" :disabled="!selectedKec" @change="applyFilter">
                    <option value="">-- Semua --</option>
                    <option v-for="k in kelurahanList" :key="k.id_kel" :value="k.id_kel">
                        {{ k.nama_kel }}
                    </option>
                </select>
            </div>
        </div>

        <!-- TABEL -->
        <DataTable :columns="columns" :rows="rows" :perPage="10">
            <template #col-actions="{ row }">
                <Link :href="`/posyandu/data-umum/${row.id_posyandu}`">
                    <span class="bg-info p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
                        <i class="icon-eye"></i>
                    </span>
                </Link>

                <Link :href="`/posyandu/data-umum/${row.id_posyandu}/edit`">
                    <span class="bg-primary p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
                        <i class="icon-pencil"></i>
                    </span>
                </Link>

                <span class="bg-danger p-3 rounded-circle text-white" style="cursor:pointer;" @click="deleteRow(row)">
                    <i class="icon-trash"></i>
                </span>
            </template>
        </DataTable>

        <div class="mt-3 d-flex justify-content-end" v-if="props.data?.links?.length">
            <nav>
                <ul class="pagination mb-0">
                    <li v-for="(l, idx) in props.data.links" :key="idx" class="page-item" :class="{ active: l.active, disabled: !l.url }">
                        <a class="page-link" href="#" @click.prevent="l.url && router.visit(l.url, { preserveScroll:true })" v-html="l.label"></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
        <div class="modal-card">
            <h3 class="w-100 text-center">Hapus Data Posyandu?</h3>
            <hr>
            <div class="text-center">
                <i class="icon-bin" style="font-size:55px;color:#bbb"></i>
                <p class="mt-3">Anda akan menghapus data:</p>
                <b>{{ selected.nama_posyandu }}</b>
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
.overlay-blur{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.35);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index: 9999;
}
.modal-card{
    width: 420px;
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
}
</style>