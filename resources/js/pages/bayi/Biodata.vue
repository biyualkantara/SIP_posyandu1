<script setup>
import { Link } from '@inertiajs/vue3';
import DataTable from '@/components/ui/DataTable.vue';
import BaseModal from '@/components/ui/Modal.vue';
import ModalHeader from '@/components/ui/ModalHeader.vue';
import ModalBody from '@/components/ui/ModalBody.vue';
import ModalFooter from '@/components/ui/ModalFooter.vue';
import { ref } from 'vue';
import {Form} from '@inertiajs/vue3';

const props = defineProps({
    bayi: Array
})

const columns = [
    { key: "id_bayi", label: "ID Bayi", sortable: true },
    { key: "nama_posyandu", label: "Posyandu", sortable: true },
    { key: "nama_bayi", label: "Nama", sortable: true },
    { key: "jk", label: "L/P", sortable: true },
    { key: "tgl_lhr", label: "Tgl Lahir", sortable: true },
    { key: "bb", label: "BBL", sortable: true },
    { key: "nama_wuspus", label: "Nama Ibu", sortable: true },
    { key: "nama_suami", label: "Nama Suami", sortable: true },
    { key: "actions", label: "Aksi", sortable: false }
];

const id_bayi = ref(null);
const nama_posyandu = ref(null);
const nama_bayi = ref(null);
const jk = ref(null);
const tgl_lhr = ref(null);
const bb = ref(null);
const nama_wuspus = ref(null);
const nama_suami = ref(null);

function deleteRow(row) {
    id_bayi.value = row.id_bayi;
    nama_posyandu.value = row.nama_posyandu;
    nama_bayi.value = row.nama_bayi;
    jk.value = row.jk;
    tgl_lhr.value = row.tgl_lhr;
    bb.value = row.bb;
    nama_wuspus.value = row.nama_wuspus;
    nama_suami.value = row.nama_suami;
    modalOpen.value = true;
}

const modalOpen = ref(false);
</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white">
            <h1>Register Bayi</h1>
            <hr>
            <div class="d-flex justify-end">
                <Link href="/data_bayi/biodata/add" class="btn btn-primary float-right clearfix">+ Tambah Data Bayi</Link>
            </div>
            <hr>
            <DataTable :columns="columns" :rows="bayi" :perPage="10">
                <template #col-actions="{ row }">
                    <Link :href="`/data_bayi/biodata/${row.id_bayi}/edit`">
                        <span class="bg-warning p-3 mr-2" style="border-radius: 1000px;">
                            <i class="icon-pencil"></i>
                        </span>
                    </Link>
                    <span class="bg-primary p-3" style="border-radius: 1000px; cursor: pointer;" @click="deleteRow(row)">
                        <i class="icon-trash"></i>
                    </span>
                </template>
            </DataTable>
        </div>
        
        <Form :action="`/data_bayi/biodata/${id_bayi}`" method="DELETE">
            <BaseModal :show="modalOpen" @close="modalOpen = false">
                <template #header>
                <ModalHeader @close="modalOpen = false">
                    <h2>Hapus Data Bayi</h2>
                </ModalHeader>
                </template>

                <template #body>
                <ModalBody>
                    <h6 class="text-semibold">Data bayi berikut akan terhapus:</h6>
                    <ul>
                        <li>ID Bayi: {{ id_bayi }}</li>
                        <li>Nama Posyandu: {{ nama_posyandu }}</li>
                        <li>Nama Bayi: {{ nama_bayi }}</li>
                        <li>Jenis Kelamin: {{ jk }}</li>
                        <li>Tanggal Lahir: {{ tgl_lhr }}</li>
                        <li>Berat Badan (Gram): {{ bb }}</li>
                        <li>Nama Wuspus: {{ nama_wuspus }}</li>
                        <li>Nama Suami: {{ nama_suami }}</li>
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