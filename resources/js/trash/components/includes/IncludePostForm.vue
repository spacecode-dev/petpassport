<template>
    <div class="e-box e-box--padding e-post--new">
        <div class="e-card-shop--exile">
            <div class="e-post--gage">
                <div class="e-avatar">
                    <a class="e-avatar--photo" href="#" style="background: #fa6251;" v-if="sos"></a>
                    <!--<a class="e-avatar--photo" href="#" style="border: 3px solid #fa6251;" :style="{ 'background-image': 'url(\'' + profile.profile.avatar + '\')' }" v-if="sos"></a>-->
                    <a class="e-avatar--photo" href="#" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }" v-else></a>
                    <div class="e-avatar--content"></div>
                </div>
                <textarea class="e-post--report form--control form--textarea size--13" rows="" :placeholder="'Что случилось, ' + profile.name + '?'" v-model="post.body" v-if="sos"></textarea>
                <textarea class="e-post--report form--control form--textarea size--13" rows="" :placeholder="'Что нового, ' + profile.name + '?'" v-model="post.body" v-else></textarea>
                <div class="e-post--lead">
                    <i class="ico--photo ico" style="cursor: pointer;" @click="selectPhotos"></i>
                    <i class="ico--smile ico"></i>
                </div>
            </div>
            <div class="e-post--gage" v-if="photos.length">
                <div v-for="photo in photos" :key="photo.id" class="att-photo" :style="{ 'background-image': 'url(\'' + photo.thumb_180 + '\')' }">
                    <div class="att-photo-remove" @click="attPhotoRemove(photo.id)">
                        <i class="fa fa-times c-white" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="e-card-shop--subject">
            <template v-if="sos">
                <router-link class="btn btn-round btn-bigger size--13 weight--600 btn-boder btn-gray" to="/settings">
                    Указать детали
                </router-link>
                <a class="btn btn-round btn-bigger size--13 weight--600 btn-blue" style="background: #fa6251;" href="#" @click.prevent="storePost" :disabled="posting" :class="{ loading: posting }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Опубликовать
                </a>
            </template>
            <template v-else>
                <select class="btn btn-round btn-bigger size--13 btn-boder wide" v-model="post.privacy">
                    <option value="0">
                        Публичный
                    </option>
                    <option value="1">
                        Друзья
                    </option>
                    <option value="2">
                        Только мне
                    </option>
                </select>
                <a class="btn btn-round btn-bigger size--13 weight--600 btn-blue" href="#" @click.prevent="storePost" :disabled="posting" :class="{ loading: posting }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Опубликовать
                </a>
            </template>
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
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

import ModalSelectPhotos from './modals/ModalSelectPhotos';

export default {
    props: {
        sos: {
            type: Boolean,
            default: false
        },
        wall_id: [Number, String],
        wall_type: {
            type: String,
            default: 'profile'
        }
    },
    data() {
        return {
            posting: false,
            post: {
                body: null,
                type: 1,
                owner_type: 'profile',
                privacy: 0
            },
            photos: []
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        })
    },
    created() {
        //this.$root.on('photos-selected', this.photosSelected);
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
        /*
        $('#modal-attach-photo').modal({
            fadeDuration: 250
        });
        */
    },
    watch: {
        sos() {
            if (this.sos) {
                $(this.$el).find('select').niceSelect('destroy');
                this.$nextTick(() => {
                    $(this.$el).find('textarea')[0].focus();
                });
            } else {
                this.$nextTick(() => {
                    $(this.$el).find('select').niceSelect();
                });
            }
        }
    },
    methods: {
        async storePost() {
            this.posting = true;
            const data = this.post;
            data.wall_id = this.wall_id;
            data.wall_type = this.wall_type;
            data.owner_id = this.profile.user_id;
            data.sos = + this.sos;

            if (this.photos.length) {
                const photos = [];
                for (const photo of this.photos) {
                    photos.push(photo.id);
                }
                data.photos = photos.join(',');
            }

            const post = (await axios.post('/api/posts', data)).data;

            post.owner = this.profile;
            post.likes_count = 0;
            post.liked = false;
            post.reposts_count = 0;
            post.reposted = false;
            post.sos = this.sos;

            this.$store.commit('POSTS_UNSHIFT', post);

            this.post.body = null;
            this.photos = [];
            this.posting = false;
        },
        selectPhotos() {
            this.$modal.show(ModalSelectPhotos, {
                owner_id: this.profile.user_id,
                owner_type: 'profile',
                section: 4
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            }, {
                'photos-selected': this.photosSelected
            });
        },
        photosSelected(photos) {
            this.photos = this.photos.concat(photos);
        },
        attPhotoRemove(id) {
            this.photos = this.photos.filter(p => p.id != id);
        }
    }
}
</script>

<style lang="scss" scoped>
.att-photo {
    margin: 10px 10px 0 0;
    background-size: cover;
    width: 40px;
    height: 40px;

    .att-photo-remove {
        display: none;
        height: 100%;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .7);
        cursor: pointer;
    }

    &:hover .att-photo-remove {
        display: flex;
    }
}
</style>
