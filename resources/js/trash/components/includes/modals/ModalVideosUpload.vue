<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box">
                <p class="size--18 weight--700">
                    Добавление видео
                </p>
            </div>
            <div class="modal-box-gray modal-box">
                <p class="color--black weight--600 margin--bottom-10">
                    Ссылка на YouTube/Vimeo:
                </p>
                <input type="text" class="form--control form--control-gray size--13 margin--bottom-20" placeholder="Вставьте ссылку" v-model="url">
                <button class="btn btn-blue-border-style btn-wider" @click="store" :disabled="!url">
                    Добавить
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

export default {
    props: {
        owner_id: Number,
        owner_type: String
    },
    computed: {
    },
    data() {
        return {
            url: null
        }
    },
    mounted() {

    },
    methods: {
        async store() {
            try {
                const { owner_id, owner_type, url } = this;
                const response = (await axios.post('/api/videos', {
                    owner_id,
                    owner_type,
                    url,
                    album_id: this.$route.params.album_id || null,
                    section: 1
                })).data;

                this.$store.commit('VIDEOS_PREPEND', [ response ]);
                this.$emit('close');

                this.url = null;

                toastr.success('Видео добавлено');
            } catch (e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Добавление видео с указанного ресурса не поддерживается');
                        break;
                    case 2:
                        toastr.error('По указанной ссылке видео не найдено');
                        break;
                    case 3:
                        toastr.error('Добавление видео на сторонние сайты запрещено его владельцем');
                        break;
                    default:
                        toastr.error('Произошла ошибка при добавлении видео');
                }
            }
        }
    }
}
</script>
