import apiService from './apiService';

// Login request
export const createPost = async (postData) => {
  try {
    const response = await apiService.post('/posts/create', postData);
    console.log(response);
    return response;
  } catch (error) {
    console.error('Post creation failed:', error);
    throw error;
  }
};

export const getPost = async (postData) => {
  try {
    const response = await apiService.get('/posts/getPost/' + postData);
    console.log(response);
    return response;
  } catch (error) {
    console.error('Post creation failed:', error);
    throw error;
  }
};

export const getPosts = async (paginate) => {
  try {
    const response = await apiService.get('/posts/' + paginate);
    console.log(response);
    return response;
  } catch (error) {
    console.error('Post creation failed:', error);
    throw error;
  }
};

export const likePost = async (postId) => {
  try {
    const response = await apiService.get(`/posts/${postId}/like`);
    console.log(response);
    return response;
  } catch (error) {
    console.error('Post like failed:', error);
    throw error;
  }

}

export const dislikePost = async (postId) => {
  try {
    const response = await apiService.get(`/posts/${postId}/dislike`);
    console.log(response);
    return response;
  } catch (error) {
    console.error('Post like failed:', error);
    throw error;
  }

}
