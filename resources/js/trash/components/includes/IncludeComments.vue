<template>
    <div class="comments">
        <div class="scrollbar-inner">
            <div class="e-box--padding comments-loading" v-if="loading">
                <span class="size--13 c-gray">
                    <i class="fa fa-circle-notch fa-spin" aria-hidden="true"></i>
                    Загрузка комментариев...
                </span>
            </div>
            <div class="e-box--padding comments-load-more" @click="load" v-else-if="comments.length < total">
                <span class="size--13">
                    Загрузить еще
                </span>
            </div>
            <div>
                <IncludeComment v-for="comment in comments" :key="comment.id" :comment="comment"/>
            </div>
        </div>
        <div class="e-box--padding comment-form" v-if="profile">
            <div class="e-avatar">
                <router-link class="e-avatar--photo" :to="profile.link" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></router-link>
                <div class="e-avatar--content">
                    <textarea class="form--control form--textarea size--13" :rows="body_rows" placeholder="Написать комментарий" v-model="comment.body" @keydown.enter.exact.prevent="store"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

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
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        body_rows() {
            if (!this.comment.body) {
                return 1;
            }
            return this.comment.body.split('\n').length;
        },
    },
    created() {
        this.$on('comment:delete', id => {
            this.comments = this.comments.filter(c => c.id != id);
            this.total--;

            if (this.object_type == 'post') {
                this.$store.commit('POSTS_UPDATE', {
                    id: this.object_id,
                    comments_count: this.total
                });
            }

            if (this.object_type == 'photo') {
                this.$parent.$emit('comments_count:update', this.total);
            }
        });
        this.load();
    },
    mounted() {
        if (this.scroll) {
            $(this.$el).find('.scrollbar-inner').scrollbar();
        }
        $(this.$el).find('textarea')[0].focus();
    },
    methods: {
        ...mapActions([
            'COMMENTS_GET',
            'COMMENTS_STORE'
        ]),
        async load() {
            const { object_id, object_type } = this;

            this.loading = true;
            const data = await this.COMMENTS_GET({
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

            const comment = await this.COMMENTS_STORE({
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
            const $s = $(this.$el).find('.scrollbar-inner').last();
            $s.scrollTop($s[0].scrollHeight);
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

<style>
.comments .scroll-wrapper {
    flex: 1;
}
</style>

<style lang="scss" scoped>
.comments {
    display: flex;
    flex-direction: column;
    flex: 1;
    border-top: 1px solid #E6E9EE;
    overflow: hidden;
}

.comments-loading,
.comments-load-more {
    border-bottom: 1px solid #E6E9EE;
    text-align: center;
}

.comments-load-more {
    cursor: pointer;
}

.comment-form {
    border-top: 1px solid #E6E9EE;

    .e-avatar {
        align-items: flex-start;
    }

    .e-avatar--content {
        display: flex;
        flex: 1;

        .form--control {
            border: 1px solid transparent;
            margin-top: .1em;
            padding-left: 0;
        }
    }
}
</style>
