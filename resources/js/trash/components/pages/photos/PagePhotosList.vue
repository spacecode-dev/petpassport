<template>
    <div>
        <div class="e-box--padding color--regent-gray text-center" v-if="loading">
            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            Загрузка фотографий...
        </div>
        <template v-else>
            <div class="al-nav" v-if="album">
                <div class="al-nav--floor">
                    <router-link :to="owner.link + '/photos/albums'">
                        Список альбомов /
                    </router-link>
                    <span>
                        {{ album.name }}
                    </span>
                </div>
                <div class="al-nav--term">
                    <i class="ico ico--image"></i>
                    <span class="color--regent-gray size--13">
                        {{ total }}
                    </span>
                </div>
            </div>
            <div class="photos __grid--album-photos __grid" v-if="photos.length">
                <a v-for="photo in photos" :key="photo.id" :href="makePhotoLink(photo)" @click.prevent="showPhoto(photo)">
                    <img :srcset="photo.srcset" :src="photo.thumb_360" alt="" :class="{ 'thumb-portrait': photo.original_width < photo.original_height, 'thumb-landscape': photo.original_width >= photo.original_height }">
                    <button class="photo-delete" @click.prevent.stop="photoDelete(photo.id)" v-if="can_upload">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </a>
            </div>
            <div class="e-box--padding c-gray text-center" v-else>
                <div style="margin-bottom: 1.5em;">
                    В этом альбоме еще нет фотографий
                </div>
                <a href="#" class="btn btn-blue-style btn-wider" @click.prevent="$parent.selectPhoto" :disabled="$parent.uploading" :class="{ loading: $parent.uploading }" v-if="can_upload">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        Загрузка {{ $parent.uploadedCount + 1 }} из {{ $parent.uploadsCount }}
                    </div>
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    Загрузить фото
                </a>
            </div>
        </template>
        <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loadingMore" @click="loadMore" v-if="photos.length < total">
            <i class="ico ico--reload" :class="{ 'fa-spin': loadingMore }"></i>
            <span class="size--13 color--mirage">
                Показать еще
            </span>
        </a>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

import ModalMediaView from '../../includes/modals/ModalMediaView';

export default {
    data() {
        return {
            loading: false,
            loadingMore: false,
            photos: [],
            album: null,
            total: 0
        }
    },
    async created() {
        this.$parent.$on('photos:uploaded', (photo) => {
            photo.owner = this.owner;
            this.photos.unshift(photo);
            this.total++;

            if (this.album) {
                this.album.photos_count++;
            }
        });
        this.$root.$on('photo:update', payload => {
            let index = this.photos.findIndex(p => p.id == payload.id);
            if (index != -1) {
                this.$set(this.photos, index, {
                    ...this.photos[index],
                    ...payload
                });
            }
        });
        if (this.owner_id) {
            await this.load();
        }
        if (this.photo_id) {
            const photo = this.photos.find(p => p.id == this.photo_id);

            photo ? this.showPhoto(photo) : this.loadPhoto(this.photo_id);
        }
    },
    computed: {
        owner() {
            return this.$parent.owner;
        },
        owner_id() {
            return this.$parent.owner_id;
        },
        owner_type() {
            return this.$parent.owner_type;
        },
        can_upload() {
            return this.$parent.can_upload;
        },
        album_id() {
            return this.$route.params.album_id;
        },
        photo_id() {
            return this.$route.params.photo_id;
        },
        baseUri() {
            return this.owner.link + '/photos' + (this.album ? ('/albums/' + this.album.id) : '');
        }
    },
    methods: {
        makePhotoLink(photo) {
            return this.baseUri + '/' + photo.id;
        },
        async load() {
            this.loading = true;

            this.photos = [];
            this.album = null;
            this.total = 0;

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

            for (let photo of data.photos) {
                photo.owner = this.owner;
            }

            this.photos = data.photos;
            this.album = data.album;
            this.total = data.total;

            this.loading = false;
        },
        async loadMore() {
            this.loadingMore = true;

            const {
                owner_id,
                owner_type,
                album_id
            } = this;

            const { data } = await axios.get('/api/photos', {
                params: {
                    owner_id,
                    owner_type,
                    album_id,
                    offset: this.photos.length
                }
            });

            for (let photo of data.photos) {
                photo.owner = this.owner;
            }

            this.photos = this.photos.concat(data.photos);
            this.album = data.album;
            this.total = data.total;

            this.loadingMore = false;
        },
        async loadPhoto(id) {
            const album_id = this.album_id || 0
            const { data } = await axios.get('/api/photos/' + id + '?reason=album&album_id=' + album_id);
            data.owner = this.owner;
            this.showPhoto(data);
        },
        async photoDelete(id) {
            const confirmed = confirm('Вы действительно хотите удалить эту фотографию?');

            if (!confirmed) return;

            await axios.delete('/api/photos/' + id);

            this.total--;
            this.photos = this.photos.filter(p => p.id != id);

            toastr.success('Фотография успешно удалена');
        },
        showPhoto(object, immediate) {
            this.$modal.show(ModalMediaView, {
                object,
                object_type: 'photo',
                object_set: this.photos,
                closeUri: this.baseUri
            }, {
                classes: '',
                width: '100%',
                height: '100%',
                maxWidth: 2880,
                adaptive: true
            });
        }
    },
    watch: {
        '$route': async function (newVal, oldVal) {
            if (this.album && this.album.id != newVal.params.album_id) {
                await this.load();
            }
            if (this.photo_id) {
                const photo = this.photos.find(p => p.id == this.photo_id);

                photo ? this.showPhoto(photo) : this.loadPhoto(this.photo_id);
                //this.loadPhoto(this.photo_id);
                return;
            }
        },
        owner_id() {
            this.load();
        }
    }
}
</script>

<style lang="scss">

</style>
