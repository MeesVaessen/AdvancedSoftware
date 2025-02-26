// stores/authStore.js
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: null,
    user: null,
  }),
  actions: {
    setAuthData(token, user) {
      this.token = token;
      this.user = user;
    },
    logout() {
      this.token = null;
      this.user = null;
    },
  },
  persist: {
    enabled: true,  // Ensures persistence is enabled
    strategies: [
      {
        storage: localStorage, // You can change this to sessionStorage if you prefer
        paths: ['token', 'user'], // Persist only these fields
      },
    ],
  },
});
