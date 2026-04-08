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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EventosCards",
  data() {
    return {
      eventos: []
    };
  },
  methods: {
    estadoClase(estado) {
      switch (estado) {
        case "confirmado":
          return "bg-green-100 text-green-700";
        case "pendiente":
          return "bg-yellow-100 text-yellow-700";
        case "cancelado":
          return "bg-red-100 text-red-700";
        default:
          return "bg-gray-100 text-gray-700";
      }
    }
  },
  mounted() {
    // Simulación de datos (puedes sustituir por fetch a PHP)
    this.eventos = [
      {
        id: 1,
        titulo: "Concierto Rock",
        fecha_evento: "2026-05-10",
        hora_inicio: "20:00",
        aforo_max: 150,
        estado: "confirmado"
      },
      {
        id: 2,
        titulo: "Festival Indie",
        fecha_evento: "2026-06-15",
        hora_inicio: "18:00",
        aforo_max: 200,
        estado: "pendiente"
      },
      {
        id: 3,
        titulo: "Fiesta DJ",
        fecha_evento: "2026-04-20",
        hora_inicio: "23:00",
        aforo_max: 100,
        estado: "cancelado"
      }
    ];
  }
};
</script>