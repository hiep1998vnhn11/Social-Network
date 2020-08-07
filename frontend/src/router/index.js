import Vue from 'vue'
import VueRouter from 'vue-router'
import About from '@/views/about/Index'
import Home from '@/views/home/Index'
import Login from '@/components/User/Login'
import Register from '@/components/User/Register'
import Test from '@/views/test/Index'

Vue.use(VueRouter)

  const routes = [
    { path: '/about', component: About },
    { path: '/home', component: Home},
    { path: '/login', component: Login},
    { path: '/register', component: Register},
    { path: '/test', component: Test },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
