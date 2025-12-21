<template>
  <div>
    <Head title="Selamat Datang di eSIP Kota Cimahi" />
    <NavbarLanding />
    <main class="pb-24">
      <HeroLanding />
      <Tentangesip />
      <Menuedukasikesehatan />
      <Halamanberita />
      <Halamandaftarposyandu />
      <Kontakesip />
    </main>
    <div class="fixed bottom-0 left-0 w-full z-50">
      <AppFooterImpl />
    </div>
  </div>
</template>

<script lang="ts">
import { Head } from '@inertiajs/vue3';

import NavbarLanding from '../components/SIPVue/NavbarLanding.vue';
import HeroLanding from '../components/SIPVue/HeroLanding.vue';

import Tentangesip from './landingpage/tentangesip.vue';
import Menuedukasikesehatan from './landingpage/menuedukasikesehatan.vue';
import Halamanberita from './landingpage/halamanberita.vue';
import Halamandaftarposyandu from './landingpage/halamandaftarposyandu.vue';
import Kontakesip from './landingpage/kontakesip.vue';

import AppFooterImpl from '@/layouts/AppFooterImpl.vue';

export default {
  name: 'Welcome',
  components: {
    Head,
    NavbarLanding,
    HeroLanding,
    Tentangesip,
    Menuedukasikesehatan,
    Halamanberita,
    Halamandaftarposyandu,
    Kontakesip,
    AppFooterImpl,
  },
};
</script>
