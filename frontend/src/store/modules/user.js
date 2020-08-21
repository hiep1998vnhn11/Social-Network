import axios from 'axios'
import Cookies from 'js-cookie'
import Vue from 'vue'


const state = {
    users: [],
    currentUser: null,
    paramUser: null,
    token: Cookies.get('access_token') || null,
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    allUser: state => state.users,
    currentUser: state => state.currentUser,
    paramUser: state => state.paramUser,
    loggedIn(state){
        return state.token !== null
    }
}

const actions = {
    async fetchUser(context){
        const response = await axios.get('/get_users');
        context.commit('SET_USER', response.data.data)
    },
    async getParamUser({commit}, payload){
        let url = '/get_users'
        const response = await axios.get(url, payload)
        commit('SET_PARAM_USER', response.data.data)
    },
    async getCurrentUser(context){
        context.state.setHeader()
        const currentUserApi = await axios.post('/auth/me')
        context.commit('SET_CURRENT_USER', currentUserApi.data)
    },
    async login(context, user){
        try{
            const auth = await axios.post('/auth/login', {
                email: user.email,
                password: user.password
            })
            const token = auth.data.access_token
            axios.defaults.headers.common['Authorization'] = 'Bearer' + token
            const UserApi = await axios.post('/auth/me')
            Cookies.set('access_token', token)
            context.commit('RETRIEVE_TOKEN', token) 
            context.commit('SET_CURRENT_USER', UserApi.data)
        } catch(err){
            Vue.swal({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
            })
        }
    },

    async register(context, data){
        const authRegister = await axios.post('/register', {
            name: data.name,
            email: data.email,
            password: data.password,
            password_confirmation: data.password_confirmation
        })
        console.log(authRegister)
    },

    async deleteUser(context, idUser){
        context.state.setHeader()
        const deleteUserApi = await axios.post(`/admin/delete/${idUser}`)
        console.log(deleteUserApi.data)
        context.commit('REMOVE_USER', idUser)
    },

    destroyToken(context){
        context.state.setHeader()
        if(context.getters.loggedIn){
            return new Promise((resolve, reject) => {
                axios.post('/auth/logout')
                .then(response => {
                    Cookies.remove('access_token')
                    context.commit('DESTROY_TOKEN')
                    resolve(response)
                    // console.log(token)
                    //console.log(response);
                })
                .catch(error => {
                    // console.log(error);
                    Cookies.remove('access_token')
                    context.commit('DESTROY_TOKEN')
                    reject(error)
                })
            })
        }
    }
}

const mutations = {
    SET_CURRENT_USER: (state, currentUser) => state.currentUser = currentUser,
    RETRIEVE_TOKEN: (state, token) => state.token = token,
    DESTROY_TOKEN: (state) => {
        state.token = null,
        state.currentUser = null,
        state.users = []
    },
    SET_USER: (state, users) => (state.users = users),
    SET_PARAM_USER: (state, paramUser) => (state.paramUser = paramUser),
    REMOVE_USER: (state, idUser) => state.users = state.users.filter(users=>users.id!=idUser)
}
export default{
    state,
    getters,
    actions,
    mutations

}