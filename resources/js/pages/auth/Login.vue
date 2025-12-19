<template>
  <div class="login-page">
    <Head title="Login" />

    <div class="wrapper">
      <!-- Left: gambar eSIP -->
      <div class="left-panel"></div>

      <!-- Right: form login -->
      <div class="right-panel">
        <div class="form-container">
          <h1 class="title">
            Selamat Datang<br />
            di eSIP Kota Cimahi
          </h1>

          <p class="subtitle">
            Masuk untuk melanjutkan ke dashboard
          </p>

          <!-- Status pesan (misal: "Password di-reset", dll) -->
          <div v-if="status" class="status-message">
            {{ status }}
          </div>

          <form class="login-form" @submit.prevent="submit">
            <div class="form-group">
              <label for="username">Username</label>
              <input
                id="username"
                type="text"
                v-model="form.username"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan Username"
              />
              <div v-if="form.errors.username" class="error">
                {{ form.errors.username }}
              </div>
            </div>

            <!-- Password -->
            <div class="form-group">
              <label for="password">Password</label>
              <input
                id="password"
                type="password"
                v-model="form.password"
                required
                autocomplete="current-password"
                placeholder="Masukkan Password"
              />
              <div v-if="form.errors.password" class="error">
                {{ form.errors.password }}
              </div>
            </div>

            <!-- Tombol Login -->
            <button
              type="submit"
              class="btn-login"
              :disabled="form.processing"
            >
              <span v-if="form.processing">Loading...</span>
              <span v-else>LOGIN</span>
            </button>

            <!-- Kembali ke landing -->
            <a href="/" class="back-link">
              &laquo; Kembali ke halaman utama
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';

const page = usePage();

const status = page.props.status ?? null;

const form = useForm({
  username: '',
  password: '',
});

const submit = () => {
  form.post('/login');
};
</script>