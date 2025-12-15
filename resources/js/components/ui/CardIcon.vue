<template>
  <div class="icon-wrapper">
    <img :src="src" :alt="alt" />
  </div>
</template>

<script setup>
const props = defineProps({
  src: { type: String, required: true },
  alt: { type: String, default: "icon" },
  size: { type: Number, default: 64 } // optional size prop
});
</script>

<style scoped>
.icon-wrapper {
  width: 64px;
  height: 64px;
  background: #fff;
  border-radius: 999px;
  box-shadow: 0 6px 12px rgba(0,0,0,0.12);
  position: absolute;
  left: 50%;
  /* place icon centered horizontally and overlapping the seam */
  top: 108px;         /* tweak this value to move icon up/down */
  transform: translateX(-50%);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 5;
  overflow: hidden;
}

/* responsive tweak: if card smaller, reduce top */
@media (max-width: 360px) {
  .icon-wrapper { top: clamp(40px, 12vw, 54px); }
}

.icon-wrapper img {
  width: 34px;
  height: 34px;
  object-fit: contain;
}
</style>
