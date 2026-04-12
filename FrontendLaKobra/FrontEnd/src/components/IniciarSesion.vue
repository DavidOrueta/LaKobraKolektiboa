<template>
  <div v-if="visible" class="overlay" @click.self="$emit('close')">
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
        ¿No tienes cuenta? <router-link to="/registro" @click="$emit('close')">Regístrate</router-link>
      </p>
    </div>
  </div>
</template>

<<<<<<< HEAD
<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
=======
<script>
export default {
  props: ["visible"],
  data() {
    return {
      email: "",
      password: "",
      error: ""
    };
  },
  methods: {
    async login() {
      try {
        const res = await fetch("http://localhost/Pruebas/LAKOBRAKOLEKTIBOA/BackendLaKobra/login.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          })
        });
>>>>>>> 8fce333ebbb3df65a2a618a6740f3c0b19d0cdd2

defineProps({ visible: Boolean })
defineEmits(['close'])

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
    console.log('login ok, user:', auth.user, 'isAdmin:', auth.isAdmin)
    router.push('/Events')
  } catch (e) {
    console.log('error:', e.message)
    error.value = e.message
  } finally {
    cargando.value = false
  }
}
</script>

<style scoped>
.overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.container { max-width: 350px; width: 100%; border: 3px solid #fff; padding: 30px; background: #000; color: #fff; }
h2  { text-align: center; margin-bottom: 16px; }
input { width: 100%; padding: 10px; margin: 8px 0; background: #111; color: #fff; border: 1px solid #444; box-sizing: border-box; }
button { width: 100%; padding: 10px; background: #39ff14; color: #000; border: none; font-weight: bold; cursor: pointer; text-transform: uppercase; }
button:disabled { opacity: 0.5; cursor: not-allowed; }
.error { color: #ff00ff; text-align: center; }
.link  { text-align: center; margin-top: 12px; }
a { color: #39ff14; }
</style>