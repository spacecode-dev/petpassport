<template>
    <div class="posts">
        <div class="b-filter">
            <h6>
                <slot name="title"></slot>
            </h6>
            <div class="b-filter--talk">
                <b-icon size="is-small" icon="menu"/>
                <b-dropdown aria-role="list">
                    <button slot="trigger" slot-scope="{ active }">
                        <span>Все записи</span>
                        <b-icon :icon="active ? 'chevron-up' : 'chevron-down'"/>
                    </button>
                    <b-dropdown-item aria-role="listitem">Меню</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Меню</b-dropdown-item>
                    <b-dropdown-item aria-role="listitem">Меню</b-dropdown-item>
                </b-dropdown>
            </div>
        </div>
        <Post v-if="posts.length" v-for="post in posts" :key="post.id" :post="post"/>
        <b-notification v-if="!posts.length" :closable="false" class="notify-help">
            <template v-if="loading && !emptyPosts">
                Загрузка
            </template>
            <template v-if="!loading && emptyPosts">
                Нет записей
            </template>
            <b-loading :is-full-page="false" :active="loading"/>
        </b-notification>
    </div>
</template>

<script>
    import store from "../../../store"
    import {mapGetters} from "vuex";
    import Post from "./post/Post";

    export default {
        data() {
            return {
                loading: true,
                emptyPosts: false,
                postsLimit: 20,
                loadingMore: false,
                hasMore: false,
                photo: null
            }
        },
        components: {
            Post
        },
        computed: {
            ...mapGetters({
                posts: 'posts',
                profile: 'selfProfile'
            })
        },
        created() {
            this.loadPosts();
        },
        methods: {
            async loadPosts() {
                const posts = await store.dispatch('POSTS_GET', {
                    reason: 'wall',
                    wall_id: this.profile.user_id,
                    wall_type: 'profile',
                    limit: this.postsLimit
                });
                this.hasMore = posts.length === this.postsLimit;
                this.emptyPosts = !posts.length;
                this.loading = false;
            },
            async loadMore() {
                this.loadingMore = true;
                const posts = await store.dispatch('POSTS_GET_MORE');
                this.hasMore = posts.length === this.postsLimit;
                this.loadingMore = false;
            }
        }
    }
</script>
