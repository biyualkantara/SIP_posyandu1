<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  posyandu: Array,
  kecamatan: Array,
  kelurahan: Array
})

const form = useForm({
  nama: '',
  username: '',
  password: '',
  role: '',
  id_posyandu: null,
  email: '',
  no_hp: '',
  alamat: '',
  kcmtn: null,
  klrhn: null
})

// State untuk menyimpan posisi scroll
const scrollPosition = ref(0)

// Simpan posisi scroll sebelum submit
const saveScrollPosition = () => {
    scrollPosition.value = window.scrollY
    sessionStorage.setItem('scrollPosition_operator', scrollPosition.value)
}

function submit() {
  saveScrollPosition()
  form.post('/operator', {
    preserveScroll: true
  })
}

// Filter kelurahan berdasarkan kecamatan yang dipilih
const filteredKelurahan = computed(() => {
  if (!form.kcmtn) return []
  return props.kelurahan.filter(x => x.id_kec === form.kcmtn)
})
</script>

<template>
<AdminLayout>
  <div class="form-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="header-left">
        <h1 class="page-title">Tambah Operator</h1>
        <p class="page-subtitle">Tambahkan data operator baru ke dalam sistem</p>
      </div>
      <div class="header-right">
        <Link href="/operator" class="btn-back">
          <span>←</span>
          <span>Kembali</span>
        </Link>
      </div>
    </div>

    <!-- Form Section -->
    <div class="form-section">
      <form @submit.prevent="submit" class="custom-form">
        <div class="form-grid">
          <!-- Kolom Kiri -->
          <div class="form-column">
            <div class="form-group">
              <label class="form-label">Nama Operator <span class="text-danger">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.nama }"
                v-model="form.nama" 
                placeholder="Masukkan nama lengkap operator"
              >
              <div v-if="form.errors.nama" class="invalid-feedback">{{ form.errors.nama }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Email</label>
              <input 
                type="email" 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.email }"
                v-model="form.email" 
                placeholder="contoh@email.com"
              >
              <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input 
                type="text" 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.username }"
                v-model="form.username" 
                placeholder="Masukkan username"
              >
              <div v-if="form.errors.username" class="invalid-feedback">{{ form.errors.username }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Password <span class="text-danger">*</span></label>
              <input 
                type="password" 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.password }"
                v-model="form.password" 
                placeholder="Masukkan password"
              >
              <div v-if="form.errors.password" class="invalid-feedback">{{ form.errors.password }}</div>
              <small class="form-text text-muted">Minimal 6 karakter</small>
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="form-column">
            <div class="form-group">
              <label class="form-label">Role <span class="text-danger">*</span></label>
              <select 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.role }"
                v-model="form.role"
              >
                <option value="">-- Pilih Role --</option>
                <option value="superadmin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="kader">Kader</option>
              </select>
              <div v-if="form.errors.role" class="invalid-feedback">{{ form.errors.role }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Posyandu</label>
              <select 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.id_posyandu }"
                v-model="form.id_posyandu"
              >
                <option :value="null">-- Opsional (Semua Posyandu) --</option>
                <option v-for="p in posyandu" :key="p.id_posyandu" :value="p.id_posyandu">
                  {{ p.nama_posyandu }}
                </option>
              </select>
              <div v-if="form.errors.id_posyandu" class="invalid-feedback">{{ form.errors.id_posyandu }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Kecamatan</label>
              <select 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.kcmtn }"
                v-model="form.kcmtn"
              >
                <option :value="null">-- Pilih Kecamatan --</option>
                <option v-for="k in kecamatan" :key="k.id_kec" :value="k.id_kec">
                  {{ k.nama_kec }}
                </option>
              </select>
              <div v-if="form.errors.kcmtn" class="invalid-feedback">{{ form.errors.kcmtn }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Kelurahan</label>
              <select 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.klrhn }"
                v-model="form.klrhn"
                :disabled="!form.kcmtn"
              >
                <option :value="null">-- Pilih Kelurahan --</option>
                <option v-for="l in filteredKelurahan" :key="l.id_kel" :value="l.id_kel">
                  {{ l.nama_kel }}
                </option>
              </select>
              <div v-if="form.errors.klrhn" class="invalid-feedback">{{ form.errors.klrhn }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">No HP</label>
              <input 
                type="text" 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.no_hp }"
                v-model="form.no_hp" 
                placeholder="Contoh: 081234567890"
              >
              <div v-if="form.errors.no_hp" class="invalid-feedback">{{ form.errors.no_hp }}</div>
            </div>

            <div class="form-group">
              <label class="form-label">Alamat</label>
              <textarea 
                class="form-control" 
                :class="{ 'is-invalid': form.errors.alamat }"
                v-model="form.alamat" 
                rows="3"
                placeholder="Masukkan alamat lengkap"
              ></textarea>
              <div v-if="form.errors.alamat" class="invalid-feedback">{{ form.errors.alamat }}</div>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
          <button type="button" class="btn-cancel" @click="router.visit('/operator')">
            Batal
          </button>
          <button type="submit" class="btn-submit" :disabled="form.processing">
            <span v-if="form.processing">⏳</span>
            <span v-else>✓</span>
            <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Data' }}</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</AdminLayout>
</template>

<style scoped>
.form-container {
  padding: 24px;
  background: #f8fafc;
  min-height: 100vh;
}

/* Header Section */
.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  background: white;
  padding: 20px 24px;
  border-radius: 16px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.header-left {
  flex: 1;
}

.page-title {
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 4px 0;
  line-height: 1.2;
}

.page-subtitle {
  font-size: 14px;
  color: #64748b;
  margin: 0;
}

.header-right {
  display: flex;
  gap: 12px;
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
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Form Section */
.form-section {
  background: white;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.custom-form {
  width: 100%;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 32px;
}

.form-column {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-label {
  font-size: 14px;
  font-weight: 600;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.form-control {
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

.form-control:focus {
  outline: none;
  border-color: #1e293b;
  background: white;
  box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
}

.form-control.is-invalid {
  border-color: #dc2626;
  background: #fef2f2;
}

.form-control.is-invalid:focus {
  box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

textarea.form-control {
  height: auto;
  padding: 12px 16px;
  resize: vertical;
}

select.form-control {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 16px center;
  background-size: 16px;
  padding-right: 48px;
}

select.form-control:disabled {
  background: #f1f5f9;
  border-color: #e2e8f0;
  color: #94a3b8;
  cursor: not-allowed;
}

.invalid-feedback {
  font-size: 12px;
  color: #dc2626;
  margin-top: 4px;
}

.form-text {
  font-size: 12px;
  color: #64748b;
}

.text-danger {
  color: #dc2626;
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
  gap: 8px;
  padding: 12px 24px;
  background: #f1f5f9;
  color: #475569;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-cancel:hover {
  background: #e2e8f0;
  color: #1e293b;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-submit {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 32px;
  background: #1e293b;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s ease;
  min-width: 150px;
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
/* Toast Notification */
.toast-notification {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 10000;
    min-width: 320px;
    max-width: 400px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    overflow: hidden;
    animation: slideInRight 0.3s ease;
    border-left: 4px solid;
}

.toast-notification.success {
    border-left-color: #10b981;
}

.toast-notification.error {
    border-left-color: #ef4444;
}

.toast-notification.info {
    border-left-color: #3b82f6;
}

.toast-notification.warning {
    border-left-color: #f59e0b;
}

.toast-content {
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.toast-icon {
    font-size: 20px;
}

.toast-message {
    flex: 1;
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #94a3b8;
    padding: 0 4px;
    line-height: 1;
}

.toast-close:hover {
    color: #475569;
}

/* Animations */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(30px);
    opacity: 0;
}
/* Responsive */
@media (max-width: 992px) {
  .form-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}

@media (max-width: 768px) {
  .form-container {
    padding: 16px;
  }
  
  .header-section {
    flex-direction: column;
    gap: 16px;
    align-items: start;
    padding: 16px;
  }
  
  .header-right {
    width: 100%;
  }
  
  .btn-back {
    width: 100%;
    justify-content: center;
  }
  
  .form-section {
    padding: 20px;
  }
  
  .form-actions {
    flex-direction: column-reverse;
  }
  
  .btn-cancel, .btn-submit {
    width: 100%;
    justify-content: center;
  }
}
</style>