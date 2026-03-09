<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const namaUser =
  page.props.auth?.user?.nama ||
  page.props.auth?.user?.username ||
  'User'
const mobileMenuOpen = ref(false)
const isDesktop = ref(true)
const dropdownOpen = ref(false)

// Fungsi untuk toggle sidebar (memanggil dari sidebar component)
const toggleSidebar = () => {

  if (window.innerWidth <= 768) {
    document.body.classList.toggle('sidebar-mobile-open')
    return
  }

  document.body.classList.toggle('sidebar-xs')

  const isCollapsed =
    document.body.classList.contains('sidebar-xs')

  localStorage.setItem('sidebarCollapsed', isCollapsed)
}

function updateIsDesktop() {
  isDesktop.value = window.innerWidth >= 768
  if (isDesktop.value) mobileMenuOpen.value = false
}

function toggleMobileMenu() {
  mobileMenuOpen.value = !mobileMenuOpen.value
}

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

function closeDropdown() {
  dropdownOpen.value = false
}

function handleClickOutside(event) {
  const dropdown = document.querySelector('.dropdown-container')
  if (dropdown && !dropdown.contains(event.target)) {
    dropdownOpen.value = false
  }
}

onMounted(() => {
  updateIsDesktop()
  window.addEventListener('resize', updateIsDesktop)
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateIsDesktop)
  document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
  <div class="navbar navbar-default header-highlight">
    <!-- Bagian kiri (logo saja) -->
    <div class="navbar-header">
      <Link href="/dashboard" class="navbar-brand">
        <img
          src="https://drive.cimahikota.go.id/s/7bGKxX4ytTT2Wrq/download"
          alt="Logo"
        />
        <span class="brand-text">eSIP Kota Cimahi</span>
      </Link>

      <!-- Mobile buttons -->
      <div class="mobile-buttons visible-xs-block">
        <button class="mobile-btn" @click="toggleMobileMenu">
          <i class="icon-menu7"></i>
        </button>
        <button class="mobile-btn" @click="toggleSidebar">
          <i class="icon-paragraph-justify3"></i>
        </button>
      </div>
    </div>

    <!-- Bagian kanan navbar -->
    <div 
      class="navbar-right-section"
      :class="{ 'mobile-open': mobileMenuOpen }"
    >
      <!-- Left menu dengan icon toggle -->
      <div class="navbar-left">
        <!-- Tombol toggle untuk desktop (GARIS 3) -->
        <button class="sidebar-toggle-btn hidden-xs" @click="toggleSidebar">
          <i class="icon-menu7"></i>
        </button>
        <span class="status-badge bg-success">Online</span>
      </div>

      <!-- Right menu dengan dropdown -->
      <div class="navbar-right">
        <div class="dropdown-container" :class="{ open: dropdownOpen }">
          <button class="dropdown-toggle" @click="toggleDropdown">
            <span class="user-name">{{ namaUser }}</span>
            <i class="caret" :class="{ rotated: dropdownOpen }"></i>
          </button>

          <transition name="dropdown">
            <ul class="dropdown-menu" v-if="dropdownOpen">
              <li class="dropdown-header">
                <div class="user-info">
                  <div class="user-avatar">
                    <i class="icon-user"></i>
                  </div>
                  <div class="user-details">
                    <span class="user-fullname">{{ namaUser }}</span>
                    <span class="user-email">{{ page.props.auth?.user?.email || 'user@example.com' }}</span>
                  </div>
                </div>
              </li>
              <li class="divider"></li>
              <li>
                <Link 
                  href="/profile" 
                  class="dropdown-item"
                  @click="closeDropdown"
                >
                  <i class="icon-user"></i>
                  <span>Profil Saya</span>
                </Link>
              </li>
              <li class="divider"></li>
              <li>
                <Link 
                  href="/logout" 
                  method="post" 
                  as="button" 
                  class="dropdown-item text-danger"
                  @click="closeDropdown"
                >
                  <i class="icon-switch2"></i>
                  <span>Logout</span>
                </Link>
              </li>
            </ul>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
:root {
  --transition-timing: cubic-bezier(0.4, 0, 0.2, 1);
  --transition-duration: 0.3s;
}

.navbar {
  min-height: 50px;
  background: #fff;
  border-bottom: 1px solid #ddd;
  display: flex;
  align-items: center;
  padding: 0;
  position: relative;
  z-index: 3000;
  box-shadow: 0 1px 3px rgba(0,0,0,.05);
  width: 100%;
  flex-shrink: 0;
}

.navbar-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 280px;
  padding-left: 15px;
  padding-right: 10px;
  transition: all var(--transition-duration) var(--transition-timing);
  background: #fff;
  flex-shrink: 0;
}

.navbar-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  padding: 0;
  height: 50px;
  overflow: hidden;
  transition: opacity .25s ease, transform .25s ease;
}

.navbar-brand img {
  height: 34px;
  width: auto;
}

.brand-text {
  font-size: 18px;
  font-weight: 900;
  color: #17b7c6;
  white-space: nowrap;
}

/* Mobile buttons */
.mobile-buttons {
  display: flex;
  gap: 8px;
  margin-left: auto;
  align-items: center;
}

.mobile-btn {
  background: transparent;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0;
  cursor: pointer;
  color: #333;
  font-size: 18px;
  transition: all 0.2s ease;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mobile-btn i {
  font-size: 18px;
  display: block;
  line-height: 1;
}

.mobile-btn:hover {
  background: #f5f5f5;
}

/* Tombol toggle sidebar (garis 3) */
.sidebar-toggle-btn {
  background: transparent;
  border: none;
  padding: 0 10px;
  height: 50px;
  cursor: pointer;
  color: #333;
  font-size: 20px;
  font-weight: 600;
  transition: all 0.2s ease;
  margin-right: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sidebar-toggle-btn:hover {
  background: #f5f5f5;
}

/* Bagian kanan navbar */
.navbar-right-section {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 15px;
}

/* Navbar left */
.navbar-left {
  display: flex;
  align-items: center;
  gap: 5px;
}

.status-badge {
  display: inline-block;
  padding: 4px 8px;
  font-size: 11px;
  font-weight: 600;
  border-radius: 3px;
  color: #fff;
}

.bg-success {
  background: #4caf50;
}

/* Navbar right */
.navbar-right {
  display: flex;
  align-items: center;
}

/* Dropdown */
.dropdown-container {
  position: relative;
}

.dropdown-toggle {
  display: flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  border: none;
  padding: 0 15px;
  height: 50px;
  cursor: pointer;
  color: #333;
  transition: all 0.2s ease;
}

.dropdown-toggle:hover {
  background: #f5f5f5;
}

.user-name {
  font-weight: 600;
  max-width: 150px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.caret {
  transition: transform 0.3s ease;
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #333;
}

.caret.rotated {
  transform: rotate(180deg);
}

/* Dropdown menu */
.dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  min-width: 260px;
  margin: 5px 0 0;
  padding: 8px 0;
  background: white;
  border: none;
  border-radius: 8px;
  box-shadow: 0 5px 20px rgba(0,0,0,.15);
  z-index: 1000;
  list-style: none;
}

.dropdown-header {
  padding: 15px;
  background: #f8f9fa;
  border-bottom: 1px solid #eee;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  width: 40px;
  height: 40px;
  background: #17b7c6;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 20px;
}

.user-details {
  flex: 1;
  min-width: 0;
}

.user-fullname {
  font-weight: 600;
  color: #333;
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-email {
  font-size: 12px;
  color: #666;
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.divider {
  height: 1px;
  background: #eee;
  margin: 8px 0;
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 20px;
  color: #333;
  text-decoration: none;
  transition: all 0.2s ease;
  width: 100%;
  border: none;
  background: none;
  font-size: 14px;
  cursor: pointer;
}

.dropdown-item:hover {
  background: #f8f9fa;
}

.dropdown-item i {
  font-size: 18px;
  width: 20px;
  color: #666;
}

.dropdown-item.text-danger {
  color: #dc3545;
}

.dropdown-item.text-danger i {
  color: #dc3545;
}

/* Animations */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

/* Sidebar collapsed states */
body.sidebar-xs .navbar-header {
  width: 76px;
  padding-left: 0;
  padding-right: 0;
  justify-content: center;
}

body.sidebar-xs .brand-text {
  display: none;
}

body.sidebar-xs .navbar-brand {
  opacity: 0;
  transform: scale(.9);
}

/* Tombol toggle tidak terpengaruh sidebar collapsed */
.sidebar-toggle-btn {
  /* style sudah di atas */
}

/* Responsive */
@media (max-width: 768px) {
  .navbar {
    flex-direction: column;
    align-items: stretch;
    padding: 0;
  }

  .navbar-header {
    width: 100%;
    padding: 0 12px;
    min-height: 50px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all var(--transition-duration) var(--transition-timing);
  }

  .navbar-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    height: 50px;
  }

  .navbar-brand img {
    height: 30px;
  }

  .brand-text {
    font-size: 16px;
    white-space: nowrap;
  }

  .sidebar-toggle-btn {
    display: none;
  }

  .navbar-right-section {
    display: none;
    flex-direction: column;
    background: #fff;
    border-top: 1px solid #ddd;
    padding: 10px 15px;
    max-height: calc(100vh - 50px);
    overflow-y: auto;
    width: 100%;
  }

  .navbar-right-section.mobile-open {
    display: flex;
  }

  .navbar-left,
  .navbar-right {
    width: 100%;
  }

  .navbar-left {
    margin-bottom: 10px;
    justify-content: flex-start;
  }

  .dropdown-container {
    width: 100%;
  }

  .dropdown-toggle {
    width: 100%;
    justify-content: space-between;
  }

  .dropdown-menu {
    position: static;
    width: 100%;
    box-shadow: none;
    margin-top: 5px;
  }

  body.sidebar-xs .navbar-header {
    width: 100%;
    justify-content: space-between;
  }

  body.sidebar-xs .navbar-brand {
    display: flex;
    opacity: 1;
    transform: none;
  }

  body.sidebar-xs .brand-text {
    display: inline-block;
  }
}
</style>