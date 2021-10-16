<template>
    <div class="modal modal-photo">
        <div class="modal-wrap" v-if="photo">
            <div class="photo">
                <router-link class="photo-prev" :to="prev" v-if="prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </router-link>
                <img :srcset="photo.srcset" :src="photo.thumb_largest" alt="" :class="{ 'thumb-portrait': photo.original_width < photo.original_height, 'thumb-landscape': photo.original_width >= photo.original_height }">
                <router-link class="photo-next" :to="next" v-if="next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </router-link>
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
                    <a class="e-bwn--like e-bwn" :class="{ like: photo.liked }" href="#" @click.prevent="toggleLike">
                        <span class="e-bwn--faith">
                            {{ photo.likes_count }}
                        </span>
                    </a>
                    <a class="e-bwn--comment e-bwn" href="#"><!--@click.prevent="commentFocus"-->
                        <span class="e-bwn--faith">
                            {{ photo.comments_count }}
                        </span>
                    </a>
                </div>
                <IncludeComments :object_id="photo.id" object_type="photo" :scroll="true"/>
            </aside>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import * as moment from 'moment';
import 'moment/locale/ru';
import toastr from 'toastr';
import { mapGetters, mapActions } from 'vuex';

export default {
    props: {
        photo: Object,
        owner: Object,
        prev: String,
        next: String
    },
    data() {
        return {
            created_at: null,
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        })
    },
    created() {
        this.$on('comments_count:update', count => {
            this.photo.comments_count = count;
        });
    },
    watch: {
        photo(newVal, oldVal) {
            this.created_at = moment(this.photo.created_at).fromNow();
            setInterval(() => {
                this.created_at = moment(this.photo.created_at).fromNow();
            }, 30000);

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
        async toggleLike() {
            const request = {
                object_id: this.photo.id,
                object_type: 'photo'
            };

            if (this.photo.liked) {
                await this.DISLIKE(request);
                this.photo.liked = false;
                this.photo.likes_count--;
            } else {
                await this.LIKE(request);
                this.photo.liked = true;
                this.photo.likes_count++;
            }
        }
    }
}
</script>

<style lang="scss">
.modal-photo {
    max-width: 2880px;
    width: 90vw;
    height: calc(100vh - 6em);
    /*height: 100%;*/

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

        .photo {
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
                z-index: 9999;

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

            &:hover {
                .photo-next,
                .photo-prev {
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
