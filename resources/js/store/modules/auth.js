import axios from 'axios';
import querystring from 'querystring';

export default {
    state: {
        status: '',
        token: ''
    },
    getters: {
        authenticated: state => !!state.token
    },
    actions: {
        AUTH_REQUEST: ({ commit, dispatch }, credentials) => {
            return new Promise((resolve, reject) => {
                commit('AUTH_REQUEST');
                axios.post('/api/auth/login', querystring.stringify(credentials))
                .then(response => {
                    dispatch('AUTH_SET_TOKEN', response.data.token);
                    resolve(response);
                }).catch(error => {
                    commit('AUTH_ERROR', error);
                    reject(error);
                });
            });
        },
        AUTH_REGISTER: ({ commit, dispatch }, credentials) => {
            return new Promise((resolve, reject) => {
                commit('AUTH_REQUEST');
                axios.post('/api/auth/register', querystring.stringify(credentials))
                .then(response => {
                    dispatch('AUTH_SET_TOKEN', response.data.token);
                    resolve(response);
                }).catch(error => {
                    commit('AUTH_ERROR', error);
                    reject(error);
                });
            });
        },
        AUTH_SET_TOKEN: ({ commit, dispatch }, token) => {
            return new Promise((resolve, reject) => {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                // window.Echo.connector.pusher.config.auth.headers['Authorization'] = 'Bearer ' + token;
                commit('AUTH_SUCCESS', token);
                dispatch('USER_REQUEST');
                resolve();
            });
        },
        AUTH_LOGOUT: ({ commit, dispatch }) => {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/logout')
                .then(response => {
                    commit('AUTH_LOGOUT');
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            })
        }
    },
    mutations: {
        AUTH_REQUEST: (state) => {
            state.status = 'loading';
        },
        AUTH_SUCCESS: (state, token) => {
            state.status = 'success';
            state.token = token;
        },
        AUTH_ERROR: (state) => {
            state.status = 'error';
        },
        AUTH_LOGOUT: (state) => {
            state.status = '';
            state.token = '';
        }
    }
}
