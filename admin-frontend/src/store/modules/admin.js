import axios from 'axios'
import Cookies from 'js-cookie'

const state = {
    users: [],
    token: Cookies.get('access_token') || null,
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    allUser: state => state.users,
    currentUser: state => state.currentUser,
    loggedIn(state){
        return state.token !== null
    }
}

const actions = {
    async fetchUser(context){
        context.state.setHeader()
        const response = await axios.post('/admin/users');
        context.commit('SET_USER', response.data)
    },
    async login(context, user){
        try{
            const auth = await axios.post('/auth/login', {
                email: user.email,
                password: user.password
            })
            const token = auth.data.access_token
            axios.defaults.headers.common['Authorization'] = 'Bearer' + token
            const UserApi = await axios.get('/user')
            Cookies.set('access_token', token)
            context.commit('RETRIEVE_TOKEN', token) 
            context.commit('SET_CURRENT_USER', UserApi.data)
        } catch(err){
            alert('Email and Password you entered did not match our record! Please check and try again!')
        }
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
                axios.get('/auth/logout')
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
    RETRIEVE_TOKEN: (state, token) => state.token = token,
    DESTROY_TOKEN: (state) => {
        state.token = null,
        state.currentUser = null,
        state.users = []
    },
    SET_USER: (state, users) => (state.users = users),
    REMOVE_USER: (state, idUser) => state.users = state.users.filter(users=>users.id!=idUser)
}
export default{
    state,
    getters,
    actions,
    mutations

}