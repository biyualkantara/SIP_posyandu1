<template>
  <div class="custom-card">
    <!-- orange header (no icon inside header) -->
    <div class="card-header"></div>

    <!-- icon slot is placed as an absolutely positioned element inside the card -->
    <slot name="icon"></slot>

    <!-- body -->
    <div class="card-body">
      <h3><slot name="title" /></h3>
      <p><slot name="description" /></p>

    </div>
    <div class="actions">
        <slot name="actions" />
      </div>
  </div>
</template>

<script setup>
// no props — purely slots for flexibility
</script>

<style scoped>
.custom-card {
  width: 100%;
  height: 400px;
  margin: 0 auto;
  border-radius: 2px;
  overflow: visible; /* allow icon overflow */
  background: #fff;
  box-shadow: 0 6px 18px rgba(0,0,0,0.12);
  text-align: center;
  font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  position: relative; /* IMPORTANT: anchors absolute icon inside card */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

/* top colored header */
.card-header {
  background: #ffbb56;
  height: 150px;
  border-top-left-radius: 2px;
  border-top-right-radius: 2px;
}

/* body */
.card-body {
  padding: 48px 18px 22px; /* top padding accounts for overlapping icon */
  /* background-color: red; */
}

.card-body h3 {
  margin: 0 0 8px;
  font-size: clamp(14px, 2.5vw, 18px);
  letter-spacing: 0.6px;
}

.card-body p {
  margin: 0 0 18px;
  font-size: clamp(12px, 2vw, 14px);
  color: #444;
  line-height: 1.3;
}
.actions { margin: 28px; }
</style>
