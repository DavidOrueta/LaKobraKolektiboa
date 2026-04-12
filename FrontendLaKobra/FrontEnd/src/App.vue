<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { ref, computed } from 'vue'
import LoginModal from '@/components/IniciarSesion.vue'
import RegisterModal from '@/components/RegistroPanel.vue'

const showLogin = ref(false)
const showRegister = ref(false)
const active = ref(0)

// 🔐 rol reactivo
const rol = ref(localStorage.getItem("rol"))

// ✅ mejor con computed (reactivo real)
const esAdmin = computed(() => rol.value === 'admin')

// 👇 login modal control
const openLogin = () => {
  showLogin.value = true
  showRegister.value = false
  active.value = 0
}

// 👇 register modal control
const openRegister = () => {
  showRegister.value = true
  showLogin.value = false
  active.value = 1
}
</script>

<template>
  <div class="fixed left-6 top-2 z-[9999] inline-flex bg-white backdrop-blur-md rounded-xl">
    <img src="@/assets/LogoLaKobra.svg" class="h-24 w-auto" />
  </div>

  <header class="h-30 bg-black flex items-center px-6 relative z-10">

    <nav class="flex-1 flex justify-center gap-6 text-sm uppercase tracking-widest font-bold text-white">
      <RouterLink to="/">Home</RouterLink>
      <RouterLink to="/about">About</RouterLink>
      <RouterLink to="/contacto">Contacto</RouterLink>
      <RouterLink to="/events">Eventos</RouterLink>
    </nav>

    <div class="flex items-center space-x-2">

      <!-- 🔥 BOTÓN SOLO ADMIN -->
      <button
        v-if="esAdmin"
        @click="$router.push('/crear-evento')"
        class="px-4 py-2 rounded font-bold bg-red-500 text-white hover:bg-red-600 transition-all"
      >
        Crear evento
      </button>

      <!-- LOGIN -->
      <button
        :class="active === 0 ? 'bg-green-500 text-white' : 'bg-gray-200 text-black'"
        @click="openLogin"
        class="px-4 py-2 rounded font-bold transition-all hover:bg-green-600"
      >
        Iniciar Sesión
      </button>

      <!-- REGISTER -->
      <button
        :class="active === 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
        @click="openRegister"
        class="px-4 py-2 rounded font-bold transition-all hover:bg-blue-600"
      >
        Registrarse
      </button>

    </div>
  </header>

  <!-- MODALES -->
  <LoginModal :visible="showLogin" @close="showLogin = false" />
  <RegisterModal :visible="showRegister" @close="showRegister = false" />

  <main class="p-8 max-w-7xl mx-auto">
    <router-view />
  </main>
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
