<template>
  <div class="modal-header">
    <button type="button" class="close" @click="$emit('close')">×</button>
    <h5 class="modal-title"><slot /></h5>
  </div>
</template>

<script setup>
defineEmits(["close"]);
</script>
