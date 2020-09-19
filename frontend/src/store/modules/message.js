import axios from 'axios'
import Cookies from 'js-cookie'

const state = {
    messages: [],
    rooms: [],
    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer' + Cookies.get('access_token')
    }
}

const getters = {
    messages: state => state.messages,
    rooms: state => state.rooms
}

const actions = {
    async getMessage({commit}, payload){
        let url = `/auth/user/room/${payload.room_id}/get`
        const messageResponse = await axios.post(url, payload)
        commit ('SET_MESSAGE', messageResponse.data.data)
    },

    async getRoom( {commit}, payload){
        const url = '/auth/user/rooms'
        const roomResponse = await axios.post(url,payload)
        commit('SET_ROOM', roomResponse.data.data)
    },

}

const mutations = {
    SET_MESSAGE: (state, messages) => state.messages = messages,
    SET_ROOM: (state, rooms) =>state.rooms = rooms
}

export default {
    state,
    getters,
    actions,
    mutations
}