<template>
  <div>
    <h1>Login</h1>
    <form @submit.prevent="handleLogin">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import { login } from '@/Services/authService.js'; // Import the login method from authService

export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async handleLogin() {
      try {
        await login({ email: this.email, password: this.password });
        this.$router.push('/dashboard');
      } catch (error) {
        console.error('Login failed:', error);
        // Optionally handle the error (e.g., show a message to the user)
      }
    },
  },
};
</script>
