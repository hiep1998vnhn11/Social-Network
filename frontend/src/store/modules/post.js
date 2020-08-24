import axios from 'axios'
import Cookies from 'js-cookie'

const state = {
    posts: [],
    paramPost: null,
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    allPosts: state => state.posts, 
    paramPost: state => state.paramPost
}

const actions = {
    async getPost(context){
        context.state.setHeader()
        let url = '/auth/user/post/get'
        const response = await axios.get(url, {params: {limit: 5, page: 2}});
        context.commit('SET_POST', response.data)
    },
    async getParamPost({ commit, state }, payload){
        state.setHeader()
        let url = '/get_posts'
        const response = await axios.get(url, payload)
        commit('SET_PARAM_POST', response.data.data)

    }
}

const mutations = {
    SET_POST: (state, posts) => state.posts = posts,
    SET_PARAM_POST: (state, paramPost) => state.paramPost = paramPost,

}

export default {
    state,
    getters,
    actions,
    mutations
}