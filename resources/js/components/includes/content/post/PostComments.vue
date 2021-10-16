<template>
    <div>
        <vue-custom-scrollbar class="scroll-area" tagname="div" :settings="settings">
            <b-notification v-if="loading" :closable="false" class="notify-help">
                <b-loading :is-full-page="false" :active="loading"/>
            </b-notification>
<!--            <div class="e-box&#45;&#45;padding comments-load-more" @click="load" v-else-if="comments.length < total">-->
<!--                <span class="size&#45;&#45;13">-->
<!--                    Загрузить еще-->
<!--                </span>-->
<!--            </div>-->
            <div class="comments-list">
<!--                <Comment v-for="comment in comments" :key="comment.id" :comment="comment"/>-->
            </div>
        </vue-custom-scrollbar>
        <div class="comment-form" v-if="profile">
            <router-link :to="profile.link">
                <figure class="media-left">
                    <div class="image is-32x32">
                        <img class="is-rounded" :src="getAvatar" alt=""/>
                    </div>
                </figure>
            </router-link>
            <b-field>
                <b-input maxlength="500" :rows="body_rows" type="textarea" @keydown.enter.exact.prevent="store" v-model="comment.body" placeholder="Написать комментарий"/>
            </b-field>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import vueCustomScrollbar from "vue-custom-scrollbar";
    import store from "../../../../store";

    export default {
        props: {
            object_id: Number,
            object_type: String,
            first_limit: {
                type: Number,
                default: 10
            },
            scroll: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                loading: false,
                comments: [],
                total: 0,
                comment: {
                    body: null
                }
            }
        },
        components: {
            vueCustomScrollbar
        },
        computed: {
            ...mapGetters({
                profile: 'selfProfile'
            }),
            ...mapState({
                storage: state => state.settings.storage.path,
                settings: state => state.settings.comments.scroll.settings
            }),
            getAvatar() {
                return this.storage + this.profile.avatar;
            },
            body_rows() {
                if (!this.comment.body) {
                    return 1;
                }
                return this.comment.body.split('\n').length;
            },
        },
        created() {
            this.$on('comment:delete', id => {
                this.comments = this.comments.filter(c => c.id !== id);
                this.total--;
                if (this.object_type === 'post') {
                    this.$store.commit('POSTS_UPDATE', {
                        id: this.object_id,
                        comments_count: this.total
                    });
                }
                if (this.object_type === 'photo') {
                    this.$parent.$emit('comments_count:update', this.total);
                }
            });
            this.load();
        },
        mounted() {
            // if (this.scroll) {
            //     $(this.$el).find('.scrollbar-inner').scrollbar();
            // }
            // $(this.$el).find('textarea')[0].focus();
        },
        methods: {
            async load() {
                const { object_id, object_type } = this;
                this.loading = true;
                const data = await store.dispatch('COMMENTS_GET', {
                    object_id,
                    object_type,
                    offset: this.comments.length,
                    limit: this.comments.length > 0 ? 10 : this.first_limit
                });
                for (const comment of data.comments) {
                    comment.liked = data.liked.includes(comment.id);
                }
                this.comments = data.comments.concat(this.comments);
                this.total = data.total;
                this.loading = false;
                this.$nextTick(() => {
                    this.scrollBottom();
                });
            },
            async store() {
                const { object_id, object_type } = this;
                const comment = await store.dispatch('COMMENTS_STORE', {
                    object_id,
                    object_type,
                    ...this.comment
                });
                comment.likes_count = 0;
                comment.owner = this.profile;
                this.comments.push(comment);
                this.comment.body = null;
                this.$nextTick(() => {
                    this.scrollBottom();
                });
            },
            scrollBottom() {
                // const $s = $(this.$el).find('.scrollbar-inner').last();
                // $s.scrollTop($s[0].scrollHeight);
            }
        },
        watch: {
            object_id(newVal, oldVal) {
                if (oldVal) {
                    this.comments = [];
                    this.total = 0;
                    this.load();
                }
            }
        }
    }
</script>
