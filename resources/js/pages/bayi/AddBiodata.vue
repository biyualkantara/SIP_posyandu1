<script setup>
import Table from '@/components/ui/Table.vue';
import TableCol from '@/components/ui/TableCol.vue';
import TableHead from '@/components/ui/TableHead.vue';
import TableRow from '@/components/ui/TableRow.vue';

import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { onMounted, onBeforeUnmount } from 'vue';
import VueSelect from "vue3-select-component";

const props = defineProps({
    kecamatan: Array,
    kelurahan: Object,
    posyandu: Object,
    wuspus: Object
})

const emptyRow = () => ({
    tanggal_daftar: "",
    id_wuspus: "",
    nama_bayi: "",
    jenis_kelamin: "L",
    tanggal_lahir: "",
    bbl: "",
    keterangan: ""
})

const form = useForm({
    kecamatan_id: null,
    kelurahan_id: null,
    posyandu_id: null,
    rows: [emptyRow()]
})

function addRow() {
    form.rows.push(emptyRow());
}

function deleteRow(index) {
    if (form.rows.length <= 1) return

    form.rows.splice(index, 1)
}

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
        <div class="mt-3 p-4 bg-white" style="position: relative; min-height: 100vh;">
            <h1>Data Register Bayi  {{form.kecamatan_id}}</h1>
            <hr>
            <h2>Register Bayi</h2>
            <form @submit.prevent="form.post('/data_bayi/biodata')">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.kecamatan_id}">
                            <label for="kecamatan">Kecamatan</label>

                            <VueSelect
                                v-model="form.kecamatan_id"
                                :options="kecamatan.map(item => ({ label: item.nama_kec, value: item.id_kec }))"
                                placeholder="Pilih Kecamatan"
                            />

                            <!-- <select name="kecamatan" id="kecamatan" v-model="form.kecamatan_id" class="form-control">
                                <option :value="null" :selected="true">-- Pilih Kecamatan --</option>
                                <option :value="item.id_kec" v-for="item in kecamatan" :key="item.id_kec">{{ item.nama_kec }}</option>
                            </select> -->
                            <span class="help-block" v-if="form.errors.kecamatan_id">Kecamatan wajib diisi</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.kelurahan_id}">
                            <label for="kelurahan">Kelurahan</label>



                            <VueSelect
                                v-model="form.kelurahan_id"
                                placeholder="Pilih Kelurahan"
                                :options="kelurahan[form.kecamatan_id]?.map(item => ({ label: item.nama_kel, value: item.id_kel })) || []"
                                :isDisabled="!form.kecamatan_id"
                            />
                            <!-- <select name="kelurahan" id="kelurahan" v-model="form.kelurahan_id" class="form-control" :disabled="!form.kecamatan_id">
                                <option :value="null" :selected="true">-- Pilih Kelurahan --</option>
                                <option :value="item.id_kel" v-for="item in kelurahan[form.kecamatan_id]" :key="item.id_kel">{{ item.nama_kel }}</option>
                            </select> -->
                            <span class="help-block" v-if="form.errors.kelurahan_id">Kelurahan wajib diisi</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.posyandu_id}">
                            <label for="posyandu" >Posyandu</label>

                            <VueSelect
                                v-model="form.posyandu_id"
                                placeholder="Pilih Posyandu"
                                :options="posyandu[form.kelurahan_id]?.map(item => ({ label: item.nama_posyandu, value: item.id_posyandu })) || []"
                                :isDisabled="!form.kecamatan_id || !form.kelurahan_id"
                            />

                            <!-- <select name="posyandu" id="posyandu" v-model="form.posyandu_id" class="form-control" :disabled="!form.kecamatan_id || !form.kelurahan_id">
                                <option :value="null" :selected="true">-- Pilih Posyandu --</option>
                                <option :value="item.id_posyandu" v-for="item in posyandu[form.kelurahan_id]" :key="item.id_posyandu">{{ item.nama_posyandu }}</option>
                            </select> -->
                            <span class="help-block" v-if="form.errors.posyandu_id">Posyandu wajib diisi</span>
                        </div>
                    </div>
                </div>

                <Table class="mt-4" style="min-height: 200px;">
                    <TableHead>
                        <TableRow>
                            <TableCol asHead>Tanggal Daftar</TableCol>
                            <TableCol asHead>Nama Orang Tua</TableCol>
                            <TableCol asHead>Nama Bayi</TableCol>
                            <TableCol asHead>Jenis Kelamin</TableCol>
                            <TableCol asHead>Tanggal Lahir</TableCol>
                            <TableCol asHead>BBL (Gram)</TableCol>
                            <TableCol asHead>Keterangan</TableCol>
                            <TableCol asHead>Hapus?</TableCol>
                        </TableRow>
                        <TableRow v-for="(row, index) in form.rows" :key="index">
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.tanggal_daftar`] }">
                                    <input type="date" class="form-control" name="tanggal_daftar" v-model="row.tanggal_daftar"/>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.tanggal_daftar`]">Tanggal Daftar wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.id_wuspus`] }">
                                    <VueSelect
                                        v-model="row.id_wuspus"
                                        :options="wuspus[form.posyandu_id]?.map(i => ({ label: i.nama_wuspus + ' & ' + i.nama_suami, value: i.id_wuspus })) || []"
                                        :isDisabled="!form.posyandu_id"
                                        placeholder="Pilih Nama Orang Tua"
                                    />

                                    <!-- <Autocomplete  
                                        v-model="row.id_wuspus"
                                        :items="wuspus[form.posyandu_id]"
                                        :label="i => i.nama_wuspus + ' & ' + i.nama_suami"
                                        :searchBy="i => i.nama_wuspus + ' ' + i.nama_suami"
                                        :valueBy="i => i.id_wuspus"
                                    /> -->
                                    <span class="help-block" v-if="form.errors[`rows.${index}.id_wuspus`]">Nama Orang Tua wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.nama_bayi`] }">
                                    <input type="text" class="form-control" name="nama_bayi" v-model="row.nama_bayi"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.nama_bayi`]">Nama Bayi wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.jenis_kelamin`] }">
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" v-model="row.jenis_kelamin">
                                        <option value="L">L</option>
                                        <option value="P">P</option>
                                    </select>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.jenis_kelamin`]">Nama Orang Tua wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.tanggal_lahir`] }">
                                    <input type="date" class="form-control" v-model="row.tanggal_lahir" name="tanggal_lahir"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.tanggal_lahir`]">Tanggal Lahir wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.bbl`] }">
                                    <input type="text" class="form-control" v-model="row.bbl" name="bbl"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.bbl`]">Berat wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.keterangan`] }">
                                    <input type="text" class="form-control" v-model="row.keterangan" name="keterangan"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.keterangan`]">Keterangan tidak dapat diterima</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <span class="bg-primary p-3" style="border-radius: 1000px;" @click="deleteRow(index)">
                                    <i class="icon-trash"></i>
                                </span>
                            </TableCol>
                        </TableRow>
                    </TableHead>
                </Table>

                <button type="button" class="btn btn-success mt-5" style="float: right;" @click="addRow">Tambah Baris +</button>
                <button type="submit" class="btn btn-primary mt-5">Simpan Data</button>
            </form>
        </div>
    </AdminLayout>
</template>