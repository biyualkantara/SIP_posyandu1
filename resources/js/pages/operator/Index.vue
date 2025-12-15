<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import Table from '@/components/ui/Table.vue'
import TableHead from '@/components/ui/TableHead.vue'
import TableRow from '@/components/ui/TableRow.vue'
import TableCol from '@/components/ui/TableCol.vue'
import { ref, computed } from 'vue'

const props = defineProps({
  data: Object,
  filter: Object
})

const rows = computed(() => props.data?.data ?? [])
const searchText = ref(props.filter.q)
const status = ref(props.filter.status)

const modalOpen = ref(false)
const selected = ref({})

function applyFilter() {
  router.get('/operator', {
    q: searchText.value || '',
    status: status.value || '',
  }, { preserveState:true, preserveScroll:true })
}

function deleteRow(row) {
  selected.value = row
  modalOpen.value = true
}

function closeModal() {
  modalOpen.value = false
  selected.value = {}
}

function confirmDelete() {
  router.delete(`/operator/${selected.value.id}`, {
    onFinish: () => closeModal()
  })
}
</script>

<template>
  <AdminLayout>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Daftar Operator</h2>
        <Link href="/operator/create" class="btn btn-primary">Tambah Operator</Link>
      </div>

      <hr />

      <div class="row mb-3">
        <div class="col-lg-4 mb-2">
          <input class="form-control" v-model="searchText" placeholder="Cari nama / email"
                 @keyup.enter="applyFilter" />
        </div>

        <div class="col-lg-3 mb-2">
          <select class="form-control" v-model="status" @change="applyFilter">
            <option value="">-- Semua Status --</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>

        <div class="col-lg-2 mb-2">
          <button class="btn btn-secondary w-100" @click="applyFilter">Terapkan</button>
        </div>
      </div>

      <Table>
        <TableHead>
          <TableRow>
            <TableCol>Nama</TableCol>
            <TableCol>Email</TableCol>
            <TableCol>Status</TableCol>
            <TableCol class="text-center">Aksi</TableCol>
          </TableRow>
        </TableHead>

        <tbody>
          <TableRow v-for="r in rows" :key="r.id">
            <TableCol>{{ r.name }}</TableCol>
            <TableCol>{{ r.email }}</TableCol>
            <TableCol>
              <span :class="r.status === 'aktif' ? 'badge bg-success' : 'badge bg-secondary'">
                {{ r.status }}
              </span>
            </TableCol>

            <TableCol class="text-center">
              <Link :href="`/operator/${r.id}`" class="bg-primary p-3 d-inline-flex justify-content-center">
                <i class="icon-eye"></i>
              </Link>

              <Link :href="`/operator/${r.id}/edit`" class="bg-warning p-3 d-inline-flex justify-content-center ms-2">
                <i class="icon-pencil"></i>
              </Link>

              <span class="bg-danger p-3 d-inline-flex justify-content-center ms-2"
                    @click="deleteRow(r)">
                <i class="icon-trash"></i>
              </span>
            </TableCol>
          </TableRow>
        </tbody>
      </Table>
    </div>

    <div v-if="modalOpen" class="overlay-blur" @click.self="closeModal">
      <div class="modal-card border border-danger">
        <h3>Konfirmasi Hapus</h3>
        <p>Hapus operator <b>{{ selected.name }}</b>?</p>
        <div class="d-flex gap-2 mt-3">
          <button class="btn btn-danger w-50" @click="confirmDelete">Hapus</button>
          <button class="btn btn-secondary w-50" @click="closeModal">Batal</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>