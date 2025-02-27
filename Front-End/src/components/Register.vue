<template>
  <div>
    <h1>Register</h1>
    <form @submit.prevent="handleRegister">
      <input v-model="name" type="text" placeholder="Name" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import { register } from '@/Services/AuthService';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
    };
  },
  methods: {
    async handleRegister() {
      try {
        await register({name: this.name, email: this.email, password: this.password });
        this.$router.push('/dashboard');
      } catch (error) {
        console.error('Registration failed:', error);
        // Optionally handle the error (e.g., show a message to the user)
      }
    },
  },
};
</script>
