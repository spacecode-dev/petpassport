import axios from 'axios';
import querystring from 'querystring';

export default {
    state: {
        token: '',
        status: ''
    },
    getters: {
        authenticated: state => !!state.token
    },
    actions: {
        AUTH_REQUEST: ({ commit, dispatch }, credentials) => {
            return new Promise((resolve, reject) => {
                commit('AUTH_REQUEST');
                axios.post('/api/auth/login', querystring.stringify(credentials))
                .then(resp => {
                    dispatch('AUTH_SET_TOKEN', resp.data.token);
                    resolve(resp);
                })
                .catch(err => {
                    commit('AUTH_ERROR', err);
                    //localStorage.removeItem('token');
                    reject(err);
                });
            });
        },
        AUTH_SET_TOKEN: ({ commit, dispatch }, token) => {
            return new Promise((resolve, reject) => {
                //localStorage.setItem('token', token);
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                window.Echo.connector.pusher.config.auth.headers['Authorization'] = 'Bearer ' + token;
                commit('AUTH_SUCCESS', token);
                dispatch('USER_REQUEST');
                resolve();
            });
        },
        AUTH_LOGOUT: ({ commit, dispatch }) => {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/logout')
                .then(resp => {
                    commit('AUTH_LOGOUT');
                    //localStorage.removeItem('token');
                    resolve(resp);
                })
                .catch(err => {
                    //localStorage.removeItem('token');
                    reject(err);
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
            //state.hasLoadedOnce = true;
        },
        AUTH_ERROR: (state) => {
            state.status = 'error';
            //state.hasLoadedOnce = true;
        },
        AUTH_LOGOUT: (state) => {
            state.status = '';
            state.token = '';
        }
    }
}
