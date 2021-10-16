import axios from 'axios';
import querystring from 'querystring';

export default {
    state: {
        request: {},
        posts: []
    },
    getters: {
        posts: state => state.posts
    },
    actions: {
        POSTS_GET({commit}, request) {
            return new Promise((resolve, reject) => {
                axios.get('/api/posts?' + querystring.stringify(request)).then(response => {
                    const posts = response.data;
                    commit('POSTS_SUCCESS', {request, posts});
                    resolve(posts);
                }).catch(response => {
                    reject(response);
                });
            });
        },
        POSTS_GET_MORE({commit, state}) {
            return new Promise((resolve, reject) => {
                const offset = state.posts.length;
                axios.get('/api/posts?' + querystring.stringify({...state.request, offset})).then(response => {
                    const posts = response.data;
                    commit('POSTS_SUCCESS_MORE', posts);
                    resolve(posts);
                }).catch(response => {
                    reject(response);
                });
            });
        }
    },
    mutations: {
        POSTS_SUCCESS(state, payload) {
            state.request = payload.request
            state.posts = payload.posts;
        },
        POSTS_SUCCESS_MORE(state, posts) {
            state.posts.concat(posts);
        },
        POSTS_UNSHIFT(state, post) {
            state.posts.unshift(post);
        },
        POSTS_UPDATE(state, payload) {
            const post = state.posts.find(p => p.id === payload.id);
            Object.assign(post, payload);
        },
        POSTS_DELETE(state, id) {
            state.posts = state.posts.filter(p => p.id !== id);
        }
    }
};
