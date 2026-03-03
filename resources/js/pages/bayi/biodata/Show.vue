<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  row: Object
})
</script>

<template>
    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Detail Bayi</h2>
        <Link href="/posyandu/bayi" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="detail-card">

        <!-- Identitas Bayi -->
        <div class="detail-section">
          <h4 class="section-title">Identitas Bayi</h4>
          <div class="detail-grid">

            <div class="detail-item">
              <span class="detail-label">Nama Bayi</span>
              <span class="detail-value">
                {{ row.nama_bayi || '-' }}
              </span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Jenis Kelamin</span>
              <span class="detail-value">
                {{ row.jk === 'L' ? 'Laki-laki' : (row.jk === 'P' ? 'Perempuan' : '-') }}
              </span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Tanggal Lahir</span>
              <span class="detail-value">
                {{ row.tgl_lhr || '-' }}
              </span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Berat Badan Lahir</span>
              <span class="detail-value">
                {{ row.bb ?? '-' }}
              </span>
            </div>

          </div>
        </div>

        <hr class="separator">

        <!-- Data Orang Tua -->
        <div class="detail-section">
          <h4 class="section-title">Data Ibu (WUS / PUS)</h4>
          <div class="detail-grid">

            <div class="detail-item">
              <span class="detail-label">NIK - Nama Ibu</span>
              <span class="detail-value">
                {{ row.nik_wuspus }} - {{ row.nama_wuspus }}
              </span>
            </div>

          </div>
        </div>

        <hr class="separator">

        <!-- Lokasi -->
        <div class="detail-section">
          <h4 class="section-title">Lokasi</h4>
          <div class="detail-grid">

            <div class="detail-item">
              <span class="detail-label">Posyandu</span>
              <span class="detail-value">
                {{ row.nama_posyandu || '-' }}
              </span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Kelurahan</span>
              <span class="detail-value">
                {{ row.nama_kel || '-' }}
              </span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Kecamatan</span>
              <span class="detail-value">
                {{ row.nama_kec || '-' }}
              </span>
            </div>

          </div>
        </div>

        <hr class="separator">

        <!-- Informasi Tambahan -->
        <div class="detail-section">
        <h4 class="section-title">Informasi Tambahan</h4>
        <div class="detail-grid">

          <div class="detail-item">
            <span class="detail-label">Tanggal Daftar</span>
            <span class="detail-value">
              {{ row.tgl_daftar || '-' }}
            </span>
          </div>

          <div class="detail-item">
            <span class="detail-label">Keterangan</span>
            <span class="detail-value">
              {{ row.ket || '-' }}
            </span>
          </div>

        </div>
      </div>
      </div>
    </div>

</template>

<style scoped>
.main-container {
  min-height: 100vh;
}

.header-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.detail-card {
  border: 1px solid #eaeaea;
  border-radius: 12px;
  padding: 24px;
  background: #ffffff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.detail-section {
  margin-bottom: 20px;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 16px;
  padding-bottom: 8px;
  border-bottom: 2px solid #f0f2f5;
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 16px 24px;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.detail-item.full-width {
  grid-column: 1 / -1;
}

.detail-label {
  font-size: 13px;
  font-weight: 500;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.detail-value {
  font-size: 15px;
  font-weight: 500;
  color: #1e293b;
  background: #f8fafc;
  padding: 8px 12px;
  border-radius: 6px;
  border: 1px solid #eef1f4;
}

.separator {
  margin: 20px 0;
  border: 0;
  border-top: 1px solid #eef1f4;
}

@media (max-width: 768px) {
  .detail-card {
    padding: 16px;
  }

  .detail-grid {
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .header-flex {
    flex-direction: column;
    gap: 12px;
    align-items: start;
  }
}

</style>