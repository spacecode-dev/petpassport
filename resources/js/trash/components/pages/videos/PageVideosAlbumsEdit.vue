<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">
                    Название альбома
                </span>
                <span class="color--persimmon size--13">
                    *
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Название альбома" type="text" required v-model="album.name" :disabled="processing">
            </div>
            <div></div>
        </div>
        <div class="e-field--align-up e-field--first e-field">
            <div>
                <span class="size--13">
                    Описание альбома
                </span>
            </div>
            <div>
                <textarea class="form--control form--textarea form--control-gray size--13" rows="4" placeholder="Описание альбома" v-model="album.description" :disabled="processing" maxlength="1000"></textarea>
                <div class="size--12 margin--top-5 color--regent-gray">
                    Осталось символов: {{ 1000 - (album.description ? album.description.length : 0) }}
                </div>
            </div>
        </div>
        <div class="e-field">
            <div></div>
            <div>
                <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Сохранить
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import querystring from 'querystring';

export default {
    data() {
        return {
            processing: false,
            album: {
                name: null,
                description: null
            }
        }
    },
    computed: {
        owner() {
            return this.$parent.owner;
        }
    },
    async beforeRouteEnter(to, from, next) {
        const data = (await axios.get('/api/video_albums/' + to.params.album_id)).data;
        next(vm => {
            vm.album = data;
        });
    },
    methods: {
        async update() {
            this.processing = true;

            const { data } = await axios.put('/api/video_albums/' + this.album.id, querystring.stringify(this.album));

            toastr.success('Альбом успешно изменен');

            this.$router.push(this.owner.link + '/videos/albums/' + data.id);

            this.processing = false;
        }
    }
}
</script>
