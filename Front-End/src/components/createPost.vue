<template>
  <div>
    <h1>Create Post</h1>
    <form @submit.prevent="handlePost">
      <input v-model="title" type="text" placeholder="post title" required />
      <input v-model="body" type="text" placeholder="post body" required />
      <button type="submit">create post</button>
    </form>
  </div>
</template>

<script>
import { createPost } from '@/Services/postService.js';

export default {
  data() {
    return {
      title: '',
      body: '',
    };
  },
  methods: {
    async handlePost() {
      try {
        await createPost({title: this.title, body: this.body });
        this.$router.push('/dashboard');
      } catch (error) {
        console.error('post failed:', error);
        // Optionally handle the error (e.g., show a message to the user)
      }
    },
  },
};
</script>
