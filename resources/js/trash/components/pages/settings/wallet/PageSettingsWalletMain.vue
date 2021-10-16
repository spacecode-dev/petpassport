<template>
    <form class="e-box e-box--padding" @submit.prevent="pay">
        <div class="e-field">
            <div>
                <span class="size--13">
                    Баланс кошелька
                </span>
            </div>
            <div style="display: flex; align-items: center;">
                <span class="color--mirage size--14 weight--700" style="flex: 1;">
                    {{ (user.balance / 100) | price }}
                    <template v-if="user.currency == 1">₽</template>
                    <template v-if="user.currency == 2">$</template>
                    <template v-if="user.currency == 3">€</template>
                </span>
                <button type="button" class="btn btn-gray btn-boder size--12 btn-round" @click.prevent="changeCurrency">
                    Изменить валюту
                </button>
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Введите сумму для пополнения
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Сумма" type="number" min="1" v-model="amount">
            </div>
        </div>
        <div class="e-field e-field--wide" v-if="false">
            <div></div>
            <div class="e-field e-field--three e-field--no-margin e-field--money">
                <label class="form--card">
                    <input type="radio" name="card">
                    <div>
                        <span class="size--13">
                            Банковская карта
                        </span>
                    </div>
                </label>
                <label class="form--card">
                    <input type="radio" name="card">
                    <div>
                        <span class="size--13">
                            Яндекс.Деньги
                        </span>
                    </div>
                </label>
                <label class="form--card">
                    <input type="radio" name="card">
                    <div>
                        <span class="size--13">
                            WebMoney
                        </span>
                    </div>
                </label>
            </div>
        </div>
        <div class="e-field">
            <div></div>
            <div>
                <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Пополнить
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapGetters } from 'vuex';

import ModalChangeCurrency from '../../../includes/modals/ModalChangeCurrency';

export default {
    data() {
        return {
            amount: null,
            processing: false
        }
    },
    computed: {
        ...mapGetters([
            'user'
        ])
    },
    methods: {
        changeCurrency() {
            this.$modal.show(ModalChangeCurrency, {
                user: this.user
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 500,
                adaptive: true,
                scrollable: true
            });
        },
        async pay() {
            this.processing = true;

            const { amount } = this;

            const user = (await axios.post('/api/user/transactions', {
                amount: amount * 100
            })).data;

            this.$store.commit('USER_SUCCESS', user);

            toastr.success('Средства зачислены');

            this.amount = null;
            this.processing = false;
        }
    }
}
</script>
