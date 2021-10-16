o<template>
    <div class="cn-main">
        <div class="cn-main--left">

        </div>
        <div class="cn-main--content">
            <div class="row cn-top--new" v-if="flags.self">
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <IncludePostForm :wall_id="profile.user_id" :sos="sos"/>
                </div>
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12" v-if="profile.type !== 3">
                    <div class="e-box e-box--padding e-post--new">
                        <div class="e-card-shop--exile">
                            <p class="size--13 style--center e-post--text">
                                <template v-if="profile.type == 3">
                                    Щенки, котята, хорьки, кролики, попугаи, морские свинки, черепахи, ёжики, рыбки и другие домашние питомцы, корм для них, игрушки, домики, аптека, перевозки, передержки, обучение и многое другое Вы найдете в:
                                </template>
                                <template v-else>
                                    Подавайте объявления, откройте свой магазин, предложите услуги. Воспользуйтесь продвижением
                                </template>
                            </p>
                        </div>
                        <div class="e-card-shop--subject">
                            <router-link class="btn btn-round btn-bigger size--13 weight--600 btn-boder btn-gray" to="/settings/shops">
                                Магазины
                            </router-link>
                            <router-link class="btn btn-round btn-bigger size--13 weight--600 btn-blue btn-green" to="/settings/announcements">
                                Объявления
                            </router-link>
                            <IncludeDropdown class="dropdown-right">
                                <template v-slot:toggle>
                                    <div class="btn-round size--13 weight--600 btn-boder btn-more">
                                        <i class="ico ico--more"></i>
                                    </div>
                                </template>
                                <ul class="dropdown-menu-custom separated" style="text-align: left;">
                                    <li><a>...</a></li>
                                </ul>
                            </IncludeDropdown>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row cn-main--inner">
                <div class="col-xl-6 __cn-main--body">
                    <IncludePosts :request="postsRequest">
                        <template v-slot:title>
                            Недавние обновления
                        </template>
                    </IncludePosts>
                </div>
                <div class="col-xl-6 __cn-main--right" style="display: flex;">
                    <div style="flex: 1; margin-right: 20px;">
                        <div class="e-box--with-sep e-box e-box--padding">
                            <h4 class="e-box--title">
                                Рекомендуемые пользователи
                            </h4>
                            <div>
                                <div class="e-avatar--50 e-add--users e-avatar" v-for="i in 5">
                                    <a class="e-avatar--photo" href="" style="background-image: url(img/other/it.jpg)"></a>
                                    <div class="e-avatar--content">
                                        <a class="e-add--floor" href="">
                                            BAMBELBI GOOD BETTER
                                        </a>
                                        <a class="e-add--refer" href="">
                                            Добавить в друзья
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="e-box--with-sep e-box e-box--padding" v-if="profile.recommended_groups.length">
                            <h4 class="e-box--title">
                                Рекомендуемые группы
                            </h4>
                            <div>
                                <div class="e-avatar--50 e-add--users e-avatar" v-for="group in profile.recommended_groups" :key="group.id">
                                    <router-link class="e-avatar--photo" :to="group.link" :style="{ 'background-image': 'url(\'' + group.avatar + '\')' }"></router-link>
                                    <div class="e-avatar--content">
                                        <router-link class="e-add--floor" :to="group.link">
                                            {{ group.name }}
                                        </router-link>
                                        <span class="e-add--refer" v-if="group.joined">
                                            Вы вступили
                                        </span>
                                        <a class="e-add--refer" href="#" @click.prevent="COMMUNITY_JOIN(group.id)" v-else>
                                            Вступить в группу
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 12em;">
                        <div class="e-box--with-sep e-box e-box--padding">
                            <h4 class="e-box--title">
                                В сети
                            </h4>
                            <div>
                                <div class="e-avatar--50 e-avatar" v-for="i in 3">
                                    <a class="e-avatar--photo" href="" style="background-image: url(/img/other/it.jpg); position: relative;">
                                        <div style="width: 1em; height: 1em; border-radius: 50%; position: absolute; right: 0; bottom: 0;" class="bg-green"></div>
                                    </a>
                                    <div class="e-avatar--content">
                                        <a class="e-add--floor" href="" style="margin: 0;">
                                            Киба
                                        </a>
                                        <!--
                                        <a class="e-add--refer" href="" style="font-weight: normal;">
                                            онлайн
                                        </a>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="e-box--with-sep e-box e-box--padding">
                            <h4 class="e-box--title">
                                Недавно в сети
                            </h4>
                            <div>
                                <div class="e-avatar--50 e-avatar" v-for="i in 6">
                                    <a class="e-avatar--photo" href="" style="background-image: url(/img/other/it.jpg); position: relative;">
                                        <div style="width: 1em; height: 1em; border-radius: 50%; position: absolute; right: 0; bottom: 0;" class="bg-red"></div>
                                    </a>
                                    <div class="e-avatar--content">
                                        <a class="e-add--floor" href="" style="margin: 0;">
                                            Киба
                                        </a>
                                        <!--
                                        <a class="e-add--refer" href="" style="font-weight: normal;">
                                            онлайн
                                        </a>
                                        -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import * as moment from 'moment';
import 'moment/locale/ru';
import { mapState, mapActions } from 'vuex';

export default {
    data() {
        return {
            postsRequest: null
        }
    },
    computed: {
        ...mapState({
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        }),
        sos() {
            return this.$parent.$parent.sos;
        }
    },
    /*
    async beforeRouteEnter(to, from, next) {
        next(async (vm) => {
            await vm.loadPosts();
        });
    },
    async beforeRouteUpdate(to, from, next) {
        if (from.params.slug == to.params.slug) {
            next();
            return;
        }
        this.posts = [];
        this.hasMore = false;
        await this.loadPosts();
        next();
    },
    */
    created() {
        console.log('PageProfileMain created');
        this.updatePostsRequest();
    },
    watch: {
        '$route': function() {
            console.log('PageProfileMain route changed')
            this.updatePostsRequest();
        }
    },
    methods: {
        ...mapActions([
            'COMMUNITY_JOIN'
        ]),
        updatePostsRequest() {
            this.postsRequest = {
                reason: 'wall',
                wall_id: this.profile.user_id,
                wall_type: 'profile'
            };
        }
    }
}
</script>

