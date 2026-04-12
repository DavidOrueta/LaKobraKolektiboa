<template>
  <div class="eventos-page">

    <!-- CABECERA -->
    <div class="eventos-header">
      <h1>Eventos</h1>
      <button v-if="auth.isAdmin" class="btn-crear" @click="abrirFormulario()">+ Nuevo Evento</button>
    </div>

    <!-- LISTA DE EVENTOS -->
    <div v-if="cargando" class="msg">Cargando eventos...</div>
    <div v-else-if="eventos.length === 0" class="msg">No hay eventos disponibles.</div>
    <div v-else class="grid">
      <div v-for="ev in eventos" :key="ev.id" class="card">
        <div class="card-estado" :class="ev.estado">{{ ev.estado }}</div>
        <h2>{{ ev.titulo }}</h2>
        <p>📅 {{ ev.fecha_evento }} {{ ev.hora_inicio ? '· ' + ev.hora_inicio : '' }}</p>
        <p>👥 Aforo: {{ ev.aforo_max }}</p>
        <p v-if="auth.isAdmin">👁 {{ ev.visible_publico ? 'Visible' : 'Oculto' }}</p>
        <div v-if="auth.isAdmin" class="card-actions">
          <button class="btn-edit" @click="abrirFormulario(ev)">Editar</button>
          <button class="btn-del"  @click="borrarEvento(ev.id)">Borrar</button>
        </div>
      </div>
    </div>

    <!-- MODAL CREAR / EDITAR -->
    <div v-if="mostrarModal" class="overlay" @click.self="cerrarModal">
      <div class="modal">
        <h2>{{ form.id ? 'Editar Evento' : 'Nuevo Evento' }}</h2>
        <p v-if="errorModal" class="error">{{ errorModal }}</p>

        <label>Título *</label>
        <input v-model="form.titulo" type="text" required />

        <label>Fecha *</label>
        <input v-model="form.fecha_evento" type="date" required />

        <label>Hora inicio</label>
        <input v-model="form.hora_inicio" type="time" />

        <label>Aforo máximo</label>
        <input v-model.number="form.aforo_max" type="number" min="1" />

        <label>Estado</label>
        <select v-model="form.estado">
          <option value="pendiente">Pendiente</option>
          <option value="confirmado">Confirmado</option>
          <option value="cancelado">Cancelado</option>
        </select>

        <label class="check-label">
          <input v-model="form.visible_publico" type="checkbox" :true-value="1" :false-value="0" />
          Visible al público
        </label>

        <div class="modal-actions">
          <button class="btn-cancel" @click="cerrarModal">Cancelar</button>
          <button class="btn-save"   @click="guardarEvento" :disabled="guardando">
            {{ guardando ? 'Guardando...' : 'Guardar' }}
          </button>
          <pre>{{ eventos }}</pre>
        </div>
      </div>
    </div>

  </div>
  
</template>

<<<<<<< HEAD
<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth     = useAuthStore()
const eventos  = ref([])
const cargando = ref(true)

const mostrarModal = ref(false)
const guardando    = ref(false)
const errorModal   = ref('')

const formVacio = () => ({
  id: null, titulo: '', fecha_evento: '', hora_inicio: '',
  aforo_max: 120, estado: 'pendiente', visible_publico: 0
})
const form = ref(formVacio())

const BASE = 'http://localhost/LaKobraKolektiboa/BackendLaKobra/api/Events.php'
async function cargarEventos() {
  cargando.value = true
  try {
    const url = auth.isAdmin ? BASE + '?todos=1' : BASE
    const res = await fetch(url, { credentials: 'include' })
    eventos.value = await res.json()
  } finally {
    cargando.value = false
  }
}

function abrirFormulario(ev = null) {
  errorModal.value = ''
  form.value = ev
    ? { ...ev }
    : formVacio()
  mostrarModal.value = true
}

function cerrarModal() {
  mostrarModal.value = false
}

async function guardarEvento() {
  if (!form.value.titulo || !form.value.fecha_evento) {
    errorModal.value = 'Título y fecha son obligatorios'
    return
  }
  guardando.value = true
  errorModal.value = ''
  try {
    const url    = form.value.id ? `${BASE}?id=${form.value.id}` : BASE
    const method = form.value.id ? 'PUT' : 'POST'
    const res = await fetch(url, {
      method,
      headers:     { 'Content-Type': 'application/json' },
      credentials: 'include',
      body:        JSON.stringify(form.value)
    })
    const data = await res.json()
    if (!res.ok) { errorModal.value = data.error || 'Error al guardar'; return }
    cerrarModal()
    await cargarEventos()
  } catch {
    errorModal.value = 'No se pudo conectar con el servidor'
  } finally {
    guardando.value = false
  }
}

async function borrarEvento(id) {
  if (!confirm('¿Seguro que quieres borrar este evento?')) return
  await fetch(`${BASE}?id=${id}`, { method: 'DELETE', credentials: 'include' })
  await cargarEventos()
}

onMounted(async () => {
  await auth.fetchMe()
  console.log('user:', auth.user)
  console.log('isAdmin:', auth.isAdmin)
  await cargarEventos()
})
</script>

<style scoped>
.eventos-page { max-width: 900px; margin: 0 auto; color: #fff; }
.eventos-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
h1 { font-size: 2rem; text-transform: uppercase; letter-spacing: 4px; }

.grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
.card { background: #111; border: 1px solid #333; padding: 20px; position: relative; }
.card h2 { font-size: 1.1rem; margin-bottom: 8px; }
.card p  { font-size: 0.85rem; color: #aaa; margin: 4px 0; }
.card-estado { font-size: 0.7rem; text-transform: uppercase; font-weight: bold; margin-bottom: 8px; }
.card-estado.confirmado { color: #39ff14; }
.card-estado.pendiente  { color: #ffcc00; }
.card-estado.cancelado  { color: #ff00ff; }
.card-actions { display: flex; gap: 8px; margin-top: 12px; }

.msg { text-align: center; color: #aaa; padding: 40px; }

/* Botones */
.btn-crear  { background: #39ff14; color: #000; border: none; padding: 10px 20px; font-weight: bold; cursor: pointer; text-transform: uppercase; }
.btn-edit   { background: #444; color: #fff; border: none; padding: 6px 12px; cursor: pointer; font-size: 0.8rem; }
.btn-del    { background: #ff00ff; color: #000; border: none; padding: 6px 12px; cursor: pointer; font-size: 0.8rem; font-weight: bold; }
.btn-cancel { background: #333; color: #fff; border: none; padding: 10px 20px; cursor: pointer; }
.btn-save   { background: #39ff14; color: #000; border: none; padding: 10px 20px; font-weight: bold; cursor: pointer; }
.btn-save:disabled { opacity: 0.5; cursor: not-allowed; }

/* Modal */
.overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.8); display: flex; align-items: center; justify-content: center; z-index: 1000; }
.modal { background: #000; border: 2px solid #fff; padding: 30px; width: 100%; max-width: 420px; }
.modal h2 { margin-bottom: 16px; text-transform: uppercase; }
.modal label { display: block; font-size: 0.8rem; color: #aaa; margin: 10px 0 4px; text-transform: uppercase; }
.modal input, .modal select { width: 100%; padding: 8px; background: #111; color: #fff; border: 1px solid #444; box-sizing: border-box; }
.check-label { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #aaa; cursor: pointer; }
.check-label input { width: auto; }
.modal-actions { display: flex; gap: 10px; margin-top: 20px; justify-content: flex-end; }
.error { color: #ff00ff; margin-bottom: 10px; }
</style>
=======
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
>>>>>>> 8fce333ebbb3df65a2a618a6740f3c0b19d0cdd2
