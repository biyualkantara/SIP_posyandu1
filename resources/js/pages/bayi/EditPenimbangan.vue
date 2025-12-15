<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from 'vue';
import VueSelect from 'vue3-select-component';

const props = defineProps({
    penimbangan: Object,
    bayi: Object,
    orang_tua: Object
})

const form = useForm({
    id_bayi: props.penimbangan.id_bayi || '',
    tanggal_penimbangan: props.penimbangan.tgl_pnb || '',
    berat: props.penimbangan.berat || '',
    hasil: props.penimbangan.hasil || '',
    pmt: props.penimbangan.pmt || '',
    keterangan: props.penimbangan.keterangan || ''
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
            <form @submit.prevent="form.put(`/data_bayi/penimbangan/${penimbangan.id_bayi_pnb}`)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.tanggal_penimbangan}">
                            <label for="tanggal_penimbangan">Tanggal Penimbangan</label>
                            <input type="date" v-model="form.tanggal_penimbangan" class="form-control" id="tanggal_penimbangan" />
                            <span class="help-block" v-if="form.errors.tanggal_penimbangan">{{ form.errors.tanggal_penimbangan }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.berat}">
                            <label for="berat">Berat (Gram)</label>
                            <input type="text" v-model="form.berat" class="form-control" id="berat" />
                            <span class="help-block" v-if="form.errors.berat">{{ form.errors.berat }}</span>
                        </div>  
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.jenis_kelamin}">
                            <label for="hasil">Hasil</label>
                            <VueSelect
                                v-model="form.hasil"
                                :options="[
                                    { label: 'N', value: 'N' },
                                    { label: 'T', value: 'T' },
                                    { label: 'O', value: 'O' },
                                    { label: 'B', value: 'B' }
                                ]"
                                placeholder="Pilih Hasil"
                            />
                            <span class="help-block" v-if="form.errors.hasil">Hasil wajib diisi</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.pmt}">
                            <VueSelect
                                v-model="form.pmt"
                                :options="['Ya', 'Tidak']"
                                placeholder="PMT"
                            />
                            <span class="help-block" v-if="form.errors.pmt">PMT wajib diisi</span>
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