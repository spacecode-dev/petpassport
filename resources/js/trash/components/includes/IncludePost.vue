<template>
    <div class="e-box e-article" :class="{ sos: post.sos || (post.origin && post.origin.sos) }">
        <div class="e-box--padding">
            <div class="e-avatar--50 e-avatar">
                <router-link
                    class="e-avatar--photo"
                    :to="post.owner.link"
                    :style="{
                        'background-image': 'url(\'' + post.owner.avatar + '\')',
                        'border-radius': (post.owner_type == 'shop' ? 0 : null)
                    }"
                ></router-link>
                <div class="e-avatar--content">
                    <div class="e-article--floor">
                        <router-link :to="post.owner.link">
                            {{ post.owner.name }}
                        </router-link>
                        <span class="c-gray" v-if="announcement">
                            <template v-if="post.owner.gender == 2">
                                разместила
                            </template>
                            <template v-else>
                                разместил
                            </template>
                            объявление
                        </span>
                        <span class="c-gray" v-if="post.type == 2">
                            <template v-if="post.owner.gender == 2">
                                обновила
                            </template>
                            <template v-else>
                                обновил
                            </template>
                            аватар
                            <template v-if="post.owner_type == 'profile'">
                                профиля
                            </template>
                            <template v-if="post.owner_type == 'community'">
                                сообщества
                            </template>
                        </span>
                        <span class="c-gray" v-if="post.type == 3">
                            <template v-if="post.owner.gender == 2">
                                обновила
                            </template>
                            <template v-else>
                                обновил
                            </template>
                            фото стены
                            <template v-if="post.owner_type == 'profile'">
                                профиля
                            </template>
                            <template v-if="post.owner_type == 'community'">
                                сообщества
                            </template>
                        </span>
                    </div>
                    <div class="e-article--utter">
                        <span class="e-article--exile" :title="post.created_at">
                            {{ created_at }}
                        </span>
                        <IncludeDropdown class="dropdown-inline dropdown-right">
                            <template v-slot:toggle>
                                <span class="size--13 c-gray">
                                    <i class="fa fa-fw fa-globe-americas" aria-hidden="true" v-if="!post.privacy"></i>
                                    <i class="fa fa-fw fa-users" aria-hidden="true" v-if="post.privacy == 1"></i>
                                    <i class="fa fa-fw fa-lock" aria-hidden="true" v-if="post.privacy == 2"></i>
                                    <i class="fa fa-chevron-down m-0" aria-hidden="true" v-if="owner_self"></i>
                                </span>
                            </template>
                            <ul class="dropdown-menu-custom separated" style="text-align: left;">
                                <li :class="{ 'selected': !post.privacy }">
                                    <a href="#" @click.prevent="updatePrivacy(0)">
                                        <i class="fa fa-fw fa-globe-americas" aria-hidden="true"></i>
                                        Публичный
                                    </a>
                                </li>
                                <li :class="{ 'selected': post.privacy == 1 }">
                                    <a href="#" @click.prevent="updatePrivacy(1)">
                                        <i class="fa fa-fw fa-users" aria-hidden="true"></i>
                                        Друзья
                                    </a>
                                </li>
                                <li :class="{ 'selected': post.privacy == 2 }">
                                    <a href="#" @click.prevent="updatePrivacy(2)">
                                        <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
                                        Только мне
                                    </a>
                                </li>
                            </ul>
                        </IncludeDropdown>
                        <!--<i class="e-article--motto"></i>-->
                    </div>
                </div>
                <IncludeDropdown class="dropdown-right">
                    <template v-slot:toggle>
                        <div class="btn btn-round size--13 __btn-boder btn-more c-gray">
                            <i class="fa fa-chevron-down m-0" aria-hidden="true"></i>
                        </div>
                    </template>
                    <ul class="dropdown-menu-custom separated" style="text-align: left;">
                        <li v-if="owner_self && post.body">
                            <a href="#" @click.prevent="editing = !editing">
                                <i class="fa fa-fw fa-pencil-alt" aria-hidden="true"></i>
                                Редактировать
                            </a>
                        </li>
                        <li v-if="false">
                            <a href="#">
                                <i class="fa fa-fw fa-flag" aria-hidden="true"></i>
                                Пожаловаться
                            </a>
                        </li>
                        <li>
                            <a href="#" @click="destroy" v-if="owner_self">
                                <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
                                Удалить
                            </a>
                        </li>
                    </ul>
                </IncludeDropdown>
            </div>
        </div>
        <!--
        <a href="">
            <img class="e-article--article" src="/img/other/avatar.jpg" alt="">
        </a>
        -->
        <template v-if="editing">
            <div class="e-box--padding">
                <textarea v-model="edit.body" class="e-post--report form--control form--textarea size--13" autofocus :disabled="updating"></textarea>
                <a class="btn btn-round btn-bigger size--13 weight--600 btn-blue" href="#" @click.prevent="update" :disabled="updating" :class="{ loading: updating }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Сохранить
                </a>
            </div>
        </template>
        <template v-else>
            <div class="e-box--padding e-article--thing" v-if="post.body && !videos.length">
                <!--
                <a class="e-article--unite hover--link" href="">
                    Антропологический политический процесс в современной России
                </a>
                -->
                <p class="e-article--rap">
                    <span class="size--14" v-html="post.body" v-linkified></span>
                </p>
            </div>
            <div class="e-box--padding repost-content" v-if="post.origin">
                <div class="e-box--padding">
                    <div class="e-avatar">
                        <router-link class="e-avatar--photo" :to="post.origin.owner.link" :style="{ 'background-image': 'url(\'' + post.origin.owner.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-article--floor" :to="post.origin.owner.link">
                                {{ post.origin.owner.name }}
                            </router-link>
                            <div class="e-article--utter">
                                <span class="e-article--exile" :title="post.origin.created_at">
                                    {{ origin_created_at }}
                                </span>
                                <i class="e-article--motto"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="e-box--padding" v-if="post.origin.body">
                    <!--
                    <a class="e-article--unite hover--link" href="">
                        Антропологический политический процесс в современной России
                    </a>
                    -->
                    <p class="e-article--rap">
                        <span class="size--14">{{ post.origin.body }}</span>
                    </p>
                </div>
            </div>
            <div v-if="photos.length == 1">
                <div v-for="photo in photos" :key="photo.id" style="cursor: pointer;" @click="showPhoto(photo)">
                    <img :src="photo.thumb_largest" alt="" style="max-width: 100%; max-height: 300px; display: block; margin: 0 auto;">
                </div>
            </div>
            <div class="post-photos" v-else-if="photos.length">
                <div class="swiper-container slider-main">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="photo in photos" :key="photo.id" style="height: 300px; cursor: pointer; background-position: center center; background-size: cover;" :style="{ 'background-image': 'url(\'' + photo.thumb_largest + '\')'}">
                            <!--<img :src="photo.thumb_largest" alt="">-->
                        </div>
                    </div>
                    <span class="photo-prev">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </span>
                    <span class="photo-next">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="swiper-container slider-thumbs" style="max-height: 80px;">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide cd-photos--slide" v-for="photo in photos" style="height: 80px; cursor: pointer; background-position: center center; background-size: cover;" :style="{ 'background-image': 'url(\'' + photo.thumb_360 + '\')'}">
                        </div>
                    </div>
                </div>
            </div>
            <template v-if="videos.length">
                <IncludeVideoPlayer :video="videos[0]"/>
            </template>
            <router-link class="d-block" :to="'/market/announcements/' + announcement.id" v-if="announcement">
                <div v-if="announcement.photo">
                    <img :src="announcement.photo.thumb_largest" :alt="announcement.title" style="width: 100%; max-width: 100%;">
                </div>
                <div class="e-box--padding e-article--thing">
                    <div class="e-article--unite">
                        {{ announcement.title }}
                    </div>
                    <p class="e-article--rap margin--top-10">
                        <span class="size--14">{{ announcement.description }}</span>
                    </p>
                    <div class="e-price margin--top-15 c-black">
                        <span class="size--14 weight--700">
                            {{ announcement.price | price }}
                        </span>
                        <i class="fa fa-ruble-sign weight--700 size--10" v-if="announcement.currency == 1"></i>
                        <i class="fa fa-dollar-sign weight--700 size--10" v-if="announcement.currency == 2"></i>
                        <i class="fa fa-euro-sign weight--700 size--10" v-if="announcement.currency == 3"></i>
                    </div>
                </div>
            </router-link>
        </template>
        <div class="e-article--lead e-box--padding">
            <div class="e-article--cry">
                <a class="e-bwn--like e-bwn" :class="{ like: post.liked }" href="#" @click.prevent="toggleLike">
                    <span class="e-bwn--faith">
                        {{ post.likes_count }}
                    </span>
                </a>
                <a class="e-bwn--share e-bwn" href="#" @click.prevent="repost">
                    <span class="e-bwn--faith">
                        {{ post.reposts_count }}
                    </span>
                </a>
            </div>
            <a class="e-bwn--comment e-bwn" href="#" @click.prevent="showComments">
                <span class="e-bwn--faith">
                    {{ post.comments_count }}
                </span>
            </a>
        </div>
        <IncludeComments v-if="commentsShow" :object_id="post.id" object_type="post" :first_limit="3" />
    </div>
</template>

<script>
import axios from 'axios';
import * as moment from 'moment';
import 'moment/locale/ru';
import toastr from 'toastr';
import { mapGetters, mapActions } from 'vuex';
import Swiper from 'swiper';

import ModalMediaView from './modals/ModalMediaView';

export default {
    props: {
        post: Object
    },
    data() {
        return {
            commentsShow: false,
            created_at: null,
            origin_created_at: null,
            editing: false,
            updating: false,
            edit: {
                body: null
            },
            photos: [],
            videos: [],
            announcement: null,
            swiper: null
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        wall_self() {
            return this.post.wall_type == 'profile' && this.post.wall_id == this.profile.user_id;
        },
        owner_self() {
            return this.post.owner_type == 'profile' && this.post.owner_id == this.profile.user_id;
        }
    },
    created() {
        for (let attachment of this.post.attachments) {
            switch (attachment.attachment_type) {
                case 'photo':
                    this.photos.push(attachment.attachment);
                    break;
                case 'video':
                    this.videos.push(attachment.attachment);
                    break;
                case 'announcement':
                    this.announcement = attachment.attachment;
                    break;
            }
        }

        if (this.photos.length) {
            this.$root.$on('photo:update', payload => {
                let index = this.photos.findIndex(p => p.id == payload.id);
                if (index != -1) {
                    this.$set(this.photos, index, {
                        ...this.photos[index],
                        ...payload
                    });
                }
            });
        }

        if (this.videos.length) {
            this.$root.$on('video:update', payload => {
                let index = this.videos.findIndex(p => p.id == payload.id);
                if (index != -1) {
                    this.$set(this.videos, index, {
                        ...this.videos[index],
                        ...payload
                    });
                }
            });
        }

        this.created_at = moment(this.post.created_at).fromNow();
        setInterval(() => {
            this.created_at = moment(this.post.created_at).fromNow();
        }, 30000);

        if (this.post.origin) {
            this.origin_created_at = moment(this.post.origin.created_at).fromNow();
            setInterval(() => {
                this.origin_created_at = moment(this.post.origin.created_at).fromNow();
            }, 30000);
        }

        this.edit.body = this.post.body;
    },
    mounted() {
        const $cont = $(this.$el).find('.post-photos');
        if ($cont.length) {
            const mini = new Swiper($cont.find('.slider-thumbs')[0], {
                spaceBetween: 5,
                slidesPerView: 4,
                autoHeight: true,
                roundLengths: false,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
            });
            const $big = $cont.find('.slider-main');
            this.swiper = new Swiper($big[0], {
                spaceBetween: 0, //8
                slidesPerView: 'auto',
                /*centeredSlides: vm.announcement.photos.length == 1,*/
                height: 300,
                /*autoHeight: true,*/
                roundLengths: false,
                loop: true,
                loopedSlides: this.photos.length,
                navigation: {
                    nextEl: $big.find('.photo-next')[0],
                    prevEl: $big.find('.photo-prev')[0]
                },
                thumbs: {
                    swiper: mini
                }
            });

            $big.on('click', '.swiper-slide', () => {
                this.showPhoto(this.photos[this.swiper.realIndex]);
            });
        }
    },
    methods: {
        ...mapActions([
            'LIKE',
            'DISLIKE'
        ]),
        async toggleLike() {
            const request = {
                object_id: this.post.id,
                object_type: 'post'
            };

            if (this.post.liked) {
                await this.DISLIKE(request);

                this.$store.commit('POSTS_UPDATE', {
                    id: this.post.id,
                    liked: false,
                    likes_count: this.post.likes_count - 1
                });
            } else {
                await this.LIKE(request);

                this.$store.commit('POSTS_UPDATE', {
                    id: this.post.id,
                    liked: true,
                    likes_count: this.post.likes_count + 1
                });
            }
        },
        async repost() {
            if (this.post.reposted) {
                toastr.error('Вы уже поделились этой публикацией ранее');
                return;
            }

            if (this.wall_self) {
                toastr.error('Невозможно поделиться публикацией с своей же стены');
                return;
            }

            const confirmed = confirm('Вы действительно хотите поделиться этой публикацией?');

            if (!confirmed) return;

            const post = {
                type: 1,
                wall_id: this.profile.user_id,
                wall_type: 'profile',
                owner_id: this.profile.user_id,
                owner_type: 'profile',
                origin_id: this.post.origin_id ? this.post.origin_id : this.post.id
            };

            await axios.post('/api/posts', post);

            toastr.success('Публикация отправлена на вашу страницу');

            this.$store.commit('POSTS_UPDATE', {
                id: this.post.id,
                reposted: true,
                reposts_count: !this.post.origin_id ? (this.post.reposts_count + 1) : this.post.reposts_count
            });
        },
        async updatePrivacy(privacy) {
            await axios.put('/api/posts/' + this.post.id, {
                privacy
            });

            this.$store.commit('POSTS_UPDATE', {
                id: this.post.id,
                privacy
            });

            toastr.success('Видимость публикации успешно изменена');
        },
        async update() {
            this.updating = true;

            const { body } = this.edit;

            await axios.put('/api/posts/' + this.post.id, {
                body
            });

            this.$store.commit('POSTS_UPDATE', {
                id: this.post.id,
                body
            });

            this.editing = false;
            this.updating = false;
        },
        async destroy() {
            const confirmed = confirm('Вы действительно хотите удалить эту публикацию?');

            if (!confirmed) return;

            await axios.delete('/api/posts/' + this.post.id);

            this.$store.commit('POSTS_DELETE', this.post.id);

            toastr.success('Публикация успешно удалена');
        },
        async showComments() {
            this.commentsShow = !this.commentsShow;
        },
        async showPhoto(photo) {
            this.$modal.show(ModalMediaView, {
                object: photo,
                object_type: 'photo',
                object_set: this.photos
            }, {
                classes: '',
                width: '100%',
                height: '100%',
                maxWidth: 2880,
                adaptive: true
            }, {
                'index-changed': index => {
                    this.swiper.slideTo(index);
                }
            });
        }
    }
}
</script>

<style lang="scss">
.post-photos {
    position: relative;

    img {
        max-width: 100%;
        max-height: 300px;
    }

    .slider-thumbs {
        margin-top: 5px;
    }

    .swiper-wrapper {
        align-items: center;
    }

    .swiper-slide {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-container-thumbs {
        .swiper-slide {
            transition: all .15s ease-in;

            &:hover {
                opacity: .9;
            }

            &.swiper-slide-thumb-active {
                opacity: .5;
            }
        }
    }

    .photo-next,
    .photo-prev {
        position: absolute;
        top: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1.1em;
        padding: .5em;
        color: #FFF;
        font-size: 3em;
        opacity: 0;
        cursor: pointer;
        transition: all .15s ease-in;
        z-index: 3;
        text-shadow: 0px 0px 10px rgba(0, 0, 0, .5);

        @media (max-width: 800px) {
            opacity: .5;
        }

        &:hover {
            opacity: 1 !important;
        }
    }

    .photo-next {
        right: 0;
    }

    .photo-prev {
        left: 0;
    }

    & :hover {
        .photo-next,
        .photo-prev {
            opacity: .5;
        }
    }
}
</style>
