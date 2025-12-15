<template>
  <div class="p-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
      <h2 class="text-2xl font-semibold">Data WUSPUS</h2>

      <div class="flex items-center gap-2">
        <input v-model="q" @input="debouncedFetch" placeholder="Type to filter..." class="px-3 py-2 border rounded w-56" />
        <select v-model.number="perPage" @change="fetchList" class="px-2 py-2 border rounded">
          <option v-for="n in [5,10,25,50]" :key="n" :value="n">{{ n }}</option>
        </select>
        <button @click="openCreate" class="px-3 py-2 bg-blue-600 text-white rounded">+ Tambah Data WUSPUS</button>
      </div>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="min-w-full divide-y">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-3 py-2 text-left text-sm font-medium">ID</th>
            <th class="px-3 py-2 text-left text-sm font-medium">Posyandu</th>
            <th class="px-3 py-2 text-left text-sm font-medium">Nama Wuspus</th>
            <th class="px-3 py-2 text-left text-sm font-medium">Nama Suami</th>
            <th class="px-3 py-2 text-left text-sm font-medium">NIK Suami</th>
            <th class="px-3 py-2 text-left text-sm font-medium">Umur</th>
            <th class="px-3 py-2 text-left text-sm font-medium">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr v-for="row in items" :key="row.id" class="hover:bg-gray-50">
            <td class="px-3 py-2 text-sm">{{ row.wuspus_id }}</td>
            <td class="px-3 py-2 text-sm">{{ row.posyandu }}</td>
            <td class="px-3 py-2 text-sm">{{ row.nama_wuspus }}</td>
            <td class="px-3 py-2 text-sm">{{ row.nama_suami }}</td>
            <td class="px-3 py-2 text-sm">{{ row.nik_suami }}</td>
            <td class="px-3 py-2 text-sm">{{ row.umur }}</td>
            <td class="px-3 py-2 text-sm">
              <button @click="edit(row)" class="px-2 py-1 mr-1 border rounded text-sm">Edit</button>
              <button @click="remove(row.id)" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
            </td>
          </tr>
          <tr v-if="items.length === 0">
            <td class="px-3 py-4 text-sm text-center" colspan="7">No data</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex flex-col md:flex-row items-center justify-between gap-3">
      <div class="text-sm text-gray-600">Showing {{ meta.from ?? 0 }} to {{ meta.to ?? 0 }} of {{ meta.total ?? 0 }} entries</div>
      <div class="flex items-center gap-1">
        <button :disabled="!meta.prev_page_url" @click="fetchPage(meta.current_page - 1)" class="px-2 py-1 border rounded">Prev</button>
        <div class="px-3">{{ meta.current_page ?? 1 }}</div>
        <button :disabled="!meta.next_page_url" @click="fetchPage(meta.current_page + 1)" class="px-2 py-1 border rounded">Next</button>
      </div>
    </div>

    <!-- Modal simple create/edit -->
    <div v-if="showModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded shadow max-w-md w-full p-4">
        <h3 class="text-lg font-medium mb-2">{{ editing ? 'Edit' : 'Tambah' }} Data WUSPUS</h3>
        <form @submit.prevent="save">
          <div class="grid grid-cols-1 gap-2">
            <input v-model="form.wuspus_id" placeholder="ID (e.g. 00000001)" class="px-3 py-2 border rounded" />
            <input v-model="form.posyandu" placeholder="Posyandu" class="px-3 py-2 border rounded" />
            <input v-model="form.nama_wuspus" placeholder="Nama WUSPUS" class="px-3 py-2 border rounded" />
            <input v-model="form.nama_suami" placeholder="Nama Suami" class="px-3 py-2 border rounded" />
            <input v-model="form.nik_suami" placeholder="NIK Suami" class="px-3 py-2 border rounded" />
            <input v-model.number="form.umur" type="number" placeholder="Umur" class="px-3 py-2 border rounded" />
          </div>

          <div class="mt-3 flex justify-end gap-2">
            <button type="button" @click="closeModal" class="px-3 py-2 border rounded">Cancel</button>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">{{ editing ? 'Update' : 'Save' }}</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import debounce from 'lodash/debounce';

export default {
  name: 'WuspusTable',
  data() {
    return {
      items: [],
      meta: {},
      q: '',
      perPage: 10,
      page: 1,
      showModal: false,
      editing: false,
      form: {
        id: null,
        wuspus_id: '',
        posyandu: '',
        nama_wuspus: '',
        nama_suami: '',
        nik_suami: '',
        umur: null
      }
    }
  },
  created() {
    this.debouncedFetch = debounce(this.fetchList, 350);
    this.fetchList();
  },
  methods: {
    apiUrl(params = {}) {
      const qs = new URLSearchParams(params).toString();
      return `/api/wuspus${qs ? '?' + qs : ''}`;
    },
    fetchList() {
      const params = { q: this.q, per_page: this.perPage, page: this.page };
      axios.get(this.apiUrl(params)).then(res => {
        this.items = res.data.data;
        this.meta = {
          total: res.data.total,
          per_page: res.data.per_page,
          current_page: res.data.current_page,
          last_page: res.data.last_page,
          from: res.data.from,
          to: res.data.to,
          next_page_url: res.data.next_page_url,
          prev_page_url: res.data.prev_page_url
        };
      }).catch(e => {
        console.error(e);
      });
    },
    fetchPage(n) {
      if (n < 1) return;
      this.page = n;
      this.fetchList();
    },
    openCreate() {
      this.editing = false;
      this.form = { id: null, wuspus_id: '', posyandu: '', nama_wuspus: '', nama_suami: '', nik_suami: '', umur: null };
      this.showModal = true;
    },
    edit(row) {
      this.editing = true;
      this.form = Object.assign({}, row);
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    save() {
      if (this.editing && this.form.id) {
        axios.put(`/api/wuspus/${this.form.id}`, this.form).then(() => {
          this.closeModal();
          this.fetchList();
        });
      } else {
        axios.post('/api/wuspus', this.form).then(() => {
          this.closeModal();
          this.fetchList();
        });
      }
    },
    remove(id) {
      if (!confirm('Delete this record?')) return;
      axios.delete(`/api/wuspus/${id}`).then(() => {
        this.fetchList();
      }).catch(e => console.error(e));
    }
  }
}
</script>

<style scoped>
/* Small local tweaks if needed */
</style>
