<template>
  <div v-if="visible" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-white/90 backdrop-blur-md p-6 rounded-2xl w-96 shadow-xl">
      <h2 class="text-xl font-bold mb-4">Registro</h2>

      <input
        v-model="nombre"
        type="text"
        placeholder="Nombre"
        class="w-full mb-3 p-2 border rounded"
      />

      <input v-model="dni" type="text" placeholder="DNI" class="w-full mb-3 p-2 border rounded" />

      <input
        v-model="email"
        type="email"
        placeholder="Email"
        class="w-full mb-3 p-2 border rounded"
      />

      <input
        v-model="password"
        type="password"
        placeholder="Password"
        class="w-full mb-3 p-2 border rounded"
      />

      <input
        v-model="direccion"
        type="text"
        placeholder="Dirección"
        class="w-full mb-3 p-2 border rounded"
      />

      <button
        type="button"
        @click="register"
        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600"
      >
        Registrarse
      </button>

      <p v-if="message" class="mt-2 text-sm">
        {{ message }}
      </p>

      <button @click="$emit('close')" class="mt-3 text-sm text-gray-500">Cerrar</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['visible'],
  data() {
    return {
      nombre: '',
      dni: '',
      email: '',
      password: '',
      direccion: '',
      message: '',
    }
  },
  methods: {
    async register() {
      try {
        const res = await fetch(
          'http://localhost/Practicas/LAKOBRAKOLEKTIBOA/BackendLakobra/registro.php',
          {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              nombre: this.nombre,
              dni: this.dni,
              email: this.email,
              password: this.password,
              direccion: this.direccion,
            }),
          },
        )

        const data = await res.json()

        if (data.success) {
          this.message = '✔ Registro correcto'
          this.$emit('success', data)
          setTimeout(() => this.$emit('close'), 1000)
        } else {
          this.message = data.message
        }
      } catch (err) {
  console.log("ERROR REAL:", err);
  this.message = err.message;
}
    },
  },
}
</script>
