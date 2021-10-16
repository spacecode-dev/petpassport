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
                axios.get('/api/user')
                .then(resp => {
                    commit('USER_SUCCESS', resp.data.user);
                    commit('PROFILE_SUCCESS', resp.data.profile);
                    commit('COUNTERS_UPDATE', resp.data.counters);
                    resolve(resp);
                })
                .catch(resp => {
                    commit('USER_ERROR');
                    // if resp is unauthorized, logout, to
                    dispatch('AUTH_LOGOUT');
                    reject(resp);
                });
            });
        },
        USER_UPDATE:  ({commit, dispatch}, data, successCallback, failCallback) => {
            return axios.put('/api/user', querystring.stringify(data))
                .then(response => {
                    return response.data;
                })
                .catch(error => {
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
