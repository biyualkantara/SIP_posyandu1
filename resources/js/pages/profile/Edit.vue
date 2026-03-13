<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  user: Object
})

const form = useForm({
  nama: props.user.nama,
  username: props.user.username,
  email: props.user.email,
  password: '',
  password_confirmation: ''
})

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

const togglePassword = (field) => {
  if (field === 'password') {
    showPassword.value = !showPassword.value
  } else {
    showPasswordConfirmation.value = !showPasswordConfirmation.value
  }
}
</script>

<template>
  <AdminLayout>
    <div class="profile-wrapper">
      <div class="profile-header">
        <div class="header-content">
          <div class="header-left">
            <Link href="/profile" class="btn-back">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
              </svg>
              <span>Kembali</span>
            </Link>
            <div class="header-title">
              <h1>Edit Profil</h1>
              <p>Perbarui informasi akun Anda</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Form Card -->
      <div class="form-card">
        <form @submit.prevent="form.put('/profile')" autocomplete="off">
          <!-- Informasi Dasar -->
          <div class="form-section">
            <h3 class="section-title">Informasi Dasar</h3>
            
            <div class="form-grid">
              <!-- Nama Lengkap -->
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
                  autocomplete="off"
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

              <!-- Username (BARU - untuk login) -->
              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M5.37 20c.92-3 4.29-4 6.63-4s5.71 1 6.63 4"></path>
                  </svg>
                  <span>Username <span class="text-danger">*</span></span>
                </label>
                <input 
                  type="text" 
                  class="form-input" 
                  v-model="form.username" 
                  placeholder="Masukkan username untuk login"
                  autocomplete="off"
                />
                <div v-if="form.errors.username" class="form-error">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                  </svg>
                  {{ form.errors.username }}
                </div>
                <small class="field-note">Username digunakan untuk login</small>
              </div>

              <!-- Email -->
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
                  placeholder="Masukkan email (opsional)"
                  autocomplete="off"
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

          <!-- Ubah Password -->
          <div class="form-section">
            <h3 class="section-title">Ubah Password</h3>
            <p class="section-description">Kosongkan jika tidak ingin mengubah password</p>
            
            <div class="form-grid">
              <!-- Password Baru -->
              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                  <span>Password Baru</span>
                </label>
                <div class="password-input-wrapper">
                  <input 
                    :type="showPassword ? 'text' : 'password'" 
                    class="form-input password-input" 
                    v-model="form.password" 
                    placeholder="Masukkan password baru"
                    autocomplete="new-password"
                  />
                  <button 
                    type="button" 
                    class="password-toggle" 
                    @click="togglePassword('password')"
                  >
                    <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                      <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Konfirmasi Password -->
              <div class="form-group">
                <label class="form-label">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                  </svg>
                  <span>Konfirmasi Password</span>
                </label>
                <div class="password-input-wrapper">
                  <input 
                    :type="showPasswordConfirmation ? 'text' : 'password'" 
                    class="form-input password-input" 
                    v-model="form.password_confirmation" 
                    placeholder="Konfirmasi password baru"
                    autocomplete="new-password"
                  />
                  <button 
                    type="button" 
                    class="password-toggle" 
                    @click="togglePassword('confirmation')"
                  >
                    <svg v-if="showPasswordConfirmation" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                      <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                      <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                  </button>
                </div>
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
            <Link href="/profile" class="btn-cancel">
              Batal
            </Link>
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

/* Button Back - Konsisten */
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
  stroke: currentColor;
}

/* Form Card */
.form-card {
  background: white;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.form-section {
  margin-bottom: 24px;
}

.section-title {
  font-size: 18px;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 8px 0;
}

.section-description {
  color: #64748b;
  font-size: 14px;
  margin: 0 0 20px 0;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #475569;
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.form-label svg {
  stroke: #64748b;
  width: 18px;
  height: 18px;
}

.form-input {
  width: 100%;
  height: 42px;
  padding: 0 16px;
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  font-size: 14px;
  color: #1e293b;
  transition: all 0.2s;
}

.form-input:focus {
  outline: none;
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
}

.form-input.is-invalid {
  border-color: #dc2626;
  background: #fef2f2;
}

/* Password Input Wrapper */
.password-input-wrapper {
  position: relative;
  width: 100%;
}

.password-input {
  padding-right: 48px;
}

.password-toggle {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #64748b;
}

.password-toggle:hover {
  color: #1e293b;
}

.password-toggle svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
}

/* Field Note */
.field-note {
  font-size: 12px;
  color: #64748b;
  margin-top: 4px;
}

.text-danger {
  color: #dc2626;
}

/* Form Error */
.form-error {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #dc2626;
  font-size: 12px;
  margin-top: 4px;
  background: #fef2f2;
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid #fee2e2;
}

.form-error svg {
  stroke: #dc2626;
  flex-shrink: 0;
}

.form-divider {
  height: 2px;
  background: #f1f5f9;
  margin: 24px 0;
}

/* Form Actions */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 16px;
  margin-top: 32px;
  padding-top: 24px;
  border-top: 2px solid #f1f5f9;
}

.btn-cancel {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 12px 28px;
  background: #f1f5f9;
  color: #475569;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.btn-cancel:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
}

.btn-submit {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 12px 32px;
  background: #1e293b;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  min-width: 180px;
  justify-content: center;
}

.btn-submit:hover:not(:disabled) {
  background: #0f172a;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(30, 41, 59, 0.3);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-submit svg {
  stroke: currentColor;
}

.spinner {
  width: 18px;
  height: 18px;
  border: 2px solid #ffffff;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 0.6s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
  .profile-wrapper {
    padding: 16px;
  }

  .header-left {
    flex-direction: column;
    align-items: flex-start;
  }

  .btn-back {
    width: 100%;
    justify-content: center;
  }

  .form-card {
    padding: 20px;
  }

  .form-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .form-actions {
    flex-direction: column-reverse;
  }

  .btn-cancel, .btn-submit {
    width: 100%;
  }
}
</style>