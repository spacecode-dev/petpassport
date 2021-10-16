<template>
    <LayoutMain white-header without-sidebar>
        <div class="cn-main cn-main--page">
            <div class="cn-main--left">

            </div>
            <div class="cn-main--content">
                <div class="e-box e-box--padding sr-page" style="opacity: .2;">
                    <div class="sr-page--field">
                        <button class="sr-page--go"></button>
                        <input class="sr-page--input size--13" placeholder="Поиск пользователей">
                    </div>
                    <div class="b-filter--talk mdrop--wrap mdrop--toggle">
                        <i class="ico ico--menu"></i>
                        <span class="size--13">Сортировка</span>
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
                <div class="grid grid--three grid--gap">
                    <div class="e-do e-do--static" v-for="profile in profiles">
                        <div class="e-do--gossip">
                            <div class="e-avatar--65 e-box--padding e-avatar">
                                <router-link class="e-avatar--photo" :to="profile.link" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></router-link>
                                <div class="e-avatar--content">
                                    <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="profile.link">
                                        {{ profile.name }}
                                    </router-link>
                                    <p class="weight--600 color--regent-gray size--12">
                                        Был 6 месяцев назад
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="e-do--foot e-box--padding" v-if="profile.flags.self">
                            <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="unsubscribe(subscription.wall_id)">
                                Отменить подписку
                            </button>
                        </div>
                        -->
                    </div>
                </div>
                <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loadingMore" @click="loadMore" v-if="hasMore">
                    <i class="ico ico--reload" :class="{ 'fa-spin': loadingMore }"></i>
                    <span class="size--13 color--mirage">
                        Показать еще
                    </span>
                </a>
            </div>
        </div>
    </LayoutMain>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            loadingMore: false,
            profiles: [],
            total: 0
        }
    },
    computed: {
        hasMore() {
            return this.profiles.length < this.total;
        }
    },
    async created() {
        await this.loadMore();
    },
    methods: {
        async loadMore(limit = 15) {
            this.loadingMore = true;

            const data = (await axios.get('/api/profiles', {
                params: {
                    reason: 'search',
                    limit,
                    offset: this.profiles.length,
                    ...this.$route.query
                }
            })).data;

            this.profiles = this.profiles.concat(data.profiles);
            this.total = data.total;

            this.loadingMore = false;
        }
    },
    watch: {
        
    }
}
</script>
