<template>
    <div class="modal-box">
        <template v-if="!price">
            <p class="color--black weight--600 margin--bottom-10">
                Выберите срок действия услуги:
            </p>
            <div class="margin--bottom-20">
                <select class="form--control-gray wide form--control size--13" v-model="days">
                    <option v-for="price in prices" :value="price.days">
                        {{ price.days }} дней
                        <!--
                        - {{ (price.price / 100) | price }}
                        <template v-if="user.currency == 1">₽</template>
                        <template v-if="user.currency == 2">$</template>
                        <template v-if="user.currency == 3">€</template>
                        -->
                    </option>
                </select>
            </div>
        </template>
        <p class="color--black weight--600 margin--bottom-10">
            К оплате:
        </p>
        <div class="margin--bottom-20 size--13">
            {{ (total / 100) | price }}
            <template v-if="user.currency == 1">₽</template>
            <template v-if="user.currency == 2">$</template>
            <template v-if="user.currency == 3">€</template>
        </div>
        <p class="color--black weight--600 margin--bottom-10">
            Выберите способ оплаты:
        </p>
        <div class="e-field e-field--wide margin--bottom-20">
            <div class="e-field e-field--no-margin m-0" style="flex: 1; align-items: normal;">
                <label class="form--card" style="flex: 1;">
                    <input type="radio" v-model="paytype" value="1">
                    <div style="height: 100%; padding-bottom: 15px;">
                        <span class="size--13">
                            Кошелек сайта
                        </span>
                        <div class="size--13 color--regent-gray margin--top-10">
                            Доступно:
                            <span class="weight--700">
                                {{ (user.balance / 100) | price }}
                                <template v-if="user.currency == 1">₽</template>
                                <template v-if="user.currency == 2">$</template>
                                <template v-if="user.currency == 3">€</template>
                            </span>
                        </div>
                    </div>
                </label>
                <label class="form--card" style="flex: 1;">
                    <input type="radio" v-model="paytype" value="2">
                    <div style="height: 100%; padding-bottom: 15px;">
                        <span class="size--13">
                            Банковская карта или онлайн кошелек
                        </span>
                    </div>
                </label>
            </div>
        </div>
        <template v-if="paytype == 1 && user.balance < total">
            <div class="size--13 weight--600 color--persimmon margin--top-30 margin--bottom-30">
                В Вашем кошельке недостаточно средств для оплаты данной услуги. Вам необходимо доплатить еще
                <span class="color--mirage weight--700">
                    {{ ((total - user.balance) / 100) | price }}
                    <template v-if="user.currency == 1">₽</template>
                    <template v-if="user.currency == 2">$</template>
                    <template v-if="user.currency == 3">€</template>
                </span>
            </div>
        </template>

        <button class="btn btn-blue-border-style btn-wider" @click="pay" v-if="paytype == 1 && user.balance >= total">
            Подключить услугу
        </button>
        <button class="btn btn-blue-border-style btn-wider" @click="pay" v-else-if="paytype == 1">
            Перейти к доплате
        </button>
        <button class="btn btn-blue-border-style btn-wider" @click="pay" v-else>
            Перейти к оплате
        </button>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapGetters } from 'vuex';

export default {
    props: {
        announcement: Object,
        opcode: Number,
        price: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            paytype: 1,
            days: 7,
            prices: [
                { days: 7, price: 1000 },
                { days: 14, price: 2000 },
                { days: 28, price: 4000 }
            ]
        }
    },
    computed: {
        ...mapGetters([
            'user'
        ]),
        total() {
            if (this.price) {
                return this.price;
            }
            return this.prices.find(p => p.days == this.days).price;
        }
    },
    created() {
        this.paytype = this.user.balance >= this.total ? 1 : 2;
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    methods: {
        async pay() {
            try {
                const { opcode, paytype, days } = this;

                const user = (await axios.post('/api/user/transactions', {
                    opcode,
                    announcement_id: this.announcement.id,
                    paytype,
                    days
                })).data;

                this.$store.commit('USER_SUCCESS', user);

                this.$emit('close');
                toastr.success('Услуга успешно подключена');
            } catch (e) {

            }
        }
    }
}
</script>
