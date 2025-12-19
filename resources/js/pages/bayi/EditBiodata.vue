<script setup>
import Table from '@/components/ui/Table.vue';
import TableCol from '@/components/ui/TableCol.vue';
import TableHead from '@/components/ui/TableHead.vue';
import TableRow from '@/components/ui/TableRow.vue';
import Autocomplete from '@/components/ui/Autocomplete.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    bayi: Object,
    orang_tua: Object
})

const form = useForm({
    tanggal_daftar: props.bayi.tgl_daftar,
    id_wuspus: props.orang_tua.id_wuspus,
    nama_bayi: props.bayi.nama_bayi,
    jenis_kelamin: props.bayi.jk,
    tanggal_lahir: props.bayi.tgl_lhr,
    bbl: props.bayi.bb,
    keterangan: props.bayi.ket
})

onMounted(() => {
    window.addEventListener('beforeunload', handleBeforeUnload)
})

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', handleBeforeUnload)
})

function handleBeforeUnload(event) {
    // Shows the browser's default dialog
    event.preventDefault()
    event.returnValue = ''
}
</script>

<template>
    <AdminLayout>
        <div class="mt-3 py-4 px-5 bg-white" style="position: relative; min-height: 100vh;">
            <h1>Edit Data Bayi</h1>
            <hr>
            <h2>Data Bayi</h2>
            <form @submit.prevent="form.put(`/data_bayi/biodata/${bayi.id_bayi}`)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tanggal_daftar">Tanggal Daftar</label>
                            <input type="date" v-model="form.tanggal_daftar" class="form-control" id="tanggal_daftar" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama_bayi">Nama Bayi</label>
                            <input type="text" v-model="form.nama_bayi" class="form-control" id="nama_bayi" />
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.jenis_kelamin}">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" v-model="form.jenis_kelamin" class="form-control">
                                <option :value="null" :selected="true">-- Pilih Jenis Kelamin --</option>
                                <option value="L">L</option>
                                <option value="P">P</option>
                            </select>
                            <span class="help-block" v-if="form.errors.jenis_kelamin">Jenis Kelamin wajib diisi</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" v-model="form.tanggal_lahir" class="form-control" id="tanggal_lahir" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="bbl">BBL (Gram)</label>
                            <input type="text" v-model="form.bbl" class="form-control" id="bbl" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama_orang_tua">Nama Orang Tua</label>
                            <input type="text" v-model="form.id_wuspus" class="form-control" id="nama_orang_tua" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" v-model="form.keterangan" class="form-control" id="keterangan" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary mt-5" style="float: right;">Simpan Data</button>
                        <button type="button" class="btn btn-primary mt-5 mr-4" style="float: right;">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>