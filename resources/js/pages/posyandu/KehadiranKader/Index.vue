<script setup>
import { Link, router } from '@inertiajs/vue3'
import DataTable from '@/components/ui/DataTable.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import { ref, computed, watch } from 'vue'

const props = defineProps({
    data: Object,
    kecamatan: Array,
    kelurahanGrouped: Object,
    filter: Object
})

const rows = computed(() => props.data?.data ?? [])

const columns = [
    { key: "id_kdrhdr", label: "ID", sortable: true },
    { key: "nama_posyandu", label: "Posyandu", sortable: true },
    { key: "bulan_tahun", label: "Bulan/Tahun", sortable: true },
    { key: "pkk", label: "PKK", sortable: true },
    { key: "plkb", label: "PLKB", sortable: true },
    { key: "medis", label: "Medis", sortable: true },
    { key: "actions", label: "Aksi", sortable: false },
]

const selectedKec = ref(props.filter?.kec ?? '')
const selectedKel = ref(props.filter?.kel ?? '')
const selectedBln = ref(props.filter?.bln ?? '')
const searchText  = ref(props.filter?.q ?? '')

const kelurahanList = computed(() => {
    if (!selectedKec.value) return []
    return props.kelurahanGrouped?.[selectedKec.value] ?? []
})

watch(selectedKec, () => {
    selectedKel.value = ''
})

function applyFilter() {
    router.get('/posyandu/kehadiran-kader', {
        kec: selectedKec.value || '',
        kel: selectedKel.value || '',
        bln: selectedBln.value || '',
        q:   searchText.value || '',
    }, { preserveState: true, preserveScroll: true, replace: true })
}

// modal delete
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
    router.delete(`/posyandu/kehadiran-kader/${selected.value.id_kdrhdr}`, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()
            router.reload({ only: ['data'] })
            window.dispatchEvent(new CustomEvent("toast", {
                detail: { type: "success", message: "Data kehadiran kader berhasil dihapus!" }
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
    <div class="mt-3 p-4 bg-white" style="min-height: 100vh;">
         <div class="header-flex mb-3">
            <h1 class="mb-0">Data Kehadiran Kader</h1>
            <div>
                <Link href="/posyandu/kehadiran-kader/create" class="btn btn-primary">
                    + Tambah Kehadiran
                </Link>
            </div>
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

            <div class="col-lg-3">
                <label>Bulan</label>
                <input type="month" class="form-control" v-model="selectedBln" @change="applyFilter">
            </div>

            <div class="col-lg-3">
                <label>Cari Posyandu</label>
                <input type="text" class="form-control" v-model="searchText" @input="applyFilter">
            </div>
        </div>

        <DataTable :columns="columns" :rows="rows" :perPage="10">
            <template #col-actions="{ row }">
                <Link :href="`/posyandu/kehadiran-kader/${row.id_kdrhdr}`">
                    <span class="bg-info p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
                        <i class="icon-eye"></i>
                    </span>
                </Link>

                <Link :href="`/posyandu/kehadiran-kader/${row.id_kdrhdr}/edit`">
                    <span class="bg-primary p-3 mr-2 rounded-circle text-white" style="cursor:pointer;">
                        <i class="icon-pencil"></i>
                    </span>
                </Link>

                <span class="bg-danger p-3 rounded-circle text-white" style="cursor:pointer;" @click="deleteRow(row)">
                    <i class="icon-trash"></i>
                </span>
            </template>

            <template #col-bulan_tahun="{ row }">
                <span>{{ (row.bulan_tahun || '').toString().slice(0,7) }}</span>
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
            <h3 class="modal-title">Hapus Data Posyandu?</h3>
            <hr>
            <div class="text-center">
                <i class="icon-bin" style="font-size:55px;color:#f44336"></i>
                <h6 class="mt-3">Anda akan menghapus data:</h6>
                <b>{{ selected.nama_posyandu }}</b>
                <div class="mt-1">
                    <b>Kehadiran Kader ({{ (selected.bulan_tahun || '').toString().slice(0,7) }})</b>
                </div>
            </div>
            <div class="btn-area">
                <button class="btn btn-light px-4" @click="closeModal">Batal</button>
                <button class="btn btn-danger px-4 ms-2" @click="confirmDelete">Hapus</button>
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
.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}
</style>