import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import Cookies from 'js-cookie'

import './plugins'

Vue.config.productionTip = false
Vue.use(Cookies)

axios.defaults.baseURL = 'http://dev.socialnetwork.api.com/api'

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)){
    if(!store.getters.loggedIn) { 
      next({
        name:'Login',
      })
    } else {
      next()
    }
  } else if(to.matched.some(record => record.meta.requiresVisitor)){
    if(store.getters.loggedIn) { 
      next({
        name:'Profile',
      })
    } else {
      next()
    }
  }
   else {
    next()
  }
})

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
