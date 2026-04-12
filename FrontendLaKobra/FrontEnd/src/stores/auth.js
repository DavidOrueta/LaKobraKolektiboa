import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null
  }),

  getters: {
    isLoggedIn: (state) => !!state.user,
    rol:        (state) => state.user?.rol ?? null,
    isAdmin:    (state) => state.user?.rol === 'admin'
  },

  actions: {
    async login(email, password) {
      const res = await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/api/login.php', {
        method:      'POST',
        headers:     { 'Content-Type': 'application/json' },
        credentials: 'include',
        body:        JSON.stringify({ email, password })
      })
      const data = await res.json()
      if (!res.ok) throw new Error(data.error || 'Error al iniciar sesión')
      this.user = data  // { nombre, rol }
      // sin redirección — el componente decide a dónde ir
    },

    async logout() {
      await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/logout.php', {
        method:      'POST',
        credentials: 'include'
      })
      this.user = null
    },

    async fetchMe() {
      try {
        const res = await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/me.php', {
          credentials: 'include'
        })
        if (res.ok) this.user = await res.json()
      } catch {
        this.user = null
      }
    }
  }
})