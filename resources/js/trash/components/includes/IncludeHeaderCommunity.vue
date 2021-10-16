<template>
    <div>
        <div class="h-layer--middle">
            <div class="h-middle" :style="{ 'background-image': 'url(\'' + community.cover + '\')' }">
                <!-- /img/background/head.jpg -->
                <div class="h-middle--top">
                    <router-link class="btn-refer btn" :to="'/settings/communities/' + community.id + '/edit'" v-if="community.user_role == 1">
                        Обновить
                    </router-link>
                </div>
                <div class="h-middle--item">
                    <div class="h-middle--guide style--center">
                        <a href="">
                            <img class="h-middle--code" :src="qrcode" :alt="community.name">
                        </a>
                        <!--
                        <a class="h-middle--floor" href="" v-if="[1, 2].includes(community.type)">
                            Участники: {{ community.members_count }}
                        </a>
                        <a class="h-middle--floor" href="" v-if="[3, 4].includes(community.type)">
                            Понравилось: {{ community.likes_count }}
                        </a>
                        -->
                        <a class="h-middle--floor" href="">
                            Рейтинг: {{ community.rating }}
                        </a>
                    </div>
                    <div class="h-middle--ava" :style="{ 'background-image': 'url(\'' + community.avatar + '\')' }" v-if="!community.noavatar">
                        <!--
                        <div class="avatar-default" v-if="!community.avatar">
                            <i class="fa fa-users" aria-hidden="true" style="font-size: 100px;"></i>
                        </div>
                        -->
                        <ul class="avatar-actions" v-if="community.user_role == 1">
                            <li @click="selectAvatar">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                                Обновить аватар
                            </li>
                        </ul>
                    </div>
                    <div class="h-middle--piece">
                        <h4 class="h-middle--utter">
                            {{ community.name }}
                            <i class="ico ico--accepted" v-if="community.verified" title="Проверенное сообщество"></i>
                        </h4>
                        <div class="bg-change" v-if="community.user_role == 1">
                            <div @click="selectCover">
                                Обновить фото стены сообщества
                                <i class="fa fa-camera" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-layer--bottom">
                <div class="h-bottom">
                    <div class="h-bottom--line">
                        <div class="h-bottom--aside h-bottom--status color--daisy-bush">
                            <div class="size--18">
                                Статус:
                                <template v-if="community.type == 1">
                                    Группа
                                </template>
                                <template v-if="community.type == 2">
                                    Питомник
                                </template>
                                <template v-if="community.type == 3">
                                    Страница
                                </template>
                                <template v-if="community.type == 4">
                                    Порода
                                </template>
                            </div>
                        </div>
                        <ul class="h-bottom--term">
                            <template v-if="[1, 2].includes(community.type)">
                                <li v-if="flags.joined">
                                    <a class="h-bottom--wash" href="#" @click.prevent="leave">
                                        Покинуть сообщество
                                    </a>
                                </li>
                                <li v-else>
                                    <a class="h-bottom--wash" href="#" @click.prevent="join">
                                        Вступить в сообщество
                                    </a>
                                </li>
                            </template>
                            <template v-if="[3, 4].includes(community.type)">
                                <li v-if="flags.liked">
                                    <a class="h-bottom--wash" href="#" @click.prevent="dislike">
                                        Больше не нравится
                                    </a>
                                </li>
                                <li v-else>
                                    <a class="h-bottom--wash" href="#" @click.prevent="like">
                                        Мне нравится
                                    </a>
                                </li>
                            </template>
                            <li v-if="flags.subscribed">
                                <a class="h-bottom--wash" href="#" @click.prevent="unsubscribe">
                                    Отписаться
                                </a>
                            </li>
                            <li v-else-if="flags.joined || [3, 4].includes(community.type)">
                                <a class="h-bottom--wash" href="#" @click.prevent="subscribe">
                                    Подписаться
                                </a>
                            </li>
                            <li>
                                <IncludeDropdown class="dropdown-right">
                                    <template v-slot:toggle>
                                        <span class="h-bottom--lead">
                                            <i></i><i></i><i></i>
                                        </span>
                                    </template>
                                    <ul class="dropdown-menu-custom">
                                        <li>
                                            <router-link active-class="active" to="/" exact>
                                                Главная
                                            </router-link>
                                        </li>
                                    </ul>
                                </IncludeDropdown>
                            </li>
                        </ul>
                    </div>
                    <div class="h-bottom--line">
                        <div class="h-bottom--aside h-bottom--sos">
                            <!--
                            <a class="h-bottom--have color--mirage" href="/sos" @click.prevent="$emit('sos')">
                                <span class="sb-who--be" v-if="true">on</span>
                                <span class="sb-who--be" v-else>off</span>
                                <span class="size--13">Помощь</span>
                            </a>
                            -->
                        </div>
                        <ul class="h-bottom--menu">
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link" exact>
                                    <template v-if="[1, 2].includes(community.type)">
                                        Лента
                                    </template>
                                    <template v-if="[3, 4].includes(community.type)">
                                        Публикации
                                    </template>
                                </router-link>
                            </li>
                            <li style="margin: 0 0 0 20px;" v-if="[1, 2].includes(community.type)">
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link + '/members'">
                                    Участники
                                </router-link>
                            </li>
                            <li style="margin: 0 0 0 20px;" v-if="[3, 4].includes(community.type)">
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link + '/likes'">
                                    Понравилось
                                </router-link>
                            </li>
                            <li style="margin: 0 0 0 20px;">
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link + '/subscribers'">
                                    Подписчики
                                </router-link>
                            </li>
                            <li style="margin: 0 0 0 20px;">
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link + '/photos'">
                                    Фото
                                </router-link>
                            </li>
                            <li style="margin: 0 0 0 20px;">
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link + '/videos'">
                                    Видео
                                </router-link>
                            </li>
                            <li style="margin: 0 auto 0 20px;">
                                <router-link class="h-bottom--rumor" active-class="active" :to="community.link + '/events'">
                                    Мероприятия
                                </router-link>
                            </li>
                            <!--
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug" exact>
                                    Профиль
                                </router-link>
                            </li>
                            <li v-if="flags.self">
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/news'">
                                    Новости
                                </router-link>
                            </li>
                            <li v-if="flags.self">
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/_'">
                                    Рынок
                                </router-link>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/photos'">
                                    Фото
                                </router-link>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/friends'">
                                    Друзья
                                </router-link>
                                <span class="prefab--label">
                                    {{ counters.friends }}
                                </span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/pages'">
                                    Страницы
                                </router-link>
                                <span class="prefab--label">{{ counters.pages }}</span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/groups'">
                                    Группы
                                </router-link>
                                <span class="prefab--label">{{ counters.groups }}</span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/nurseries'">
                                    Питомники
                                </router-link>
                                <span class="prefab--label">{{ counters.nurseries }}</span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/posts'">
                                    Объявления
                                </router-link>
                                <span class="prefab--label">{{ counters.posts }}</span>
                            </li>
                            <li v-if="flags.self">
                                <router-link class="h-bottom--rumor" active-class="active" :to="'/' + profile.slug + '/promote'">
                                    Продвижение
                                </router-link>
                            </li>
                            <li class="mdrop--wrap mdrop--toggle">
                                <a class="h-bottom--say" href="#">
                                    <span class="size--14">Еще</span>
                                    <i class="prefab--arrow-down"></i>
                                </a>
                                <div class="mdrop mdrop--align-right">
                                    <div>
                                        <ul class="style--uppercase">
                                            <li><a class="active" href="">Выбрать</a></li>
                                            <li><a href="">Выбрать</a></li>
                                            <li><a href="">Выбрать</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapState, mapGetters, mapActions } from 'vuex';

import ModalSelectPhotos from './modals/ModalSelectPhotos';

export default {
    data() {
        return {
            fileAvatar: null,
            fileBackground: null,
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        ...mapState({
            community: state => state.communities.community,
            flags: state => state.communities.flags,
            counters: state => state.communities.counters
        }),
        qrcode() {
            const link = document.location.origin + '/' + this.community.slug;
            return 'https://chart.apis.google.com/chart?choe=UTF-8&chld=H|1&cht=qr&chs=300x300&chl=' + link;
        }
    },
    methods: {
        ...mapActions([
            'PHOTOS_SELECT'
        ]),
        async join() {
            await this.$store.dispatch('COMMUNITY_JOIN', this.community.id);
        },
        async leave() {
            await this.$store.dispatch('COMMUNITY_LEAVE', this.community.id);
        },
        async like() {
            await this.$store.dispatch('COMMUNITY_LIKE', this.community.id);
        },
        async dislike() {
            await this.$store.dispatch('COMMUNITY_DISLIKE', this.community.id);
        },
        async subscribe() {
            await this.$store.dispatch('COMMUNITY_SUBSCRIBE', this.community.id);
        },
        async unsubscribe() {
            await this.$store.dispatch('COMMUNITY_UNSUBSCRIBE', this.community.id);
        },
        selectAvatar() {
            this.$modal.show(ModalSelectPhotos, {
                owner_id: this.community.id,
                owner_type: 'community',
                section: 2,
                count: 1
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        },
        selectCover() {
            this.$modal.show(ModalSelectPhotos, {
                owner_id: this.community.id,
                owner_type: 'community',
                section: 3,
                count: 1
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        }
    },
    created() {
    }
}
</script>
