<template>
    <div>
        <div class="e-box--padding color--regent-gray text-center" v-if="loading">
            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            Загрузка видео...
        </div>
        <template v-else>
            <div class="al-nav" v-if="album">
                <div class="al-nav--floor">
                    <router-link :to="owner.link + '/videos/albums'">
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
            <div class="videos" v-if="videos.length">
                <span style="cursor: pointer;" v-for="video in videos" :to="makeVideoLink(video)" :key="video.id" @click.prevent.stop="showVideo(video)">
                    <div class="thumbnail" :style="{ 'background-image': 'url(\'' + video.thumbnail + '\')' }">
                        <div class="processing" v-if="!video.processed">
                            <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                            <span class="size--13">
                                Видео обрабатывается
                            </span>
                        </div>
                    </div>
                    <button class="video-delete" @click.prevent.stop="videoDelete(video.id)" v-if="can_upload">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                    <span class="size--13 weight--600 color--mirage">
                        {{ video.title }}
                    </span>
                </span>
            </div>
            <div class="e-box--padding color--regent-gray text-center" v-else>
                <div style="margin-bottom: 1.5em;">
                    В этом альбоме еще нет видео
                </div>
                <a href="#" class="btn btn-blue-style btn-wider" @click.prevent="$parent.selectVideo" :disabled="$parent.uploading" :class="{ loading: $parent.uploading }" v-if="can_upload">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        Загрузка {{ $parent.uploadedCount + 1 }} из {{ $parent.uploadsCount }}
                    </div>
                    <i class="fa fa-upload" aria-hidden="true"></i>
                    Загрузить видео
                </a>
            </div>
        </template>
        <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loadingMore" @click="loadMore" v-if="videos.length < total">
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
import { mapState, mapActions } from 'vuex';

import ModalMediaView from '../../includes/modals/ModalMediaView';

export default {
    data() {
        return {
            loading: false,
            loadingMore: false
        }
    },
    computed: {
        ...mapState({
            videos: state => state.videos.videos,
            total: state => state.videos.total,
            album: state => state.videos.album
        }),
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
        video_id() {
            return this.$route.params.video_id;
        }
    },
    created() {
        this.$parent.$on('videos:uploaded', (photo) => {
            /*
            this.photos.unshift(photo);
            this.total++;

            if (this.album) {
                this.album.photos_count++;
            }
            */
        });
        if (this.owner_id) {
            this.load();
        }
    },
    mounted() {
        /*
        this.photoModal = $('#modal-photo');
        this.photoModal.on('modal:close', () => {
            this.photoModalShowed = false;
            const base = this.owner.link + '/photos';
            this.$router.push(base + (this.album ? ('/albums/' + this.album.id) : ''));
        });
        if (this.photo_id) {
            this.loadPhoto(this.photo_id);
        }
        */
    },
    methods: {
        ...mapActions([
            'VIDEOS_LOAD',
            'VIDEOS_LOAD_MORE',
            'VIDEOS_DELETE'
        ]),
        makeVideoLink(video) {
            const base = this.owner.link + '/videos';
            return base + (this.album ? ('/albums/' + this.album.id) : '') + '/' + video.id;
        },
        async load() {
            this.loading = true;

            const {
                owner_id,
                owner_type,
                album_id
            } = this;

            this.VIDEOS_LOAD({
                owner_id,
                owner_type,
                album_id
            });

            this.loading = false;
        },
        async loadMore() {
            this.loadingMore = true;

            this.VIDEOS_LOAD_MORE();

            this.loadingMore = false;
        },
        async videoDelete(id) {
            const confirmed = confirm('Вы действительно хотите удалить это видео?');

            if (!confirmed) return;

            await this.VIDEOS_DELETE(id);

            toastr.success('Видео успешно удалено');
        },
        showVideo(object) {
            this.$modal.show(ModalMediaView, {
                object,
                object_type: 'video',
                object_set: this.videos,
                object_set_owner: this.owner
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
        '$route': function (newVal, oldVal) {
            if (this.video_id) {
                /*
                const photo = this.photos.find(p => p.id == this.photo_id);

                photo ? this.showPhoto(photo) : this.loadPhoto(this.photo_id);
                */
                //this.loadVideo(this.photo_id);
                return;
            }
            //if (this.album && this.album.id != newVal.params.album_id) {
                this.load();
            //}
        },
        owner_id() {
            this.load();
        }
    }
}
</script>

<style lang="scss">

</style>
