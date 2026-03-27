<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { ref } from 'vue'

const active = ref(0) // valor inicial 0
</script>
<template>
<div class="fixed left-6 top-2 z-[9999] inline-flex bg-white backdrop-blur-md rounded-xl">
  <img src="@/assets/LogoLaKobra.svg" class="h-24 w-auto" />
</div>

  <header class="h-30 bg-black flex items-center px-6 relative z-10">

    <!-- NAV -->
    <nav class="flex-1 flex justify-center gap-6 text-sm uppercase tracking-widest font-bold text-white">
      <RouterLink to="/" class="hover:text-kobra-green transition-all">Home</RouterLink>
      <RouterLink to="/about" class="hover:text-kobra-green transition-all">About</RouterLink>
      <RouterLink to="/contacto" class="text-kobra-green hover:text-white transition-all underline decoration-2 underline-offset-4">
        Contacto
      </RouterLink>
    </nav>

    <!-- BOTONES -->
    <div class="flex items-center space-x-2">
      <button
        :class="active === 0 ? 'bg-green-500 text-white' : 'bg-gray-200 text-black'"
        @click="active = 0"
        class="px-4 py-2 rounded font-bold transition-all hover:bg-green-600"
      >
        Iniciar Sesión
      </button>

      <button
        :class="active === 1 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'"
        @click="active = 1"
        class="px-4 py-2 rounded font-bold transition-all hover:bg-blue-600"
      >
        Registrarse
      </button>
    </div>

  </header>




  <main class="p-8 max-w-7xl mx-auto">
    <router-view></router-view>
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
