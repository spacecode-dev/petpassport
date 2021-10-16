<template>
    <transition name="fade" mode="out-in">
        <router-view v-if="show"/>
    </transition>
</template>

<script>
    // import Echo from 'laravel-echo';
    // window.Pusher = require('pusher-js');
    // window.Echo = new Echo({
    //     broadcaster: 'pusher',
    //     key: process.env.MIX_PUSHER_APP_KEY,
    //     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    //     encrypted: true
    // });
    import {mapState} from 'vuex';
    export default {
        computed: {
            ...mapState({
                show: state => state.settings.show
            }),
        },
        mounted() {
            document.addEventListener("DOMContentLoaded", () => {
                this.$store.dispatch('SHOW_TOGGLE', true);
            })
        }
    }
</script>

<style lang="scss" scoped>
    section::v-deep {
        overflow: hidden;
    }
    ::v-deep {
        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 50rem;
            background: var(--violet);
            color: white;
            margin-left: .2rem;
            position: relative;
            top: -6px;
        }
        .ps--active-x > .ps__rail-x, .ps--active-y > .ps__rail-y {
            z-index: 999;
        }
        & > .scroll-area {
            position: relative;
            margin: auto;
            width: 100%;
            height: 100vh;
        }
    }
</style>
