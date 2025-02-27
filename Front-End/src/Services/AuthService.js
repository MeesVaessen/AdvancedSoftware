import { useAuthStore } from '@/stores/authStore';  // Import the Pinia store
import apiService from './apiService';

// Login request
export const login = async (credentials) => {
  try {
    const response = await apiService.post('/auth/login', credentials);

    const token = response.data.token;
    const user = response.data.user;

    const authStore = useAuthStore();
    authStore.setAuthData(token, user);

    return response;
  } catch (error) {
    console.error('Login failed:', error);
    throw error;
  }
};

export const register = async (userData) => {
  try {
    const response = await apiService.post('/auth/register', userData);
    const token = response.data.token;
    const user = response.data.user;

    const authStore = useAuthStore();
    authStore.setAuthData(token, user);

    return response;
  } catch (error) {
    console.error('Registration failed:', error);
    throw error;
  }
};

export const getUserData = async () => {
  try {
    const response = await apiService.get('/auth/user'); // API call to fetch user data
    return response.data;
  } catch (error) {
    console.error('Failed to fetch user data:', error);
    throw error;
  }
};

export const logout = async () => {
  try {
    const response = await apiService.post('/auth/logout'); // API call to log the user out

    const authStore = useAuthStore();
    authStore.logout();

    return response;
  } catch (error) {
    console.error('Logout failed:', error);
    throw error;
  }
};
