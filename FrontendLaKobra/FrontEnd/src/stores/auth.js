import { defineStore } from 'pinia'
 
export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null
  }),
 
  getters: {
    isLoggedIn: (state) => !!state.user,
    rol:        (state) => state.user?.rol ?? null
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
      window.location.href = 'http://localhost/LaKobraKolektiboa/BackendLaKobra/index.php'
    },
 
    async logout() {
      await fetch('http://localhost/LaKobraKolektiboa/BackendLaKobra/logout.php', {
        method:      'POST',
        credentials: 'include'
      })
      this.user = null
    }
  }
})
 