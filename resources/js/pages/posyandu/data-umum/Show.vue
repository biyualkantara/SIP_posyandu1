<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  duspy: Object
})
</script>

<template>

    <div class="bg-white p-4 main-container">
      <div class="header-flex mb-3">
        <h2>Detail Data Posyandu</h2>
        <Link href="/posyandu/data-umum" class="btn btn-secondary">← Kembali</Link>
      </div>

      <hr>

      <div class="detail-card">

        <!-- Informasi Posyandu -->
        <div class="detail-section">
          <h4 class="section-title">Informasi Posyandu</h4>
          <div class="detail-grid">
            <div class="detail-item">
              <span class="detail-label">Nama Posyandu</span>
              <span class="detail-value">{{ duspy.nama_posyandu || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Strata</span>
              <span class="detail-value">{{ duspy.strata_psy || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Alamat</span>
              <span class="detail-value">{{ duspy.alamat_posyandu || '-' }}</span>
            </div>
          </div>
        </div>

        <hr class="separator">

        <!-- Lokasi -->
        <div class="detail-section">
          <h4 class="section-title">Lokasi</h4>
          <div class="detail-grid">
            <div class="detail-item">
              <span class="detail-label">Kecamatan</span>
              <span class="detail-value">
                {{ duspy?.kelurahan?.kecamatan?.nama_kec || '-' }}
              </span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Kelurahan</span>
              <span class="detail-value">
                {{ duspy?.kelurahan?.nama_kel || '-' }}
              </span>
            </div>
          </div>
        </div>

        <hr class="separator">

        <!-- Struktur Pengurus -->
        <div class="detail-section">
          <h4 class="section-title">Struktur Pengurus</h4>
          <div class="detail-grid">
            <div class="detail-item">
              <span class="detail-label">PJ Umum</span>
              <span class="detail-value">{{ duspy.pj_umum || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">PJ Operasional</span>
              <span class="detail-value">{{ duspy.pj_operasional || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Ketua Pelaksana</span>
              <span class="detail-value">{{ duspy.ketuplak || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Sekretaris</span>
              <span class="detail-value">{{ duspy.sekretaris || '-' }}</span>
            </div>
          </div>
        </div>

        <hr class="separator">

        <!-- Data Kader -->
        <div class="detail-section">
          <h4 class="section-title">Data Kader</h4>
          <div class="detail-grid">
            <div class="detail-item">
              <span class="detail-label">Kader Aktif</span>
              <span class="detail-value">{{ duspy.kader_aktif || '0' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Kader Tidak Aktif</span>
              <span class="detail-value">{{ duspy.kader_taktif || '0' }}</span>
            </div>
          </div>
        </div>

        <hr class="separator">

        <!-- Petugas -->
        <div class="detail-section">
          <h4 class="section-title">Petugas</h4>
          <div class="detail-grid">
            <div class="detail-item">
              <span class="detail-label">Petugas KB</span>
              <span class="detail-value">{{ duspy.ptgs_kb || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Petugas Medis</span>
              <span class="detail-value">{{ duspy.ptgs_medis || '-' }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Petugas Bidan</span>
              <span class="detail-value">{{ duspy.ptgs_bidan || '-' }}</span>
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
}
</style>