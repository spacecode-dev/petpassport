import Vue from 'vue';
import axios from "axios";
import Buefy from 'buefy';
import linkify from 'vue-linkify';

Vue.use(Buefy);
Vue.directive('linkified', linkify);

// Token
if (store.state.auth.token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.auth.token;
    // window.Echo.connector.pusher.config.auth.headers['Authorization'] = 'Bearer ' + store.state.auth.token;
}
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import App from './App.vue';

// Store
import store from './store';

// Routes
import router from './router';

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
});

