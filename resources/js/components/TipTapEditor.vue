<template>
  <div class="border rounded p-2">
    <div class="mb-2 d-flex gap-2 flex-wrap">
      <button type="button" class="btn btn-sm btn-outline-secondary" @click="cmd('toggleBold')" :disabled="!editor">
        Bold
      </button>
      <button type="button" class="btn btn-sm btn-outline-secondary" @click="cmd('toggleItalic')" :disabled="!editor">
        Italic
      </button>
      <button type="button" class="btn btn-sm btn-outline-secondary" @click="cmd('toggleBulletList')" :disabled="!editor">
        • List
      </button>
      <button type="button" class="btn btn-sm btn-outline-secondary" @click="cmd('toggleOrderedList')" :disabled="!editor">
        1. List
      </button>
    </div>

    <EditorContent :editor="editor" />
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, watch } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const props = defineProps({
  modelValue: { type: String, default: '' },
})
const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  extensions: [StarterKit],
  content: props.modelValue || '',
  onUpdate({ editor }) {
    emit('update:modelValue', editor.getHTML())
  },
})

watch(
  () => props.modelValue,
  (val) => {
    if (!editor.value) return
    const current = editor.value.getHTML()
    if (val !== current) editor.value.commands.setContent(val || '', false)
  }
)

function cmd(method) {
  if (!editor.value) return
  editor.value.chain().focus()[method]().run()
}

onBeforeUnmount(() => {
  editor.value?.destroy()
})
</script>

<style scoped>
/* TipTap editor area */
:deep(.ProseMirror) {
  min-height: 220px;
  outline: none;
}
</style>