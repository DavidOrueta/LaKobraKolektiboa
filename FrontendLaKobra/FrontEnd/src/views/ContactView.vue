<script setup>
import { ref } from 'vue'

// Esto es para guardar lo que el usuario escribe
const formulario = ref({
  nombre: '',
  email: '',
  mensaje: ''
})

const enviarFormulario = () => {
  alert(`¡Aquelarre avisado! Gracias ${formulario.value.nombre}. (Aquí conectaremos con el PHP mañana)`)

}
</script>

<template>
  <div class="max-w-2xl mx-auto py-12 px-6 bg-black/40 border border-kobra-green/20 rounded-2xl shadow-2xl">
    <h2 class="text-3xl font-black text-kobra-green uppercase italic mb-2 tracking-tighter">
      Resuelve tus dudas
    </h2>
    <p class="text-gray-400 mb-8 text-sm uppercase tracking-widest">Contacto / Booking / Quejas al infierno</p>

    <form @submit.prevent="enviarFormulario" class="space-y-6">
      <div>
        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nombre / Colectivo</label>
        <input v-model="formulario.nombre" type="text" class="w-full bg-zinc-900 border border-zinc-800 p-4 rounded-lg focus:outline-none focus:border-kobra-green transition-all text-white" placeholder="Tu nombre..." required>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Email de contacto</label>
        <input v-model="formulario.email" type="email" class="w-full bg-zinc-900 border border-zinc-800 p-4 rounded-lg focus:outline-none focus:border-kobra-green transition-all text-white" placeholder="tu@email.com" required>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Mensaje / Propuesta</label>
        <textarea v-model="formulario.mensaje" rows="4" class="w-full bg-zinc-900 border border-zinc-800 p-4 rounded-lg focus:outline-none focus:border-kobra-green transition-all text-white" placeholder="Cuéntanos el lío..." required></textarea>
      </div>

      <button type="submit" class="w-full bg-kobra-green text-black font-black py-4 rounded-lg hover:bg-white transition-colors uppercase italic tracking-tighter text-lg">
        Enviar Mensaje
      </button>
    </form>
  </div>
</template>