<template>
  <div>
    <Head title="Selamat Datang di eSIP Kota Cimahi" />
    <NavbarLanding />
    <HeroLanding />
  </div>
</template>

<script lang="ts">
import { Head } from '@inertiajs/vue3';
import NavbarLanding from '../components/SIPVue/NavbarLanding.vue';
import HeroLanding from '../components/SIPVue/HeroLanding.vue';

export default {
  name: "Welcome",
  components: {
    Head,
    NavbarLanding,
    HeroLanding
  }
};
</script>