<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed, onMounted, watch, onBeforeUnmount } from 'vue'

const page = usePage()
const user = page.props.auth?.user

const openIndex = ref(null)
const isCollapsed = ref(false)
const mobileMenuOpen = ref(false)
const isAnimating = ref(false)

// Fungsi untuk menutup sidebar di mobile dengan animasi
const closeMobileSidebar = () => {
  if (!mobileMenuOpen.value || isAnimating.value) return
  
  isAnimating.value = true
  mobileMenuOpen.value = false
  document.body.classList.remove('sidebar-mobile-open')
  
  // Beri tahu navbar bahwa sidebar ditutup
  window.dispatchEvent(new CustomEvent('sidebar-closed'))
  
  // Hapus status animasi setelah selesai
  setTimeout(() => {
    isAnimating.value = false
  }, 300) // Sesuaikan dengan durasi transisi
}

// Fungsi untuk membuka sidebar mobile dengan animasi
const openMobileSidebar = () => {
  if (mobileMenuOpen.value || isAnimating.value) return
  
  isAnimating.value = true
  mobileMenuOpen.value = true
  document.body.classList.add('sidebar-mobile-open')
  
  // Beri tahu navbar untuk menutup menu mobile-nya
  window.dispatchEvent(new CustomEvent('close-navbar-mobile-menu'))
  
  // Hapus status animasi setelah selesai
  setTimeout(() => {
    isAnimating.value = false
  }, 300) // Sesuaikan dengan durasi transisi
}

// Fungsi untuk toggle sidebar mobile dengan animasi
const toggleMobileSidebar = () => {
  if (isAnimating.value) return
  
  if (mobileMenuOpen.value) {
    closeMobileSidebar()
  } else {
    openMobileSidebar()
  }
}

// Cek state sidebar dari localStorage
onMounted(() => {
  const saved = localStorage.getItem('sidebarCollapsed') === 'true'
  isCollapsed.value = saved

  if (saved) {
    document.body.classList.add('sidebar-xs')
  } else {
    document.body.classList.remove('sidebar-xs')
  }

  // Sinkron jika navbar toggle dipencet
  const observer = new MutationObserver(() => {
    const collapsed = document.body.classList.contains('sidebar-xs')
    isCollapsed.value = collapsed
  })

  observer.observe(document.body, {
    attributes: true,
    attributeFilter: ['class']
  })

  // Listen untuk event dari navbar
  window.addEventListener('toggle-mobile-sidebar', toggleMobileSidebar)
  window.addEventListener('close-mobile-sidebar', closeMobileSidebar)
  window.addEventListener('navbar-mobile-opened', closeMobileSidebar)
})

onBeforeUnmount(() => {
  window.removeEventListener('toggle-mobile-sidebar', toggleMobileSidebar)
  window.removeEventListener('close-mobile-sidebar', closeMobileSidebar)
  window.removeEventListener('navbar-mobile-opened', closeMobileSidebar)
})

const toggleSidebar = () => {
  if (window.innerWidth <= 768) {
    toggleMobileSidebar()
    return
  }

  isCollapsed.value = !isCollapsed.value

  if (isCollapsed.value) {
    document.body.classList.add('sidebar-xs')
    openIndex.value = null
  } else {
    document.body.classList.remove('sidebar-xs')
  }

  localStorage.setItem('sidebarCollapsed', isCollapsed.value)
}

const toggleSubmenu = (index) => {
  if (window.innerWidth <= 768) {
    // Di mobile, toggle submenu dengan animasi
    openIndex.value = openIndex.value === index ? null : index
    return
  }

  if (isCollapsed.value) {
    isCollapsed.value = false
    document.body.classList.remove('sidebar-xs')
    localStorage.setItem('sidebarCollapsed', false)

    openIndex.value = index
    return
  }

  openIndex.value = openIndex.value === index ? null : index
}

// Watch untuk collapse state
watch(isCollapsed, (newVal) => {
  if (newVal) {
    openIndex.value = null
  }
})

// LABEL ROLE
const roleLabel = computed(() => {
  if (user?.role === 'superadmin') return 'Super Admin'
  if (user?.role === 'admin') return 'Admin'
  return 'Kader'
})

// MENU SIDEBAR
const sidebarItems = computed(() => {
  const items = [
    { icon: 'icon-home', label: 'Dashboard', path: '/dashboard' },

    {
      icon: 'icon-office',
      label: 'Data Umum Posyandu',
      children: [
        { label: 'Data Posyandu', path: '/posyandu/data-umum' },
        { label: 'Data Kehadiran Kader', path: '/posyandu/kehadiran-kader' }
      ]
    },

    {
      icon: 'icon-users',
      label: 'Registrasi WUS PUS',
      children: [
        { label: 'Biodata', path: '/posyandu/wuspus' },
        { label: 'Imunisasi', path: '/posyandu/wuspus-imun' },
        { label: 'Kontrasepsi', path: '/posyandu/wuspus-kontrasepsi' },
        { label: 'Kematian', path: '/posyandu/wuspus-kematian' }
      ]
    },

    {
      icon: 'icon-user-check',
      label: 'Registrasi Ibu Hamil',
      children: [
        { label: 'Biodata', path: '/posyandu/bumil' },
        { label: 'Penimbangan', path: '/posyandu/bumil-pnb' },
        { label: 'Imunisasi', path: '/posyandu/bumil-imun' }
      ]
    },

    {
      icon: 'icon-users4',
      label: 'Registrasi Bayi',
      children: [
        { label: 'Biodata', path: '/posyandu/bayi' },
        { label: 'Penimbangan', path: '/posyandu/bayi-pnb' },
        { label: 'Imunisasi', path: '/posyandu/bayi-imun' },
        { label: 'Kematian', path: '/posyandu/bayi-wafat' }
      ]
    },
    {
      icon: 'icon-newspaper2',
      label: 'Berita',
      children: [
        { label: 'Berita', path: '/berita' }
      ]
    },
    { icon: 'icon-stats-bars', label: 'Rekapitulasi SIP', path: '/rekapitulasi' },
    {
      icon: 'icon-brain',
      label: 'SiPintar',
      children: [
        { label: 'Chat Bot SiPintar', path: '/sipintar/chatbot' },
        { label: 'Daftar Potensi Stunting', path: '/sipintar/stunting' }
      ]
    }
  ]

  if (user?.role === 'superadmin') {
    items.push({
      icon: 'icon-user-plus',
      label: 'Operator',
      children: [{ label: 'Daftar Operator', path: '/operator' }]
    })
  }

  return items
})

// Ekspose fungsi ke komponen lain
defineExpose({
  toggleSidebar,
  closeMobileSidebar
})
</script>

<template>
  <div class="sidebar sidebar-dark sidebar-main">
    <div class="sidebar-content">
      <!-- USER BOX -->
      <div class="sidebar-user">
        <div class="media">
          <div class="media-left">
            <span class="btn bg-teal-400 btn-rounded btn-icon btn-lg">
              <i class="icon-lock"></i>
            </span>
          </div>
          <div class="media-body">
            <span class="media-heading text-semibold">
              {{ user?.nama || user?.nama_operator || user?.username || 'User' }}
            </span>
            <div class="text-size-mini text-muted">
              {{ roleLabel }}
            </div>
          </div>
        </div>
      </div>

      <p class="sidebar-menu-label" v-if="!isCollapsed">MENU</p>

      <ul class="navigation">
        <li v-for="(item, i) in sidebarItems" :key="i">
          <!-- Link tanpa children -->
          <Link 
            v-if="!item.children" 
            :href="item.path" 
            class="nav-link"
            :class="{ 'justify-center': isCollapsed }"
            @click="closeMobileSidebar"
          >
            <i :class="item.icon"></i>
            <span class="nav-text" v-if="!isCollapsed">{{ item.label }}</span>
          </Link>

          <!-- Link dengan children -->
          <div v-else class="nav-item has-submenu">
            <a 
              href="#" 
              @click.prevent="toggleSubmenu(i)" 
              class="nav-link"
              :class="{ 
                'justify-center': isCollapsed,
                'active': openIndex === i 
              }"
            >
              <i :class="item.icon"></i>
              <span class="nav-text" v-if="!isCollapsed">{{ item.label }}</span>
              <span class="arrow" v-if="!isCollapsed" :class="{ 'arrow-down': openIndex === i }"></span>
            </a>

            <!-- Submenu dengan transisi yang lebih smooth -->
            <transition name="slide-submenu">
              <ul v-if="openIndex === i" class="nav-submenu">
                <li v-for="c in item.children" :key="c.path">
                  <Link :href="c.path" class="nav-link-sub" @click="closeMobileSidebar">
                    {{ c.label }}
                  </Link>
                </li>
              </ul>
            </transition>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
:root {
  --transition-timing: cubic-bezier(0.4, 0, 0.2, 1);
  --transition-duration: 0.3s;
}

.sidebar {
  width: 260px;
  height: 100%;
  background: #1e2b37;
  color: #fff;
  transition: width var(--transition-duration) var(--transition-timing),
              transform var(--transition-duration) var(--transition-timing);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  box-shadow: 2px 0 5px rgba(0,0,0,.1);
}

.nav-text,
.sidebar-user .media-body,
.sidebar-menu-label {
  transition: opacity var(--transition-duration) var(--transition-timing),
              transform var(--transition-duration) var(--transition-timing);
}

.sidebar-header {
  padding: 10px 15px;
  border-bottom: 1px solid rgba(255,255,255,.1);
  display: flex;
  justify-content: flex-end;
}

.sidebar-toggle-btn:hover {
  background: rgba(255,255,255,.1);
  color: #fff;
}

.sidebar-content {
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  padding-bottom: 20px;
}

/* Scrollbar styling */
.sidebar-content::-webkit-scrollbar {
  width: 5px;
}

.sidebar-content::-webkit-scrollbar-track {
  background: rgba(255,255,255,.05);
}

.sidebar-content::-webkit-scrollbar-thumb {
  background: rgba(255,255,255,.2);
  border-radius: 3px;
}

.sidebar-content::-webkit-scrollbar-thumb:hover {
  background: rgba(255,255,255,.3);
}

.sidebar-user {
  padding: 20px 15px;
  border-bottom: 1px solid rgba(255,255,255,.1);
  margin-bottom: 10px;
}

.sidebar-user .media {
  display: flex;
  align-items: center;
  gap: 12px;
}

.sidebar-user .media-left {
  flex-shrink: 0;
}

.sidebar-user .media-body {
  flex: 1;
  min-width: 0;
  transition: opacity var(--transition-duration) var(--transition-timing);
}

.sidebar-user .media-heading {
  color: #fff;
  font-weight: 600;
  font-size: 14px;
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.sidebar-user .text-muted {
  color: #9ca3af;
  font-size: 12px;
}

.sidebar-menu-label {
  color: #9ca3af;
  margin: 10px 15px;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 500;
  opacity: 1;
  transform: translateX(0);
  transition: opacity var(--transition-duration) var(--transition-timing),
              transform var(--transition-duration) var(--transition-timing);
}

.navigation {
  list-style: none;
  padding: 0;
  margin: 0;
}

.nav-item {
  position: relative;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: rgba(255,255,255,.8);
  text-decoration: none;
  transition: all var(--transition-duration) var(--transition-timing);
  gap: 12px;
  cursor: pointer;
  border-left: 3px solid transparent;
}

.nav-link:hover {
  background: rgba(255,255,255,.1);
  color: #fff;
  border-left-color: #17b7c6;
}

.nav-link.active {
  background: rgba(255,255,255,.15);
  color: #fff;
  border-left-color: #17b7c6;
}

.nav-link.justify-center {
  justify-content: center;
  padding: 15px 0;
}

.nav-link i {
  font-size: 16px;
  width: 20px;
  text-align: center;
  transition: font-size var(--transition-duration) var(--transition-timing);
}

.nav-text {
  flex: 1;
  font-size: 13px;
  font-weight: 500;
  white-space: nowrap;
  opacity: 1;
  transform: translateX(0);
  transition: opacity var(--transition-duration) var(--transition-timing),
              transform var(--transition-duration) var(--transition-timing);
}

.arrow {
  font-size: 12px;
  transition: transform var(--transition-duration) var(--transition-timing);
}

.arrow::before {
  content: '▶';
  font-family: 'icomoon';
  display: inline-block;
  transition: transform var(--transition-duration) var(--transition-timing);
}

.arrow-down::before {
  transform: rotate(90deg);
}

/* Submenu styling dengan animasi yang lebih smooth */
.nav-submenu {
  list-style: none;
  padding: 8px 0;
  margin: 0;
  background: rgba(0, 0, 0, 0.25);
  border-left: 2px solid #17b7c6;
  border-radius: 0 4px 4px 0;
  transform-origin: top;
}

/* Animasi slide yang lebih halus untuk submenu */
.slide-submenu-enter-active,
.slide-submenu-leave-active {
  transition: all 0.25s ease-in-out;
  max-height: 300px;
  overflow: hidden;
}

.slide-submenu-enter-from,
.slide-submenu-leave-to {
  max-height: 0;
  opacity: 0;
  transform: translateY(-10px);
}

.slide-submenu-enter-to,
.slide-submenu-leave-from {
  max-height: 300px;
  opacity: 1;
  transform: translateY(0);
}

.nav-link-sub {
  display: block;
  padding: 10px 15px 10px 47px;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  font-size: 13px;
  transition: all var(--transition-duration) var(--transition-timing);
  white-space: nowrap;
  position: relative;
}

.nav-link-sub:before {
  content: "•";
  position: absolute;
  left: 32px;
  color: #17b7c6;
  opacity: 0.7;
  font-size: 14px;
  transition: opacity var(--transition-duration) var(--transition-timing),
              color var(--transition-duration) var(--transition-timing);
}

.nav-link-sub:hover {
  background: rgba(23, 183, 198, 0.15);
  color: #fff;
  padding-left: 52px;
}

.nav-link-sub:hover:before {
  opacity: 1;
  color: #fff;
}

/* Active state untuk submenu */
.nav-link-sub.router-link-active,
.nav-link-sub.active {
  background: rgba(23, 183, 198, 0.2);
  color: #fff;
  font-weight: 500;
  border-left: 2px solid #17b7c6;
}

/* Menu aktif */
.nav-link.router-link-active,
.nav-link.active {
  background: rgba(23, 183, 198, 0.2);
  color: #fff;
  border-left-color: #17b7c6;
}

.nav-link.router-link-active i,
.nav-link.active i {
  color: #17b7c6;
}

/* HOVER SUBMENU SAAT SIDEBAR COLLAPSED (DESKTOP) */
body.sidebar-xs .sidebar .nav-item {
  position: relative;
}

body.sidebar-xs .sidebar .nav-submenu {
  position: absolute;
  left: 56px;
  top: 0;
  min-width: 220px;
  background: #1e2b37;
  border-radius: 6px;
  padding: 8px 0;
  box-shadow: 0 10px 25px rgba(0,0,0,.25);
  z-index: 9999;
  border-left: none;
  display: none;
  animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

body.sidebar-xs .sidebar .nav-item:hover .nav-submenu {
  display: block !important;
}

body.sidebar-xs .nav-text,
body.sidebar-xs .sidebar-user .media-body,
body.sidebar-xs .sidebar-menu-label {
  opacity: 0;
  transform: translateX(-5px);
  transition: opacity var(--transition-duration) var(--transition-timing),
              transform var(--transition-duration) var(--transition-timing);
}

body.sidebar-xs .nav-link {
  justify-content: center;
  padding: 14px 0 !important;
}

body.sidebar-xs .nav-link i {
  margin: 0 !important;
  width: auto;
  font-size: 18px;
  transition: font-size var(--transition-duration) var(--transition-timing);
}

body.sidebar-xs .navigation li {
  display: flex;
  justify-content: center;
}

body.sidebar-xs .sidebar-user {
  padding: 18px 0;
  text-align: center;
}

body.sidebar-xs .sidebar-user .media {
  justify-content: center;
}

body.sidebar-xs .sidebar-user .media-left {
  margin: 0;
}

/* ===== RESPONSIVE MOBILE - FIX DENGAN ANIMASI SMOOTH ===== */
@media (max-width: 768px) {
  /* Sidebar default - tersembunyi dengan animasi */
  .sidebar {
    position: fixed !important;
    top: 76px !important;
    left: 0 !important;
    right: auto !important;
    bottom: 0 !important;
    width: 280px !important;
    height: calc(100vh - 76px) !important;
    background: #1e2b37 !important;
    transform: translateX(-100%) !important;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    z-index: 9999 !important;
    box-shadow: 2px 0 10px rgba(0,0,0,0.3) !important;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }

  /* Sidebar saat class sidebar-mobile-open aktif - animasi slide in */
  body.sidebar-mobile-open .sidebar {
    transform: translateX(0) !important;
  }

  /* Overlay gelap dengan animasi fade */
  body.sidebar-mobile-open::before {
    content: "" !important;
    position: fixed !important;
    top: 50px !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background: rgba(0, 0, 0, 0.5) !important;
    z-index: 9998 !important;
    pointer-events: auto !important;
    animation: fadeInOverlay 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
  }

  @keyframes fadeInOverlay {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  /* Animasi fade out untuk overlay saat sidebar ditutup */
  body:not(.sidebar-mobile-open)::before {
    animation: fadeOutOverlay 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    opacity: 0;
  }

  @keyframes fadeOutOverlay {
    from {
      opacity: 1;
    }
    to {
      opacity: 0;
    }
  }

  /* Di mobile, semua text tampil normal dengan animasi */
  .sidebar .media-body,
  .sidebar .sidebar-menu-label,
  .sidebar .nav-text,
  .sidebar .arrow {
    display: block !important;
    opacity: 1 !important;
    transform: none !important;
  }

  .sidebar .nav-link {
    justify-content: flex-start !important;
    padding: 12px 15px !important;
    transition: all 0.2s ease !important;
  }

  .sidebar .nav-link:hover {
    background: rgba(255,255,255,.1);
    transform: translateX(5px);
  }

  .sidebar .nav-link i {
    margin-right: 12px !important;
    font-size: 16px !important;
  }

  .sidebar .sidebar-user .media-left {
    margin: 0 !important;
  }

  .sidebar .sidebar-user {
    padding: 20px 15px !important;
    text-align: left !important;
  }

  .sidebar .sidebar-user .media {
    justify-content: flex-start !important;
  }

  /* Submenu normal di mobile dengan animasi */
  .nav-submenu {
    position: static !important;
    box-shadow: none !important;
    display: block !important;
    border-left: 2px solid #17b7c6 !important;
    animation: slideDown 0.25s ease !important;
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

  /* Matikan efek hover submenu di mobile */
  body.sidebar-xs .sidebar .nav-item:hover .nav-submenu {
    display: none !important;
  }

  /* Abaikan sidebar-xs di mobile */
  body.sidebar-xs .sidebar .nav-text,
  body.sidebar-xs .sidebar .sidebar-menu-label,
  body.sidebar-xs .sidebar .arrow {
    display: block !important;
    opacity: 1 !important;
  }

  body.sidebar-xs .sidebar .nav-link {
    justify-content: flex-start !important;
    padding: 12px 15px !important;
  }

  body.sidebar-xs .sidebar .nav-link i {
    margin-right: 12px !important;
  }

  body.sidebar-xs .sidebar .sidebar-user {
    padding: 20px 15px !important;
  }
}
</style>