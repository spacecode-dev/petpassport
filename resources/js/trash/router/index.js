import Vue from 'vue';
import VueRouter from 'vue-router';
import NProgress from 'nprogress';

import routes from './routes';
import store from '../store';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (!from || from.path.split('/')[1] == to.path.split('/')[1]) {
            if (from &&
                from.matched.filter(route => route.meta.preserveScroll).length &&
                to.matched.filter(route => route.meta.preserveScroll).length) {
                return savedPosition;
            }
        }
        return {
            x: 0,
            y: 0
        };
    }
});

router.beforeEach(async (to, from, next) => {
    //NProgress.start();

    if (store.getters.authenticated && !store.getters.userLoaded) {
        NProgress.start();
        await store.dispatch('USER_REQUEST');
        NProgress.done();
    }

    if (to.path == '/') {
        next('/' + (store.getters.authenticated ? store.getters.user.login : 'login'));
        return;
    }

    next();
});

router.afterEach((to, from) => {
    document.title = to.meta.title || '';
    //NProgress.done();
});

export default router;
