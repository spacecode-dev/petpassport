import Vue from 'vue';
import axios from 'axios';
import toastr from 'toastr';
import NProgress from 'nprogress';
import AsyncComputed from 'vue-async-computed';
Vue.use(AsyncComputed);
import linkify from 'vue-linkify';
Vue.directive('linkified', linkify);
import VModal from 'vue-js-modal';
Vue.use(VModal, {
    dynamic: true,
    injectModalsContainer: true
});
import * as moment from 'moment';
import 'moment/locale/ru';

import store from './store';
import router from './router';

import './components';
import App from './App.vue';

if (store.state.auth.token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.auth.token;
    window.Echo.connector.pusher.config.auth.headers['Authorization'] = 'Bearer ' + store.state.auth.token;
}

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.interceptors.request.use(
    function (config) {
        config.headers['X-Socket-ID'] = window.Echo.socketId();
        return config;
    },
    function (error) {
        return Promise.reject (error);
    }
);

toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: 'toast-bottom-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '5000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
    messageClass: 'toast-message size--14'
};

NProgress.configure({
    showSpinner: false
});

Vue.filter('plural', function (number, titles) {
    const cases = [2, 0, 1, 1, 1, 2];
    return titles[
        (number % 100 > 4 && number % 100 < 20) ? 2 :
        cases[(number % 10 < 5) ? number % 10 : 5]
    ];
});

Vue.filter('price', function (value) {
    if (value) {
        return value.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    }
    return value;
});

Vue.filter('fromnow', function (date, f = false) {
    if (date) {
        return moment(date).fromNow(f);
    }
    return date;
});

Vue.filter('timestamp', function (date) {
    if (date) {
        return moment(date).format('DD.MM.YYYY hh:mm:ss');
    }
    return date;
});

Vue.filter('datetime', function (date) {
    if (date) {
        return moment(date).format('DD.MM.YYYY hh:mm');
    }
    return date;
});

Vue.mixin({
    methods: {
        queryAppend(append) {
            this.$route.meta.preserveScroll = true;

            return {
                query: {
                    ...this.$route.query,
                    ...append
                }
            }
        },
        queryRemove(remove) {
            this.$route.meta.preserveScroll = true;

            const query = { ...this.$route.query };
            for (const prop of remove) {
                if (query[prop]) {
                    delete query[prop];
                }
            }
            return {
                query
            }
        }
    }
});

const app = new Vue({
    el: '#app',
    store,
    router,
    render: h => h(App),
    created() {
        axios.interceptors.response.use(undefined, function (err) {
            return new Promise(function (resolve, reject) {
                if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
                    // if you ever get an unauthorized, logout the user
                    this.$store.dispatch('AUTH_LOGOUT');
                    this.$router.push('/login');
                }
                throw err;
            });
        });
    },
    mounted() {

    },
    methods: {
        async logout() {
            await this.$store.dispatch('AUTH_LOGOUT');
            this.$router.go();
        },
        async loginOwner() {
            try {
                const data = (await axios.post('/api/user/login_owner')).data;

                await this.$store.dispatch('AUTH_LOGOUT');
                await this.$store.dispatch('AUTH_SET_TOKEN', data.token);
                this.$router.push('/settings/breeder');
                toastr.success('Аккаунт успешно сменен', 'Аккаунт сменен');
            } catch (e) {
                toastr.error('Возникла ошибка при смене аккаунтов', 'Ошибка');
                console.log(e);
            }
        },
        showModal(name) {
            $('#modal-' + name).modal({
                fadeDuration: 250
            });
        }
    }
});

$(document).on('click', '.mdrop--toggle', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    $(this).toggleClass('open');
    if ($(this).hasClass('open')) {
        $(this).find('.mdrop').show();
    } else {
        $(this).find('.mdrop').hide();
    }
});

$(document).on('click', function() {
    $('.mdrop--toggle').removeClass('open');
    $('.mdrop').hide();
});

// NiceSelect fix
$(document).on('change', 'select', function(e) {
    if (e.originalEvent && e.originalEvent._FOR_VUE) {
        return;
    }

    var ve = document.createEvent('HTMLEvents');
    ve.initEvent('change', true, true);
    ve._FOR_VUE = true;
    $(this)[0].dispatchEvent(ve);
});
