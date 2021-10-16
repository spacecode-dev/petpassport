<template>
    <router-link class="market-card e-box" :to="'/market/announcements/' + announcement.id" :class="{ 'market-card-colored' : announcement.colored }" target="_blank">
        <div class="market-card-img" :style="{ 'background-image': photo ? 'url(\'' + photo + '\')' : null }">
            <i class="far fa-image color--regent-gray" aria-hidden="true" v-if="!photo"></i>
            <!--
            <img class="sp-article--term" src="/img/cat/1.jpg" :alt="announcement.title" v-if="announcement.photo">
            -->
        </div>
        <div class="market-card-body">
            <div class="cart-icon text-center" :class="{ added: announcement.in_cart }" @click.prevent.stop="toggleCart" v-if="announcement.owner_type == 'shop'">
                <i class="fa fa-fw fa-cart-arrow-down" aria-hidden="true" v-if="announcement.in_cart"></i>
                <i class="fa fa-fw fa-cart-plus" aria-hidden="true" v-else></i>
            </div>
            <div class="market-card-desc size--13">
                <div>{{ announcement.title }}</div>
            </div>
            <div class="e-price margin--top-15">
                <span class="size--14 weight--700">
                    {{ announcement.price | price }}
                </span>
                <i class="fa fa-ruble-sign weight--700 size--10" v-if="announcement.currency == 1"></i>
                <i class="fa fa-dollar-sign weight--700 size--10" v-if="announcement.currency == 2"></i>
                <i class="fa fa-euro-sign weight--700 size--10" v-if="announcement.currency == 3"></i>
            </div>
        </div>
        <i class="fa fa-heart" aria-hidden="true" title="В избранном" v-if="announcement.liked"></i>
        <!--<i class="ico--like-red sp-article--liked ico"></i>-->
    </router-link>
</template>

<script>
/*
import * as moment from 'moment';
import 'moment/locale/ru';
*/
import { mapActions } from 'vuex';

export default {
    props: {
        announcement: Object
    },
    data() {
        return {

        }
    },
    created() {
        this.$root.$on('cart:add', announcement_id => {
            if (announcement_id == this.announcement.id) {
                this.announcement.in_cart = true;
            }
        });
        this.$root.$on('cart:delete', announcement_id => {
            if (announcement_id == this.announcement.id) {
                this.announcement.in_cart = false;
            }
        });
    },
    computed: {
        photo() {
            if (this.announcement.photo) {
                return this.announcement.photo.thumb_360;
            }
            if (this.announcement.photos && this.announcement.photos.length) {
                return this.announcement.photos[0].thumb_360;
            }
        }
        /*
        age() {
            return moment(this.announcement.announcement_pet.birthday).fromNow(true);
        }*/
    },
    methods: {
        ...mapActions([
            'CART_ADD',
            'CART_DELETE'
        ]),
        async toggleCart() {
            if (this.announcement.in_cart) {
                await this.CART_DELETE(this.announcement.id);
                this.$root.$emit('cart:delete', this.announcement.id);
            } else {
                await this.CART_ADD(this.announcement.id);
                this.$root.$emit('cart:add', this.announcement.id);
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/_market-card';

.market-card {
    background: var(--c-white);
}

.market-card-body {
    position: relative;
}

.fa-heart {
    position: absolute;
    right: 10px;
    bottom: 10px;
    color: red;
    background: #FFF;
    border-radius: 50%;
    padding: 7px;
}

.cart-icon {
    position: absolute;
    right: 20px;
    top: -20px;
    width: 40px;
    height: 40px;
    line-height: 40px;
    background: #FFF;
    border-radius: 50%;
    /*border: 1px solid #EEE;*/
    color: var(--c-gray);
    cursor: pointer;
    transition: all 200ms ease-in;
    box-shadow: 1px 1px 5px rgba(0, 0, 0, .3);

    &:hover {
        box-shadow: 1px 1px 5px rgba(0, 0, 0, .6);
    }

    &.added {
        background: var(--c-violet);
        color: var(--c-white);
        border-color: rgba(255, 255, 255, .5);
    }

    &:not(.added):hover {
        color: var(--c-violet);
        background: #EEE;
        border-color: #BBB;
        box-shadow: 1px 1px 5px rgba(0, 0, 0, .5);
    }
}
</style>
