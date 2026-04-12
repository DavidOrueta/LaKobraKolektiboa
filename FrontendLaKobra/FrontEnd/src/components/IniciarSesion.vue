<template>
  <div v-if="visible" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    
    <div class="bg-white/90 backdrop-blur-md p-6 rounded-2xl w-96 shadow-xl">
      
      <h2 class="text-xl font-bold mb-4">Iniciar Sesión</h2>

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

      <button
        @click="login"
        class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600"
      >
        Entrar
      </button>

      <p v-if="error" class="text-red-500 mt-2">
        {{ error }}
      </p>

      <button @click="$emit('close')" class="mt-3 text-sm text-gray-500">
        Cerrar
      </button>

    </div>
  </div>
</template>

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

        const data = await res.json();

        if (data.success) {
          this.$emit("success", data.user);
          this.$emit("close");
        } else {
          this.error = data.message;
        }

      } catch (err) {
        this.error = "Error de conexión";
      }
    }
  }
};
</script>