import axios from 'axios';

export default {
    actions: {
        COMMENTS_GET({ state }, params) {
            return new Promise((resolve, reject) => {
                axios.get('/api/comments', {
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
        COMMENTS_STORE({ state }, request) {
            return new Promise((resolve, reject) => {
                axios.post('/api/comments', request)
                .then(response => {
                    resolve(response.data);
                })
                .catch(err => {
                    reject(err);
                });
            });
        },
        COMMENTS_DELETE({ state }, id) {
            return axios.delete('/api/comments/' + id);
        },
    }
}
