<template>
  <div class="container">
    <div class="content">
    <StickyThreads/>

      <PostPaginator/>
    </div>
  </div>
</template>

<script setup>

import StickyThreads from '@/components/StickyThreads.vue'
import PostPaginator from '@/components/PostPaginator.vue'
</script>

<style scoped>
.container {
  background-color: #1a202c;
  min-height: 100vh;
  color: white;
  padding: 24px;
  display: flex;
  justify-content: center;
}

.content {
  width: 60%;
}
</style>
