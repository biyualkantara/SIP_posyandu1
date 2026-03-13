<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})

const formatDate = (date) => {
  if (!date) return '-'
  const d = new Date(date)
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
  const year = d.getFullYear()
  const month = months[d.getMonth()]
  const day = d.getDate().toString().padStart(2, '0')
  const hours = d.getHours().toString().padStart(2, '0')
  const minutes = d.getMinutes().toString().padStart(2, '0')
  const seconds = d.getSeconds().toString().padStart(2, '0')
  return `${day} ${month} ${year} - ${hours}:${minutes}:${seconds}`
}

const getRoleClass = (role) => {
  const roleStr = String(role || '').toLowerCase()
  if (roleStr.includes('super') || roleStr === 'superadmin') return 'role-superadmin'
  if (roleStr === 'admin') return 'role-admin'
  if (roleStr === 'kader') return 'role-kader'
  return 'role-default'
}

const formatRole = (role) => {
  if (!role) return '-'
  if (role === 'superadmin') return 'Super Admin'
  if (role === 'admin') return 'Admin'
  if (role === 'kader') return 'Kader'
  return role
}
</script>

<template>
  <AdminLayout>
    <div class="profile-wrapper">
      <div class="profile-header">
        <div class="header-content">
          <div class="header-left">
            <Link href="/posyandu/data-umum" class="btn-back">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
              </svg>
              <span>Kembali</span>
            </Link>
            <div class="header-title">
              <h1>Profil Saya</h1>
              <p>Informasi detail akun Anda</p>
            </div>
          </div>
          <Link href="/profile/edit" class="btn-edit">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
              <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
            </svg>
            Edit Profil
          </Link>
        </div>
      </div>

      <!-- Profile Content -->
      <div class="profile-card">
        <div class="info-grid">
          <!-- Nama Lengkap -->
          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              <span>Nama Lengkap</span>
            </div>
            <div class="info-value">
              {{ user.nama }}
            </div>
          </div>

          <!-- Username -->
          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"></circle>
                <path d="M5.37 20c.92-3 4.29-4 6.63-4s5.71 1 6.63 4"></path>
              </svg>
              <span>Username</span>
            </div>
            <div class="info-value">
              {{ user.username || '-' }}
            </div>
          </div>

          <!-- Email -->
          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
              </svg>
              <span>Email</span>
            </div>
            <div class="info-value">
              {{ user.email || '-' }}
            </div>
          </div>

          <!-- No HP (BARU - dari tabel operator) -->
          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                <line x1="12" y1="18" x2="12.01" y2="18"></line>
              </svg>
              <span>No. HP</span>
            </div>
            <div class="info-value">
              {{ user.no_hp || '-' }}
            </div>
          </div>

          <!-- Role -->
          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="5"></circle>
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              </svg>
              <span>Role</span>
            </div>
            <div class="info-value">
              <span class="role-badge" :class="getRoleClass(user.role)">
                {{ formatRole(user.role) }}
              </span>
            </div>
          </div>

          <!-- Alamat (BARU - dari tabel operator) -->
          <div class="info-item full-width">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
              </svg>
              <span>Alamat</span>
            </div>
            <div class="info-value">
              {{ user.alamat || '-' }}
            </div>
          </div>

          <!-- Dibuat Pada (menggunakan reg_times) -->
          <div class="info-item">
            <div class="info-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
              </svg>
              <span>Dibuat Pada</span>
            </div>
            <div class="info-value">
              {{ formatDate(user.reg_times) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<style scoped>
.profile-wrapper {
  width: 100%;
  padding: 24px;
  background: #f8fafc;
  min-height: 100vh;
}

.profile-header {
  margin-bottom: 24px;
  background: white;
  padding: 20px 24px;
  border-radius: 16px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 16px;
  flex: 1;
}

.header-title h1 {
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 4px 0;
  line-height: 1.2;
}

.header-title p {
  color: #64748b;
  font-size: 14px;
  margin: 0;
}

/* Button Back - Konsisten dengan halaman lain */
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
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-back svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
}

/* Button Edit */
.btn-edit {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 24px;
  background: #1e293b;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  text-decoration: none;
  transition: all 0.2s ease;
  box-shadow: 0 2px 4px rgba(30, 41, 59, 0.1);
}

.btn-edit:hover {
  background: #0f172a;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
}

.btn-edit svg {
  stroke: white;
}

/* Profile Card */
.profile-card {
  background: white;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.info-item.full-width {
  grid-column: 1 / -1;
}

.info-label {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #64748b;
  font-size: 13px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.info-label svg {
  width: 18px;
  height: 18px;
  stroke: #94a3b8;
}

.info-value {
  color: #1e293b;
  font-size: 16px;
  font-weight: 500;
  background: #f8fafc;
  padding: 10px 14px;
  border-radius: 8px;
  border: 1px solid #eef1f4;
  word-break: break-word;
}

/* Role Badge */
.role-badge {
  display: inline-block;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
  text-transform: capitalize;
}

.role-superadmin {
  background: #fef3c7;
  color: #92400e;
}

.role-admin {
  background: #dbeafe;
  color: #1e40af;
}

.role-kader {
  background: #d1fae5;
  color: #065f46;
}

.role-default {
  background: #f1f5f9;
  color: #475569;
}

/* Responsive */
@media (max-width: 768px) {
  .profile-wrapper {
    padding: 16px;
  }

  .header-content {
    flex-direction: column;
    align-items: stretch;
  }

  .header-left {
    flex-direction: column;
    align-items: flex-start;
  }

  .btn-back {
    width: 100%;
    justify-content: center;
  }

  .btn-edit {
    width: 100%;
    justify-content: center;
  }

  .info-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .profile-card {
    padding: 20px;
  }
}
</style>