<template>
    <div>
        <IncludeSearch
            placeholder="Поиск подписчиков"
            :order="[{
                name: 'Новые'
            }, {
                name: 'Старые',
                value: 'created_at-asc'
            }]"
        />
        <div class="grid grid--three grid--gap">
            <div class="e-do" :class="{ 'e-do--static': !can_edit }" v-for="user in subscribers">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="user.link" :style="{ 'background-image': 'url(\'' + user.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <a class="size--14 weight--600 color--mirage margin--bottom-5 style--inline">
                                {{ user.name }}
                            </a>
                            <p class="weight--600 color--regent-gray size--12">
                                Был 6 месяцев назад
                            </p>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding" v-if="can_edit">
                    <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(user.user_id)">
                        Удалить из подписчиков
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
import { mapState, mapGetters } from 'vuex';
import toastr from 'toastr';

export default {
    data() {
        return {
            loadingMore: false,
            subscribers: [],
            total: 0,
            limit: 15
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        ...mapState({
            counters: state => state.counters.counters
        }),
        wall_type() {
            return this.$route.params.type ? 'community' : 'profile';
        },
        owner_profile() {
            if (this.wall_type == 'profile') {
                return this.$store.state.profiles.profile;
            }
        },
        owner() {
            if (this.wall_type == 'profile') {
                return this.owner_profile;
            } else {
                return this.$parent.$parent.$parent.community;
            }
        },
        wall_id() {
            return this.owner.id || this.owner.user_id;
        },
        can_edit() {
            return this.owner.user_id == this.profile.user_id || (this.owner.user_role && this.owner.user_role <= 2);
        },
        hasMore() {
            return this.subscribers.length < this.total;
        }
    },
    async created() {
        if (this.wall_id) {
            //NProgress.start();
            await this.load();
            //NProgress.done();
        }
    },
    methods: {
        async load(limit) {
            limit = limit || this.limit;

            this.loadingMore = true;

            const {
                wall_id,
                wall_type
            } = this;

            const data = (await axios.get('/api/subscribers', {
                params: {
                    wall_id,
                    wall_type,
                    offset: this.subscribers.length,
                    limit,
                    ...this.$route.query
                }
            })).data;

            this.subscribers = this.subscribers.concat(data.subscribers);
            this.total = data.total;

            this.loadingMore = false;
        },
        async remove(user_id) {

            const {
                wall_id,
                wall_type
            } = this;

            await axios.delete('/api/subscribers', {
                data: {
                    user_id,
                    wall_id,
                    wall_type
                }
            });

            this.subscribers = this.subscribers.filter(s => s.user_id != user_id);
            this.total--;

            toastr.success('Подписка успешно отменена');

            await this.load(1);
        }
    },
    watch: {
        wall_id() {
            this.load();
        },
        '$route.query': function() {
            this.total = 0;
            this.subscribers = [];
            this.load();
        }
    }
}
</script>
