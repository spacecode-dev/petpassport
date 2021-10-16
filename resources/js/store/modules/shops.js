import axios from 'axios';

const API_BASE = '/api/shops';

export default {
    state: {
        shop: {}
    },
    actions: {
        async SHOP_SHOW({ dispatch, commit }, slug) {
            const data = await dispatch('SHOP_GET', {
                slug,
                reason: 'show'
            });

            commit('SHOP_LOADED', data);
        },
        async SHOP_GET({ commit }, request) {
            const params = { ...request };
            delete params.slug;
            return (await axios.get(API_BASE + '/' + request.slug, {
                params
            })).data;
        }
    },
    mutations: {
        SHOP_LOADED(state, data) {
            state.shop = data;
        },
        SHOP_UPDATE(state, shop) {
            state.shop = Object.assign({}, state.shop, shop);
        }
    }
}
