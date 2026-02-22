<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const page = usePage()
const user = page.props.auth?.user

const openIndex = ref(null)
const toggle = i => {
  openIndex.value = openIndex.value === i ? null : i
}

/* LABEL ROLE */
const roleLabel = computed(() => {
  if (user?.role === 'superadmin') return 'Super Admin'
  if (user?.role === 'admin') return 'Admin'
  return 'Kader'
})

/* MENU SIDEBAR */
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

  /* MENU OPERATOR → HANYA SUPERADMIN */
  if (user?.role === 'superadmin') {
    items.push({
      icon: 'icon-user-plus',
      label: 'Operator',
      children: [{ label: 'Daftar Operator', path: '/operator' }]
    })
  }

  return items
})
</script>

<template>
  <div class="sidebar sidebar-dark sidebar-main">
    <div class="sidebar-content" style="margin-top:15px">

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

      <p style="color:lightslategray;margin:10px 5px">Menu</p>

      <ul class="navigation navigation-main navigation-accordion">
        <li v-for="(item,i) in sidebarItems" :key="i">
          <Link v-if="!item.children" :href="item.path">
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
          </Link>

          <a v-else href="#" @click.prevent="toggle(i)">
            <i :class="item.icon"></i>
            <span>{{ item.label }}</span>
            <span class="arrow"></span>
          </a>

          <ul v-if="item.children && openIndex === i" class="navigation navigation-level-2">
            <li v-for="c in item.children" :key="c.path">
              <Link :href="c.path">{{ c.label }}</Link>
            </li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</template>

<style scoped>
.sidebar-user {
  padding: 10px;
  border-bottom: 1px solid rgba(255,255,255,.1);
}

.sidebar-user .media-heading {
  color: #fff;
}

.sidebar-user .text-muted {
  color: #9ca3af;
}

.navigation > li > a {
  font-size: 14px;
  font-weight: 500;
}

.navigation-level-2 > li > a {
  padding-left: 52px;
  font-size: 13px;
}

.arrow {
  float: right;
}
</style>