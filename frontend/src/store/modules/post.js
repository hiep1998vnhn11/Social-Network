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
        commit('SET_PARAM_USER_POST', response.data.data)
    },
    async createPost({commit}, payload) {
        const url = "/auth/user/post/create";
        const response = await axios.post(url, payload)
        commit('CREATE_POST', response.data.data)    
    },
    async deletePost( {commit}, payload){
        const url = `/auth/user/post/${payload.post_id}/delete`
        const response = await axios.post(url)
        console.log(response)
        commit('DELETE_POST', payload.post_id)
    }
}

const mutations = {
    SET_POST: (state, posts) => state.posts = posts,
    SET_PARAM_POST: (state, paramPost) => state.paramPost = paramPost,
    SET_PARAM_USER_POST: (state, paramUserPost) => state.paramUserPost = paramUserPost,
    CREATE_POST: (state, post) => state.posts.data.unshift(post),
    DELETE_POST: (state, postId) => state.posts.data = state.posts.data.filter( data =>  data.id != postId)
}

export default {
    state,
    getters,
    actions,
    mutations
}