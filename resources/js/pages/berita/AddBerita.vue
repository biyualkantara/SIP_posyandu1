<script setup>
import { useForm } from '@inertiajs/vue3'
import { onMounted, onBeforeUnmount, nextTick, ref } from 'vue'

const form = useForm({
  judul: '',
  ringkasan: '',
  isi: '',
  penulis: '',
})

const editorInstance = ref(null)

onMounted(async () => {
  await nextTick()

  const CKEDITOR = window.CKEDITOR
  if (!CKEDITOR) {
    console.error('CKEDITOR belum kebaca. Pastikan file ckeditor.js sudah dimuat di app.blade.php')
    return
  }

  const textarea = document.getElementById('editor-full')
  if (!textarea) {
    console.error('Textarea #editor-full tidak ditemukan')
    return
  }

  editorInstance.value = CKEDITOR.replace('editor-full', {
    height: 420,
    allowedContent: true,
    toolbar: [
      { name: 'document', items: ['Source', '-', 'Maximize', 'ShowBlocks'] },
      { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
      { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
      { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
      { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },

      '/',
      { name: 'styles', items: ['Styles', 'Format'] },
      { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
      {
        name: 'paragraph',
        items: [
          'NumberedList',
          'BulletedList',
          '-',
          'Outdent',
          'Indent',
          '-',
          'Blockquote',
          '-',
          'JustifyLeft',
          'JustifyCenter',
          'JustifyRight',
          'JustifyBlock',
        ],
      },
      { name: 'colors', items: ['TextColor', 'BGColor'] },
    ],
  })

  editorInstance.value.on('change', () => {
    form.isi = editorInstance.value.getData()
  })
})

onBeforeUnmount(() => {
  if (editorInstance.value) {
    editorInstance.value.destroy()
    editorInstance.value = null
  }
})

function submit() {
  if (editorInstance.value) form.isi = editorInstance.value.getData()
  form.post('/berita')
}
</script>

<template>
  <AdminLayout>
    <div class="content">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title">Full featured CKEditor</h5>

          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
              <li><a data-action="reload"></a></li>
              <li><a data-action="close"></a></li>
            </ul>
          </div>
        </div>

        <div class="panel-body">
          <p class="content-group">
            CKEditor adalah editor HTML WYSIWYG. Isi berita disimpan sebagai HTML dan bisa ditampilkan kembali menggunakan
            <code>v-html</code>.
          </p>

          <form @submit.prevent="submit">
            <div class="form-group" :class="{ 'has-error': form.errors.judul }">
              <label>Judul</label>
              <input type="text" class="form-control" v-model="form.judul" />
              <span v-if="form.errors.judul" class="help-block text-danger">{{ form.errors.judul }}</span>
            </div>

            <div class="form-group" :class="{ 'has-error': form.errors.ringkasan }">
              <label>Ringkasan</label>
              <textarea class="form-control" rows="3" v-model="form.ringkasan"></textarea>
              <span v-if="form.errors.ringkasan" class="help-block text-danger">{{ form.errors.ringkasan }}</span>
            </div>

            <div class="content-group" :class="{ 'has-error': form.errors.isi }">
              <label>Isi Berita</label>
              <textarea name="editor-full" id="editor-full" rows="4" cols="4"></textarea>
              <span v-if="form.errors.isi" class="help-block text-danger">{{ form.errors.isi }}</span>
            </div>

            <div class="form-group" :class="{ 'has-error': form.errors.penulis }">
              <label>Penulis</label>
              <input type="text" class="form-control" v-model="form.penulis" />
              <span v-if="form.errors.penulis" class="help-block text-danger">{{ form.errors.penulis }}</span>
            </div>

            <div class="text-right">
              <button type="submit" class="btn bg-teal-400" :disabled="form.processing">
                Submit form <i class="icon-arrow-right14 position-right"></i>
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
:global(.cke) {
  width: 100% !important;
}
</style>