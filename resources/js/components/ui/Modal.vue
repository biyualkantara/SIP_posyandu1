<template>
  <div class="modal fade" :class="{ in: show }" v-show="show">
    <div class="modal-dialog">
      <div class="modal-content">
        <slot name="header"></slot>
        <slot name="body"></slot>
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
});

const emit = defineEmits(["close"]);

function close() {
  emit("close");
}
</script>

<style scoped>
.modal {
  display: block; /* required for Vue control */
}
</style>
