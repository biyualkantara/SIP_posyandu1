<template>
  <AdminLayout>
    <div class="esip-posyandu-page">
      <div class="posyandu-inner">
        <!-- KIRI: CARD UTAMA -->
        <div class="panel-main">
          <h3 class="panel-title">Daftar Posyandu</h3>

          <!-- FILTER -->
          <div class="filter-box">
            <div class="filter-grid">
              <div class="fi">
                <label>Nama Posyandu</label>
                <input v-model="filters.nama" type="text" placeholder="Filter nama..." />
              </div>

              <div class="fi">
                <label>Status</label>
                <input v-model="filters.status" type="text" placeholder="Filter status..." />
              </div>

              <div class="fi">
                <label>Alamat</label>
                <input v-model="filters.alamat" type="text" placeholder="Filter alamat..." />
              </div>

              <div class="fi">
                <label>Kecamatan</label>
                <select v-model="filters.kecamatan">
                  <option value="">Semua Kecamatan</option>
                  <option value="Cimahi Tengah">Cimahi Tengah</option>
                  <option value="Cimahi Utara">Cimahi Utara</option>
                  <option value="Cimahi Selatan">Cimahi Selatan</option>
                </select>
              </div>

              <div class="fi fi-actions">
                <label>&nbsp;</label>
                <button class="btn-pill btn-primary" type="button" @click="applyFilter">
                  Filter
                </button>
                <button class="btn-pill btn-ghost" type="button" @click="resetFilter">
                  Reset
                </button>
              </div>
            </div>
          </div>

          <!-- TABLE (SCROLL) -->
          <div class="table-wrap">
            <table class="tbl">
              <thead>
                <tr>
                  <th>Nama Posyandu</th>
                  <th>Status</th>
                  <th>Alamat</th>
                  <th>Kecamatan</th>
                  <th class="col-aksi">Aksi</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="row in pagedRows" :key="row.id">
                  <td>{{ row.nama }}</td>
                  <td>{{ row.status }}</td>
                  <td>{{ row.alamat }}</td>
                  <td>{{ row.kecamatan }}</td>
                  <td class="col-aksi">
                    <button class="btn-pill btn-soft" type="button" @click="openModal(row)">
                      Lihat
                    </button>
                  </td>
                </tr>

                <tr v-if="pagedRows.length === 0">
                  <td colspan="5" class="empty">Tidak ada data.</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          <div class="pager">
            <button class="btn-mini" type="button" :disabled="page === 1" @click="prevPage">
              Previous
            </button>
            <div class="page-info">Page {{ page }} of {{ totalPages }}</div>
            <button
              class="btn-mini"
              type="button"
              :disabled="page === totalPages"
              @click="nextPage"
            >
              Next
            </button>
          </div>
        </div>

        <!-- KANAN: INFO CARDS -->
        <div class="panel-side">
          <div class="stat-card">
            <div class="stat-title">Total Posyandu</div>
            <div class="stat-number">{{ totalPosyandu }}</div>
          </div>

          <div class="stat-card">
            <div class="stat-title">Total Kecamatan</div>
            <div class="stat-number">{{ totalKecamatan }}</div>
          </div>
        </div>
      </div>

      <!-- MODAL -->
      <div v-if="modal.open" class="modal-overlay" @click.self="closeModal">
        <div class="modal-card" role="dialog" aria-modal="true">
          <div class="modal-head">
            <div class="modal-title">Detail Posyandu</div>
            <button class="modal-x" type="button" @click="closeModal" aria-label="Close">
              ×
            </button>
          </div>

          <div class="modal-body">
            <div class="rowx">
              <div class="lbl">Nama Posyandu:</div>
              <div class="val">{{ modal.data?.nama }}</div>
            </div>
            <div class="rowx">
              <div class="lbl">Status:</div>
              <div class="val">{{ modal.data?.status }}</div>
            </div>
            <div class="rowx">
              <div class="lbl">Alamat:</div>
              <div class="val">{{ modal.data?.alamat }}</div>
            </div>
            <div class="rowx">
              <div class="lbl">Kecamatan:</div>
              <div class="val">{{ modal.data?.kecamatan }}</div>
            </div>
          </div>
        </div>
      </div>
      <!-- /MODAL -->
    </div>
  </AdminLayout>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, reactive, ref } from "vue";

onMounted(() => document.body.classList.add("esip-posyandu-body"));
onBeforeUnmount(() => document.body.classList.remove("esip-posyandu-body"));

/* contoh data (ganti dari API nanti) */
const rows = ref([
  { id: 1, nama: "Aulea H", status: "Aktif", alamat: "RT 01", kecamatan: "Cimahi Tengah" },
  { id: 2, nama: "Sakura C 01", status: "Aktif", alamat: "RT 01", kecamatan: "Cimahi Tengah" },
  { id: 3, nama: "Andrey A", status: "Pasif", alamat: "RT 02", kecamatan: "Cimahi Utara" },
  { id: 4, nama: "Cindai Tengah", status: "Aktif", alamat: "RT 01", kecamatan: "Cimahi Selatan" },
  { id: 5, nama: "Melati 02", status: "Aktif", alamat: "RT 03", kecamatan: "Cimahi Utara" },
  { id: 6, nama: "Anggrek 01", status: "Pasif", alamat: "RT 05", kecamatan: "Cimahi Tengah" },
  { id: 7, nama: "Flamboyan 03", status: "Aktif", alamat: "RT 07", kecamatan: "Cimahi Selatan" },
  { id: 8, nama: "Kenanga 01", status: "Aktif", alamat: "RT 02", kecamatan: "Cimahi Tengah" },
  { id: 9, nama: "Cempaka 04", status: "Aktif", alamat: "RT 01", kecamatan: "Cimahi Utara" },
]);

const filters = reactive({
  nama: "",
  status: "",
  alamat: "",
  kecamatan: "",
});

const page = ref(1);
const perPage = 4;

const filteredRows = ref([...rows.value]);

function applyFilter() {
  const nama = filters.nama.trim().toLowerCase();
  const status = filters.status.trim().toLowerCase();
  const alamat = filters.alamat.trim().toLowerCase();
  const kec = filters.kecamatan.trim().toLowerCase();

  filteredRows.value = rows.value.filter((r) => {
    const okNama = !nama || r.nama.toLowerCase().includes(nama);
    const okStatus = !status || r.status.toLowerCase().includes(status);
    const okAlamat = !alamat || r.alamat.toLowerCase().includes(alamat);
    const okKec = !kec || r.kecamatan.toLowerCase() === kec;
    return okNama && okStatus && okAlamat && okKec;
  });

  page.value = 1;
}

function resetFilter() {
  filters.nama = "";
  filters.status = "";
  filters.alamat = "";
  filters.kecamatan = "";
  filteredRows.value = [...rows.value];
  page.value = 1;
}

const totalPages = computed(() => Math.max(1, Math.ceil(filteredRows.value.length / perPage)));

const pagedRows = computed(() => {
  const start = (page.value - 1) * perPage;
  return filteredRows.value.slice(start, start + perPage);
});

function prevPage() {
  page.value = Math.max(1, page.value - 1);
}
function nextPage() {
  page.value = Math.min(totalPages.value, page.value + 1);
}

/* side stats */
const totalPosyandu = computed(() => rows.value.length);
const totalKecamatan = computed(() => new Set(rows.value.map((r) => r.kecamatan)).size);

/* modal */
const modal = reactive({
  open: false,
  data: null,
});

function openModal(row) {
  modal.data = row;
  modal.open = true;
  document.body.style.overflow = "hidden";
}

function closeModal() {
  modal.open = false;
  modal.data = null;
  document.body.style.overflow = "";
}
</script>

<style scoped>
/* =========================
   LIMITLESS OVERRIDE (khusus page ini)
   ========================= */
:global(body.esip-posyandu-body .content) {
  padding: 0 !important;
}
:global(body.esip-posyandu-body .page-container),
:global(body.esip-posyandu-body .page-content),
:global(body.esip-posyandu-body .content-wrapper),
:global(body.esip-posyandu-body .content) {
  background: transparent !important;
  background-image: none !important;
}

/* =========================
   PAGE + BACKGROUND (ikut scroll, bukan fixed)
   ========================= */
.esip-posyandu-page {
  position: relative;
  min-height: 100vh;
  padding: 36px 0 70px;
  isolation: isolate;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

.esip-posyandu-page::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;

  background-image: url("/storage/tentangesip_page/bg-kotak-kotak.png");
  background-repeat: repeat;
  background-size: auto;
  background-position: center -12px;
}

/* =========================
   LAYOUT tengah
   ========================= */
.posyandu-inner {
  width: min(1120px, 100%);
  margin: 0 auto;
  padding: 0 22px;

  display: grid;
  grid-template-columns: 1fr 230px;
  gap: 22px;
  align-items: start;
}

/* =========================
   PANEL UTAMA
   ========================= */
.panel-main {
  background: #fff;
  border-radius: 10px;
  padding: 18px 18px 14px;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

.panel-title {
  margin: 2px 0 12px;
  font-size: 16px;
  font-weight: 800;
  color: #2d2d2d;
}

/* =========================
   FILTER BOX
   ========================= */
.filter-box {
  background: #f5f6f8;
  border-radius: 10px;
  padding: 12px;
  margin-bottom: 12px;
}

.filter-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr)) 110px;
  gap: 10px;
  align-items: end;
}

.fi label {
  display: block;
  font-size: 11px;
  font-weight: 700;
  color: #666;
  margin-bottom: 6px;
}

.fi input,
.fi select {
  width: 100%;
  height: 34px;
  border: 1px solid #e2e5ea;
  border-radius: 8px;
  padding: 0 10px;
  font-size: 12px;
  outline: none;
  background: #fff;
}

.fi input:focus,
.fi select:focus {
  border-color: #bfc7d8;
  box-shadow: 0 0 0 3px rgba(140, 154, 210, 0.18);
}

.fi-actions {
  display: grid;
  gap: 8px;
  align-self: end;          /* nempel bawah */
  justify-items: stretch;
}

.fi-actions label {
  display: block;
  height: 17px;             /* samain tinggi label input lain */
  margin-bottom: 6px;       /* samain jarak label -> input */
  visibility: hidden;       /* tetap makan tempat, tapi ga kelihatan */
}

.btn-pill {
  height: 32px;
  border-radius: 999px;
  border: 0;
  cursor: pointer;
  font-weight: 800;
  font-size: 12px;
}


.btn-primary {
  background: #e9eaf5;
  color: #3a3d66;
}

.btn-ghost {
  background: #f1f2f6;
  color: #666;
}

.btn-soft {
  background: #ececf6;
  color: #3a3d66;
  padding: 0 14px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

/* =========================
   TABLE SCROLL
   ========================= */
.table-wrap {
  border: 1px solid #ececec;
  border-radius: 10px;
  overflow: hidden;
  background: #fff;

  max-height: 290px;
  overflow-y: auto;
}

.tbl {
  width: 100%;
  border-collapse: collapse;
  font-size: 12px;
}

.tbl thead th {
  position: sticky;
  top: 0;
  background: #f7f7f7;
  z-index: 1;
  text-align: left;
  padding: 10px 12px;
  color: #555;
  border-bottom: 1px solid #e9e9e9;
  font-weight: 800;
}

.tbl tbody td {
  padding: 12px;
  border-bottom: 1px solid #f1f1f1;
  color: #4c4c4c;
}

.tbl tbody tr:hover {
  background: #fafafa;
}

/* ✅ AKSI & BUTTON CENTER */
.col-aksi {
  width: 120px;
}
.tbl thead th.col-aksi,
.tbl tbody td.col-aksi {
  text-align: center !important;
  vertical-align: middle;
}

.empty {
  text-align: center;
  padding: 18px !important;
  color: #777;
}

/* =========================
   PAGER
   ========================= */
.pager {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 12px;
  padding-top: 12px;
}

.btn-mini {
  height: 30px;
  padding: 0 14px;
  border-radius: 6px;
  border: 1px solid #e6e6e6;
  background: #fff;
  cursor: pointer;
  font-size: 12px;
}

.btn-mini:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.page-info {
  font-size: 12px;
  color: #555;
}

/* =========================
   SIDE STATS
   ========================= */
.panel-side {
  display: grid;
  gap: 14px;
}

.stat-card {
  background: #fff;
  border-radius: 12px;
  padding: 18px 16px;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
  min-height: 120px;
  display: grid;
  align-content: center;
  text-align: center;
}

.stat-title {
  font-size: 12px;
  font-weight: 800;
  color: #4a69a8;
  margin-bottom: 8px;
}

.stat-number {
  font-size: 42px;
  font-weight: 900;
  color: #2a2a2a;
  line-height: 1;
}

/* =========================
   MODAL
   ========================= */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  z-index: 9999;

  display: grid;
  place-items: center;
  padding: 22px;
}

.modal-card {
  width: min(520px, 100%);
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
  overflow: hidden;
}

.modal-head {
  padding: 18px 18px 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modal-title {
  font-size: 18px;
  font-weight: 800;
  color: #4a78c2;
}

.modal-x {
  width: 34px;
  height: 34px;
  border: 0;
  border-radius: 8px;
  background: transparent;
  font-size: 24px;
  line-height: 1;
  cursor: pointer;
  color: #888;
}

.modal-body {
  padding: 8px 18px 18px;
}

.rowx {
  display: grid;
  grid-template-columns: 170px 1fr;
  gap: 10px;
  padding: 12px 0;
  border-top: 1px solid #f0f0f0;
}

.lbl {
  font-weight: 800;
  color: #444;
}

.val {
  color: #555;
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 992px) {
  .posyandu-inner {
    grid-template-columns: 1fr;
  }

  .filter-grid {
    grid-template-columns: 1fr 1fr;
  }

  .fi-actions {
    grid-column: 1 / -1;
    grid-template-columns: 1fr 1fr;
  }

  .panel-side {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 576px) {
  .panel-side {
    grid-template-columns: 1fr;
  }

  .rowx {
    grid-template-columns: 1fr;
  }
}
</style>