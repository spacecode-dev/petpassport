<template>
    <div>
        <IncludeSearch
            placeholder="Поиск подписок"
            :order="[{
                name: 'Новые'
            }, {
                name: 'Старые',
                value: 'created_at-asc'
            }]"
        />
        <div class="grid grid--three grid--gap">
            <div class="e-do" :class="{ 'e-do--static': !flags.self }" v-for="subscription in subscriptions">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="subscription.wall.link" :style="{ 'background-image': 'url(\'' + subscription.wall.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="subscription.wall.link">
                                {{ subscription.wall.name }}
                            </router-link>
                            <p class="weight--600 color--regent-gray size--12">
                                Был 6 месяцев назад
                            </p>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding" v-if="flags.self">
                    <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="unsubscribe(subscription.wall_id)">
                        Отменить подписку
                    </button>
                </div>
            </div>
        </div>
        <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loadingMore" @click="load" v-if="hasMore">
            <i class="ico ico--reload" :class="{ 'fa-spin': loadingMore }"></i>
            <span class="size--13 color--mirage">
                Показать еще
            </span>
        </a>
    </div>
</template>

<script>
import axios from 'axios';
import NProgress from 'nprogress';
import { mapState } from 'vuex';
import toastr from 'toastr';

export default {
    data() {
        return {
            loadingMore: false,
            subscriptions: [],
            total: 0,
            limit: 15
        }
    },
    computed: {
        ...mapState({
            counters: state => state.counters.counters,
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        }),
        hasMore() {
            return this.subscriptions.length < this.total;
        }
    },
    async created() {
        this.load();
    },
    methods: {
        async load(limit = 15) {
            this.loadingMore = true;

            const data = (await axios.get('/api/subscriptions', {
                params: {
                    user_id: this.profile.user_id,
                    wall_type: 'profile',
                    offset: this.subscriptions.length,
                    limit,
                    ...this.$route.query
                }
            })).data;

            this.subscriptions = this.subscriptions.concat(data.subscriptions);
            this.total = data.total

            this.loadingMore = false;
        },
        async unsubscribe(id) {
            await axios.delete('/api/user/subscriptions', {
                data: {
                    wall_id: id,
                    wall_type: 'profile'
                }
            });

            this.subscriptions = this.subscriptions.filter(s => !(s.wall_id == id && s.wall_type == 'profile'));
            this.total--;

            toastr.success('Подписка успешно отменена');

            await this.loadMore(1);
        }
    },
    watch: {
        '$route.query': function() {
            this.total = 0;
            this.subscriptions = [];
            this.load();
        }
    }
}
</script>
