<template>
    <div class="modal modal-media" :class="{ 'modal-video': object_type == 'video' }">
        <div class="modal-wrap" v-if="current">
            <div class="media">
                <a :href="makeLink(prev)" class="media-prev" v-if="objects.length != 1 && prev" @click.prevent="swiper.slidePrev()">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </a>
                <div class="swiper-container" style="width: 100%;" v-if="object_type == 'video'" :style="{ opacity: swiperInit ? 1 : 0 }">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="(video, i) in objects" :key="video.id" style="display: flex; align-items: center; justify-content: center;">
                           <IncludeVideoPlayer :video="video" style="width: 100%;" v-if="rendered.includes(video.id) || i == index || i == (index - 1) || i == (index + 1)" @x-created="rendered.push(video.id)"/>
                        </div>
                    </div>
                </div>
                <div class="swiper-container" v-if="object_type == 'photo'" :style="{ opacity: swiperInit ? 1 : 0 }">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="photo in objects" :key="photo.id" style="display: flex; align-items: center; justify-content: center;">
                           <img :srcset="photo.srcset" :src="photo.thumb_largest" alt="" :class="{ 'thumb-portrait': photo.original_width < photo.original_height, 'thumb-landscape': photo.original_width >= photo.original_height }">
                        </div>
                    </div>
                </div>
                <a :href="makeLink(next)" class="media-next" v-if="objects.length != 1 && next" @click.prevent="swiper.slideNext()">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
            <aside>
                <div class="e-box--padding">
                    <div class="e-avatar--50 e-avatar">
                        <router-link class="e-avatar--photo" :to="owner.link" :style="{ 'background-image': 'url(\'' + owner.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link :to="owner.link">
                                {{ owner.name }}
                            </router-link>
                            <p class="color--regent-gray size--13 margin--top-5 margin--bottom-5">
                                {{ created_at }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="e-box--padding photo-actions">
                    <a class="e-bwn--like e-bwn" :class="{ like: current.liked }" href="#" @click.prevent="toggleLike">
                        <span class="e-bwn--faith">
                            {{ current.likes_count }}
                        </span>
                    </a>
                    <a class="e-bwn--comment e-bwn" href="#"><!--@click.prevent="commentFocus"-->
                        <span class="e-bwn--faith">
                            {{ current.comments_count }}
                        </span>
                    </a>
                </div>
                <IncludeComments :object_id="current.id" :object_type="object_type" :scroll="true"/>
            </aside>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import * as moment from 'moment';
import 'moment/locale/ru';
import toastr from 'toastr';
import Swiper from 'swiper';
import { mapGetters, mapActions } from 'vuex';

export default {
    props: {
        object: Object,
        object_type: String,
        object_set: Array,
        object_set_owner: Object,
        closeUri: String
    },
    data() {
        return {
            created_at: null,
            objects: [],
            index: 0,
            initialUri: null,
            swiper: null,
            swiperInit: false,
            rendered: []
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        current() {
            return this.objects[this.index];
        },
        prev() {
            if (this.index == 0) {
                return this.objects[this.objects.length - 1];
                return false;
            }

            return this.objects[this.index - 1];
        },
        next() {
            if (this.index == (this.objects.length - 1)) {
                return this.objects[0];
                return false;
            }

            return this.objects[this.index + 1];
        },
        owner() {
            return this.object_set_owner ? this.object_set_owner : this.current.owner;
        }
    },
    created() {
        this.objects = [ this.object ];
        this.index = 0;

        if (this.object_set) {
            const index = this.object_set.indexOf(this.object);
            if (index != -1) {
                this.objects = this.object_set;
                this.index = index;
            }
        }

        this.initialUri = this.closeUri || document.location.href;
        this.updateUri();

        this.$parent.$on('before-close', () => {
            history.pushState(
                {},
                null,
                this.initialUri
            );
            //this.$router.replace(this.initialUri);
        });

        this.updateCreatedAt();
        setInterval(() => this.updateCreatedAt(), 30000);
        this.$on('comments_count:update', count => {
            this.current.comments_count = count;
        });

        window.addEventListener('keydown', this.keyNav);
    },
    mounted() {
        //if (this.object_type == 'photo') {
            this.swiper = new Swiper($(this.$el).find('.swiper-container')[0], {
                initialSlide: this.index,
                spaceBetween: 0, //8
                slidesPerView: 'auto',
                centeredSlides: true,
                /*height: 300,*/
                /*autoHeight: true,*/
                roundLengths: false,
                loop: true,
                loopedSlides: this.objects.length,
                on: {
                    init: () => {
                        this.swiperInit = true
                    }
                }
                /*
                navigation: {
                    nextEl: $(this.$el).find('.media-next')[0],
                    prevEl: $(this.$el).find('.media-prev')[0]
                }
                */
            });

            this.swiper.on('slideChange', () => {
                this.index = this.swiper.realIndex;
            });
        //}
    },
    beforeDestroy() {
        window.removeEventListener('keydown', this.keyNav)
    },
    watch: {
        index() {
            this.$parent.$emit('index-changed', this.index);

            if (this.index == 0) {
                this.$parent.$emit('first');
            }

            if (this.index == (this.objects.length - 1)) {
                this.$parent.$emit('last');
            }
        },
        current(newVal, oldVal) {
            this.updateCreatedAt();
            this.updateUri();

            if (oldVal) {
                //this.loadComments();
            }
        }
    },
    methods: {
        ...mapActions([
            'LIKE',
            'DISLIKE'
        ]),
        updateCreatedAt() {
            this.created_at = moment(this.current.created_at).fromNow();
        },
        updateUri() {
            if (this.object_type == 'photo') {
                history.pushState(
                    {},
                    null,
                    this.makeLink(this.current)
                );
                //this.$router.replace(this.owner.link + '/photos/' + this.current.id);
            }
        },
        makeLink(object) {
            if (this.object_type == 'photo') {
                return this.owner.link + '/photos/' + (object.album_id ? 'albums/' + object.album_id + '/' : '') + object.id;
            }

            if (this.object_type == 'video') {
                return this.owner.link + '/videos/' + (object.album_id ? 'albums/' + object.album_id + '/' : '') + object.id;
            }
        },
        async toggleLike() {
            const { object_type } = this;
            const request = {
                object_id: this.current.id,
                object_type
            };

            if (this.current.liked) {
                await this.DISLIKE(request);
                this.$root.$emit(this.object_type + ':update', {
                    id: this.current.id,
                    liked: false,
                    likes_count: this.current.likes_count - 1
                });
            } else {
                await this.LIKE(request);
                this.$root.$emit(this.object_type + ':update', {
                    id: this.current.id,
                    liked: true,
                    likes_count: this.current.likes_count + 1
                });
            }
        },
        keyNav(e) {
            if (this.objects.length == 1) return;

            e = e || window.event;

            if (e.keyCode == '37') {
               this.swiper.slidePrev();
            }

            if (e.keyCode == '39') {
               this.swiper.slideNext();
            }
        }
    }
}
</script>

<style lang="scss">
.modal-media {
    max-width: 2880px;
    width: 90vw;
    height: calc(100vh - 6em);
    /*height: 100%;*/

    .modal-video {
        height: auto;
    }

    @media (max-width: 800px) {
        height: auto;
        width: 100%;
        margin-top: -20px;
        margin-bottom: -20px;
        border-radius: 0;

        .close-modal {
            top: 1em !important;
            right: 1em !important;
            z-index: 99999;
        }
    }

    .modal-wrap {
        display: flex;
        border-radius: 0;
        height: 100%;

        @media (max-width: 800px) {
            flex-direction: column;
            height: auto;
        }

        .media {
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
            flex: 1;

            @media (max-width: 800px) {
                flex: none;
                height: 100vw;
                overflow: hidden;
            }

            img {
                max-width: 100%;
                max-height: 100%;

                @media (max-width: 800px) {
                    position: absolute;
                    top: -100%;
                    bottom: -100%;
                    right: -100%;
                    left: -100%;
                    /*height: 100%;*/
                    margin: auto;
                    max-width: none;
                    max-height: none;

                    &.thumb-landscape {
                        height: 100%
                    }
                    
                    &.thumb-portrait {
                        width: 100%;
                    }
                }
            }

            .media-next,
            .media-prev {
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
                z-index: 9999;

                @media (max-width: 800px) {
                    opacity: .5;
                }

                &:hover {
                    opacity: 1 !important;
                }
            }

            .media-next {
                right: 0;
            }

            .media-prev {
                left: 0;
            }

            &:hover {
                .media-next,
                .media-prev {
                    opacity: .5;
                }
            }
        }

        aside {
            width: 320px;
            display: flex;
            flex-direction: column;

            @media (max-width: 800px) {
                width: auto;
            }

            .photo-actions {
                border-top: 1px solid #E6E9EE;
                /*border-bottom: 1px solid #E6E9EE;*/

                .e-bwn--comment {
                    float: right;
                }
            }
        }
    }
}
</style>
