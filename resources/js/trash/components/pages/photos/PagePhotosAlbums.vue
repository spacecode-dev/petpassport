<template>
    <div>
        <div class="e-box--padding color--regent-gray text-center" v-if="loading">
            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            Загрузка альбомов...
        </div>
        <div class="albums __grid __grid--gap __grid--album" v-else-if="albums.length">
            <div class="__al-group" v-for="album in albums" :key="album.id">
                <router-link class="album-photo __al-group--photo" :to="owner.link + '/photos/albums/' + album.id">
                    <img class="__img-fluid __img-full" v-if="album.cover" :srcset="album.cover.srcset" :src="album.cover.thumb_720" :alt="album.name" :class="{ 'thumb-portrait': album.cover.original_width < album.cover.original_height, 'thumb-landscape': album.cover.original_width >= album.cover.original_height }">
                    <div class="album-empty color--regent-gray text-center" v-else>
                        <i class="fa fa-image" aria-hidden="true"></i>
                        <div>
                            Нет фотографий
                        </div>
                    </div>
                    <!--<img class="img-fluid img-full" src="/img/other/img.jpg" alt="">-->
                    <template v-if="can_upload">
                        <router-link class="album-edit" :to="owner.link + '/photos/albums/' + album.id + '/edit'">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </router-link>
                        <button class="album-delete" @click.prevent.stop="albumDelete(album.id)">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </template>
                </router-link>
                <router-link class="size--13 weight--600 color--mirage" :to="owner.link + '/photos/albums/' + album.id">
                    {{ album.name }}
                </router-link>
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
            <router-link class="btn btn-blue-style btn-wider" style="margin-left: 1em;" :to="owner.link + '/photos/albums/create'" v-if="can_upload">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Создать альбом
            </router-link>
        </div>
        <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loadingMore" @click="loadMore" v-if="albums.length < total">
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

export default {
    data() {
        return {
            loading: false,
            loadingMore: false,
            albums: [],
            total: 0
        }
    },
    created() {
        this.load();
    },
    mounted() {

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
        }
    },
    methods: {
        async load() {
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
        async loadMore() {
            this.loadingMore = true;

            const {
                owner_id,
                owner_type
            } = this;

            const { data } = await axios.get('/api/photo_albums', {
                params: {
                    owner_id,
                    owner_type,
                    offset: this.albums.length
                }
            });

            this.albums = this.albums.concat(data.albums);
            this.total = data.total;

            this.loadingMore = false;
        },
        async albumDelete(id) {
            const confirmed = confirm('Вы действительно хотите удалить этот альбом со всеми фотографиями?');

            if (!confirmed) return;

            await axios.delete('/api/photo_albums/' + id);

            this.total--;
            this.albums = this.albums.filter(a => a.id != id);

            toastr.success('Альбом успешно удален');
        }
    },
    watch: {
        '$route': function () {
            
        }
    }
}
</script>

<style lang="scss">

</style>

