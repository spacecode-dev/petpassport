import axios from 'axios';

export default {
    state: {
        request: {},
        videos: [],
        total: 0,
        album: null
    },
    actions: {
        VIDEOS_GET({ state }, params) {
            return new Promise((resolve, reject) => {
                axios.get('/api/videos', {
                    params
                })
                .then(response => {
                    resolve(response.data);
                })
                .catch(err => {
                    reject(err);
                });
            });
        },
        async VIDEOS_LOAD({ dispatch, commit }, request) {
            commit('VIDEOS_BEFORE_LOAD', request);

            const response = await dispatch('VIDEOS_GET', request);

            commit('VIDEOS_LOADED', response);
        },
        async VIDEOS_LOAD_MORE({ state, dispatch, commit }) {
            const response = await dispatch('VIDEOS_GET', {
                ...state.request,
                offset: state.videos.length
            });

            commit('VIDEOS_LOADED_MORE', response);
        },
        VIDEOS_SELECT({ commit }, multiple) {
            return new Promise((resolve, reject) => {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'video/*';
                input.multiple = multiple ? true : false;
                input.style.position = 'fixed';
                input.style.left = '-9999px';
                input.style.top = '-9999px';
                input.onchange = (e) => {
                    resolve(e.target.files);
                };
                document.body.appendChild(input);
                input.click();
            });
        },
        VIDEOS_UPLOAD() {

        },
        async VIDEOS_DELETE({ commit }, id) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/videos/' + id)
                .then(response => {
                    commit('VIDEOS_DELETED', id);
                    resolve(response);
                })
                .catch(err => {
                    reject(err);
                });
            })
        }
    },
    mutations: {
        VIDEOS_BEFORE_LOAD(state, request) {
            state.request = request;
            state.videos = [];
            state.total = 0;
        },
        VIDEOS_LOADED(state, response) {
            state.videos = response.videos;
            state.total = response.total;
        },
        VIDEOS_LOADED_MORE(state, response) {
            state.videos = response.videos.concat(response.videos);
            state.total = response.total;
        },
        VIDEOS_DELETED(state, id) {
            state.videos = state.videos.filter(v => v.id != id);
            state.total--;
            if (state.album) {
                state.album.videos_count--;
            }
        },
        VIDEOS_PREPEND(state, videos) {
            state.videos = videos.concat(state.videos);
            state.total += videos.length;
        },
        VIDEOS_APPEND(state, videos) {
            state.videos = state.videos.concat(videos);
            state.total += videos.length;
        }
    }
}
