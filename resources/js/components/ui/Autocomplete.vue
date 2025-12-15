<template>
  <div class="w-full" ref="root" style="position: relative;">

    <!-- INPUT -->
    <input
      type="text"
      class="form-control w-full"
      v-model="search"
      @focus="open = true"
      @input="open = true"
    />

    <!-- DROPDOWN -->
    <div
      v-if="open && filtered.length > 0"
      class="dropdown"
    >
      <div
        v-for="(item, index) in filtered"
        :key="index"
        @click="select(item)"
        class="px-3 py-2 hover:bg-gray-200 cursor-pointer"
      >
        {{ props.label(item) }}
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, onBeforeUnmount } from "vue"

const props = defineProps({
  modelValue: String,
  items: Array,
  label: { type: Function, required: true },     
  searchBy: { type: Function, required: true },  
  valueBy: { type: Function, required: true }
})

const emit = defineEmits(['update:modelValue'])

const open = ref(false)
const search = ref(props.modelValue || "")

watch(() => props.modelValue, (val) => {
  const found = props.items.find(i => props.valueBy(i) === val)
  search.value = found ? props.label(found) : ""
})

// Generic filtering logic
const filtered = computed(() => {
  if (!search.value) return props.items
  const s = search.value.toLowerCase()
  return props.items.filter(i =>
    props.searchBy(i).toLowerCase().includes(s)
  )
})

const select = (item) => {
  const display = props.label(item)
  search.value = display
  emit("update:modelValue", props.valueBy(item))
  open.value = false
}

const root = ref(null)
const onClickOutside = (e) => {
  if (!root.value.contains(e.target)) open.value = false
}

onMounted(() => document.addEventListener("click", onClickOutside))
onBeforeUnmount(() => document.removeEventListener("click", onClickOutside))
</script>

<style scoped>
.dropdown {
  position: absolute;
  width: 100%;          /* This makes it follow input width */
  background: white;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  z-index: 100;
  max-height: 12rem;
  overflow-y: auto;
}

</style>