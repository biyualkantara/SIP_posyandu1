<script setup>
  import Table from '@/components/ui/Table.vue';
  import TableCol from '@/components/ui/TableCol.vue';
  import TableHead from '@/components/ui/TableHead.vue';
  import TableRow from '@/components/ui/TableRow.vue';

  import { useForm } from '@inertiajs/vue3';
  import VueSelect from "vue3-select-component";

  const props = defineProps({
      kecamatan: Array,
      kelurahan: Object,
      posyandu: Object,
      bayi: Array,
  })
  
  const emptyRow = () => ({
      id_bayi: '',
      tanggal_kematian: '',
      keterangan: ''
  });

  const form = useForm({
      kecamatan_id: '',
      kelurahan_id: '',
      posyandu_id: '',
      rows: [ emptyRow() ]
  });

  function addRow() {
      form.rows.push(emptyRow());
  }

  function deleteRow(index) {
      form.rows.splice(index, 1);
  }
</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white" style="position: relative; min-height: 100vh;">
            <h1>Data Kematian Bayi </h1>
            <hr>
            <h2>Kematian Bayi</h2>
            <form @submit.prevent="form.post('/data_bayi/kematian')">
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
                            <TableCol asHead>Nama Bayi</TableCol>
                            <TableCol asHead>Tanggal Meninggal</TableCol>
                            <TableCol asHead>Keterangan</TableCol>
                            <TableCol asHead>Hapus?</TableCol>
                        </TableRow>
                        <TableRow v-for="(row, index) in form.rows" :key="index">
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.id_bayi`] }">
                                    <VueSelect
                                        v-model="row.id_bayi"
                                        :options="bayi.map(item => ({ label: item.nama_bayi, value: item.id_bayi })) || []"
                                        placeholder="Pilih Nama Bayi"
                                        :isDisabled="!form.posyandu_id"
                                    />
                                    <span class="help-block" v-if="form.errors[`rows.${index}.id_bayi`]">Nama Bayi wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.tanggal_kematian`] }">
                                    <input type="date" class="form-control" v-model="row.tanggal_kematian" name="tanggal_kematian"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.tanggal_kematian`]">Tanggal Meninggal wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.keterangan`] }">
                                    <input type="text" class="form-control" v-model="row.keterangan" name="keterangan"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.keterangan`]">Keterangan wajib diisi</span>
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