<template>
    <form class="e-box e-box--padding" @submit.prevent="create">
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
                    Создать
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

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
        },
        owner_id() {
            return this.$parent.owner_id;
        },
        owner_type() {
            return this.$parent.owner_type;
        }
    },
    methods: {
        async create() {
            this.processing = true;

            const {
                owner_id,
                owner_type
            } = this;

            const request = {
                ...this.album,
                owner_id,
                owner_type
            };

            const { data } = await axios.post('/api/photo_albums', request);

            toastr.success('Альбом успешно создан');

            this.$router.push(this.owner.link + '/photos/albums/' + data.id);

            this.processing = false;
        }
    }
}
</script>
