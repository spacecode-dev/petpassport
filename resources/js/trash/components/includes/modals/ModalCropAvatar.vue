<template>
    <div class="modal modal-crop-avatar">
        <div class="modal-wrap" v-show="!loading">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Выберите область для миниатюры
                </p>
                <p class="usl-do size--13 margin--top-25">
                    Выбранная миниатюра будет отображаться на странице
                    <template v-if="owner_type == 'profile'">
                        профиля,
                    </template>
                    <template v-else-if="owner_type == 'community'">
                        сообщества,
                    </template>
                    <template v-else-if="owner_type == 'shop'">
                        магазина,
                    </template>
                    <template v-else>
                        ,
                    </template>
                    в новостях, комментариях, и других разделах сайта.
                </p>
            </div>
            <div class="crop-container"></div>
            <div class="modal-box" style="text-align: center;">
                <button class="btn btn-blue-border-style btn-wider" @click="upload" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader" style="background: #FFF;">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Croppr from 'croppr';
import toastr from 'toastr';
import { mapActions } from 'vuex';

export default {
    props: {
        owner_id: Number,
        owner_type: String,
        file: File,
        photo: Object
    },
    data() {
        return {
            loading: false,
            processing: false,
            img: null,
            croppr: null
        }
    },
    mounted() {
        if (this.file) {
            this.readFile();
        }
        if (this.photo) {
            this.createImage(this.photo.original);
        }
    },
    watch: {
        file() {
            if (this.file) {
                //this.readFile();
            }
        }
    },
    methods: {
        ...mapActions([
            'PHOTOS_UPLOAD'
        ]),
        readFile() {
            this.loading = true
            const reader = new FileReader();

            reader.onabort = () => {
                //alert('abort');
            };

            reader.onloadend = () => {
                this.createImage(reader.result);
            };

            reader.readAsDataURL(this.file);
        },
        createImage(src) {
            this.img = document.createElement('img');
            this.img.className = 'crop-image';
            this.img.alt = '';
            this.img.src = src;
            $(this.$el).find('.crop-container').empty().append(this.img);
            this.loading = false;
            this.$nextTick(() => {
                this.croppr = new Croppr(this.img, {
                    aspectRatio: 1,
                    minSize: [
                        200,
                        200,
                        'px'
                    ]
                });
            });
        },
        async upload() {
            this.processing = true;

            const { owner_id, owner_type } = this;

            const resp = await this.PHOTOS_UPLOAD({
                owner_id,
                owner_type,
                section: 2,
                photo: this.file,
                photo_id: this.photo ? this.photo.id : null,
                crop: JSON.stringify(this.croppr.getValue())
            });

            this.$emit('uploaded', resp.photo);

            const update = {
                avatar: resp.photo.original
            };

            if (this.owner_type == 'profile') {
                this.$store.commit('PROFILE_UPDATE', update);
                this.$store.commit('PROFILE_SELF_UPDATE', update);
            }

            if (this.owner_type == 'community') {
                this.$store.commit('COMMUNITY_UPDATE', update);
            }

            if (this.owner_type == 'shop') {
                this.$store.commit('SHOP_UPDATE', update);
            }

            this.$emit('close');

            toastr.success('Аватар успешно обновлен');

            this.processing = false;
        }
    }
}
</script>

<style lang="scss" scoped>
.modal {
    max-width: 600px;
}
.crop-container {
    position: relative;
    text-align: center;
    background: rgba(255, 255, 255, .9);

    /*
    img {
        max-width: 100%;
        max-height: 50vh;
    }
    */
}
.crop-container:before {
    content: '';
    display: block;
    position: absolute;
    left: -30px;
    right: -30px;
    top: -30px;
    bottom: -30px;
    z-index: 1;
}
.modal-crop-avatar .modal-wrap {
    overflow: visible;
}
.modal-crop-avatar .modal-box:first-child {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.modal-crop-avatar .modal-box:last-child {
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}
</style>

<style>
.crop-container img {
    max-width: 100%;
    max-height: 600px;
}
.modal-crop-avatar .croppr {
    overflow: hidden;
}
.modal-crop-avatar .croppr-overlay {
    background: none;
}
.modal-crop-avatar .croppr-region:after {
    content: '';
    display: block;
    border: 1px dashed rgba(0, 0, 0, .5);
    position: absolute;
    left: -1px;
    right: -1px;
    top: -1px;
    bottom: -1px;
    border-radius: 50%;
    box-shadow: 0 0 0 1000px rgba(0,0,0,0.5);
}
</style>
