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
const isAnimating = ref(false)

// Fungsi untuk menutup menu mobile navbar dengan animasi
const closeMobileMenu = () => {
  if (!mobileMenuOpen.value || isAnimating.value) return
  
  isAnimating.value = true
  mobileMenuOpen.value = false
  
  // Hapus status animasi setelah selesai
  setTimeout(() => {
    isAnimating.value = false
  }, 300) // Sesuaikan dengan durasi transisi
}

// Fungsi untuk membuka menu mobile navbar dengan animasi
const openMobileMenu = () => {
  if (mobileMenuOpen.value || isAnimating.value) return
  
  isAnimating.value = true
  mobileMenuOpen.value = true
  // Beri tahu sidebar untuk menutup
  window.dispatchEvent(new CustomEvent('close-mobile-sidebar'))
  
  // Hapus status animasi setelah selesai
  setTimeout(() => {
    isAnimating.value = false
  }, 300) // Sesuaikan dengan durasi transisi
}

// Fungsi untuk toggle menu mobile navbar dengan animasi
const toggleMobileMenu = () => {
  if (isAnimating.value) return
  
  if (mobileMenuOpen.value) {
    closeMobileMenu()
  } else {
    openMobileMenu()
  }
}

// Fungsi untuk toggle sidebar (memanggil dari sidebar component)
const toggleSidebar = () => {
  if (window.innerWidth <= 768) {
    // Tutup menu mobile navbar dulu
    closeMobileMenu()
    
    // Trigger event untuk toggle sidebar mobile
    window.dispatchEvent(new CustomEvent('toggle-mobile-sidebar'))
    
    // Tutup dropdown navbar dengan animasi
    if (dropdownOpen.value) {
      dropdownOpen.value = false
    }
    return
  }

  document.body.classList.toggle('sidebar-xs')

  const isCollapsed =
    document.body.classList.contains('sidebar-xs')

  localStorage.setItem('sidebarCollapsed', isCollapsed)
}

// Fungsi untuk toggle dropdown dengan animasi
function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
  
  // Jika membuka dropdown, tutup sidebar di mobile
  if (dropdownOpen.value && window.innerWidth <= 768) {
    window.dispatchEvent(new CustomEvent('close-mobile-sidebar'))
    closeMobileMenu()
  }
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

function updateIsDesktop() {
  isDesktop.value = window.innerWidth >= 768
  if (isDesktop.value) {
    mobileMenuOpen.value = false
  }
}

// Listen untuk event dari sidebar
onMounted(() => {
  updateIsDesktop()
  window.addEventListener('resize', updateIsDesktop)
  document.addEventListener('click', handleClickOutside)
  
  // Listen untuk event dari sidebar
  window.addEventListener('close-navbar-mobile-menu', closeMobileMenu)
  window.addEventListener('sidebar-opened', closeMobileMenu)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateIsDesktop)
  window.removeEventListener('click', handleClickOutside)
  window.removeEventListener('close-navbar-mobile-menu', closeMobileMenu)
  window.removeEventListener('sidebar-opened', closeMobileMenu)
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
    <transition name="mobile-menu">
      <div 
        v-if="mobileMenuOpen || isDesktop"
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
    </transition>
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
  transition: opacity 0.25s ease, transform 0.25s ease;
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
  transform: scale(1.05);
}

.mobile-btn:active {
  transform: scale(0.95);
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
  transform: scale(1.05);
}

.sidebar-toggle-btn:active {
  transform: scale(0.95);
}

/* Bagian kanan navbar */
.navbar-right-section {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 15px;
  transition: opacity 0.3s ease;
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
  transition: transform 0.2s ease;
}

.status-badge:hover {
  transform: scale(1.05);
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
  transition: transform 0.3s var(--transition-timing);
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 4px solid #333;
}

.caret.rotated {
  transform: rotate(180deg);
}

/* Dropdown menu dengan animasi */
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
  transform-origin: top right;
}

.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s var(--transition-timing);
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(-10px);
}

.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  transform: scale(1) translateY(0);
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
  transition: transform 0.2s ease;
}

.user-avatar:hover {
  transform: scale(1.1);
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
  transform: translateX(5px);
}

.dropdown-item i {
  font-size: 18px;
  width: 20px;
  color: #666;
  transition: transform 0.2s ease;
}

.dropdown-item:hover i {
  transform: scale(1.1);
}

.dropdown-item.text-danger {
  color: #dc3545;
}

.dropdown-item.text-danger i {
  color: #dc3545;
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

/* Animasi untuk mobile menu */
.mobile-menu-enter-active,
.mobile-menu-leave-active {
  transition: all 0.3s var(--transition-timing);
  max-height: 300px;
  overflow: hidden;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
  opacity: 0;
  max-height: 0;
  transform: translateY(-10px);
}

.mobile-menu-enter-to,
.mobile-menu-leave-from {
  opacity: 1;
  max-height: 300px;
  transform: translateY(0);
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
    display: flex;
    flex-direction: column;
    background: #fff;
    border-top: 1px solid #ddd;
    padding: 10px 15px;
    width: 100%;
    transform-origin: top;
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
    animation: slideDown 0.2s ease;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
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

  .mobile-menu-enter-active,
  .mobile-menu-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    max-height: 300px;
    overflow: hidden;
  }

  .mobile-menu-enter-from,
  .mobile-menu-leave-to {
    opacity: 0;
    max-height: 0;
    transform: translateY(-20px);
  }

  .mobile-menu-enter-to,
  .mobile-menu-leave-from {
    opacity: 1;
    max-height: 300px;
    transform: translateY(0);
  }
}
</style>