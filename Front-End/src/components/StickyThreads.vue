<script setup>
import { ref } from 'vue';

const threads = ref([
  { id: 1, title: "Vue 3 vs React", author: "User123", date: "March 10, 2025", image: "https://placehold.co/40" },
  { id: 2, title: "Best practices for Vue 3", author: "DevMaster", date: "March 11, 2025", image: "https://placehold.co/40" },
  { id: 3, title: "Pinia vs Vuex", author: "CoderX", date: "March 12, 2025", image: "https://placehold.co/40" }
]);
</script>

<template>
  <h1>Stickied Threads</h1>
  <div v-for="thread in threads" :key="thread.id" class="thread">
    <img :src="thread.image" alt="User Avatar" class="avatar" />
    <router-link :to="'/thread/' + thread.id" class="thread-title">
      {{ thread.title }}
    </router-link>
  </div>
</template>

<style scoped>
.thread {
  background-color: #2d3748;
  padding: 16px;
  margin-bottom: 16px;
  border-radius: 8px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  width: 100%;
}

.avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  margin-right: 16px;
}

.thread-title {
  font-size: 18px;
  font-weight: 600;
  text-decoration: none;
  color: white;
  flex-grow: 1;
}

.thread-title:hover {
  text-decoration: underline;
}
</style>
