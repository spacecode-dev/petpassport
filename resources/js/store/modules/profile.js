import Vue from 'vue';
import axios from 'axios';
import querystring from 'querystring';

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
                axios.get('/api/user/profile').then(response => {
                    commit('PROFILE_SUCCESS', response.data);
                    resolve(response);
                }).catch(error => {
                    commit('PROFILE_ERROR');
                    dispatch('AUTH_LOGOUT');
                    reject(error);
                });
            });
        },
        PROFILE_UPDATE: ({ commit, dispatch }, data) => {
            return new Promise((resolve, reject) => {
                // const bool = [
                //     'mating',
                //     'info_hidden',
                //     'noavatar',
                //     'memory'
                // ];
                // for (let prop in data) {
                //     if (bool.includes(prop)) {
                //         data[prop] = +data[prop];
                //     }
                // }
                axios.put('/api/user/profile', querystring.stringify(data)).then(response => {
                    commit('PROFILE_SUCCESS', response.data.user.profile);
                    commit('PROFILE_UPDATE', response.data.user.profile);
                    // TODO: cache clean
                    //commit('PROFILE_CACHE_UPDATE', {
                    //    profile: response.data
                    //});
                    resolve(response.data);
                }).catch(error => {
                    reject(error);
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
