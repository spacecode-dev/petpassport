<template>
    <div class="cn-main">
        <div class="cn-main--left">

        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Видеозаписи
            </h3>
            <ul class="left e-tab--nav" :class="{ add: can_upload }">
                <router-link tag="li" class="label-show" active-class="active" :to="owner.link + '/videos'" exact :class="{ active: $route.params.video_id && !$route.params.album_id }">
                    <span class="size--14">
                        Все видеозаписи
                    </span>
                    <span class="color--regent-gray size--14" v-if="false">
                        0
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="owner.link + '/videos/albums'" :class="{ active: $route.params.album_id }">
                    <span class="size--14">
                        Альбомы
                    </span>
                    <span class="color--regent-gray size--14" v-if="false">
                        0
                    </span>
                </router-link>
                <li v-if="can_upload">
                    <router-link class="btn btn-blue-style btn-wider" style="margin-left: 1em;" :to="owner.link + '/videos/albums/create'" v-if="$route.path.includes('albums') && !$route.params.album_id">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Создать альбом
                    </router-link>
                    <a href="#" class="btn btn-blue-style btn-wider" @click.prevent="selectVideo" :disabled="uploading" :class="{ loading: uploading }" v-else>
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            Загрузка {{ uploadedCount + 1 }} из {{ uploadsCount }}
                        </div>
                        <i class="fa fa-upload" aria-hidden="true"></i>
                        Загрузить видео
                    </a>
                    <router-link class="btn btn-blue-style btn-wider btn-album-edit" style="margin-left: 1em;" :to="owner.link + '/videos/albums/' + $route.params.album_id + '/edit'" v-if="$route.params.album_id">
                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        Редактировать
                    </router-link>
                </li>
            </ul>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import toastr from 'toastr';

import ModalVideosUpload from '../../includes/modals/ModalVideosUpload';

export default {
    data() {
        return {
            uploading: false,
            uploadsCount: 0,
            uploadedCount: 0
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        ...mapState({
            counters: state => state.counters.counters
        }),
        owner_type() {
            return this.$route.params.type ? 'community' : 'profile';
        },
        owner() {
            if (this.owner_type == 'profile') {
                return this.$store.state.profiles.profile;
            } else {
                return this.$parent.$parent.community;
            }
        },
        owner_id() {
            return this.owner.id || this.owner.user_id;
        },
        can_upload() {
            return this.owner.user_id == this.profile.user_id;
        }
    },
    created() {
        
    },
    methods: {
        ...mapActions([
            'VIDEOS_SELECT',
            'VIDEOS_UPLOAD'
        ]),
        async selectVideo() {
            const { owner_id, owner_type } = this;

            this.$modal.show(ModalVideosUpload, {
                owner_id,
                owner_type
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });

            /*
            const files = await this.VIDEOS_SELECT(true);
            
            this.uploadsCount = files.length;
            this.uploadedCount = 0;
            this.uploading = true;
            for (const video of files) {
                const request = {
                    video,
                    owner_id: this.owner_id,
                    owner_type: this.owner_type,
                    section: 1
                };

                if (this.$route.params.album_id) {
                    request.album_id = this.$route.params.album_id;
                }

                const resp = await this.VIDEOS_UPLOAD(request);
                this.$emit('videos:uploaded', resp.video);
                this.uploadedCount++;
            }
            this.uploading = false;
            if (this.uploadedCount > 1) {
                toastr.success('Видеозаписи успешно загружены');
            } else {
                toastr.success('Видеозапись успешно загружена');
            }
            */
        }
    }
}
</script>

<style>
.btn-album-edit {
    background: #FFF;
    color: #1e2638;
}
</style>
