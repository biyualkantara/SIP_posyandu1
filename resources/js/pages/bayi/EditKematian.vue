<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from 'vue';
import VueSelect from 'vue3-select-component';

const props = defineProps({
    kematian: Object
})

const form = useForm({
    tanggal_kematian: props.kematian.tgl_kematian || '',
    keterangan: props.kematian.ket || ''
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
            <h1>Edit Kematian Bayi</h1>
            <hr>
            <h2>Data Bayi</h2>
            <form @submit.prevent="form.put(`/data_bayi/kematian/${kematian.id_wafat}`)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.tanggal_kematian}">
                            <label for="tanggal_kematian">Tanggal Kematian</label>
                            <input type="date" v-model="form.tanggal_kematian" class="form-control" id="tanggal_kematian" />
                            <span class="help-block" v-if="form.errors.tanggal_kematian">{{ form.errors.tanggal_kematian }}</span>
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