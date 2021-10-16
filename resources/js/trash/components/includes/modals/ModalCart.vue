<template>
    <div class="modal modal-basket">
        <div class="modal-wrap">
            <div class="modal-box">
                <p class="size--18 weight--700">
                    Корзина
                </p>
            </div>
            <div class="modal-box modal-box-gray c-gray text-center py-5" v-if="loading">
                <i class="fa fa-circle-notch fa-spin" aria-hidden="true" style="font-size: 50px; margin: 0 0 20px;"></i>
                <div class="size--14">
                    &nbsp;
                    <!--Загрузка корзины...-->
                </div>
            </div>
            <template v-else-if="owners.length">
                <div class="modal-box" v-for="(owner, i) in owners" :class="{ 'modal-box-gray': i % 2 == 0 }">
                    <p class="weight--700 margin--bottom-10" v-if="i == 0 || owners[i - 1].id != owner.id">
                        Магазин «{{ owner.name }}»
                    </p>
                    <div class="e-basket" v-for="item in owner.items">
                        <div class="e-basket--lead">
                            <div class="cart-img" :style="{ 'background-image': item.announcement.photo ? 'url(\'' + item.announcement.photo.thumb_360 + '\')' : null }">
                                <i class="far fa-image c-gray" aria-hidden="true" v-if="!item.announcement.photo"></i>
                            </div>
                        </div>
                        <div class="e-basket--query">
                            <div class="e-basket--exile">
                                <router-link class="size--13 weight--600 color--mirage" :to="'/market/announcements/' + item.announcement.id">
                                    {{ item.announcement.title }}
                                </router-link>
                                <div class="e-basket--note">
                                    <span class="size--14 weight--700">
                                        {{ item.announcement.price | price }}
                                    </span>
                                    <i class="fa fa-ruble-sign weight--700 size--10" v-if="item.announcement.currency == 1"></i>
                                    <i class="fa fa-dollar-sign weight--700 size--10" v-if="item.announcement.currency == 2"></i>
                                    <i class="fa fa-euro-sign weight--700 size--10" v-if="item.announcement.currency == 3"></i>
                                </div>
                            </div>
                            <div class="e-basket--cry">
                                <div class="form--num">
                                    <div @click="decrement(item);" :style="{ visibility: owner.ordered ? 'hidden' : 'visible' }">
                                        <i class="fa fa-fw fa-minus" aria-hidden="true"></i>
                                    </div>
                                    <input type="number" v-model="item.count" min="1" readonly>
                                    <div @click="increment(item);" :style="{ visibility: owner.ordered ? 'hidden' : 'visible' }">
                                        <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="e-basket--say">
                                <span class="size--16 weight--700">
                                    {{ (item.announcement.price * item.count) | price }}
                                </span>
                                <i class="fa fa-ruble-sign weight--700 size--10" v-if="item.announcement.currency == 1"></i>
                                <i class="fa fa-dollar-sign weight--700 size--10" v-if="item.announcement.currency == 2"></i>
                                <i class="fa fa-euro-sign weight--700 size--10" v-if="item.announcement.currency == 3"></i>
                            </div>
                            <div class="e-basket--tie" :style="{ visibility: owner.ordered ? 'hidden' : 'visible' }">
                                <a class="e-basket--rap" href="#" @click.prevent="remove(item.announcement_id)">
                                    <i class="ico ico--remove"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="e-bastet-foot">
                        <div class="e-bastet-foot--word">
                            <span class="size--13 weight--600 e-bastet-foot--sector">
                                Общая стоимость:
                            </span>
                            <span class="size--16 weight--700">
                                {{ owner.items.reduce((p, i) => p + (i.announcement.price * i.count), 0) | price }}
                            </span>
                            <i class="fa fa-ruble-sign weight--700 size--10" v-if="owner.currency == 1"></i>
                            <i class="fa fa-dollar-sign weight--700 size--10" v-if="owner.currency == 2"></i>
                            <i class="fa fa-euro-sign weight--700 size--10" v-if="owner.currency == 3"></i>
                        </div>
                        <button class="btn btn-blue-style btn-bigger btn-wider" :disabled="owner.ordered" @click="order(owner)">
                            <template v-if="owner.ordered">
                                Заказ подтвержден
                            </template>
                            <template v-else>
                                Подтвердить заказ
                            </template>
                        </button>
                    </div>
                </div>
            </template>
            <div class="modal-box modal-box-gray c-gray text-center py-5" v-else>
                <i class="far fa-meh" aria-hidden="true" style="font-size: 50px; margin: 0 0 20px;"></i>
                <div class="size--14">
                    В вашей корзине пока нет товаров
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapActions } from 'vuex';

export default {
    data() {
        return {
            loading: false,
            items: []
        }
    },
    computed: {
        owners() {
            const owners = [];

            for (const item of this.items) {
                let owner = owners.find(o => o.id == item.announcement.owner_id && o.currency == item.announcement.currency);
                if (!owner) {
                    owner = item.announcement.owner;
                    //owner.id = item.announcement.owner_id;
                    owner.items = [ item ];
                    owner.currency = item.announcement.currency;
                    this.$set(owner, 'ordered', false);
                    owners.push(owner);
                    continue;
                }
                owner.items.push(item);
            }

            return owners;
        }
    },
    created() {
        this.load();
    },
    methods: {
        ...mapActions([
            'CART_GET',
            'CART_ADD',
            'CART_UPDATE',
            'CART_DELETE',
            'CART_ORDER'
        ]),
        async load() {
            this.loading = true;

            this.items = await this.CART_GET();

            this.loading = false;
        },
        async increment(item) {
            item.count++;

            this.update(item);
        },
        async decrement(item) {
            if (item.count > 1) {
                item.count--;

                this.update(item);
            }
        },
        async update(item) {
            const { announcement_id, count } = item;

            await this.CART_UPDATE({ announcement_id, count });
        },
        async remove(announcement_id) {
            const confirmed = confirm('Убрать этот товар из корзины?');

            if (!confirmed) return;

            await this.CART_DELETE(announcement_id);

            this.items = this.items.filter(i => i.announcement_id != announcement_id);
            this.$root.$emit('cart:delete', announcement_id);
        },
        async order(owner) {
            const confirmed = confirm('Подтвердить заказ в магазине \"' + owner.name + '\"?\n\nПродавец свяжется с Вами через личные сообщения или с помощью общедоступных контактных данных в Вашем профиле');

            if (!confirmed) return;

            await this.CART_ORDER(owner.id);

            owner.ordered = true;

            for (let item of owner.items) {
                this.$root.$emit('cart:delete', item.announcement_id);
            }

            this.$store.commit('COUNTERS_UPDATE', {
                cart: this.$store.state.counters.counters.cart - owner.items.length
            });

            toastr.success('Заказ подтвержден, продавец свяжется с Вами в ближайшее время');
        }
    }
}
</script>

<style lang="scss">
.cart-img {
    width: 120px;
    padding-bottom: 75%;
    background-color: #E6E9EE;
    background-position: center;
    background-size: cover;
    position: relative;

    i {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
    }
}
.form--num > div {
    background: none !important;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: .8em;
    cursor: pointer;
    width: auto;
    padding: 0 .5em;
}
</style>
