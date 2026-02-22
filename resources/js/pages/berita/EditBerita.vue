<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount } from 'vue';
import TipTapEditor from '@/components/TipTapEditor.vue';

const props = defineProps({
    berita: Object
})

const form = useForm({
    judul: props.berita.judul || '',
    ringkasan: props.berita.ringkasan || '',
    isi: props.berita.isi || '',
    penulis: props.berita.penulis || '',
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
        <div class="mt-3 p-4 bg-white" style="position: relative; min-height: 100vh;">
            <h1>Tambah Berita</h1>
            <hr>
            <form @submit.prevent="form.put(`/berita/${props.berita.id_berita}`)">
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.judul}">
                            <label for="judul">Judul Berita</label>
                            <input type="text" id="judul" v-model="form.judul" class="form-control" />
                            <span v-if="form.errors.judul" class="text-danger">{{ form.errors.judul }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.ringkasan}">
                            <label for="ringkasan">Ringkasan</label>
                            <textarea id="ringkasan" v-model="form.ringkasan" class="form-control" rows="3"></textarea>
                            <span v-if="form.errors.ringkasan" class="text-danger">{{ form.errors.ringkasan }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="form-group" :class="{'has-error': form.errors.isi}">
                            <label for="isi">Isi Berita</label>
                            <!-- <RichTextEditor v-model="form.isi" /> -->
                            <!-- <EditorContent :editor="editor" /> -->
                             <TipTapEditor v-model="form.isi" />
                            <span v-if="form.errors.isi" class="text-danger">{{ form.errors.isi }}</span>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="form-group" :class="{'has-error': form.errors.penulis}">
                            <label for="penulis">Penulis</label>
                            <input type="text" id="penulis" v-model="form.penulis" class="form-control" />
                            <span v-if="form.errors.penulis" class="text-danger">{{ form.errors.penulis }}</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-5">Ubah Data</button>
            </form>
        </div>
    </AdminLayout>
</template>