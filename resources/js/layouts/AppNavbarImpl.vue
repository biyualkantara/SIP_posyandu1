<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const namaUser =
  page.props.auth?.user?.nama ||
  page.props.auth?.user?.username ||
  'User'
const navbarOpen = ref(false)
const isDesktop = ref(true)

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

onMounted(() => {
  updateIsDesktop()
  window.addEventListener('resize', updateIsDesktop)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateIsDesktop)
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
      <!-- RIGHT -->
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown dropdown-user">
          <a class="dropdown-toggle" data-toggle="dropdown">
            <span>{{ namaUser }}</span>
            <i class="caret"></i>
          </a>

          <ul class="dropdown-menu dropdown-menu-right">
            <li><Link href="/profile" method="get" as="button"type="button"class="btn btn-link text-left w-full"style="padding:6px 20px;">
                <i class="icon-user"></i> Profil Saya
                </Link>
            </li>
            <li><Link href="/logout" method="post" as="button"type="button"class="btn btn-link text-left w-full"style="padding:6px 20px;">
                <i class="icon-switch2"></i> Logout
                </Link>
            </li>
          </ul>
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
</style>