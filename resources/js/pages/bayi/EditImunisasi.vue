<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from 'vue';
import VueSelect from 'vue3-select-component';

const props = defineProps({
    daftar_imunisasi: Array,
    imunisasi: Object,
    bayi: Object,
    orang_tua: Object
})

const form = useForm({
    id_bayi: props.imunisasi.id_bayi || '',
    id_imun: props.imunisasi.id_imun || '',
    tanggal_imunisasi: props.imunisasi.tgl_imun || '',
    keterangan: props.imunisasi.ket || ''
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
            <h1>Edit Imunisasi Bayi</h1>
            <hr>
            <h2>Data Bayi</h2>
            <form @submit.prevent="form.put(`/data_bayi/imunisasi/${imunisasi.id_bayi_imun}`)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.id_imun}">
                            <label for="id_imun">Jenis Imunisasi</label>
                            <VueSelect
                                v-model="form.id_imun"
                                :options="daftar_imunisasi.map(imun => ({ label: imun.kd_imun, value: imun.id_imun }))"
                                placeholder="Pilih Jenis Imunisasi"
                            />    
                            <span class="help-block" v-if="form.errors.id_imun">{{ form.errors.id_imun }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.tanggal_imunisasi}">
                            <label for="tanggal_imunisasi">Tanggal Imunisasi</label>
                            <input type="date" v-model="form.tanggal_imunisasi" class="form-control" id="tanggal_imunisasi" />
                            <span class="help-block" v-if="form.errors.tanggal_imunisasi">{{ form.errors.tanggal_imunisasi }}</span>
                        </div>  
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.keterangan}">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" v-model="form.keterangan" class="form-control" id="keterangan" />
                            <span class="help-block" v-if="form.errors.keterangan">{{ form.errors.keterangan }}</span>
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