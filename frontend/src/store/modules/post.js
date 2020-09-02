import axios from 'axios'
import Cookies from 'js-cookie'

const state = {
    posts: [],
    paramPost: null,
    paramUserPost: null,
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    allPosts: state => state.posts, 
    paramPost: state => state.paramPost,
    paramUserPost: state => state.paramUserPost,
}

const actions = {
    async getPost(context){
        context.state.setHeader()
        let url = '/auth/user/post/get'
        const response = await axios.get(url);
        context.commit('SET_POST', response.data)
    },
    // payload: { post_id } => param post only
    async getParamPost({ commit, state }, payload){
        state.setHeader()
        let url = '/get_posts'
        const response = await axios.get(url, payload)
        commit('SET_PARAM_POST', response.data.data)

    },
    // payload: { user_id } => posts for params user]
    async getParamUserPost( {commit, state}, payload){
        state.setHeader()
        let url = '/get_posts'
        const response = await axios.get(url, payload)
        commit('SET_PARAM_USER_POST', response.data.data.data)
    }
}

const mutations = {
    SET_POST: (state, posts) => state.posts = posts,
    SET_PARAM_POST: (state, paramPost) => state.paramPost = paramPost,
    SET_PARAM_USER_POST: (state, paramUserPost) => state.paramUserPost = paramUserPost
}

export default {
    state,
    getters,
    actions,
    mutations
}