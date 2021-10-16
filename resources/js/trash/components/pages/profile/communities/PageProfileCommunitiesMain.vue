<template>
    <div>
        <IncludeSearch
            placeholder="Поиск сообществ"
            :order="[{
                name: 'Новые'
            }, {
                name: 'Старые',
                value: 'created_at-asc'
            }]"
        />
        <div class="grid grid--three grid--gap">
            <div class="e-do" :class="{ 'e-do--static': !flags.self }" v-for="community in communities">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="community.link" :style="{ 'background-image': 'url(\'' + community.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="community.link">
                                {{ community.name }}
                            </router-link>
                            <div class="c-gray size--12" v-if="community.members_count">
                                <!--<i class="ico--user ico"></i>-->
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span>
                                    {{ community.members_count }}
                                </span>
                            </div>
                            <div class="c-gray size--12" v-if="community.likes_count">
                                <!--<i class="ico--like-gray ico"></i>-->
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <span>
                                    {{ community.likes_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding" v-if="flags.self">
                    <button class="btn btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="leave(community.id)" :disabled="community.processing || community.removed" :class="{ 'btn-boder': !community.removed, loading: community.processing }" v-if="[1, 2].includes(community.type)">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        <template v-if="community.removed">
                            Вы вышли из группы
                        </template>
                        <template v-else-if="community.processing">
                            &nbsp;
                        </template>
                        <template v-else>
                            Выйти из группы
                        </template>
                    </button>
                    <button class="btn btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="dislike(community.id)" :disabled="community.processing || community.removed" :class="{ 'btn-boder': !community.removed, loading: community.processing }" v-if="[3, 4].includes(community.type)">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        <template v-if="community.removed">
                            Вам больше не нравится
                        </template>
                        <template v-else-if="community.processing">
                            &nbsp;
                        </template>
                        <template v-else>
                            Больше не нравится
                        </template>
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

import store from '../../../../store';

export default {
    data() {
        return {
            loadingMore: false,
            total: 0,
            communities: []
        }
    },
    computed: {
        ...mapState({
            counters: state => state.profiles.counters,
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        }),
        hasMore() {
            return this.total > this.communities.length;
        },
        type() {
            return this.getCommunityType(this.$route.params.type);
        }
    },
    async created() {
        this.load();
    },
    methods: {
        getCommunityType(type) {
            switch (type) {
                case 'groups':
                    return 1;
                case 'nurseries':
                    return 2;
                case 'pages':
                    return 3;
            }
        },
        async load() {
            this.loadingMore = true;

            const data = (await axios.get('/api/user_communities/' + this.profile.user_id, {
                params: {
                    type: this.type,
                    offset: this.communities,
                    ...this.$route.query
                }
            })).data;

            this.total = data.total;
            this.communities = this.communities.concat(data.communities);

            this.loadingMore = false;
        },
        async leave(id) {
            const community = this.communities.find(c => c.id == id);
            this.$set(community, 'processing', true);
            await this.$store.dispatch('COMMUNITY_LEAVE', community.id);
            this.$set(community, 'removed', true);

            this.total--;
            community.processing = false;
        },
        async dislike(id) {
            const community = this.communities.find(c => c.id == id);
            this.$set(community, 'processing', true);
            await this.$store.dispatch('COMMUNITY_DISLIKE', community.id);
            this.$set(community, 'removed', true);

            this.total--;
            community.processing = false;
        }
    },
    watch: {
        total() {
            if (this.flags.self) {
                this.$store.commit('COUNTERS_UPDATE', {
                    [this.$route.type]: this.total
                });
            } else {
                this.$store.commit('PROFILE_UPDATE_COUNTERS', {
                    [this.$route.type]: this.total
                })
            }
        },
        '$route': function() {
            this.total = 0;
            this.communities = [];
            this.load();
        }
    }
}
</script>
