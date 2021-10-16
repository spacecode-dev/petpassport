<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Магазины
            </h3>
            <IncludeSearch
                placeholder="Поиск магазинов"
                :order="[{
                    name: 'Новые'
                }, {
                    name: 'Старые',
                    value: 'created_at-asc'
                }]"
            />
            <div class="grid grid--three grid--gap">
                <div class="e-do e-do--static" v-for="shop in shops">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="shop.link" :style="{ 'background-image': 'url(\'' + shop.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="shop.link">
                                    {{ shop.name }}
                                </router-link>
                                <!--
                                <p class="weight--600 color--regent-gray size--12">
                                    {{ shop.announcements_count }} 
                                </p>
                            -->
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
            shops: [],
            total: 0,
            limit: 15
        }
    },
    computed: {
        ...mapState({
            profile: state => state.profiles.profile,
            counters: state => state.counters.counters
        }),
        hasMore() {
            return this.shops.length < this.total;
        }
    },
    async created() {
        if (this.profile) {
            //NProgress.start();
            await this.load();
            //NProgress.done();
        }
    },
    methods: {
        async load() {
            if (!this.profile.user_id) return;

            const { limit } = this;

            this.loadingMore = true;

            const data = (await axios.get('/api/shops', {
                params: {
                    user_id: this.profile.user_id,
                    offset: this.shops.length,
                    limit,
                    ...this.$route.query
                }
            })).data;

            this.shops = this.shops.concat(data.shops);
            this.total = data.total;

            this.loadingMore = false;
        },
    },
    watch: {
        profile() {
            this.load();
        },
        '$route.query': function() {
            this.total = 0;
            this.shops = [];
            this.load();
        }
    }
}
</script>
