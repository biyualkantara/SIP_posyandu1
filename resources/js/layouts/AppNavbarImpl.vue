<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const namaUser =
  page.props.auth?.user?.nama ||
  page.props.auth?.user?.username ||
  'User'
const navbarOpen = ref(false)
const isDesktop = ref(true)
const dropdownOpen = ref(false)

function toggleSidebar() {
  document.body.classList.toggle('sidebar-xs')
}

function updateIsDesktop() {
  isDesktop.value = window.innerWidth >= 768
  if (isDesktop.value) navbarOpen.value = false
}

function closeMobileIfClickLink(e) {
  if (!isDesktop.value) {
    const el = e.target.closest('a,button')
    if (el) navbarOpen.value = false
  }
}

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

// Fungsi untuk menutup dropdown
function closeDropdown() {
  dropdownOpen.value = false
}

// Click outside untuk close dropdown
function handleClickOutside(event) {
  const dropdown = document.querySelector('.dropdown-container')
  if (dropdown && !dropdown.contains(event.target)) {
    dropdownOpen.value = false
  }
}

// Tutup dropdown saat navigasi
function handleNavigation() {
  closeDropdown()
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
  <div class="navbar navbar-default header-highlight esip-navbar">
    <div class="navbar-header">
      <a class="navbar-brand esip-navbar-brand" href="#">
        <img
          src="https://drive.cimahikota.go.id/s/7bGKxX4ytTT2Wrq/download"
          alt="Logo"
        />
        <span class="esip-brand-text">eSIP Kota Cimahi</span>
      </a>

      <ul class="nav navbar-nav visible-xs-block">
        <li>
          <a href="#" @click.prevent="navbarOpen = !navbarOpen">
            <i class="icon-tree5"></i>
          </a>
        </li>
        <li>
          <a href="#" class="esip-sidebar-toggle" @click.prevent="toggleSidebar">
            <i class="icon-paragraph-justify3"></i>
          </a>
        </li>
      </ul>
    </div>

    <div
      id="navbar-mobile"
      class="navbar-collapse"
      :class="{
        collapse: !isDesktop && !navbarOpen,
        in: !isDesktop && navbarOpen
      }"
      @click="closeMobileIfClickLink"
    >
      <!-- LEFT -->
      <ul class="nav navbar-nav">
        <li class="hidden-xs">
          <a href="#" class="esip-sidebar-toggle" @click.prevent="toggleSidebar">
            <i class="icon-paragraph-justify3"></i>
          </a>
        </li>
      </ul>
      <span class="label bg-success" style="margin-top: 17px; margin-left: 10px;">Online</span>
      
      <!-- RIGHT - DROPDOWN YANG DIPERBAIKI -->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown-container" :class="{ open: dropdownOpen }">
          <a class="dropdown-toggle" @click.prevent="toggleDropdown">
            <span class="user-name">{{ namaUser }}</span>
            <i class="caret" :class="{ rotated: dropdownOpen }"></i>
          </a>

          <transition name="dropdown">
            <ul class="dropdown-menu dropdown-menu-right" v-if="dropdownOpen">
              <li class="dropdown-header">
                <div class="user-info">
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
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.esip-navbar-brand{
  display:flex !important;
  align-items:center !important;
  gap:10px !important;
  padding: 0 14.6px !important;
  height: 50px !important;
}
.esip-navbar-brand img{
  height:34px !important;
}
.esip-brand-text{
  font-size:18px !important;
  font-weight:900 !important;
  color:#17b7c6 !important;
  white-space:nowrap !important;
}

:global(body.sidebar-main-resized) .esip-navbar-brand .esip-brand-text{
  display:none !important;
}

/* rapih navbar */
:global(.esip-navbar){
  min-height:50px;
}
:global(.esip-navbar .navbar-nav > li > a){
  height:50px;
  line-height:50px;
  padding-top:0 !important;
  padding-bottom:0 !important;
}
:global(.esip-navbar .navbar-text){
  height:50px;
  line-height:50px;
  margin:0 10px;
}

:global(.esip-navbar .esip-sidebar-toggle i){
  display:inline-block !important;
  visibility:visible !important;
}
.esip-navbar-brand {
  display: flex;
  align-items: center;
  gap: 10px;
}

body.sidebar-xs .esip-brand-text {
  display: none !important;
}

body.sidebar-xs .esip-navbar-brand img {
  display: block !important;
}

body.sidebar-xs .sidebar-main .sidebar-header,
body.sidebar-xs .sidebar-main .sidebar-logo,
body.sidebar-xs .sidebar-main .sidebar-brand {
  display: none !important;
}

.esip-navbar-brand img {
  height: 30px !important;
  width: auto !important;
  max-width: none !important;
  object-fit: contain !important;
}

/* ===== DROPDOWN STYLES YANG DIPERBAIKI ===== */

/* Dropdown Container */
.dropdown-container {
  position: relative;
}

.dropdown-container.open .dropdown-toggle {
  background-color: #f5f5f5;
}

/* Dropdown Toggle */
.dropdown-toggle {
  display: flex !important;
  align-items: center !important;
  gap: 6px !important;
  cursor: pointer !important;
  padding: 0 15px !important;
  transition: all 0.2s ease;
}

.dropdown-toggle:hover {
  background-color: #f8f8f8 !important;
}

.user-name {
  font-weight: 600;
  color: #333;
  max-width: 150px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Caret Animation */
.caret {
  transition: transform 0.3s ease;
  border-top-color: #777;
}

.caret.rotated {
  transform: rotate(180deg);
}

/* Dropdown Menu */
.dropdown-menu {
  position: absolute !important;
  top: 100% !important;
  right: 0 !important;
  left: auto !important;
  min-width: 260px !important;
  margin-top: 5px !important;
  padding: 8px 0 !important;
  background: white !important;
  border: none !important;
  border-radius: 12px !important;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
  z-index: 1000 !important;
  list-style: none !important;
}

/* Dropdown Header */
.dropdown-header {
  padding: 16px !important;
  background: linear-gradient(135deg, #f9f9f9 0%, #f5f5f5 100%) !important;
  border-bottom: 1px solid #eee !important;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 24px;
}

.user-details {
  display: flex;
  flex-direction: column;
}

.user-fullname {
  font-size: 15px;
  font-weight: 700;
  color: #333;
  line-height: 1.4;
}

.user-email {
  font-size: 12px;
  color: #888;
  margin-top: 2px;
}

/* Divider */
.divider {
  height: 1px !important;
  background: #eee !important;
  margin: 8px 0 !important;
  padding: 0 !important;
}

/* Dropdown Items */
.dropdown-item {
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  padding: 10px 20px !important;
  color: #333 !important;
  text-decoration: none !important;
  transition: all 0.2s ease !important;
  width: 100% !important;
  border: none !important;
  background: none !important;
  text-align: left !important;
  font-size: 14px !important;
  cursor: pointer !important;
  line-height: normal !important;
}

.dropdown-item i {
  font-size: 18px !important;
  color: #666 !important;
  transition: color 0.2s ease;
}

.dropdown-item:hover {
  background-color: #f8f8f8 !important;
}

.dropdown-item:hover i {
  color: #333 !important;
}

.dropdown-item.text-danger {
  color: #dc3545 !important;
}

.dropdown-item.text-danger i {
  color: #dc3545 !important;
}

.dropdown-item.text-danger:hover {
  background-color: #fff5f5 !important;
}

/* Dropdown Animation */
.dropdown-enter-active {
  animation: dropdownFade 0.2s ease;
}

.dropdown-leave-active {
  animation: dropdownFade 0.2s ease reverse;
}

@keyframes dropdownFade {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .dropdown-menu {
    position: fixed !important;
    top: auto !important;
    right: 10px !important;
    left: 10px !important;
    width: auto !important;
    max-width: none !important;
  }
  
  .user-name {
    max-width: 100px;
  }
}
</style>