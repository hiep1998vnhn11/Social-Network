import Vue from 'vue'
import VueRouter from 'vue-router'
import About from '@/views/about/Index'
import App from '@/views/app/Index'
import Login from '@/pages/Auth/Login'
import Register from '@/pages/Auth/Register'
import Profile from '@/pages/User/Profile'
import Logout from '@/pages/Auth/Logout'
import Home from '@/pages/Home/Home'
import FOF from '@/views/404/Index'
import Post from '@/pages/Post/Post'
import Message from '@/pages/Message/Message'
import MyProfile from '@/pages/User/MyProfile'
import History from '@/components/Navbar/History'

Vue.use(VueRouter)

  const routes = [
    { path: '/about', component: About },
    { path: '/app', component: App, name: 'App', meta: {
      requiresVisitor: true
    }},
    { path: '/', component: Home, name: 'Home', meta: {
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
      path: '/history', name: 'History', component: History
    },
    { path: '*', name: 'FOF', component: FOF}
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
