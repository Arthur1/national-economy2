import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isInitialized: false,
        userID: null,
        name: null,
    },
    mutations: {
        login(state, data) {
            state.userID = data.id
            state.name = data.name
        },
        logout(state) {
            state.userID = null
            state.name = null
        },
        initialize(state) {
            state.isInitialized = true
        }
    },
    actions: {
        setUser: function({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/users/me').then(res => {
                    commit('login', res.data)
                    commit('initialize')
                    resolve(res)
                }).catch(err => {
                    commit('logout')
                    commit('initialize')
                    resolve(err)
                })
            })
        }
    },
    getters: {
        isLoggedIn: state => Boolean(state.userID && state.name)
    }
})
