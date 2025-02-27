import axios from 'axios';
import { useAuthStore } from '@/stores/authStore'; // Import the Pinia store

// Base URL for your authentication microservice
const API_URL = 'http://localhost:8080/api';

const apiService = axios.create({
  baseURL: API_URL,
  timeout: 10000, // Optional: Specify a timeout for the request
  headers: {
    'Content-Type': 'application/json',
  },
});

apiService.interceptors.request.use(
  (config) => {
    const authStore = useAuthStore();
    const token = authStore.token;
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

apiService.interceptors.response.use(
  (response) => response,
  (error) => {
    const authStore = useAuthStore();

    if (error.response && error.response.status === 401) {
      authStore.logout();
      window.location.href = '/login';
    }

    if (error.response && error.response.status === 500) {
      console.error('Server error, please try again later.');
    }

    return Promise.reject(error);
  }
);

export default apiService;
