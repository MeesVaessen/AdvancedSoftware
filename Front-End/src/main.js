import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)
import piniaPersist from 'pinia-plugin-persistedstate';  // Import the persist plugin

const pinia = createPinia();
pinia.use(piniaPersist);
app.use(pinia)

app.use(router)

app.mount('#app')
