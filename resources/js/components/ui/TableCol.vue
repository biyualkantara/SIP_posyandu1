<template>
  <component :is="asHead ? 'th' : 'td'" >
    <slot />
  </component>
</template>

<script setup>
defineProps({
  asHead: {
    type: Boolean,
    default: false
  }
})
</script>