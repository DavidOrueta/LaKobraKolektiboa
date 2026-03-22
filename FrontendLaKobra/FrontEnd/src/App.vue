<script setup>
import { RouterLink, RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
</script>
<template>
  <header class="flex flex-col items-center py-10">
    <img alt="Logo LaKobra" class="logo mb-6" src="@/assets/LogoLaKobra.svg" width="125" height="125" />

    <div class="wrapper flex flex-col items-center">
      <div class="bg-kobra-dark p-6 rounded-xl border border-kobra-green shadow-[0_0_15px_rgba(173,255,47,0.3)]">
        <h1 class="text-kobra-green font-black text-2xl uppercase tracking-tighter">Bienvenidos a LaKobra</h1>
      </div>

      <nav class="mt-6 flex gap-6 text-sm uppercase tracking-widest font-bold">
        <RouterLink to="/" class="hover:text-kobra-green transition-all">Home</RouterLink>
        <RouterLink to="/about" class="hover:text-kobra-green transition-all">About</RouterLink>
        
        <RouterLink to="/contacto" class="text-kobra-green hover:text-white transition-all underline decoration-2 underline-offset-4">Contacto</RouterLink>
      </nav>
    </div>
  </header>

  <main class="p-8 max-w-7xl mx-auto">
    <RouterView />
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
