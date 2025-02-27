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
    const response = await apiService.get('/posts/' + postData.id);
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
