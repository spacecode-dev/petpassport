<template>
    <div>
        <div class="h-layer--middle">
            <div class="h-middle" :style="{ 'background-image': 'url(\'' + profile.cover + '\')' }">
                <!-- /img/background/head.jpg -->
                <div class="h-middle--top">
                    <router-link class="btn-refer btn" to="/settings/profile" v-if="flags.self">
                        Обновить
                    </router-link>
                </div>
                <div class="h-middle--item">
                    <div class="h-middle--guide style--center">
                        <a href="">
                            <img class="h-middle--code" :src="qrcode" :alt="profile.name">
                        </a>
                        <a class="h-middle--floor" href="">
                            Рейтинг: {{ profile.rating }}
                        </a>
                    </div>
                    <div class="h-middle--ava" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }" v-if="!profile.noavatar">
                        <ul class="avatar-actions" v-if="flags.self">
                            <li @click="selectAvatar">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                                Обновить аватар
                            </li>
                        </ul>
                    </div>
                    <div class="h-middle--piece">
                        <h4 class="h-middle--utter">
                            {{ profile.name }}
                            <i class="ico ico--accepted" v-if="profile.verified" title="Проверенный профиль"></i>
                        </h4>
                        <div class="bg-change" v-if="flags.self">
                            <div @click="selectCover">
                                Обновить фото стены профиля
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
                                <template v-if="profile.type == 1">
                                    Пользователь
                                </template>
                                <template v-if="profile.type == 2">
                                    Заводчик
                                </template>
                                <template v-if="profile.type == 3">
                                    Питомец
                                </template>
                            </div>
                        </div>
                        <ul class="h-bottom--term" :style="{ visibility: flags.self || !$store.getters.authenticated ? 'hidden' : 'visible' }">
                            <template v-if="flags.friend">
                                <li>
                                    <span class="h-bottom--wash">
                                        <span class="color--regent-gray">
                                            В друзьях
                                        </span>
                                    </span>
                                </li>
                                <li>
                                    <a class="h-bottom--wash" href="#" @click.prevent="removeFromFriends">
                                        Убрать из друзей
                                    </a>
                                </li>
                            </template>
                            <template v-else-if="flags.friendship_outgoing">
                                <li>
                                    <span class="h-bottom--wash">
                                        <span class="color--regent-gray">
                                            Запрос отправлен
                                        </span>
                                    </span>
                                </li>
                                <li>
                                    <a class="h-bottom--wash" href="#" @click.prevent="removeFromFriends">
                                        Отменить запрос
                                    </a>
                                </li>
                            </template>
                            <template v-else-if="flags.friendship_incoming">
                                <li>
                                    <span class="h-bottom--wash">
                                        <span class="color--regent-gray">
                                            Запрос получен
                                        </span>
                                    </span>
                                </li>
                                <li>
                                    <a class="h-bottom--wash" href="#" @click.prevent="addToFriends">
                                        Принять запрос
                                    </a>
                                </li>
                            </template>
                            <li v-else>
                                <a class="h-bottom--wash" href="#" @click.prevent="addToFriends">
                                    Добавить в друзья
                                </a>
                            </li>
                            <li v-if="flags.subscribed">
                                <a class="h-bottom--wash" href="#" @click.prevent="unsubscribe">
                                    Отписаться
                                </a>
                            </li>
                            <li v-else>
                                <a class="h-bottom--wash" href="#" @click.prevent="subscribe">
                                    Подписаться
                                </a>
                            </li>
                            <li>
                                <a class="h-bottom--wash" href="#" @click.prevent="$root.$emit('chat:open', profile.user_id, 'profile', profile)">
                                    Сообщение
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
                            <a class="h-bottom--have color--mirage" href="/sos" @click.prevent="$emit('sos')">
                                <span class="sb-who--be" v-if="true">on</span>
                                <span class="sb-who--be" v-else>off</span>
                                <span class="size--13">Помощь</span>
                            </a>
                        </div>
                        <ul class="h-bottom--menu">
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link" exact>
                                    Профиль
                                </router-link>
                            </li>
                            <li v-if="flags.self">
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/news'">
                                    Новости
                                </router-link>
                            </li>
                            <li v-if="flags.self">
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/_'">
                                    Рынок
                                </router-link>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/photos'">
                                    Фото
                                </router-link>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/videos'">
                                    Видео
                                </router-link>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/friends'">
                                    Друзья
                                </router-link>
                                <span class="prefab--label">
                                    {{ counters.friends }}
                                </span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/pages'">
                                    Страницы
                                </router-link>
                                <span class="prefab--label">
                                    {{ counters.pages }}
                                </span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/groups'">
                                    Группы
                                </router-link>
                                <span class="prefab--label">
                                    {{ counters.groups }}
                                </span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/nurseries'">
                                    Питомники
                                </router-link>
                                <span class="prefab--label">
                                    {{ counters.nurseries }}
                                </span>
                            </li>
                            <li>
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/announcements'">
                                    Объявления
                                </router-link>
                                <span class="prefab--label">
                                    {{ profile.announcements_count }}
                                </span>
                            </li>
                            <li v-if="flags.self">
                                <router-link class="h-bottom--rumor" active-class="active" :to="profile.link + '/promote'">
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
import { mapState, mapActions } from 'vuex';

import ModalSelectPhotos from './modals/ModalSelectPhotos';

export default {
    data() {
        return {
            fileAvatar: null,
            fileBackground: null,
        }
    },
    computed: {
        ...mapState({
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags,
            counters: state => state.profiles.counters
        }),
        qrcode() {
            const link = document.location.origin + this.profile.link;
            return 'https://chart.apis.google.com/chart?choe=UTF-8&chld=H|1&cht=qr&chs=300x300&chl=' + link;
        }
    },
    methods: {
        ...mapActions([
            'PHOTOS_SELECT'
        ]),
        async addToFriends() {
            const friendship = (await axios.post('/api/user/friends', {
                friend_id: this.profile.user_id
            })).data;

            if (friendship.accepted) {
                this.$store.commit('PROFILE_UPDATE_FLAGS', {
                    friend: true,
                    friendship_incoming: true,
                    friendship_outgoing: false
                });
                this.$store.commit('PROFILE_UPDATE_COUNTERS', {
                    friends: this.counters.friends + 1
                });
            } else {
                this.$store.commit('PROFILE_UPDATE_FLAGS', {
                    friendship_incoming: false,
                    friendship_outgoing: true,
                    subscribed: true
                });
            }
        },
        async removeFromFriends() {
            await axios.delete('/api/user/friends/' + this.profile.user_id);

            const flags = {
                friend: false,
                friendship_incoming: false,
                friendship_outgoing: false
            };

            if (!this.flags.friendship_outgoing) {
                this.$store.commit('PROFILE_UPDATE_COUNTERS', {
                    friends: this.counters.friends - 1
                });
            } else {
                flags.subscribed = false;
            }

            this.$store.commit('PROFILE_UPDATE_FLAGS', flags);
        },
        async subscribe() {
            await axios.post('/api/user/subscriptions', {
                wall_id: this.profile.user_id,
                wall_type: 'profile'
            });

            this.$store.commit('PROFILE_UPDATE_FLAGS', {
                subscribed: true
            });
        },
        async unsubscribe() {
            await axios.delete('/api/user/subscriptions', {
                data: {
                    wall_id: this.profile.user_id,
                    wall_type: 'profile'
                }
            });

            this.$store.commit('PROFILE_UPDATE_FLAGS', {
                subscribed: false
            });
        },
        selectAvatar() {
            this.$modal.show(ModalSelectPhotos, {
                owner_id: this.profile.user_id,
                owner_type: 'profile',
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
                owner_id: this.profile.user_id,
                owner_type: 'profile',
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
        this.$root.$on('echo:friendship.accepted', e => {
            if (e.user.user_id == this.profile.user_id) {
                this.$store.commit('PROFILE_UPDATE_FLAGS', {
                    friend: true,
                    friendship_incoming: false,
                    friendship_outgoing: false
                });
                this.$store.commit('PROFILE_UPDATE_COUNTERS', {
                    friends: this.counters.friends + 1
                });
            }
        });
        this.$root.$on('echo:friendship.received', e => {
            if (e.user.user_id == this.profile.user_id) {
                this.$store.commit('PROFILE_UPDATE_FLAGS', {
                    friendship_incoming: true
                });
            }
        });
    },
    destroyed() {
        $('#modal-select-avatar').remove();
        $('#modal-select-cover').remove();
    }
}
</script>
