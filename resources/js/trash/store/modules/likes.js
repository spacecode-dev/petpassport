import axios from 'axios';

export default {
    actions: {
        LIKE({ state }, request) {
            return axios.post('/api/like', request);
        },
        DISLIKE({ state }, data) {
            return axios.delete('/api/like', { data });
        },
    }
}
