<script setup>
import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route  = useRoute()
</script>

<template>
  <div class="fixed left-6 top-2 z-[9999] inline-flex bg-white backdrop-blur-md rounded-xl">
    <img src="@/assets/LogoLaKobra.svg" class="h-24 w-auto" />
  </div>

  <header class="h-30 bg-black flex items-center px-6 relative z-10">
    <nav
      class="flex-1 flex justify-center gap-6 text-sm uppercase tracking-widest font-bold text-white"
    >
      <RouterLink to="/" class="hover:text-kobra-green transition-all">Home</RouterLink>
      <RouterLink to="/about" class="hover:text-kobra-green transition-all">About</RouterLink>
      <RouterLink
        to="/contacto"
        class="text-kobra-green hover:text-white transition-all underline decoration-2 underline-offset-4"
      >
        Contacto
      </RouterLink>
      <RouterLink
        to="/Events"
        class="text-kobra-green hover:text-white transition-all underline decoration-2 underline-offset-4"
      >
        Eventos
      </RouterLink>
    </nav>

    <div
      v-if="route.path !== '/login' && route.path !== '/registro'"
      class="flex items-center space-x-2"
    >
      <button
        @click="router.push('/login')"
        class="px-4 py-2 rounded font-bold transition-all bg-gray-200 text-black hover:bg-green-600 hover:text-white"
      >
        Iniciar Sesión
      </button>

      <button
        @click="router.push('/registro')"
        class="px-4 py-2 rounded font-bold transition-all bg-gray-200 text-black hover:bg-blue-600 hover:text-white"
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

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;

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
  }

</style>