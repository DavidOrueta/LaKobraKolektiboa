import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(sessionStorage.getItem('kobra_user') || 'null')
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
      this.user = data
      sessionStorage.setItem('kobra_user', JSON.stringify(data))
    },

    async logout() {
      await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/logout.php', {
        method:      'POST',
        credentials: 'include'
      })
      this.user = null
      sessionStorage.removeItem('kobra_user')
    },

    async fetchMe() {
      try {
        const res = await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/me.php', {
          credentials: 'include'
        })
        if (res.ok) {
          const data = await res.json()
          this.user = data
          sessionStorage.setItem('kobra_user', JSON.stringify(data))
        } else {
          this.user = null
          sessionStorage.removeItem('kobra_user')
        }
      } catch {
       
      }
    }
  }
})