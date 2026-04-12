<template>
  <div class="container">
    <h2>Acceso</h2>
    <p v-if="error" class="error">{{ error }}</p>
    <form @submit.prevent="handleLogin">
      <input v-model="email"    type="email"    placeholder="EMAIL"    required />
      <input v-model="password" type="password" placeholder="PASSWORD" required />
      <button type="submit" :disabled="cargando">
        {{ cargando ? 'Entrando...' : 'Entrar' }}
      </button>
    </form>
    <p class="link">
      ¿No tienes cuenta? <router-link to="/registro">Regístrate</router-link>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router   = useRouter()
const auth     = useAuthStore()
const email    = ref('')
const password = ref('')
const error    = ref('')
const cargando = ref(false)

async function handleLogin() {
  error.value    = ''
  cargando.value = true
  try {
    await auth.login(email.value, password.value)
    router.push('/Events')
  } catch (e) {
    error.value = e.message
  } finally {
    cargando.value = false
  }
}
</script>

<style scoped>
.container { max-width: 350px; margin: 80px auto; border: 3px solid #fff; padding: 30px; background: #000; color: #fff; }
h2  { text-align: center; margin-bottom: 16px; }
input { width: 100%; padding: 10px; margin: 8px 0; background: #111; color: #fff; border: 1px solid #444; box-sizing: border-box; }
button { width: 100%; padding: 10px; background: #ffffff; color: #000; border: none; font-weight: bold; cursor: pointer; text-transform: uppercase; }
button:disabled { opacity: 0.5; cursor: not-allowed; }
.error { color: #ffffff; text-align: center; }
.link  { text-align: center; margin-top: 12px; }
a { color: #ffffff; }
</style>s