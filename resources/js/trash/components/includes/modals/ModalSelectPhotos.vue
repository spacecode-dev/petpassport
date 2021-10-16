<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Выберите
                    <template v-if="count > 1">
                        фотографии
                    </template>
                    <template v-else>
                        фотографию
                    </template>
                </p>
                <!--
                <p class="usl-do size--13 margin--top-25">
                    ...
                </p>
                -->
            </div>
            <!--
            <div>
                <button class="btn btn-bigger btn-block btn-gray btn-boder size--13">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Загрузить новое фото
                </button>
            </div>
        -->
            <div class="modal-box" style="padding-top: .77em;">
                <ul class="left e-tab--nav add">
                    <li class="label-show" :class="{ active: tab == 'all' }" @click="selectTab('all')">
                        <span class="size--14">
                            Все фотографии
                        </span>
                    </li>
                    <li class="label-show" :class="{ active: tab.startsWith('album') }" @click="selectTab('albums')">
                        <span class="size--14">
                            Альбомы
                        </span>
                    </li>
                    <li>
                        <a href="#" class="btn btn-blue-style btn-wider" @click.prevent="selectForUpload" :disabled="uploading" :class="{ loading: uploading }">
                            <div class="loader">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                Загрузка {{ uploadedCount + 1 }} из {{ uploadsCount }}
                            </div>
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            Загрузить фото
                        </a>
                    </li>
                </ul>
                <div class="e-box--padding color--regent-gray text-center" v-if="loading">
                    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    Загрузка фотографий...
                </div>
                <template v-else>
                    <div class="tab" v-if="tab == 'all' || tab == 'album'">
                        <div class="al-nav" v-if="album">
                            <div class="al-nav--floor">
                                <a @click="selectTab('albums')">
                                    Список альбомов /
                                </a>
                                <span>
                                    {{ album.name }}
                                </span>
                            </div>
                            <div class="al-nav--term">
                                <i class="ico ico--image"></i>
                                <span class="color--regent-gray size--13">
                                    {{ photos_total }}
                                </span>
                            </div>
                        </div>
                        <div class="photos __grid--album-photos __grid" v-if="photos.length">
                            <a v-for="photo in photos" :key="photo.id" @click="togglePhotoSelection(photo)">
                                <img :srcset="photo.srcset" :src="photo.thumb_360" alt="" :class="{ 'thumb-portrait': photo.original_width < photo.original_height, 'thumb-landscape': photo.original_width >= photo.original_height }">
                                <!--
                                <button class="photo-delete" @click.prevent.stop="photoDelete(photo.id)" v-if="can_upload">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                                -->
                                <div class="selected" v-if="photo.selected">
                                    <i class="fa fa-check c-white" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                        <div class="e-box--padding color--regent-gray text-center" v-else>
                            <div style="margin-bottom: 1.5em;">
                                В этом альбоме еще нет фотографий
                            </div>
                            <!--
                            <a href="#" class="btn btn-blue-style btn-wider" @click.prevent="$parent.selectPhoto" :disabled="$parent.uploading" :class="{ loading: $parent.uploading }" v-if="can_upload">
                                <div class="loader">
                                    <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                    Загрузка {{ $parent.uploadedCount + 1 }} из {{ $parent.uploadsCount }}
                                </div>
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                Загрузить фото
                            </a>
                            -->
                        </div>
                    </div>
                    <div class="tab" v-if="tab == 'albums'">
                        <div class="albums __grid __grid--gap __grid--album" v-if="albums.length">
                            <div class="__al-group" v-for="album in albums" :key="album.id">
                                <a class="album-photo __al-group--photo" @click="selectAlbum(album.id)">
                                    <img class="__img-fluid __img-full" v-if="album.cover" :srcset="album.cover.srcset" :src="album.cover.thumb_720" :alt="album.name" :class="{ 'thumb-portrait': album.cover.original_width < album.cover.original_height, 'thumb-landscape': album.cover.original_width >= album.cover.original_height }">
                                    <div class="album-empty color--regent-gray text-center" v-else>
                                        <i class="fa fa-image" aria-hidden="true"></i>
                                        <div class="size--13">
                                            Нет фотографий
                                        </div>
                                    </div>
                                    <!--<img class="img-fluid img-full" src="/img/other/img.jpg" alt="">-->
                                    <!--
                                    <template v-if="can_upload">
                                        <router-link class="album-edit" :to="owner.link + '/photos/albums/' + album.id + '/edit'">
                                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                        </router-link>
                                        <button class="album-delete" @click.prevent.stop="albumDelete(album.id)">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </button>
                                    </template>
                                    -->
                                </a>
                                <a class="size--13 weight--600 color--mirage">
                                    {{ album.name }}
                                </a>
                                <div class="al-group--foot">
                                    <i class="ico ico--image"></i>
                                    <span class="color--regent-gray size--13">
                                        {{ album.photos_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="e-box--padding color--regent-gray text-center" v-else>
                            <div style="margin-bottom: 1.5em;">
                                Альбомов еще не создано
                            </div>
                            <!--
                            <router-link class="btn btn-blue-style btn-wider" style="margin-left: 1em;" :to="owner.link + '/photos/albums/create'" v-if="can_upload">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Создать альбом
                            </router-link>
                            -->
                        </div>
                    </div>
                </template>
                <div class="margin--top-20 text-center" v-if="selected.length">
                    <button class="btn btn-blue-border-style btn-wider" @click="select" :disabled="processing" :class="{ loading: processing }">
                        <div class="loader" style="background: #FFF;">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        <template v-if="selected.length == 1">
                            Выбрать фотографию
                        </template>
                        <template v-else>
                            Выбрать {{ selected.length }} фотографий
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapActions } from 'vuex';

import ModalCropAvatar from './ModalCropAvatar';
import ModalCropBackground from './ModalCropBackground';

export default {
    props: {
        owner_id: Number,
        owner_type: String,
        count: {
            type: Number,
            default: 5
        },
        section: Number
    },
    data() {
        return {
            tab: 'all',
            loading: false,
            processing: false,
            selected: [],
            album_id: null,
            album: null,
            photos: [],
            photos_total: 0,
            albums: [],
            albums_total: 0,
            uploading: false,
            uploadsCount: 0,
            uploadedCount: 0,
            file: null,
            photo: null
        }
    },
    created() {
        this.selectTab('all');
    },
    watch: {

    },
    methods: {
        ...mapActions([
            'PHOTOS_SELECT',
            'PHOTOS_UPLOAD'
        ]),
        async selectTab(tab) {
            this.selected = [];

            this.tab = tab;

            if (this.tab == 'all') {
                this.album_id = null;
            }

            if (this.tab == 'all' || this.tab == 'album') {
                await this.loadPhotos();
            }

            if (this.tab == 'albums') {
                await this.loadAlbums();
            }
        },
        async selectAlbum(album_id) {
            this.album_id = album_id;
            await this.selectTab('album');
        },
        togglePhotoSelection(photo) {
            photo.selected ? this.unselectPhoto(photo) : this.selectPhoto(photo);
        },
        selectPhoto(photo) {
            if (this.count == 1) {
                if (this.section == 2 || this.section == 3) {
                    this.photo = photo;
                    this.showCropModal();
                    return;
                }
            } else {
                if (this.selected.length >= this.count) {
                    toastr.error('Можно выбрать не более ' + this.count + ' фотографий');
                    return;
                }
            }

            photo.selected = true;

            this.selected.push(photo);
        },
        unselectPhoto(photo) {
            photo.selected = false;

            this.selected = this.selected.filter(p => p.id != photo.id);
        },
        async loadPhotos() {
            this.loading = true;

            this.album = null;
            
            const {
                owner_id,
                owner_type,
                album_id
            } = this;

            const { data } = await axios.get('/api/photos', {
                params: {
                    owner_id,
                    owner_type,
                    album_id
                }
            });

            this.photos = data.photos;
            this.photos_total = data.total;
            this.album = data.album;

            this.loading = false;
        },
        async loadAlbums() {
            this.loading = true;

            const {
                owner_id,
                owner_type
            } = this;

            const { data } = await axios.get('/api/photo_albums', {
                params: {
                    owner_id,
                    owner_type
                }
            });

            this.albums = data.albums;
            this.total = data.total;

            this.loading = false;
        },
        showCropModal() {
            const { owner_id, owner_type, file, photo } = this;

            if (this.section == 2) {
                //this.$root.showModal('crop-avatar-' + this._uid);
                this.$modal.show(ModalCropAvatar, {
                    owner_id,
                    owner_type,
                    file,
                    photo
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 500,
                    adaptive: true,
                    scrollable: true
                });
            }

            if (this.section == 3) {
                //this.$root.showModal('crop-background-' + this._uid);
                this.$modal.show(ModalCropBackground, {
                    owner_id,
                    owner_type,
                    file,
                    photo
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 500,
                    adaptive: true,
                    scrollable: true
                });
            }

            this.$emit('close');
        },
        async selectForUpload() {
            this.selected = [];

            const files = await this.PHOTOS_SELECT(this.count > 1);

            if (files.length > this.count) {
                toastr.error('Можно загрузить не более ' + this.count + ' фотографий');
                return;
            }

            if (this.section == 2 || this.section == 3) {
                this.file = files[0];
                this.showCropModal();
                return;
            }

            this.uploadsCount = files.length;
            this.uploadedCount = 0;
            this.uploading = true;

            const { owner_id, owner_type, section } = this;
            for (const photo of files) {
                const request = {
                    photo,
                    owner_id,
                    owner_type,
                    section
                };

                /*
                if (this.$route.params.album_id) {
                    request.album_id = this.$route.params.album_id;
                }
                */

                const resp = await this.PHOTOS_UPLOAD(request);
                this.selected.push(resp.photo);
                this.uploadedCount++;
            }

            this.uploading = false;
            if (this.uploadedCount > 1) {
                toastr.success('Фотографии успешно загружены');
            } else {
                toastr.success('Фотография успешно загружена');
            }
            this.select();
        },
        select() {
            this.$parent.$emit('photos-selected', this.selected);
            this.$emit('close');
        }
    }
}
</script>

<style lang="scss" scoped>
.photos > * {
    width: calc(33.333% - 1.1em);
    padding-top: calc(33.333% - 1.1em);

    .selected {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        /*border: 3px solid var(--c-violet);*/
        background: rgba(0, 0, 0, .7);
        font-size: 2.5em;
        z-index: 5;
    }
}
.albums > * {
    width: calc(33.333% - 1.1em);
}
</style>
