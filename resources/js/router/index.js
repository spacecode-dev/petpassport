import Vue from 'vue';
import VueRouter from 'vue-router';

import routes from './routes';
import store from '../store';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'is-active',
    routes
});

function toggleClasslist(to, from)
{
    let classList = document.body.classList;
    if(to && !classList.contains(to)) {
        classList.add(to);
        if(from) {
            classList.remove(from);
        }
    }
}

router.beforeEach(async (to, from, next) => {
    toggleClasslist(to.meta.bodyClass, from.meta.bodyClass);
    if (store.getters.authenticated && !store.getters.userLoaded) {
        await store.dispatch('USER_REQUEST');
    }
    if (to.path === '/') {
        next('/' + (store.getters.authenticated ? store.getters.user.login : 'login'));
        return;
    }
    next();
});

router.afterEach((to, from) => {
    document.title = to.meta.title || '';
});

export default router;
