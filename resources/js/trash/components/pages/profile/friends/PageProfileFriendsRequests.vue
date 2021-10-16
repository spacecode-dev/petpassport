<template>
    <div class="grid grid--three grid--gap">
        <div class="e-do e-do--static" v-for="request in requests">
            <div class="e-do--gossip">
                <div class="e-avatar--65 e-box--padding e-avatar">
                    <router-link class="e-avatar--photo" :to="request.link" :style="{ 'background-image': 'url(\'' + request.avatar + '\')' }"></router-link>
                    <div class="e-avatar--content">
                        <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="request.link">
                            {{ request.name }}
                        </router-link>
                        <p class="weight--600 color--regent-gray size--12">
                            Был 6 месяцев назад
                        </p>
                    </div>
                </div>
            </div>
            <div class="e-do--foot e-box--padding">
                <button class="btn btn-round size--12 weight--600 btn-block btn-bigger" @click="accept(request.user_id)" :disabled="request.processing || request.accepted" :class="{ 'btn-blue': !request.accepted, 'btn-gray': request.accepted, loading: request.processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    <template v-if="request.accepted">
                        Запрос принят
                    </template>
                    <template v-else>
                        Добавить в друзья
                    </template>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import axios from 'axios';
import NProgress from 'nprogress';

export default {
    data() {
        return {
            requests: []
        }
    },
    computed: {
        ...mapState({
            counters: state => state.counters.counters,
            profile: state => state.profiles.profile
        })
    },
    async beforeRouteEnter(to, from, next) {
        NProgress.start();
        const data = (await axios.get('/api/user/friends/requests')).data;
        NProgress.done();
        next(vm => {
            vm.requests = data;
        });
    },
    methods: {
        async accept(id) {
            const request = this.requests.find(r => r.user_id == id);
            this.$set(request, 'processing', true);
            await axios.put('/api/user/friends/' + id);
            this.$set(request, 'accepted', true);

            this.$store.commit('COUNTERS_UPDATE', {
                friends: this.counters.friends + 1
            });
            request.processing = false;
        }
    },
    watch: {
        requests() {
            this.$store.commit('COUNTERS_UPDATE', {
                friend_requests: this.requests.filter(r => !r.accepted).length
            });
        }
    }
}
</script>
