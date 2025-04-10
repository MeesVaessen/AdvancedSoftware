<template>
  <div class="post-detail">
    <!-- Post Title -->
    <h1 class="post-title">{{ post.title }}</h1>

    <!-- Post Body -->
    <div class="post-body-box">
      <p class="post-body">{{ post.body }}</p>

      <div class="reaction-buttons">
        <!-- Like Button with dynamic count -->
        <button class="like" @click="handleLikePost">👍 Like ({{ post.likes }})</button>

        <!-- Dislike Button with dynamic count -->
        <button class="dislike" @click="handleDislikePost">👎 Dislike ({{ post.dislikes }})</button>
      </div>
    </div>

    <!-- Placeholder for Comments -->
    <div class="comments-section">
      <h2>Comments</h2>
      <p>Comments will be displayed here once implemented.</p>
    </div>
  </div>
</template>



<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getPost, likePost, dislikePost } from '@/Services/postService.js'

const post = ref({
  title: '',
  body: '',
  likes: 0,
  dislikes: 0
});
const route = useRoute();

const fetchPost = async () => {
  try {
    const response = await getPost(`${route.params.id}`);
    console.log(response.data);
    post.value = {
      ...response.data,
      likes: response.data.likes || 0,
      dislikes: response.data.dislikes || 0
    };
  } catch (error) {
    console.error("Error fetching post:", error);
  }
};

const handleLikePost = async () => {
  try {
    const response = await likePost(`${route.params.id}`);
    post.value.likes = response.data[0].Likes || 0;
    post.value.dislikes = response.data[0].Dislikes || 0;

  } catch (error) {
    console.error("Error liking post:", error);
  }
};

const handleDislikePost = async () => {
  try {
    const response = await dislikePost(`${route.params.id}`);
    post.value.likes = response.data[0].Likes || 0;
    post.value.dislikes = response.data[0].Dislikes || 0;
  } catch (error) {
    console.error("Error disliking post:", error);
  }
};

onMounted(() => {
  fetchPost();
});
</script>


<style scoped>
.post-detail {
  padding: 20px;
  max-width: 800px;
  margin: 0 auto;
}

.post-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
}

.post-body-box {
  background-color: #f7fafc; /* Lighter background */
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  position: relative;
}

.post-body {
  font-size: 1.1rem;
  color: #333;
}

.reaction-buttons {
  position: absolute;
  bottom: 10px;
  right: 10px;
  display: flex;
  gap: 10px;
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

.comments-section {
  margin-top: 40px;
  background-color: #e2e8f0; /* Light gray */
  padding: 20px;
  border-radius: 8px;
}
</style>
