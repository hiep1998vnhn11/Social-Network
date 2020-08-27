import Vue from 'vue'
import VueRouter from 'vue-router'
import About from '@/views/about/Index'
import App from '@/views/app/Index'
import Login from '@/components/User/Login'
import Register from '@/components/User/Register'
import Profile from '@/components/User/Profile'
import Logout from '@/components/User/Logout'
import Home from '@/components/Home/Home'
import FOF from '@/views/404/Index'
import Post from '@/components/Post/Post'
import Message from '@/components/Message/Message'
import MyProfile from '@/components/User/MyProfile'
import Test from '@/components/Test'

Vue.use(VueRouter)

  const routes = [
    { path: '/about', component: About },
    { path: '/', component: App, name: 'App', meta: {
      requiresVisitor: true
    }},
    { path: '/home', component: Home, name: 'Home', meta: {
      requiresAuth: true
    }},
    { path: '/login', component: Login, name: 'Login', meta: {
      requiresVisitor: true
    }},
    { path: '/logout', component: Logout},
    { path: '/register', component: Register, name: 'Register', meta: {
      requiresVisitor: true
    }},
    { path: '/user/:url', name: 'User_profile', component: Profile
    },
    {
      path: '/post/:post_id', name: 'Param_Post', component: Post
    },
    {
      path: '/message', name: 'Message', component: Message, meta: {
        requiresAuth: true
      }
    },
    {
      path: '/myprofile', name: 'MyProfile', component: MyProfile, meta: {
        requiresAuth: true
      }
    },
    {
      path: '/test', name: 'Test', component: Test
    },
    { path: '*', name: 'FOF', component: FOF}
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
