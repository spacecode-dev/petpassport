import Vue from 'vue';
import axios from 'axios';
import querystring from 'querystring';

export default {
    state: {
        status: '',
        user: {},
    },
    getters: {
        user: state => state.user,
        userLoaded: state => !!state.user.id
    },
    actions: {
        USER_REQUEST: ({ commit, dispatch }) => {
            return new Promise((resolve, reject) => {
                commit('USER_REQUEST');
                axios.get('/api/user').then(response => {
                    commit('USER_SUCCESS', response.data.user);
                    commit('PROFILE_SUCCESS', response.data.user.profile);
                    // commit('COUNTERS_UPDATE', response.data.counters);
                    resolve(response);
                })
                .catch(error => {
                    commit('USER_ERROR');
                    dispatch('AUTH_LOGOUT');
                    reject(error);
                });
            });
        },
        USER_UPDATE: ({commit, dispatch}, data) => {
            return axios.put('/api/user', querystring.stringify(data)).then(response => {
                return response.data;
            }).catch(error => {
                return error.response;
            });
        }
    },
    mutations: {
        USER_REQUEST: (state) => {
            state.status = 'loading'
        },
        USER_SUCCESS: (state, user) => {
            state.status = 'success';
            Vue.set(state, 'user', user);
        },
        USER_ERROR: (state) => {
            state.status = 'error';
        },
        USER_UPDATE: (state, user) => {
            Vue.set(state, 'user', user);
        },
        AUTH_LOGOUT: (state) => {
            state.status = '';
            state.user = {};
        }
    }
};
