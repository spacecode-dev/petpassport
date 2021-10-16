<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Выпускники
            </h3>
            <IncludeSearch
                placeholder="Поиск выпускников"
                :order="[{
                    name: 'Новые'
                }, {
                    name: 'Старые',
                    value: 'created_at-asc'
                }]"
            />
            <div class="grid grid--three grid--gap">
                <div class="e-do" :class="{ 'e-do--static': !can_edit }" v-for="user in profiles">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="user.link" :style="{ 'background-image': 'url(\'' + user.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="user.link">
                                    {{ user.name }}
                                </router-link>
                                <p class="weight--600 color--regent-gray size--12">
                                    Был 6 месяцев назад
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding" v-if="can_edit">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(user.user_id)">
                            Исключить из сообщества
                        </button>
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
            profiles: [],
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
        can_edit() {
            return false;//this.community.user_role && this.community.user_role <= 2;
        },
        hasMore() {
            return this.profiles.length < this.total;
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

            const data = (await axios.get('/api/profiles', {
                params: {
                    reason: 'search',
                    born_nursery_id: this.community.id,
                    offset: this.profiles.length,
                    limit,
                    ...this.$route.query
                }
            })).data;

            this.profiles = this.profiles.concat(data.profiles);
            this.total = data.total;

            this.loadingMore = false;
        },
        async remove(user_id) {
            /*
            await axios.delete('/api/community_members', {
                data: {
                    user_id,
                    community_id: this.community.id
                }
            });

            this.members = this.members.filter(s => s.user_id != user_id);
            this.total--;

            toastr.success('Пользователь успешно исключен из сообщества');

            await this.load(1);
            */
        }
    },
    watch: {
        community() {
            this.load();
        },
        '$route.query': function() {
            this.total = 0;
            this.profiles = [];
            this.load();
        }
    }
}
</script>
