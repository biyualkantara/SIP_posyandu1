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
      wuspus: Object,
      bayi: Object,
      imunisasi: Array,
  })
  
  const emptyRow = () => ({
      id_bayi: '',
      id_imun: '',
      tanggal_imunisasi: '',
      keterangan: ''
  });

  const form = useForm({
      kecamatan_id: '',
      kelurahan_id: '',
      posyandu_id: '',
      wuspus_id: '',
      rows: [ emptyRow() ]
  });

  function addRow() {
      form.rows.push(emptyRow());
  }

  function deleteRow(index) {
      form.rows.splice(index, 1);
  }

  // <th>Tanggal</th>
								
	// 							<th>Berat</th>
								
	// 							<th width="80px" >Hasil</th>
								
	// 							<th width="70px" >PMT</th>
								
	// 							<th>Keterangan</th> 
</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white" style="position: relative; min-height: 100vh;">
            <h1>Data Imunisasi Bayi </h1>
            <hr>
            <h2>Imunisasi Bayi</h2>
            <form @submit.prevent="form.post('/data_bayi/imunisasi')">
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

                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.wuspus_id}">
                            <label for="wuspus" >Nama Orang Tua</label>

                            <VueSelect
                                v-model="form.wuspus_id"
                                placeholder="Pilih Nama Orang Tua"
                                :options="wuspus[form.posyandu_id]?.map(i => ({ label: i.nama_wuspus + ' & ' + i.nama_suami, value: i.id_wuspus })) || []"
                                :isDisabled="!form.posyandu_id"
                            />

                            <!-- <select name="wuspus" id="wuspus" v-model="form.wuspus_id" class="form-control" :disabled="!form.posyandu_id">
                                <option :value="null" :selected="true">-- Pilih Nama Orang Tua --</option>
                                <option :value="item.id_wuspus" v-for="item in wuspus[form.posyandu_id]" :key="item.id_wuspus">{{ item.nama_wuspus }} & {{ item.nama_suami }}</option>
                            </select> -->
                            <span class="help-block" v-if="form.errors.wuspus_id">Nama Orang Tua wajib diisi</span>
                        </div>
                    </div>
                </div>
                

                <Table class="mt-4" style="min-height: 200px;">
                    <TableHead>
                        <TableRow>
                            <TableCol asHead>Nama Bayi</TableCol>
                            <TableCol asHead>Jenis Imunisasi</TableCol>
                            <TableCol asHead>Tanggal Imunisasi</TableCol>
                            <TableCol asHead>Keterangan</TableCol>
                            <TableCol asHead>Hapus?</TableCol>
                        </TableRow>
                        <TableRow v-for="(row, index) in form.rows" :key="index">
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.id_bayi`] }">
                                    <VueSelect
                                        v-model="row.id_bayi"
                                        :options="bayi[form.wuspus_id]?.map(item => ({ label: item.nama_bayi, value: item.id_bayi })) || []"
                                        placeholder="Pilih Nama Bayi"
                                        :isDisabled="!form.wuspus_id"
                                    />
                                    <span class="help-block" v-if="form.errors[`rows.${index}.id_bayi`]">Nama Bayi wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.id_imun`] }">
                                    <VueSelect
                                        v-model="row.id_imun"
                                        :options="imunisasi.map(item => ({ label: item.kd_imun + ' - ' + item.jns_imun, value: item.id_imun }))"
                                        placeholder="Pilih Jenis Imunisasi"
                                    />
                                    <span class="help-block" v-if="form.errors[`rows.${index}.id_imun`]">Jenis Imunisasi wajib diisi</span>
                                </div>
                            </TableCol>
                            <TableCol>
                                <div class="form-group" :class="{'has-error': form.errors[`rows.${index}.tanggal_imunisasi`] }">
                                    <input type="date" class="form-control" v-model="row.tanggal_imunisasi" name="tanggal_imunisasi"></input>
                                    <span class="help-block" v-if="form.errors[`rows.${index}.tanggal_imunisasi`]">Tanggal Imunisasi wajib diisi</span>
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