import Vue from 'vue'
import Vuex from 'vuex'
import Admin from './modules/admin'
Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    admin: Admin
  }
})
