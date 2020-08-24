import Vue from 'vue'
import Vuex from 'vuex'
import User from './modules/user'
import Post from './modules/post'
import Message from './modules/message'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    user: User,
    post: Post,
    message: Message,
  }
})
