import Vue from 'vue'
import VueRouter from 'vue-router'
import About from '@/views/About'
import Home from '@/views/home/Index.vue'
import Login from '@/components/User/Login'
import Register from '@/components/User/Register'

Vue.use(VueRouter)

  const routes = [
    { path: '/about', component: About },
    { path: '/home', component: Home},
    { path: '/login', component: Login},
    { path: '/register', component: Register},
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
