<template>
  <h1>Latest Posts</h1>

  <div v-if="loading" class="loading">Loading posts...</div>
  <div v-else>
    <div v-if="posts.length > 0">
      <div v-for="post in posts" :key="post.id" class="thread">
        <img :src="post.image_url" alt="Post Image" class="avatar" />
        <router-link :to="'/post/' + post.id" class="thread-title">
          {{ post.title }}
        </router-link>
      </div>

      <!-- Pagination Controls -->
      <div class="pagination">
        <button @click="changePage(currentPage - 1)" :disabled="!prevPageUrl">Previous</button>
        <span>Page {{ currentPage }} of {{ lastPage }}</span>
        <button @click="changePage(currentPage + 1)" :disabled="!nextPageUrl">Next</button>
      </div>
    </div>

    <div v-else class="no-posts">
      <p>No posts available.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getPosts } from '@/Services/postService.js'

const posts = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const prevPageUrl = ref(null);
const nextPageUrl = ref(null);
const loading = ref(true);

const fetchPosts = async (page = 1) => {
  loading.value = true;
  try {
    const response = await getPosts(`10?page=${page}`);

    posts.value = response.data.data;
    currentPage.value = response.data.current_page;
    lastPage.value = response.data.last_page;
    prevPageUrl.value = response.data.prev_page_url;
    nextPageUrl.value = response.data.next_page_url;
  } catch (error) {
    console.error("Error fetching posts:", error);
  } finally {
    loading.value = false;
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= lastPage.value) {
    fetchPosts(page);
  }
};

onMounted(() => {
  fetchPosts();
});
</script>

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

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 16px;
  margin-top: 16px;
}

button {
  background-color: #4a5568;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:disabled {
  background-color: #718096;
  cursor: not-allowed;
}

.loading, .no-posts {
  text-align: center;
  font-size: 18px;
  margin-top: 20px;
}
</style>
