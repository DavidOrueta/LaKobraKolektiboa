<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Eventos</h1>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      <div 
        v-for="evento in eventos" 
        :key="evento.id"
        class="bg-white shadow-lg rounded-2xl p-5 hover:shadow-xl transition"
      >
        <h2 class="text-xl font-semibold mb-2">
          {{ evento.titulo }}
        </h2>

        <p class="text-gray-600 mb-2">
          📅 {{ evento.fecha_evento }}
        </p>

        <p class="text-gray-600 mb-2" v-if="evento.hora_inicio">
          ⏰ {{ evento.hora_inicio }}
        </p>

        <p class="text-gray-600 mb-2">
          👥 Aforo: {{ evento.aforo_max }}
        </p>

        <span 
          class="inline-block px-3 py-1 text-sm rounded-full"
          :class="estadoClase(evento.estado)"
        >
          {{ evento.estado }}
        </span>

        <div class="mt-4">
          <button 
            class="bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600"
          >
            Ver detalles
          </button>
          <pre>{{ eventos }}</pre>
        </div>
      </div>
    </div>
  </div>
  
</template>

<script>
export default {
  data() {
    return {
      eventos: []
    }
  },
mounted() {
  fetch('http://localhost/Practicas/LAKOBRAKOLEKTIBOA/BackendLaKobra/Events.php')
    .then(res => {
      console.log("STATUS:", res.status)
      return res.text()
    })
    .then(text => {
      console.log("RAW RESPONSE:", text)

      try {
        this.eventos = JSON.parse(text)
      } catch (e) {
        console.error("JSON ERROR:", e)
      }
    })
    .catch(err => console.error("FETCH ERROR:", err))
},
  methods: {
    estadoClase(estado) {
      if (estado === 'confirmado') return 'bg-green-100 text-green-800'
      if (estado === 'pendiente') return 'bg-yellow-100 text-yellow-800'
      if (estado === 'cancelado') return 'bg-red-100 text-red-800'
      return 'bg-gray-100 text-gray-800'
    }
  }
}
</script>