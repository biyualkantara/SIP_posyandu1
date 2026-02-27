<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})
</script>

<template>
  <AdminLayout>
    <div class="profile-wrapper">
      <!-- Header Section -->
      <div class="profile-header">
        <div class="header-content">
          <div class="header-title">
            <h1>Profil Saya</h1>
            <p>Informasi detail akun Anda</p>
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
              {{ user.email }}
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
                {{ user.role }}
              </span>
            </div>
          </div>

          <!-- Dibuat Pada -->
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

<script>
export default {
  methods: {
    formatDate(date) {
      if (!date) return '-'
      // Format: 2025-11-22 07:08:09 → 22 Nov 2025 - 07:08:09
      const d = new Date(date)
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
      const year = d.getFullYear()
      const month = months[d.getMonth()]
      const day = d.getDate().toString().padStart(2, '0')
      const time = date.split(' ')[1] || ''
      return `${day} ${month} ${year} - ${time}`
    },
    getRoleClass(role) {
      const roleStr = String(role || '').toLowerCase()
      if (roleStr.includes('super')) return 'role-superadmin'
      if (roleStr === 'admin') return 'role-admin'
      if (roleStr === 'user') return 'role-user'
      return 'role-default'
    }
  }
}
</script>

<style scoped>
.profile-wrapper {
  width: 100%;
  padding: 1.5rem;
}

.profile-header {
  margin-bottom: 1.5rem;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.header-title h1 {
  font-size: 1.875rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 0.25rem 0;
}

.header-title p {
  color: #64748b;
  font-size: 0.95rem;
  margin: 0;
}

.btn-edit {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.625rem 1.25rem;
  background: white;
  color: #475569;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.95rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-edit:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
  color: #1e293b;
}

.profile-card {
  background: white;
  border-radius: 12px;
  border: 1px solid #e9eef2;
  overflow: hidden;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
}

.info-item {
  padding: 1.25rem 1.5rem;
  border-bottom: 1px solid #e9eef2;
  border-right: 1px solid #e9eef2;
}

.info-item:nth-child(even) {
  border-right: none;
}

.info-item:nth-last-child(-n+2) {
  border-bottom: none;
}

.info-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #64748b;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  margin-bottom: 0.75rem;
}

.info-label svg {
  width: 18px;
  height: 18px;
  stroke: #94a3b8;
}

.info-value {
  color: #0f172a;
  font-size: 1.1rem;
  font-weight: 500;
  padding-left: 1.625rem;
}

/* Role Badge */
.role-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 4px;
  font-size: 0.85rem;
  font-weight: 500;
  text-transform: capitalize;
}

.role-superadmin {
  background: #f1f5f9;
  color: #334155;
  border: 1px solid #cbd5e1;
}

.role-admin {
  background: #dbeafe;
  color: #1e3a8a;
}

.role-user {
  background: #dcfce7;
  color: #166534;
}

.role-default {
  background: #f1f5f9;
  color: #475569;
}

@media (max-width: 768px) {
  .profile-wrapper {
    padding: 1rem;
  }

  .info-grid {
    grid-template-columns: 1fr;
  }

  .info-item {
    border-right: none;
    padding: 1rem 1.25rem;
  }

  .info-item:nth-last-child(-n+2) {
    border-bottom: 1px solid #e9eef2;
  }

  .info-item:last-child {
    border-bottom: none;
  }

  .btn-edit {
    width: 100%;
    justify-content: center;
  }
}
</style>