<template>
    <LayoutMain white-header v-if="announcement.id">
        <div class="cn-shop cn-shop--page">
            <div class="cn-shop--inner">
                <div class="cn-shop--white cn-shop--wrap cn-shop--wrap-widder">
                    <div class="cn-shop--cope">
                        <div class="sp-speedbar">
                            <router-link class="size--14" to="/market">
                                Главная
                            </router-link>
                            <template v-if="category">
                                <router-link class="size--14" to="/market/categories">
                                    Категории
                                </router-link>
                                <router-link class="size--14" :to="'/market/announcements?category_id=' + category.id">
                                    {{ category.name }}
                                </router-link>
                            </template>
                            <a class="size--14" href="#" v-else>
                                 Без категории
                            </a>
                            <span class="size--14">
                                Объявление #{{ announcement.id }}
                            </span>
                            <span class="views-counter size--14">
                                <i class="fa fa-eye color--regent-gray" aria-hidden="true"></i>
                                {{ announcement.views }}
                                <span class="weight--700">
                                    ({{ announcement.views_today }})
                                </span>
                            </span>
                            <div class="sp-speedbar-right">
                                <span class="size--24 weight--700">
                                    {{ announcement.price | price }}
                                </span>
                                <i class="fa fa-ruble-sign color--black size--12" v-if="announcement.currency == 1"></i>
                                <i class="fa fa-dollar-sign color--black size--12" v-if="announcement.currency == 2"></i>
                                <i class="fa fa-euro-sign color--black size--12" v-if="announcement.currency == 3"></i>
                            </div>
                        </div>
                        <div class="cn-card">
                            <div class="cn-card--body">
                                <div class="cd-head">
                                    <div>
                                        <span class="color--black size--24 weight--700">
                                            {{ announcement.title }}
                                        </span>
                                    </div>
                                    <div class="e-icow">
                                        <div class="e-icow--refer ann-like" style="margin: 0;" :class="{ liked: announcement.liked }" @click="toggleLike">
                                            <i class="fa fa-heart" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="cd-photos" v-if="announcement.photos && announcement.photos.length">
                                    <div class="swiper-container" id="cd-photos-big" style="margin-bottom: 8px;">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide" v-for="photo in announcement.photos">
                                                <img class="img-fluid __img-full" :srcset="photo.srcset" :src="photo.thumb_largest" alt="" :sizes="photo.original_width + 'px'" style="height: 400px;">
                                            </div>
                                        </div>
                                        <!--
                                        <div class="swiper-button swiper-button-prev" v-show="hasPrev"></div>
                                        <div class="swiper-button swiper-button-next" v-show="hasNext"></div>
                                        -->
                                        <template v-show="announcement.photos.length">
                                            <span class="photo-prev">
                                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                                            </span>
                                            <span class="photo-next">
                                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                                            </span>
                                        </template>
                                    </div>
                                    <div class="swiper-container" id="cd-photos-small" style="max-height: 100px;">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide cd-photos--slide" v-for="photo in announcement.photos" style="height: 100px; background-position: center center; background-size: cover;" :style="{ 'background-image': 'url(\'' + photo.thumb_360 + '\')'}">
                                                <!--
                                                <img class="img-fluid __img-full" :srcset="photo.srcset" :src="photo.original" alt="" :sizes="photo.original_width + 'px'" style="max-height: 100px;">
                                            -->
                                            </div>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="cd-photos--btn cd-photos--like" :class="{ liked: announcement.liked }" @click="toggleLike">
                                        < ! --
                                        <i class="ico ico--like-blue"></i>
                                        - - >
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </div>
                                    -->
                                    <!--
                                    <div class="cd-photos--btn cd-photos--zoom">
                                        <i class="ico ico--zoom"></i>
                                    </div>
                                    -->
                                </div>
                                <!--
                                <div class="cd-foot">
                                    <div class="e-icow" v-if="announcement.country || announcement.city">
                                        <div class="e-icow--refer">
                                            <i class="ico--location ico"></i>
                                        </div>
                                        <div class="e-icow--note">
                                            <p class="size--13" v-if="announcement.country">
                                                {{ announcement.country.name }}
                                            </p>
                                            <p v-if="announcement.city">
                                                {{ announcement.city.name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="e-icow">
                                        <div class="e-icow--refer">
                                            <i class="ico--calendar ico"></i>
                                        </div>
                                        <div class="e-icow--note">
                                            <p class="size--13">
                                                Опубликовано в {{ created_at_time }},
                                            </p>
                                            <p class="color--regent-gray size--13">
                                                {{ created_at_date }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                -->
                                <div class="line-height--1_6 padding--top-30">
                                    <p class="color--black">
                                        {{ announcement.description }}
                                    </p>
                                </div>
                                <hr>
                                <table class="e-table">
                                    <tbody>
                                        <tr>
                                            <td class="color--regent-gray">
                                                Опубликовано:
                                            </td>
                                            <td>
                                                {{ created_at_time }},
                                                {{ created_at_date }}
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.from">
                                            <td class="color--regent-gray">
                                                Объявление от:
                                            </td>
                                            <td>
                                                <router-link class="color--daisy-bush" :to="announcement.owner.link" v-if="announcement.from == 1">
                                                    частного пользователя
                                                </router-link>
                                                <router-link class="color--daisy-bush" :to="announcement.owner.link" v-if="announcement.from == 2">
                                                    заводчика
                                                </router-link>
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.country || announcement.city">
                                            <td class="color--regent-gray">
                                                Местоположение:
                                            </td>
                                            <td>
                                                <template v-if="announcement.city">
                                                    {{ announcement.city.name }},
                                                </template>
                                                {{ announcement.country.name }}
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.contract != undefined">
                                            <td class="color--regent-gray">
                                                Договор:
                                            </td>
                                            <td v-if="announcement.contract">
                                                да
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.vetpassport != undefined">
                                            <td>
                                                <router-link class="color--daisy-bush" :to="pet.link + '/passport'" v-if="pet && pet.slug">
                                                    Ветпаспорт:
                                                </router-link>
                                                <template v-else>
                                                    Ветпапорт:
                                                </template>
                                            </td>
                                            <td v-if="announcement.vetpassport">
                                                да
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.pedigree != undefined">
                                            <td>
                                                <router-link class="color--daisy-bush" :to="pet.link + '/pedigree'" v-if="pet && pet.slug">
                                                    Родословная:
                                                </router-link>
                                                <template v-else>
                                                    Родословная:
                                                </template>
                                            </td>
                                            <td v-if="announcement.pedigree">
                                                да
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        <!--
                                        <tr>
                                            <td class="color--regent-gray">
                                                Торг:
                                            </td>
                                            <td v-if="announcement.bargain">
                                                уместен
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        -->
                                        <tr v-if="announcement.gender">
                                            <td class="color--regent-gray">
                                                Пол:
                                            </td>
                                            <td v-if="announcement.gender == 1">
                                                мужской
                                            </td>
                                            <td v-if="announcement.gender == 2">
                                                женский
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.birthday">
                                            <td class="color--regent-gray">
                                                Возраст:
                                            </td>
                                            <td>
                                                {{ announcement.birthday | fromnow(true) }}
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.vaccination != undefined">
                                            <td class="color--regent-gray">
                                                Прививки:
                                            </td>
                                            <td v-if="announcement.vaccination">
                                                да
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.mark != undefined">
                                            <td class="color--regent-gray">
                                                Клеймо:
                                            </td>
                                            <td v-if="announcement.mark">
                                                да
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        <tr v-if="announcement.chip != undefined">
                                            <td class="color--regent-gray">
                                                Чип:
                                            </td>
                                            <td v-if="announcement.chip">
                                                да
                                            </td>
                                            <td v-else>
                                                нет
                                            </td>
                                        </tr>
                                        <tr v-if="pet && pet.user_id">
                                            <td class="color--regent-gray">
                                                Профиль питомца:
                                            </td>
                                            <td>
                                                <router-link class="color--daisy-bush" :to="'/' + pet.slug" v-if="pet && pet.slug">
                                                    посмотреть
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div style="display: flex; align-items: center;">
                                    <div class="cd-social" style="flex: 1;">
                                        <a class="cd-social--fb" target="_blank" :href="share_link_facebook"></a>
                                        <a class="cd-social--ig" target="_blank" :href="share_link_instagram" style="opacity: .2;"></a>
                                        <a class="cd-social--vk" target="_blank" :href="share_link_vk"></a>
                                        <!--<a class="cd-social--od" href=""></a>-->
                                        <a class="cd-social--wp" target="_blank" :href="share_link_whatsapp"></a>
                                        <a class="cd-social--tl" target="_blank" :href="share_link_telegram"></a>
                                        <a class="cd-social--em" :href="share_link_email"></a>
                                    </div>
                                    <router-link class="btn btn-round btn-bigger size--12 weight--600 btn-blue btn-green" :to="'/settings/announcements/' + announcement.id + '/edit'" v-if="announcement.can_edit">
                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                        Редактировать
                                    </router-link>
                                </div>
                            </div>
                            <div class="cn-card--bar">
                                <div>
                                    <div class="cd-bar">
                                        <button class="btn btn-block btn-gray-border-style" v-if="announcement.owner_type == 'shop'" @click="toggleCart">
                                            <span class="c-violet" v-if="announcement.in_cart">
                                                <i class="fa fa-fw fa-cart-arrow-down" aria-hidden="true"></i>
                                                В корзине
                                            </span>
                                            <template v-else>
                                                <i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i>
                                                Добавить в корзину
                                            </template>
                                        </button>
                                        <router-link class="btn-blue-border-style btn btn-green-style btn-block" :to="'/' + pet.slug" v-if="pet && pet.slug">
                                            Профиль питомца
                                        </router-link>
                                        <template v-if="announcement.can_edit">
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('promote-color')">
                                                Выделить цветом
                                            </button>
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('promote-pushup')">
                                                Поднять вверх
                                            </button>
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('promote-pin')">
                                                Закрепить вверху
                                            </button>
                                            <router-link class="btn btn-block btn-gray-border-style" :to="'/settings/announcements/' + announcement.id + '/edit'">
                                                <!--<i class="fa fa-pencil-alt" aria-hidden="true"></i>-->
                                                Редактировать
                                            </router-link>
                                        </template>
                                        <template v-else>
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('contact')">
                                                Показать телефон
                                            </button>
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('contact')">
                                                Написать владельцу
                                            </button>
                                        </template>
                                        <div class="e-avatar--65 e-avatar">
                                            <router-link
                                                class="e-avatar--photo"
                                                :to="announcement.owner.link"
                                                :style="{
                                                    'background-image': 'url(\'' + announcement.owner.avatar + '\')',
                                                    'border-radius': (announcement.owner_type == 'shop' ? 0 : null)
                                                }"
                                            ></router-link>
                                            <div class="e-avatar--content">
                                                <router-link class="color--mirage" :to="announcement.owner.link">
                                                    {{ announcement.owner.name }}
                                                </router-link>
                                                <p class="color--regent-gray size--13 margin--top-5 margin--bottom-5">
                                                    на сервисе с {{ owner_created_at }}
                                                </p>
                                                <template v-if="announcement.owner.rating">
                                                    <span class="size--13">
                                                    Рейтинг:
                                                    </span>
                                                    <span class="color--daisy-bush size--13">
                                                        {{ announcement.owner.rating }}
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                        <router-link class="btn btn-block btn-gray-border-style" :to="announcement.owner.link + '/reviews'">
                                            Отзывы
                                            <IncludeStars class="margin--left-10" :value="announcement.owner.stars"/>
                                        </router-link>
                                        <template v-if="!announcement.can_edit">
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('review-add')">
                                                Оставить отзыв
                                            </button>
                                            <button class="btn btn-block btn-gray-border-style" @click="showModal('report')" style="opacity: .2;">
                                                Пожаловаться
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <div class="cd-bar--make scrollbar-inner">
                                    <IncludeReview v-for="review in reviews" :review="review" :key="review.id"/>
                                    <!--
                                    <div class="sp-nav">
                                        <a class="sp-nav--arrow sp-nav--prev" href="">
                                            <i></i>
                                        </a>
                                        <div class="sp-nav--center">
                                            <a href="">1</a>
                                            <a class="active" href="">2</a>
                                            <a href="">3</a>
                                            <a href="">4</a>
                                            <span href="">...</span>
                                            <a href="">9</a>
                                        </div>
                                        <a class="sp-nav--arrow sp-nav--next" href="">
                                            <i></i>
                                        </a>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cn-shop--gray cn-shop--wrap cn-shop--wrap-widder" v-if="popular.length">
                    <h3 class="size--18 weight--700 padding--bottom-25">
                        Популярные объявления
                    </h3>
                    <div class="grid grid--gap grid--five">
                        <IncludeAnnouncement v-for="pann in popular" :announcement="pann" :key="pann.id"/>
                    </div>
                    <div class="style--center padding--top-50">
                        <router-link to="/market/announcements" class="btn btn-blue-style btn-wider">
                            Больше объявлений
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:sidebar-content>
            <IncludeAnnouncementAside :announcement="announcement"/>
        </template>
    </LayoutMain>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import NProgress from 'nprogress';
import * as moment from 'moment';
import 'moment/locale/ru';
import Swiper from 'swiper';

import { mapGetters, mapActions } from 'vuex';
import { mapCacheActions } from 'vuex-cache';

import ModalUserContact from '../../../includes/modals/ModalUserContact';
import ModalReviewAdd from '../../../includes/modals/ModalReviewAdd';
import ModalAnnouncementColor from '../../../includes/modals/ModalAnnouncementColor';
import ModalAnnouncementPin from '../../../includes/modals/ModalAnnouncementPin';
import ModalAnnouncementPushup from '../../../includes/modals/ModalAnnouncementPushup';

export default {
    data() {
        return {
            announcement: {},
            reviews: [],
            pet: {},
            //similar: [],
            popular: []
        }
    },
    computed: {
        ...mapGetters([
            'user',
        ]),
        ...mapGetters({
            profile: 'selfProfile'
        }),
        category() {
            return this.categories.find(c => c.id == this.announcement.category_id);
        },
        created_at_date() {
            return moment(this.announcement.created_at).format('DD MMMM YYYY');
        },
        created_at_time() {
            return moment(this.announcement.created_at).format('hh:mm');
        },
        owner_created_at() {
            return moment(this.announcement.owner.created_at).format('MMM YYYY');
        },
        share_link_facebook() {
            return 'https://www.facebook.com/sharer.php?u=' + encodeURIComponent(document.location.href);
        },
        share_link_instagram() {

        },
        share_link_vk() {
            return 'https://vk.com/share.php?url=' + encodeURIComponent(document.location.href) + '&title=' + encodeURIComponent(this.announcement.title) + '&description=' + encodeURIComponent(this.announcement.description);
        },
        share_link_whatsapp() {
            return 'https://wa.me/?text=' + encodeURIComponent(this.announcement.title + '\n' + document.location.href);
        },
        share_link_telegram() {
            return 'https://telegram.me/share/url?url=' + encodeURIComponent(document.location.href) + '&text=' + encodeURIComponent(this.announcement.title);
        },
        share_link_email() {
            return 'mailto:?body=' + encodeURIComponent(this.announcement.title + '\n\n' + (this.announcement.description ? this.announcement.description + '\n\n' : '') + document.location.href) + '&subject=' + encodeURIComponent('Объявление на сервисе PetPassport');
        }
    },
    asyncComputed: {
        categories: {
            async get() {
                return await this.MARKET_CATEGORIES_GET();
            },
            default: []
        }
    },
    async beforeRouteEnter(to, from, next) {
        NProgress.start();
        const data = (await axios.get('/api/announcements/' + to.params.id)).data;
        const reviews = (await axios.get('/api/reviews', {
            params: {
                owner_id: data.announcement.owner_id,
                owner_type: data.announcement.owner_type
            }
        })).data;
        NProgress.done();
        next(vm => {
            // TODO: mass assign
            vm.announcement = data.announcement;
            vm.pet = data.pet;
            if (vm.announcement.photos && vm.announcement.photos.length) {
                vm.$nextTick(() => vm.createSlider());
            }
            vm.reviews = reviews;
            //vm.similar = data.similar;
            vm.popular = data.popular;
        });
    },
    async beforeRouteUpdate(to, from, next) {
        NProgress.start();
        const data = (await axios.get('/api/announcements/' + to.params.id)).data;
        const reviews = (await axios.get('/api/reviews', {
            params: {
                owner_id: data.announcement.owner_id,
                owner_type: data.announcement.owner_type
            }
        })).data;
        NProgress.done();
        this.announcement = data.announcement;
        this.pet = data.pet;
        if (this.announcement.photos && this.announcement.photos.length) {
            this.$nextTick(() => this.createSlider());
        }
        this.reviews = reviews;
        //this.similar = data.similar;
        this.popular = data.popular;
        next();
    },
    created() {
        this.$root.$on('cart:add', announcement_id => {
            if (announcement_id == this.announcement.id) {
                this.announcement.in_cart = true;
            }
        });
        this.$root.$on('cart:delete', announcement_id => {
            if (announcement_id == this.announcement.id) {
                this.announcement.in_cart = false;
            }
        });
    },
    mounted() {
        $(this.$el).find('.cd-bar--make').scrollbar();
    },
    methods: {
        ...mapCacheActions([
            'MARKET_CATEGORIES_GET'
        ]),
        ...mapActions([
            'CART_ADD',
            'CART_DELETE'
        ]),
        showModal(name) {
            console.log(1111);
            if (name == 'contact') {
                this.$modal.show(ModalUserContact, {
                    profile: this.announcement.owner
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                });
                return;
            }

            if (name == 'review-add') {
                const { owner_id, owner_type } = this.announcement;
                this.$modal.show(ModalReviewAdd, {
                    owner: this.announcement.owner,
                    owner_id,
                    owner_type
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                }, {
                    'review-stored': this.reviewStored
                });
                return;
            }

            const { announcement } = this;

            if (name == 'promote-color') {
                this.$modal.show(ModalAnnouncementColor, {
                    announcement
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                });
            }

            if (name == 'promote-pin') {
                this.$modal.show(ModalAnnouncementPin, {
                    announcement
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                });
            }

            if (name == 'promote-pushup') {
                this.$modal.show(ModalAnnouncementPushup, {
                    announcement
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                });
            }
        },
        createSlider() {
            const vm = this;
            const $el = $(this.$el);

            const $mini = $el.find('#cd-photos-small');
            const mini = new Swiper($mini[0], {
                spaceBetween: 8,
                slidesPerView: 4,
                autoHeight: true,
                roundLengths: false,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
            });

            const $big = $el.find('#cd-photos-big');
            const big = new Swiper($big[0], {
                spaceBetween: 8,
                slidesPerView: 'auto',
                centeredSlides: vm.announcement.photos.length == 1,
                height: 400,
                /*autoHeight: true,*/
                roundLengths: false,
                loop: true,
                loopedSlides: vm.announcement.photos.length,
                navigation: {
                    nextEl: $big.find('.photo-next')[0],
                    prevEl: $big.find('.photo-prev')[0]
                },
                thumbs: {
                    swiper: mini
                }
            });

            /*
            big.on('slideChange', () => {
                if (big.realIndex > 0 && big.realIndex < big.slides.length) {
                    mini.slideTo(big.realIndex - 1);
                }
                //console.log(big.realIndex + ' / ' + big.previousIndex);
            });
            */
            big.on('slideNextTransitionStart', () => {
                mini.slideTo(big.realIndex - 1);
            });

            big.on('slidePrevTransitionStart', () => {
                mini.slideTo(big.realIndex - 2);
            });
        },
        toggleLike() {
            if (this.announcement.liked) {
                this.dislike();
            } else {
                this.like();
            }
        },
        async like() {
            await this.$store.dispatch('LIKE', {
                object_id: this.announcement.id,
                object_type: 'announcement'
            });

            this.announcement.liked = true;
        },
        async dislike() {
            await this.$store.dispatch('DISLIKE', {
                object_id: this.announcement.id,
                object_type: 'announcement'
            });

            this.announcement.liked = false;
        },
        reviewStored(response) {
            this.reviews.unshift(response);
            this.announcement.owner = response.owner;
        },
        async toggleCart() {
            if (this.announcement.in_cart) {
                await this.CART_DELETE(this.announcement.id);
                this.$root.$emit('cart:delete', this.announcement.id);
            } else {
                await this.CART_ADD(this.announcement.id);
                this.$root.$emit('cart:add', this.announcement.id);
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.cd-head {
    display: flex;
    align-items: flex-end;
    margin-bottom: 1.50em;
    /* white-space: nowrap; */
}
.cd-head > div:first-child {
    margin-right: auto;
}
.cd-head > div + div {
    margin-left: 1.2em;
}

.sp-speedbar {
    display: flex;
    align-items: center;

    .views-counter {
        margin-left: 2em;

        span {
            color: #FA6251;
        }
    }

    .sp-speedbar-right {
        margin-left: auto;

        @media (min-width: 1200px) {
            width: 14.34em;
            text-align: center;
        }
    }
}

.cd-photos {
    position: relative;
}
.cd-photos--btn {
    position: absolute;
    top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    /*
    border-radius: 100%;
    background-color: rgba(255,255,255,1.00);
    border-radius: 2.00em;
    box-shadow: 0px 1px 1px rgba(30,38,56,0.64);
    */
    width: 40px;
    height: 40px;
    color: #FFF;
    font-size: 1.5em;
    opacity: .5;
    cursor: pointer;
    transition: all .15s ease-in;
    z-index: 3;
    text-shadow: 0px 0px 10px rgba(0, 0, 0, .5);

    &:hover {
        opacity: 1;
    }
}
/*
.cd-photos--like {
    left: 20px;
    cursor: pointer;

    &.liked {
        opacity: 1;
        color: rgb(255, 49, 49);
    }
}
*/
.ann-like {
    color: #818996;
    cursor: pointer;

    &.liked {
        color: rgb(255, 49, 49);
    }
}
.cd-photos--zoom {
    right: 20px;
    cursor: pointer;
}
.cd-photos--slide {
    cursor: pointer;
}

.cd-photos {
    .swiper-wrapper {
        align-items: center;

        .swiper-slide {
            width: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
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
/*
.cd-foot {
    display: flex;
    padding-top: 1.2em;

    & > div + div {
        margin-left: 1.2em;
    }
}
*/
.cd-social {
    display: flex;
    align-items: flex-start
}
.cd-social--fb {
    background-image: url(/img/icons/social-color/f.svg);
    border: 1px solid #395599;
}
.cd-social--ig {
    background-image: url(/img/icons/social-color/insta.svg);
    border: 1px solid #dc1d6d;
}
.cd-social--vk {
    background-image: url(/img/icons/social-color/vk.svg);
    border: 1px solid #5181b8;
}
.cd-social--od {
    background-image: url(/img/icons/social-color/od.svg);
    border: 1px solid #f8a73c;
}
.cd-social--wp {
    background-image: url(/img/icons/social-color/ws.svg);
    border: 1px solid #41bf53;
}
.cd-social--tl {
    background-image: url(/img/icons/social-color/tel.svg);
    border: 1px solid #2ea3d6;
}
.cd-social--em {
    background-image: url(/img/icons/social-color/email.svg);
    border: 1px solid #4d23b3;
}
.cd-social > a {
    background-repeat: no-repeat;
    background-position: 50% 50%;
    border-radius: 100%;
    width: 2.50em;
    height: 2.50em;
    margin-right: 0.60em;
}

.cd-bar {
    .btn {
        font-size: .88em;
        padding-top: .78em;
        padding-bottom: .78em;
        line-height: normal;
    }
}

.cn-card--bar {
    flex-shrink: 0;
    padding-top: 2.9em;

    @media (min-width: 576px) {
        display: flex;
        margin: 0 -15px;

        & > *,
        ::v-deep > *, {
            flex-basis: 100%;
            padding: 0 15px !important;
        }
    }

    @media (min-width: 1200px) {
        flex-direction: column;
        padding-top: .4em;
        margin: 0 0 0 5.4em;
        width: 14.34em;

        & > *,
        ::v-deep > *, {
            flex-basis: 0;
            padding: 0 !important;
        }

        ::v-deep .cd-bar--make {
            flex: 1;
            flex-basis: 0;
        }
    }
}
</style>
