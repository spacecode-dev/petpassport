<template>
    <div class="cn-main">
        <div class="cn-main--left">

        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Фотографии
            </h3>
            <ul class="left e-tab--nav" :class="{ add: can_upload }">
                <router-link tag="li" class="label-show" active-class="active" :to="owner.link + '/photos'" exact :class="{ active: $route.params.photo_id && !$route.params.album_id }">
                    <span class="size--14">
                        Все фотографии
                    </span>
                    <span class="color--regent-gray size--14" v-if="false">
                        0
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="owner.link + '/photos/albums'" :class="{ active: $route.params.album_id }">
                    <span class="size--14">
                        Альбомы
                    </span>
                    <span class="color--regent-gray size--14" v-if="false">
                        0
                    </span>
                </router-link>
                <li v-if="can_upload">
                    <router-link class="btn btn-blue-style btn-wider" style="margin-left: 1em;" :to="owner.link + '/photos/albums/create'" v-if="$route.path.includes('albums') && !$route.params.album_id">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Создать альбом
                    </router-link>
                    <a href="#" class="btn btn-blue-style btn-wider" @click.prevent="selectPhoto" :disabled="uploading" :class="{ loading: uploading }" v-else>
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            Загрузка {{ uploadedCount + 1 }} из {{ uploadsCount }}
                        </div>
                        <i class="fa fa-upload" aria-hidden="true"></i>
                        Загрузить фото
                    </a>
                    <router-link class="btn btn-blue-style btn-wider btn-album-edit" style="margin-left: 1em;" :to="owner.link + '/photos/albums/' + $route.params.album_id + '/edit'" v-if="$route.params.album_id">
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
            'PHOTOS_SELECT',
            'PHOTOS_UPLOAD'
        ]),
        async selectPhoto() {
            const files = await this.PHOTOS_SELECT(true);
            
            this.uploadsCount = files.length;
            this.uploadedCount = 0;
            this.uploading = true;
            for (const photo of files) {
                const request = {
                    photo,
                    owner_id: this.owner_id,
                    owner_type: this.owner_type,
                    section: 1
                };

                if (this.$route.params.album_id) {
                    request.album_id = this.$route.params.album_id;
                }

                const resp = await this.PHOTOS_UPLOAD(request);
                this.$emit('photos:uploaded', resp.photo);
                this.uploadedCount++;
            }
            this.uploading = false;
            if (this.uploadedCount > 1) {
                toastr.success('Фотографии успешно загружены');
            } else {
                toastr.success('Фотография успешно загружена');
            }
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
