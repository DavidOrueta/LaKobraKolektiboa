<template>
  <div class="container">
    <h2>Nuevo Socio</h2>
    <p v-if="error" class="msg error">{{ error }}</p>
    <p v-if="exito" class="msg exito">Registro OK. Ya puedes iniciar sesión.</p>
    <form v-if="!exito" @submit.prevent="handleRegistro">
      <input v-model="form.nombre"    type="text"     placeholder="NOMBRE COMPLETO" required />
      <input v-model="form.dni"       type="text"     placeholder="DNI"             required />
      <input v-model="form.email"     type="email"    placeholder="EMAIL"           required />
      <input v-model="form.password"  type="password" placeholder="PASSWORD"        required />
      <input v-model="form.direccion" type="text"     placeholder="DIRECCIÓN" />
      <button type="submit" :disabled="cargando">
        {{ cargando ? 'Registrando...' : 'Darse de Alta' }}
      </button>
    </form>
    <p style="text-align:center; margin-top:12px">
      ¿Ya tienes cuenta?
      <a href="#" @click.prevent="$router.push('/')">Volver al inicio</a>
    </p>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const error    = ref('')
const exito    = ref(false)
const cargando = ref(false)
const form     = reactive({ nombre: '', dni: '', email: '', password: '', direccion: '' })

async function handleRegistro() {
  error.value    = ''
  cargando.value = true
  try {
    const res = await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/api/registro.php', {
      method:      'POST',
      headers:     { 'Content-Type': 'application/json' },
      credentials: 'include',
      body:        JSON.stringify(form)
    })
    const data = await res.json()
    if (!res.ok) {
      error.value = data.error || 'Error en el registro'
    } else {
      exito.value = true
    }
  } catch (e) {
    error.value = 'No se pudo conectar con el servidor'
  } finally {
    cargando.value = false
  }
}
</script>

<style scoped>
.container { max-width: 350px; margin: 60px auto; border: 3px solid #fff; padding: 30px; background: #000; color: #fff; }
h2 { text-align: center; margin-bottom: 16px; }
input { width: 100%; padding: 10px; margin: 8px 0; background: #111; color: #fff; border: 1px solid #444; box-sizing: border-box; }
button { width: 100%; padding: 10px; background: #39ff14; color: #000; border: none; font-weight: bold; cursor: pointer; text-transform: uppercase; }
button:disabled { opacity: 0.5; cursor: not-allowed; }
.msg { text-align: center; margin-bottom: 10px; }
.error { color: #ff00ff; }
.exito { color: #39ff14; }
a { color: #39ff14; cursor: pointer; }
</style>