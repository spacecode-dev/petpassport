import axios from 'axios';

export default {
    state: {

    },
    actions: {
        async MARKET_CATEGORIES_GET({ commit }, params) {
            return (await axios.get('/api/market_categories', {
                params
            })).data;
        }
    }
}
