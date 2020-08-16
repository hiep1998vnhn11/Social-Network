import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import i18n from './lang/i18n'
import Cookies from 'js-cookies'
import axios from 'axios'


Vue.config.productionTip = false
Vue.use(Cookies)

axios.defaults.baseURL = 'http://dev.socialnetwork.api.com/api'

 new Vue({
  router,
  store,
  i18n,
  vuetify,
  render: h => h(App)
}).$mount('#app')