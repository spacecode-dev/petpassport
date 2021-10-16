import Vue from 'vue';
import axios from 'axios';
import querystring from 'querystring';
import store from '../../store';

export default {
    state: {
        status: '',
        profile: {}
    },
    getters: {
        selfProfile: state => state.profile,
        selfProfileLoaded: state => !!state.profile.user_id
    },
    actions: {
        PROFILE_REQUEST: ({ commit, dispatch }) => {
            return new Promise((resolve, reject) => {
                commit('PROFILE_REQUEST');
                axios.get('/api/user/profile')
                .then(resp => {
                    commit('PROFILE_SUCCESS', resp.data);
                    resolve(resp);
                })
                .catch(resp => {
                    commit('PROFILE_ERROR');
                    // if resp is unauthorized, logout, to
                    dispatch('AUTH_LOGOUT');
                    reject(resp);
                });
            });
        },
        PROFILE_UPDATE: ({ commit, dispatch }, data) => {
            return new Promise((resolve, reject) => {
                const bool = [
                    'mating',
                    'info_hidden',
                    'noavatar',
                    'memory'
                ];
                for (const prop in data) {
                    if (bool.includes(prop)) {
                        data[prop] = +data[prop];
                    }
                }

                axios.put('/api/user/profile', querystring.stringify(data))
                .then(resp => {
                    commit('PROFILE_SUCCESS', resp.data);
                    commit('PROFILE_UPDATE', resp.data);
                    // TODO: cache clean
                    //commit('PROFILE_CACHE_UPDATE', {
                    //    profile: resp.data
                    //});
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
            });
        }
    },
    mutations: {
        PROFILE_REQUEST: (state) => {
            state.status = 'loading'
        },
        PROFILE_SUCCESS: (state, profile) => {
            state.status = 'success';
            Vue.set(state, 'profile', profile);
        },
        PROFILE_ERROR: (state) => {
            state.status = 'error';
        },
        PROFILE_SELF_UPDATE(state, profile) {
            state.profile = {
                ...state.profile,
                ...profile
            };
        },
        AUTH_LOGOUT: (state) => {
            state.status = '';
            state.profile = {};
        }
    }
};
