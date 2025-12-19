<script setup>
import { Form, Link } from '@inertiajs/vue3';
import BaseModal from '@/components/ui/Modal.vue';
import ModalHeader from '@/components/ui/ModalHeader.vue';
import ModalBody from '@/components/ui/ModalBody.vue';
import ModalFooter from '@/components/ui/ModalFooter.vue';
import DataTable from '@/components/ui/DataTable.vue';

const props = defineProps({
    penimbangan: Array
})

const columns = [
    { key: "nama_posyandu", label: "Posyandu", sortable: true },
    { key: "nama_orang_tua", label: "Nama Orang Tua", sortable: true },
    { key: "nama_bayi", label: "Nama", sortable: true },
    { key: "tgl_pnb", label: "Tanggal Penimbangan", sortable: true },
    { key: "berat", label: "Berat", sortable: true },
    { key: "tb", label: "Tinggi Bayi", sortable: true },
    { key: "tinggi_ayah", label: "Tinggi Ayah", sortable: true },
    { key: "tinggi_ibu", label: "Tinggi Ibu", sortable: true },
    { key: "ket", label: "Keterangan", sortable: true },
    { key: "actions", label: "Aksi", sortable: false }
];

import { ref } from 'vue';

const modalOpen = ref(false);
const id_bayi_pnb = ref(null);
const nama_orangtua = ref('');
const nama_bayi = ref('');

function deleteRow(row) {
    id_bayi_pnb.value = row.id_bayi_pnb;
    nama_orangtua.value = row.nama_orang_tua;
    nama_bayi.value = row.nama_bayi;
    modalOpen.value = true;
}
</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white">
            <h1>Register Penimbangan Bayi</h1>
            <hr>
            <div class="d-flex justify-end">
                <Link href="/data_bayi/penimbangan/tambah" class="btn btn-primary float-right clearfix">+ Tambah Data Penimbangan</Link>
            </div>
            <hr>
            <DataTable :columns="columns" :rows="penimbangan" :perPage="10">
                <template #col-actions="{ row }">
                    <Link :href="`/data_bayi/penimbangan/${row.id_bayi_pnb}/edit`">
                        <span class="bg-warning p-3 mr-2" style="border-radius: 1000px;">
                            <i class="icon-pencil"></i>
                        </span>
                    </Link>
                    <span class="bg-primary p-3" style="border-radius: 1000px;" @click="deleteRow(row)">
                        <i class="icon-trash"></i>
                    </span>
                </template>
            </DataTable>
        </div>

        <Form :action="`/data_bayi/penimbangan/${id_bayi_pnb}`" method="DELETE">
            <BaseModal :show="modalOpen" @close="modalOpen = false">
                <template #header>
                <ModalHeader @close="modalOpen = false">
                    <h2>Hapus Data Bayi</h2>
                </ModalHeader>
                </template>

                <template #body>
                <ModalBody>
                    <h6 class="text-semibold">Data penimbangan berikut akan terhapus:</h6>
                    <ul>
                        <li>ID Penimbangan: {{ id_bayi_pnb }}</li>
                        <li>Nama Orangtua: {{ nama_orangtua }}</li>
                        <li>Nama Bayi: {{ nama_bayi }}</li>
                    </ul>
                </ModalBody>
                </template>

                <template #footer>
                <ModalFooter>
                    <button type="buttom" class="btn btn-danger" @click.prevent="modalOpen = false">Tidak</button>
                    <button type="submit" class="btn btn-link">Ya, Hapus</button>
                </ModalFooter>
                </template>
            </BaseModal>
        </Form>
    </AdminLayout>
</template>