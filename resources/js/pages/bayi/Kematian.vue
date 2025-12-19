<script setup>
import { Form, Link } from '@inertiajs/vue3';
import DataTable from '@/components/ui/DataTable.vue';
import BaseModal from '@/components/ui/Modal.vue';
import ModalHeader from '@/components/ui/ModalHeader.vue';
import ModalBody from '@/components/ui/ModalBody.vue';
import ModalFooter from '@/components/ui/ModalFooter.vue';
import { ref } from 'vue';

const props = defineProps({
    kematian: Array
});

const columns = [
    { key: "nama_posyandu", label: "Nama Posyandu", sortable: true },
    { key: "nama_orang_tua", label: "Nama Orang Tua", sortable: true },
    { key: "nama_bayi", label: "Nama Bayi", sortable: true },
    { key: "tgl_kematian", label: "Tgl Kematian", sortable: true },
    { key: "ket", label: "Keterangan", sortable: true },
    { key: "actions", label: "Aksi", sortable: false }
];

let modalOpen = ref(false);
const id_bayi_wafat = ref('');
const nama_orangtua = ref('');
const nama_bayi = ref('');

function deleteRow(row) {
    id_bayi_wafat.value = row.id_wafat;
    nama_orangtua.value = row.nama_orang_tua;
    nama_bayi.value = row.nama_bayi;
    modalOpen.value = true;
}
</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white">
            <h1>Register Bayi</h1>
            <hr>
            <div class="d-flex justify-end">
                <Link href="/data_bayi/kematian/tambah" class="btn btn-primary float-right clearfix">+ Tambah Data Kematian</Link>
            </div>
            <hr>
            <DataTable :columns="columns" :rows="kematian" :perPage="10">
                <template #col-actions="{ row }">
                    <Link :href="`/data_bayi/kematian/${row.id_wafat}/edit`" class="bg-warning p-3 me-2" style="border-radius: 1000px;">
                        <i class="icon-pencil"></i>
                    </Link>
                    <span class="bg-primary p-3" style="border-radius: 1000px;" @click="deleteRow(row)">
                        <i class="icon-trash"></i>
                    </span>
                </template>
            </DataTable>
        </div>

        <Form :action="`/data_bayi/kematian/${id_bayi_wafat}`" method="DELETE">
            <BaseModal :show="modalOpen" @close="modalOpen = false">
                <template #header>
                <ModalHeader @close="modalOpen = false">
                    <h2>Hapus Data Kematian</h2>
                </ModalHeader>
                </template>

                <template #body>
                <ModalBody>
                    <h6 class="text-semibold">Data kematian berikut akan terhapus:</h6>
                    <ul>
                        <li>ID Kematian: {{ id_bayi_wafat }}</li>
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