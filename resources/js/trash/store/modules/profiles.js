import Vue from 'vue';
import NProgress from 'nprogress';
import axios from 'axios';
import * as _ from 'lodash';

const API_BASE = '/api/profiles';

export default {
    state: {
        //profiles: [],
        profile: {},
        flags: {},
        counters: {}
    },
    getters: {
        /*
        profileBySlug: state => slug => {
            return state.profiles.find(p => p.profile.slug == slug)
        },
        profileById: state => id => {
            return state.profiles.find(p => p.profile.user_id == id);
        }
        */
    },
    actions: {
        async PROFILE_SHOW({ dispatch, commit }, slug) {
            const data = await dispatch('PROFILE_GET', {
                slug,
                reason: 'show'
            });

            commit('PROFILE_LOADED', data);
        },
        async PROFILE_GET({ state, dispatch }, request) {
            const params = { ...request };
            delete params.slug;
            return (await axios.get(API_BASE + '/' + request.slug, {
                params
            })).data;
        },
        /*
        PROFILE_GET({ state, dispatch }, slug) {
            return new Promise((resolve, reject) => {
                const profile = state.profiles.find(p => p.profile.slug == slug);

                if (profile) {
                    resolve(profile);
                    // Updating profile in background
                    dispatch('PROFILE_LOAD', slug);
                    return;
                }

                NProgress.start();
                dispatch('PROFILE_LOAD', slug)
                .then(profile => {
                    resolve(profile);
                    NProgress.done();
                })
                .catch(resp => {
                    reject(resp);
                    NProgress.done();
                })
                /* safari unsupported
                .finally(() => {
                    NProgress.done();
                });
                * /
            });
        },
        PROFILE_LOAD({ commit }, slug) {
            return new Promise((resolve, reject) => {
                axios.get('/api/profiles/' + slug)
                .then(resp => {
                    commit('PROFILE_CACHE', resp.data);
                    resolve(resp.data);
                })
                .catch(resp => {
                    reject(resp);
                });
            });
        }
        */
    },
    mutations: {
        PROFILE_LOADED(state, data) {
            for (let photo of data.profile.top_photos) {
                photo.owner = {
                    user_id: data.profile.user_id,
                    name: data.profile.name,
                    link: data.profile.link,
                    slug: data.profile.slug,
                    avatar: data.profile.avatar
                };
            }
            state.profile = data.profile;
            state.flags = data.flags;
            state.counters = data.counters;
        },
        PROFILE_UPDATE(state, profile) {
            state.profile = Object.assign({}, state.profile, profile);
        },
        PROFILE_UPDATE_FLAGS(state, flags) {
            state.flags = Object.assign({}, state.flags, flags);
        },
        PROFILE_UPDATE_COUNTERS(state, counters) {
            state.counters = Object.assign({}, state.counters, counters);
        }

        /*
        PROFILE_CACHE(state, profile) {
            const index = state.profiles.findIndex(p => p.profile.user_id == profile.profile.user_id);
            if (index != -1) {
                Vue.set(state.profiles, index, profile);
            } else {
                state.profiles.push(profile);
            }
        },
        PROFILE_CACHE_UPDATE(state, payload) {
            const id = payload.id || payload.profile.user_id;
            const index = state.profiles.findIndex(p => p.profile.user_id == id);
            if (index != -1) {
                let profile = state.profiles[index];
                profile = {
                    ...profile,
                    ...payload
                };
                Vue.set(state.profiles, index, profile);
            }
        },
        PROFILE_CACHE_UPDATE_PARTIAL(state, id, payload) {
            const profile = state.profiles.find(p => p.profile.user_id == id);

            if (profile) {
                _.merge(profile, payload);
            }
        }
        */
    }
}
