import axios from 'axios';

export default {
    actions: {
        CART_GET() {
            return new Promise((resolve, reject) => {
                axios.get('/api/cart')
                .then(response => {
                    resolve(response.data);
                })
                .catch(err => {
                    reject(err);
                });
            });
        },
        CART_ADD({ rootState, commit }, announcement_id) {
            return new Promise((resolve, reject) => {
                axios.post('/api/cart', {
                    announcement_id
                })
                .then(response => {
                    commit('COUNTERS_UPDATE', {
                        cart: rootState.counters.counters.cart + 1
                    });
                    resolve(response.data);
                })
                .catch(err => {
                    reject(err);
                });
            });
        },
        CART_UPDATE({}, payload) {
            return new Promise((resolve, reject) => {
                axios.put('/api/cart/' + payload.announcement_id, payload)
                .then(response => {
                    resolve(response.data);
                })
                .catch(err => {
                    reject(err);
                });
            });
        },
        CART_DELETE({ rootState, commit }, announcement_id) {
            return new Promise((resolve, reject) => {
                axios.delete('/api/cart/' + announcement_id)
                .then(response => {
                    commit('COUNTERS_UPDATE', {
                        cart: rootState.counters.counters.cart - 1
                    });
                    resolve();
                })
                .catch(err => {
                    reject(err);
                });
            });
        },
        CART_ORDER({}, owner_id) {
            return axios.post('/api/cart/order', {
                owner_id
            });
        }
    }
}
