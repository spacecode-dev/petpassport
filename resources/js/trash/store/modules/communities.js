import axios from 'axios';
import querystring from 'querystring';

const API_BASE = '/api/communities';

export default {
    state: {
        community: {},
        flags: {},
        counters: {}
    },
    actions: {
        async COMMUNITY_SHOW({ dispatch, commit }, slug) {
            const data = await dispatch('COMMUNITY_GET', {
                slug,
                reason: 'show'
            });

            commit('COMMUNITY_LOADED', data);
        },
        async COMMUNITY_GET({ commit }, request) {
            const params = { ...request };
            delete params.slug;
            return (await axios.get(API_BASE + '/' + request.slug, {
                params
            })).data;
        },
        async COMMUNITY_LIKE({ state, rootState, commit, dispatch }, object_id) {
            await dispatch('LIKE', {
                object_id,
                object_type: 'community'
            });

            if (state.community.id != object_id) return;

            const top_likers = [ ...state.community.top_likers ];
            top_likers.push(rootState.profile.profile);

            commit('COMMUNITY_UPDATE', {
                top_likers,
                likes_count: state.community.likes_count + 1,
                rating: state.community.rating + 1
            });

            commit('COMMUNITY_UPDATE_FLAGS', {
                liked: true
            });
        },
        async COMMUNITY_DISLIKE({ state, rootState, commit, dispatch }, object_id) {
            await dispatch('DISLIKE', {
                object_id,
                object_type: 'community'
            });

            if (state.community.id != object_id) return;

            const top_likers = state.community.top_likers.filter(l => l.user_id != rootState.profile.profile.user_id);
            
            commit('COMMUNITY_UPDATE', {
                top_likers,
                likes_count: state.community.likes_count - 1,
                rating: state.community.rating - 1
            });

            commit('COMMUNITY_UPDATE_FLAGS', {
                liked: false
            });
        },
        async COMMUNITY_JOIN({ state, rootState, commit }, community_id) {
            await axios.post('/api/community_members', {
                community_id
            });

            if (state.community.id != community_id) return;

            const top_members = [ ...state.community.top_members ];
            top_members.push(rootState.profile.profile);

            commit('COMMUNITY_UPDATE', {
                top_members,
                members_count: state.community.members_count + 1,
                rating: state.community.rating + 1
            });

            commit('COMMUNITY_UPDATE_FLAGS', {
                joined: true,
                subscribed: true
            });

            /*
            const profile = rootState.profile.profile;

            if (profile.recommended_groups != 'undefined') {
                const community = profile.recommended_groups.find(c => c.id == community_id);

                if (community) {
                    community.joined = true;
                    commit('PROFILE_SUCCESS', profile);
                }
            }
            */
        },
        async COMMUNITY_LEAVE({ state, rootState, commit }, community_id) {
            await axios.delete('/api/community_members', {
                data: {
                    community_id
                }
            });

            if (state.community.id != community_id) return;

            const top_members = state.community.top_members.filter(m => m.user_id != rootState.profile.profile.user_id);

            commit('COMMUNITY_UPDATE', {
                top_members,
                members_count: state.community.members_count - 1,
                rating: state.community.rating - 1
            });

            commit('COMMUNITY_UPDATE_FLAGS', {
                joined: false,
                subscribed: false
            });
        },
        async COMMUNITY_SUBSCRIBE({ state, commit }, wall_id) {
            await axios.post('/api/user/subscriptions', {
                wall_id,
                wall_type: 'community'
            });

            if (state.community.id != wall_id) return;

            commit('COMMUNITY_UPDATE_FLAGS', {
                subscribed: true
            });
        },
        async COMMUNITY_UNSUBSCRIBE({ state, commit }, wall_id) {
            await axios.delete('/api/user/subscriptions', {
                data: {
                    wall_id,
                    wall_type: 'community'
                }
            });

            if (state.community.id != wall_id) return;

            commit('COMMUNITY_UPDATE_FLAGS', {
                subscribed: false
            });
        }
    },
    mutations: {
        COMMUNITY_LOADED(state, data) {
            for (let photo of data.community.top_photos) {
                photo.owner = {
                    id: data.community.id,
                    name: data.community.name,
                    link: data.community.link,
                    slug: data.community.slug,
                    avatar: data.community.avatar
                };
            }
            state.community = data.community;
            state.flags = data.flags;
            state.counters = data.counters;
        },
        COMMUNITY_UPDATE(state, community) {
            state.community = Object.assign({}, state.community, community);
        },
        COMMUNITY_UPDATE_FLAGS(state, flags) {
            state.flags = Object.assign({}, state.flags, flags);
        },
        COMMUNITY_UPDATE_COUNTERS(state, counters) {
            state.counters = Object.assign({}, state.counters, counters);
        }
    }
}
