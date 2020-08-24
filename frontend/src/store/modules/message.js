import axios from 'axios'
import Cookies from 'js-cookie'

const state = {
    message: [],
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    message: state => state.message
}

const actions = {
    async getMessage({commit, state}, payload){
        state.setHeader()
        let url = '/auth/get_messages'
        const messageResponse = await axios.get(url, payload)
        console.log(messageResponse)
        commit ('SET_MESSAGE', messageResponse.data.data)
    }
}

const mutations = {
    SET_MESSAGE: (state, message) => state.message = message
}

export default {
    state,
    getters,
    actions,
    mutations
}