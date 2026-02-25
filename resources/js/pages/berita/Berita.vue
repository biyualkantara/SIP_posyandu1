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
    berita: Array
})

const columns = [
    { key: "id_berita", label: "ID Berita", sortable: true },
    { key: "ringkasan", label: "Ringkasan", sortable: true },
    { key: "penulis", label: "Penulis", sortable: true },
    { key: "tanggal_waktu", label: "Tanggal Waktu", sortable: true },
    { key: "actions", label: "Aksi", sortable: false }
];

const id_berita = ref(null);
const ringkasan = ref(null);
const penulis = ref(null);
const tanggal_waktu = ref(null);

function deleteRow(row) {
    id_berita.value = row.id_berita;
    ringkasan.value = row.ringkasan;
    penulis.value = row.penulis;
    tanggal_waktu.value = row.tanggal_waktu;
    modalOpen.value = true;
}

const modalOpen = ref(false);
</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white">
            <h1>Berita</h1>
            <hr>
            <div class="d-flex justify-end">
                <Link href="/berita/create" class="btn btn-primary float-right clearfix">+ Tambah Berita</Link>
            </div>
            <hr>
            <DataTable :columns="columns" :rows="berita" :perPage="10">
                <template #col-actions="{ row }">
                    <Link :href="`/berita/${row.id_berita}/edit`">
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
        
        <Form :action="`/berita/${id_berita}`" method="DELETE">
            <BaseModal :show="modalOpen" @close="modalOpen = false">
                <template #header>
                <ModalHeader @close="modalOpen = false">
                    <h2>Hapus Berita</h2>
                </ModalHeader>
                </template>

                <template #body>
                <ModalBody>
                    <h6 class="text-semibold">Data berita berikut akan terhapus:</h6>
                    <ul>
                        <li>ID Berita: {{ id_berita }}</li>
                        <li>Ringkasan: {{ ringkasan }}</li>
                        <li>Penulis: {{ penulis }}</li>
                        <li>Tanggal Waktu: {{ tanggal_waktu }}</li>
                    </ul>
                </ModalBody>
                </template>

                <template #footer>
                <ModalFooter>
                    <button type="buttom" class="btn btn-danger" @click.prevent="modalOpen = false">Tidak</button>
                    <button type="submit" class="btn btn-link" @click="modalOpen = false">Ya, Hapus</button>
                </ModalFooter>
                </template>
            </BaseModal>
        </Form>
    </AdminLayout>
</template>