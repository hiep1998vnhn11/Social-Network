import Vue from 'vue'
import VueRouter from 'vue-router'
import About from '@/views/about/Index'
import Home from '@/views/home/Index'
import Login from '@/components/User/Login'
import Register from '@/components/User/Register'
import Test from '@/views/test/Index'
import Profile from '@/components/User/Profile'
import Logout from '@/components/User/Logout'

Vue.use(VueRouter)

  const routes = [
    { path: '/about', component: About },
    { path: '/home', component: Home},
    { path: '/login', component: Login, name: 'Login',
    meta: {
      requiresVisitor: true
    }},
    { path: '/logout', component: Logout},
    { path: '/register', component: Register},
    { path: '/test', component: Test },
    { 
      path: '/profile',
      name: 'Profile',
      component: Profile, 
      meta: {
        requiresAuth: true
      }
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
