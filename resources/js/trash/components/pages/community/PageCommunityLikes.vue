<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Кому нравится
            </h3>
            <IncludeSearch
                placeholder="Поиск пользователей"
                :order="[{
                    name: 'Новые'
                }, {
                    name: 'Старые',
                    value: 'created_at-asc'
                }]"
            />
            <div class="grid grid--three grid--gap">
                <div class="e-do e-do--static" v-for="like in likes">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="like.user.link" :style="{ 'background-image': 'url(\'' + like.user.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="like.user.link">
                                    {{ like.user.name }}
                                </router-link>
                                <p class="weight--600 color--regent-gray size--12">
                                    Был 6 месяцев назад
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="e-box e-box--padding style--center btn-block e-mo" @click="load" v-if="hasMore">
                <i class="ico ico--reload"></i>
                <span class="size--13 color--mirage">
                    Показать еще
                </span>
            </a>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import NProgress from 'nprogress';
import { mapState, mapGetters } from 'vuex';
import toastr from 'toastr';

export default {
    data() {
        return {
            loadingMore: false,
            likes: [],
            total: 0,
            limit: 15
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        ...mapState({
            community: state => state.communities.community,
            counters: state => state.counters.counters
        }),
        hasMore() {
            return this.likes.length < this.total;
        }
    },
    async created() {
        if (this.community) {
            //NProgress.start();
            await this.load();
            //NProgress.done();
        }
    },
    methods: {
        async load() {
            if (!this.community.id) return;

            const { limit } = this;

            this.loadingMore = true;

            const data = (await axios.get('/api/likes', {
                params: {
                    object_id: this.community.id,
                    object_type: 'community',
                    offset: this.likes.length,
                    limit,
                    ...this.$route.query
                }
            })).data;

            this.likes = this.likes.concat(data.likes);
            this.total = data.total;

            this.loadingMore = false;
        },
    },
    watch: {
        community() {
            this.load();
        },
        '$route.query': function() {
            this.total = 0;
            this.likes = [];
            this.load();
        }
    }
}
</script>
