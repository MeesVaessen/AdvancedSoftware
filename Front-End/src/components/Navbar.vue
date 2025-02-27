<template>
  <nav class="navbar">
    <!-- Pages in the middle -->
    <div class="nav-links">
      <router-link to="/" class="nav-link">Home</router-link>
      <router-link to="/register" class="nav-link">Register</router-link>
      <router-link to="/contact" class="nav-link">Contact</router-link>
      <!-- Add more pages here -->
    </div>

    <!-- Login/Logout button on the far right -->
    <div class="auth-action">
      <button v-if="!isLoggedIn" @click="handleLogin">Login</button>
      <button v-if="isLoggedIn" @click="handleLogout">Logout</button>
    </div>
  </nav>
</template>

<script>
import {computed } from 'vue';
import { useAuthStore } from '@/stores/authStore';  // Import the Pinia store
import {logout } from '@/Services/AuthService.js';
import router from "@/router/index.js";  // Import auth service

export default {
  name: 'Navbar',
  setup() {
    const authStore = useAuthStore();  // Pinia store
    const isLoggedIn = computed(() => !!authStore.token); // Check if the user is logged in

    const handleLogin = () => {
      router.push('/login');  // Example if you have a login page
    };

    const handleLogout = async () => {
      try {
        await logout();  // Log out the user
        console.log('User logged out');
      } catch (error) {
        console.error('Logout failed:', error);
      }
    };

    return {
      isLoggedIn,
      handleLogin,
      handleLogout,
    };
  },
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background-color: #333;
  color: white;
}

.nav-links {
  display: flex;
  gap: 1rem;
}

.nav-link {
  text-decoration: none;
  color: white;
  font-size: 1.2rem;
}

.nav-link:hover {
  text-decoration: underline;
}

.auth-action button {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 1rem;
}

.auth-action button:hover {
  background-color: #45a049;
}

.auth-action button:focus {
  outline: none;
}
</style>
