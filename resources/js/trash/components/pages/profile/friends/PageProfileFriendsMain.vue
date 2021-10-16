<template>
    <div>
        <IncludeSearch
            placeholder="Поиск друзей"
            :order="[{
                name: 'Новые'
            }, {
                name: 'Старые',
                value: 'created_at-asc'
            }]"
            />
        <div class="grid grid--three grid--gap">
            <div class="e-do" :class="{ 'e-do--static': !flags.self }" v-for="friend in friends">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="friend.link" :style="{ 'background-image': 'url(\'' + friend.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="friend.link">
                                {{ friend.name }}
                            </router-link>
                            <p class="weight--600 color--regent-gray size--12">
                                Был 6 месяцев назад
                            </p>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding" v-if="flags.self">
                    <button class="btn btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(friend.user_id)" :disabled="friend.processing || friend.removed" :class="{ 'btn-boder': !friend.removed, loading: friend.processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        <template v-if="friend.removed">
                            Удален из друзей
                        </template>
                        <template v-else-if="friend.processing">
                            &nbsp;
                        </template>
                        <template v-else>
                            Удалить из друзей
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

export default {
    data() {
        return {
            loadingMore: false,
            friends: [],
            total: 0
        }
    },
    computed: {
        ...mapState({
            counters: state => state.profiles.counters,
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        }),
        hasMore() {
            return this.friends.length < this.total;
        }
    },
    async created() {
        this.load();
    },
    methods: {
        async load() {
            this.loadingMore = true;

            const data = (await axios.get('/api/friends', {
                params: {
                    user_id: this.profile.user_id,
                    offset: this.friends.length,
                    ...this.$route.query
                }
            })).data;

            this.friends = this.friends.concat(data.friends);
            this.total = data.total;

            this.loadingMore = false;
        },
        async remove(id) {
            const friend = this.friends.find(f => f.user_id == id);
            this.$set(friend, 'processing', true);
            await axios.delete('/api/user/friends/' + id);
            this.$set(friend, 'removed', true);

            this.$store.commit('PROFILE_UPDATE_COUNTERS', {
                friends: this.counters.friends - 1
            });

            friend.processing = false;
        }
    },
    watch: {
        total() {
            if (this.flags.self) {
                this.$store.commit('COUNTERS_UPDATE', {
                    friends: this.total
                });
            } else {
                this.$store.commit('PROFILE_UPDATE_COUNTERS', {
                    friends: this.total
                });
            }
        },
        '$route': function() {
            this.total = 0;
            this.friends = [];
            this.load();
        }
    }
}
</script>
