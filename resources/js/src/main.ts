import { createApp } from 'vue'
import './main.css'
import App from './App.vue'
import router from './pages/path'

const app = createApp(App)

app.use(router)

app.mount('#app')
