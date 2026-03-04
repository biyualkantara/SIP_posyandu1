<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({ 
  row: Object 
})
</script>

<template>
<AdminLayout>
  <div class="bg-white p-4 main-container">
    <div class="header-flex mb-3">
      <h2>Detail Operator</h2>
      <Link href="/operator" class="btn btn-secondary">← Kembali</Link>
    </div>

    <hr>

    <div class="detail-card">
      <!-- Identitas Dasar -->
      <div class="detail-section">
        <h4 class="section-title">Identitas Operator</h4>
        <div class="detail-grid">
          <div class="detail-item">
            <span class="detail-label">Nama Lengkap</span>
            <span class="detail-value">{{ row.nama || '-' }}</span>
          </div>

          <div class="detail-item">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ row.email || '-' }}</span>
          </div>

          <div class="detail-item">
            <span class="detail-label">Username</span>
            <span class="detail-value">{{ row.username || '-' }}</span>
          </div>

          <div class="detail-item">
            <span class="detail-label">No HP</span>
            <span class="detail-value">{{ row.no_hp || '-' }}</span>
          </div>
        </div>
      </div>

      <hr class="separator">

      <!-- Role & Akses -->
      <div class="detail-section">
        <h4 class="section-title">Role & Akses</h4>
        <div class="detail-grid">
          <div class="detail-item">
            <span class="detail-label">Role</span>
            <span class="detail-value">
              <span class="role-badge" :class="{
                'role-admin': row.role === 'admin',
                'role-superadmin': row.role === 'superadmin',
                'role-kader': row.role === 'kader'
              }">
                {{ row.role || '-' }}
              </span>
            </span>
          </div>

          <div class="detail-item full-width">
            <span class="detail-label">Posyandu</span>
            <span class="detail-value">{{ row.nama_posyandu || 'Semua Posyandu' }}</span>
          </div>
        </div>
      </div>

      <hr class="separator">

      <!-- Wilayah -->
      <div class="detail-section">
        <h4 class="section-title">Wilayah</h4>
        <div class="detail-grid">
          <div class="detail-item">
            <span class="detail-label">Kecamatan</span>
            <span class="detail-value">{{ row.nama_kec || '-' }}</span>
          </div>

          <div class="detail-item">
            <span class="detail-label">Kelurahan</span>
            <span class="detail-value">{{ row.nama_kel || '-' }}</span>
          </div>
        </div>
      </div>

      <hr class="separator">

      <!-- Alamat -->
      <div class="detail-section">
        <h4 class="section-title">Alamat</h4>
        <div class="detail-grid">
          <div class="detail-item full-width">
            <span class="detail-label">Alamat Lengkap</span>
            <span class="detail-value">{{ row.alamat || '-' }}</span>
          </div>
        </div>
      </div>

      <!-- Info Tambahan jika diperlukan -->
      <div v-if="row.created_at || row.updated_at" class="mt-4">
        <hr class="separator">
        <div class="detail-section">
          <h4 class="section-title">Informasi Sistem</h4>
          <div class="detail-grid">
            <div class="detail-item">
              <span class="detail-label">Dibuat Pada</span>
              <span class="detail-value">{{ row.created_at || '-' }}</span>
            </div>

            <div class="detail-item">
              <span class="detail-label">Diupdate Pada</span>
              <span class="detail-value">{{ row.updated_at || '-' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</AdminLayout>
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

/* Style untuk button secondary (Kembali) */
.btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  background: #f1f5f9;
  color: #475569;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}

.btn-secondary:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-1px);
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Detail Card */
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

/* Role Badge */
.role-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
}

.role-admin {
  background: #fee2e2;
  color: #991b1b;
}

.role-superadmin {
  background: #fef3c7;
  color: #92400e;
}

.role-kader {
  background: #dbeafe;
  color: #1e40af;
}

/* Separator */
.separator {
  margin: 20px 0;
  border: 0;
  border-top: 1px solid #eef1f4;
}

/* Margin */
.mt-4 {
  margin-top: 16px;
}

/* Responsive */
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

  .btn-secondary {
    width: 100%;
    justify-content: center;
  }
}
</style>