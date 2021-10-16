<template>
    <div>
        <div class="b-filter">
            <h4 class="size--14 weight--600">
                <slot name="title"></slot>
            </h4>
            <div class="b-filter--talk mdrop--wrap mdrop--toggle">
                <i class="ico ico--menu"></i>
                <span class="size--13">Все записи</span>
                <i class="prefab--arrow-down"></i>
                <div class="mdrop mdrop--align-right">
                    <div>
                        <ul class="style--uppercase">
                            <li><a class="active" href="">Выбрать</a></li>
                            <li><a href="">Выбрать</a></li>
                            <li><a href="">Выбрать</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid--gap grid--articles">
            <IncludePost v-for="post in posts" :key="post.id" :post="post" />
        </div>
        <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loadingMore" @click="loadMore" v-if="hasMore" style="/*margin-top: 0;*/">
            <i class="ico ico--reload" :class="{ 'fa-spin': loadingMore }"></i>
            <span class="size--13 color--mirage">
                Показать еще
            </span>
        </a>
    </div>
</template>

<script>
import axios from 'axios';
import * as moment from 'moment';
import 'moment/locale/ru';

export default {
    props: {
        request: Object
    },
    data() {
        return {
            postsLimit: 20,
            loadingMore: false,
            hasMore: false,
            photo: null
        }
    },
    computed: {
        posts() {
            return this.$store.state.posts.posts;
        }
    },
    created() {
        this.loadPosts();

        window.Echo.channel('wall.' + this.request.wall_type + '.' + this.request.wall_id)
            .listen('.like.updated', e => {
                this.$store.commit('POSTS_UPDATE', {
                    id: e.object_id,
                    likes_count: e.count
                });
            });
    },
    mounted() {
        //$(this.$el).find('select').niceSelect();
    },
    watch: {
        request() {
            console.log('posts request');
            this.loadPosts();
        }
    },
    methods: {
        async loadPosts() {
            if (this.request.reason != 'news' && !this.request.wall_id) {
                return;
            }

            const posts = await this.$store.dispatch('POSTS_GET', {
                ...this.request,
                limit: this.postsLimit
            });

            this.hasMore = posts.length == this.postsLimit;
        },
        async loadMore() {
            this.loadingMore = true;

            const posts = await this.$store.dispatch('POSTS_GET_MORE');

            this.hasMore = posts.length == this.postsLimit;

            this.loadingMore = false;
        },
    }
}
</script>

<style>
.grid.grid--articles {
    display: block !important;
}
</style>
