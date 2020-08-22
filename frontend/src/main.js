import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import axios from 'axios'
import Cookies from 'js-cookie'
import VueSweetalert2 from 'vue-sweetalert2'
import i18n from './lang/i18n'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import VueFilterDateFormat from 'vue-filter-date-format';




import './plugins'

Vue.config.productionTip = false
Vue.use(Cookies)
Vue.use(VueSweetalert2)
Vue.use(Datetime)
Vue.use(VueFilterDateFormat, {
  dayOfWeekNames: [
    'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',
    'Friday', 'Saturday'
  ],
  dayOfWeekNamesShort: [
    'Su', 'Mo', 'Tu', 'We', 'Tr', 'Fr', 'Sa'
  ],
  monthNames: [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
  ],
  monthNamesShort: [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
  ]
});

Vue.component('datetime', Datetime);



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
  i18n,
  vuetify,
  render: h => h(App)
}).$mount('#app')
