<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  user: Object
})

const form = useForm({
  nama: props.user.nama,
  email: props.user.email,
  password: '',
  password_confirmation: ''
})
</script>

<template>
  <AdminLayout>
    <div class="profile-wrapper">
      <div class="profile-header">
        <div class="header-content">
          <div class="header-title">
            <h1>Edit Profil</h1>
            <p>Perbarui informasi akun Anda</p>
          </div>
          <Link href="/profile" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke Profil
          </Link>
        </div>
      </div>

      <!-- Form Card -->
      <div class="form-card">
        <form @submit.prevent="form.put('/profile')">
          <div class="form-section">
            <h3 class="section-title">Informasi Dasar</h3>
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                  <span>Nama Lengkap</span>
                </label>
                <input 
                  type="text" 
                  class="form-input" 
                  v-model="form.nama" 
                  placeholder="Masukkan nama lengkap"
                />
                <div v-if="form.errors.nama" class="form-error">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {{ form.errors.nama }}
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                  </svg>
                  <span>Email</span>
                </label>
                <input 
                  type="email" 
                  class="form-input" 
                  v-model="form.email" 
                  placeholder="Masukkan email"
                />
                <div v-if="form.errors.email" class="form-error">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {{ form.errors.email }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-divider"></div>

          <!-- Password Section -->
          <div class="form-section">
            <h3 class="section-title">Ubah Password</h3>
            <p class="section-description">Kosongkan jika tidak ingin mengubah password</p>
            
            <div class="form-grid">
              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                  <span>Password Baru</span>
                </label>
                <input 
                  type="password" 
                  class="form-input" 
                  v-model="form.password" 
                  placeholder="Masukkan password baru"
                />
              </div>

              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                  <span>Konfirmasi Password</span>
                </label>
                <input 
                  type="password" 
                  class="form-input" 
                  v-model="form.password_confirmation" 
                  placeholder="Konfirmasi password baru"
                />
                <div v-if="form.errors.password" class="form-error">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {{ form.errors.password }}
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="form-actions">
            <button type="submit" class="btn-submit" :disabled="form.processing">
              <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
              </svg>
              <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
              <div v-if="form.processing" class="spinner"></div>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

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

.btn-back {
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

.btn-back:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
  color: #1e293b;
}

.form-card {
  background: white;
  border-radius: 12px;
  border: 1px solid #e9eef2;
  overflow: hidden;
}

.form-section {
  padding: 1.5rem;
}

.section-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 0.25rem 0;
}

.section-description {
  color: #64748b;
  font-size: 0.9rem;
  margin: 0 0 1.25rem 0;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #475569;
  font-size: 0.9rem;
  font-weight: 500;
}

.form-label svg {
  stroke: #64748b;
}

.form-input {
  width: 100%;
  padding: 0.625rem 0.875rem;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.95rem;
  color: #1e293b;
  transition: all 0.2s ease;
  background: #ffffff;
}

.form-input:hover {
  border-color: #cbd5e1;
}

.form-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
  color: #94a3b8;
  font-size: 0.9rem;
}

.form-error {
  display: flex;
  align-items: center;
  gap: 0.375rem;
  color: #dc2626;
  font-size: 0.85rem;
  margin-top: 0.25rem;
  background: #fef2f2;
  padding: 0.5rem 0.75rem;
  border-radius: 6px;
  border: 1px solid #fee2e2;
}

.form-error svg {
  stroke: #dc2626;
  flex-shrink: 0;
}

.form-divider {
  height: 1px;
  background: #e9eef2;
  margin: 0 1.5rem;
}

.form-actions {
  padding: 1.5rem;
  background: #f8fafc;
  border-top: 1px solid #e9eef2;
  display: flex;
  justify-content: flex-end;
}

.btn-submit {
  display: inline-flex;
  align-items: center;
  gap: 0.625rem;
  padding: 0.75rem 2rem;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  min-width: 180px;
  justify-content: center;
}

.btn-submit:hover:not(:disabled) {
  background: #2563eb;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px -1px rgb(37 99 235 / 0.2);
}

.btn-submit:active:not(:disabled) {
  transform: translateY(0);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-submit svg {
  stroke: currentColor;
}

.spinner {
  width: 20px;
  height: 20px;
  border: 2px solid #ffffff;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
  .profile-wrapper {
    padding: 1rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .form-section {
    padding: 1.25rem;
  }

  .form-divider {
    margin: 0 1.25rem;
  }

  .form-actions {
    padding: 1.25rem;
    justify-content: stretch;
  }

  .btn-submit {
    width: 100%;
  }

  .btn-back {
    width: 100%;
    justify-content: center;
  }
}
</style>