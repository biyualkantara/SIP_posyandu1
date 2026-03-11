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
        <h2>Detail WUS / PUS</h2>
        <Link href="/posyandu/wuspus" class="btn-back">
          <span>←</span>
          <span>Kembali</span>
        </Link>
      </div>

      <hr>

      <div class="detail-card">

        <!-- Identitas -->
        <div class="detail-section">
          <h4 class="section-title">Identitas WUS / PUS</h4>
          <div class="detail-grid">

            <div class="detail-item">
              <span class="detail-label">NIK - Nama</span>
              <span class="detail-value">
                {{ row.nik_wuspus }} - {{ row.nama_wuspus }}
              </span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Umur</span>
              <span class="detail-value">{{ row.umur || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Tinggi Ibu</span>
              <span class="detail-value">{{ row.tinggi_ibu || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Status</span>
              <span class="detail-value">{{ row.status || '-' }}</span>
            </div>

            <div class="detail-item full-width">
              <span class="detail-label">Tanggal Daftar</span>
              <span class="detail-value">{{ row.tgl_daftar || '-' }}</span>
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
              <span class="detail-value">{{ row.nama_posyandu || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Kecamatan</span>
              <span class="detail-value">{{ row.nama_kec || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Kelurahan</span>
              <span class="detail-value">{{ row.nama_kel || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Kelompok Dasawisma</span>
              <span class="detail-value">{{ row.klmpk_dasawisma || '-' }}</span>
            </div>

          </div>
        </div>

        <hr class="separator">

        <!-- Data Keluarga -->
        <div class="detail-section">
          <h4 class="section-title">Data Keluarga</h4>
          <div class="detail-grid">

            <div class="detail-item">
              <span class="detail-label">Nama Suami</span>
              <span class="detail-value">{{ row.nama_suami || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Tinggi Ayah</span>
              <span class="detail-value">{{ row.tinggi_ayah || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Anak Hidup</span>
              <span class="detail-value">{{ row.jml_anak_hdp || '0' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Anak Meninggal</span>
              <span class="detail-value">{{ row.jml_anak_meninggal || '0' }}</span>
            </div>

            <div class="detail-item full-width">
              <span class="detail-label">Tahapan KS</span>
              <span class="detail-value ">{{ row.thpn_ks || '-' }}</span>
            </div>

          </div>
        </div>

        <hr class="separator">

        <!-- Keterangan -->
        <div class="detail-section">
          <h4 class="section-title">Keterangan</h4>
          <div class="detail-grid">
            <span class="detail-label">Keterangan</span>
            <div class="detail-item full-width">
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

/* Button Back */
.btn-back {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background: #f1f5f9;
  color: #475569;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}

.btn-back:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
}

.btn-back:active {
  background: #cbd5e1;
  transform: translateY(0);
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
    grid-template-columns: 1fr;
    gap: 12px;
  }

  .header-flex {
    flex-direction: column;
    gap: 12px;
    align-items: start;
  }
  
  .btn-back {
    width: 100%;
    justify-content: center;
  }
}
</style>