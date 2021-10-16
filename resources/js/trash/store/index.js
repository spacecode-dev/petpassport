import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'
import createCache from 'vuex-cache';

import auth from './modules/auth';
import user from './modules/user';
import profile from './modules/profile';
import profiles from './modules/profiles';
import counters from './modules/counters';
import posts from './modules/posts';
import marketCategories from './modules/marketCategories';
import geo from './modules/geo';
import communities from './modules/communities';
import photos from './modules/photos';
import videos from './modules/videos';
import shops from './modules/shops';
import likes from './modules/likes';
import comments from './modules/comments';
import cart from './modules/cart';

Vue.use(Vuex);

const strict = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    plugins: [
        createPersistedState({
            paths: [
                'auth'
            ]
        }),
        createCache()
    ],
    modules: {
        auth,
        user,
        profile,
        profiles,
        counters,
        posts,
        marketCategories,
        geo,
        communities,
        photos,
        videos,
        shops,
        likes,
        comments,
        cart
    },
    strict
});
