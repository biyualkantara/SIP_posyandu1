<script setup>
import Table from '@/components/ui/Table.vue';
import TableHead from '@/components/ui/TableHead.vue';
import TableRow from '@/components/ui/TableRow.vue';
import TableCol from '@/components/ui/TableCol.vue';
import TableBody from '@/components/ui/TableBody.vue';
import TableFooter from '@/components/ui/TableFooter.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    columns: Array,
    rows: Array,
    searchable: { type: Boolean, default: true },
    perPage: { type: Number, default: 10 }
});

const search = ref("");
const sortKey = ref("");
const sortDirection = ref("asc");
const currentPage = ref(1);

const filtered = computed(() => {
    if(!props.searchable || !search.value) return props.rows;
    const term = search.value.toLowerCase();

    return props.rows.filter(row => 
        Object.values(row).some(v => 
            String(v).toLowerCase().includes(term)
        )
    );
});

const sorted = computed(() => {
    if(!sortKey.value) return filtered.value;

    return [...filtered.value].sort((a, b) => {
        const A = a[sortKey.value];
        const B = b[sortKey.value];

        if(A < B) return sortDirection.value === "asc" ? -1 : 1;
        if(A > B) return sortDirection.value === "asc" ? 1 : -1;
        return 0;
    });
});

const paginated = computed(() => {
  const start = (currentPage.value - 1) * props.perPage;
  return sorted.value.slice(start, start + props.perPage);
});

const totalPages = computed(() =>
  Math.ceil(sorted.value.length / props.perPage)
);

function changeSort(key) {
    if(sortKey.value === key) {
        sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc"; 
    } else {
        sortKey.value = key;
        sortDirection.value = "asc";
    }
    currentPage.value = 1;
}
</script>

<template>
    <Table class="table-bordered">
        <TableHead>
            <TableRow>
                <div v-if="searchable" class="d-flex align-end mx-3 my-2">
                    <p>Filter: </p>
                    <div class="has-feedback">
                        <div class="ml-3">
                            <input v-model="search" type="text" class="form-control" placeholder="Type to filter...">
                            <div class="form-control-feedback">
                                <i class="icon-search4 text-size-base"></i>
                            </div>
                            <div class="form-control-feedback">
                                <i class="icon-search4 text-size-base"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </TableRow>
            <TableRow>
                <TableCol asHead v-for="col in columns" :key="col.key">
                    {{ col.label }}
                    <i class="icon-sort" v-if="col.sortable" @click="changeSort(col.key)"></i>
                </TableCol>
            </TableRow>
        </TableHead>
        <TableBody>
            <TableRow v-for="row in paginated" :key="row.id">
               <td v-for="col in columns" :key="col.key">
                    <!-- Check if slot exists for this column -->
                    <slot 
                    v-if="$slots[`col-${col.key}`]"
                    :name="`col-${col.key}`"
                    :row="row"
                    />

                    <!-- Default rendering if no slot -->
                    <span v-else>
                    {{ row[col.key] }}
                    </span>
               </td>
            </TableRow>
            
        </TableBody>
        <!-- <TableFooter>
            <TableRow>
                <TableCol class="col-lg-2">
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol>
                    <select name="" class="form-control"  >
                        <option value="">Filter </option>
                    </select>
                </TableCol>
                <TableCol></TableCol>
            </TableRow>
        </TableFooter> -->
    </Table>
    <!-- DATATABLE FOOTER -->
<div class="datatable-footer flex justify-between items-center mt-3">

  <!-- LEFT: Showing X to Y of Z entries -->
  <div class="dataTables_info">
    Showing 
    {{ (currentPage - 1) * perPage + 1 }}
    to
    {{ Math.min(currentPage * perPage, sorted.length) }}
    of
    {{ sorted.length }}
    entries
  </div>

  <!-- RIGHT: Pagination -->
  <div class="dataTables_paginate paging_simple_numbers flex items-center gap-1">

        <!-- PREV BUTTON -->
        <a 
        class="paginate_button previous"
        :class="{ disabled: currentPage === 1 }"
        @click="currentPage > 1 && (currentPage--)"
        >
        ←
        </a>

        <!-- PAGE NUMBERS -->
        <span>
        <a 
            v-for="page in totalPages" 
            :key="page"
            class="paginate_button"
            :class="{ current: page === currentPage }"
            @click="currentPage = page"
        >
            {{ page }}
        </a>
        </span>

        <!-- NEXT BUTTON -->
        <a 
        class="paginate_button next"
        :class="{ disabled: currentPage === totalPages }"
        @click="currentPage < totalPages && (currentPage++)"
        >
        →
        </a>

    </div>

    </div>

</template>