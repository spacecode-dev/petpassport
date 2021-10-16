<template>
    <div class="cn-shop--gray cn-shop--wrap">
        <div class="sp-contact">
            <div class="sp-contact--article">
                <div class="sp-contact--exile">
                    <div class="sp-contact--motto">
                        <img class="sp-contact--rumor" :src="shop.avatar" :alt="shop.name">
                        <span @click="uploadAvatar" v-if="shop.owned">
                            <i class="fa fa-camera" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="sp-contact--term">
                        <h4 class="weight--600">
                            {{ shop.name }}
                        </h4>
                        <p class="size--12 sp-contact--guide">
                            {{ shop.sign }}
                        </p>
                    </div>
                </div>
                <div class="sp-contact--tie">
                    <a v-if="shop.phone" class="btn btn-contact" :href="'tel:' + shop.phone">
                        <!--<i class="ico ico--phone"></i>-->
                        <i class="fa fa-fw fa-phone c-gray size--13" aria-hidden="true" style="transform: scale(-1, 1);"></i>
                        <span class="size--13 weight--600 color--mirage">
                            {{ shop.phone }}
                        </span>
                    </a>
                    <a v-if="shop.email" class="btn btn-contact" :href="'mailto:' + shop.email">
                        <!--<i class="ico ico--email"></i>-->
                        <i class="fa fa-fw fa-envelope c-gray size--13" aria-hidden="true"></i>
                        <span class="size--13 weight--600 color--mirage">
                            {{ shop.email }}
                        </span>
                    </a>
                </div>
            </div>
            <div class="sp-contact--pack" :style="{ 'background-image': 'url(\'' + shop.cover + '\')' }">
                <div class="bg-change" v-if="shop.owned">
                    <div @click="uploadBackground">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                        Обновить баннер магазина
                    </div>
                </div>
                <!--
                <img class="sp-contact--point img-fluid" src="https://via.placeholder.com/1400x520.jpg?text=Обложка магазина не загружена" :alt="shop.name">
                -->
                <!-- /img/other/shop.jpg -->
                <div class="sp-contact--too">
                    <a class="btn btn-wider btn-blue-style" href="#">
                        Написать сообщение
                    </a>
                    <a v-if="shop.phone" class="btn btn-wider btn-blue-style btn-gray-style" :href="'tel:' + shop.phone">
                        Позвонить нам
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

import ModalCropAvatar from './modals/ModalCropAvatar';
import ModalCropBackground from './modals/ModalCropBackground';

export default {
    data() {
        return {
            fileAvatar: null,
            fileBackground: null,
        }
    },
    computed: {
        ...mapState({
            shop: state => state.shops.shop
        })
    },
    methods: {
        ...mapActions([
            'PHOTOS_SELECT'
        ]),
        async uploadBackground() {
            const files = await this.PHOTOS_SELECT();

            this.fileBackground = files[0];

            this.$modal.show(ModalCropBackground, {
                owner_id: this.shop.id,
                owner_type: 'shop',
                file: this.fileBackground
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        },
        async uploadAvatar() {
            const files = await this.PHOTOS_SELECT();

            this.fileAvatar = files[0];

            this.$modal.show(ModalCropAvatar, {
                owner_id: this.shop.id,
                owner_type: 'shop',
                file: this.fileAvatar
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.sp-contact--pack {
    padding-top: 38%;
    background-size: cover;
    overflow: hidden;

    .bg-change {
        background: rgba(0, 0, 0, .5);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        transition: all .15s ease-in;
        transform: translateY(-100%);
        text-align: left;

        div {
            color: var(--c-white);
            padding: 7px;
            opacity: .7;
            font-size: .88em;
            cursor: pointer;

            i {
                margin-left: 2px;
            }

            &:hover {
                opacity: 1;
            }
        }
    }
    &:hover .bg-change {
        transform: translateY(0);
    }
}

.sp-contact--motto {
    width: 55px;
    height: 55px;
    position: relative;
    overflow: hidden;
    -webkit-mask-image: -webkit-radial-gradient(white, black); /* fix for safari transition bug */
    /*border-radius: 50%;*/

    img {
        max-width: 100%;
        max-height: 100%;
    }
}
.sp-contact--motto span {
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    opacity: 0;
    background: rgba(0, 0, 0, .5);
    transition: all .15s ease-in;
    font-size: 1.5em;
    color: var(--c-white);
    text-align: center;
    cursor: pointer;
}
.sp-contact--motto:hover span {
    opacity: 1;
}
</style>
