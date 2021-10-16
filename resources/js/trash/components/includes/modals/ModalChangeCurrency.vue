<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Изменение валюты кошелька
                </p>
                <p class="size--13 margin--top-25">
                    С помощью этой формы Вы можете изменить валюту, в которой будет происходить оплата услуг на сайте
                </p>
            </div>
            <div class="modal-sep"></div>
            <div class="modal-box">
                <p class="color--black weight--600 margin--bottom-10">
                    Выберите новую валюту
                </p>
                <div class="margin--bottom-20">
                    <select class="form--control-gray wide form--control size--13" v-model="currency">
                        <option value="1">₽ - Рубли</option>
                        <option value="2">$ - Доллары</option>
                        <option value="3">€ - Евро</option>
                    </select>
                </div>
                <template v-if="user.balance">
                    <div class="size--13 weight--600 color--persimmon margin--top-30 margin--bottom-30">
                        При изменении валюты кошелька его баланс будет обнулен без какой-либо компенсации и возможности восстановления. Рекомендуем потратить остаток средств перед продолжением
                    </div>
                    <div class="pretty p-default p-curve margin--bottom-20">
                        <input type="checkbox" v-model="confirmed">
                        <div class="state">
                            <label>
                                <span class="size--13">
                                    Я осознаю, что потеряю
                                    <span class="color--mirage weight--700">
                                        {{ (user.balance / 100) | price }}
                                        <template v-if="user.currency == 1">₽</template>
                                        <template v-if="user.currency == 2">$</template>
                                        <template v-if="user.currency == 3">€</template>
                                    </span>
                                    , и даю согласие на обнуление
                                </span>
                            </label>
                        </div>
                    </div>
                </template>
                <button class="btn btn-blue-border-style btn-wider" :disabled="!confirmed || currency == user.currency" @click="update">
                    Изменить валюту кошелька
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import toastr from 'toastr';

export default {
    props: {
        user: Object
    },
    data() {
        return {
            currency: this.user.currency,
            confirmed: this.user.balance == 0
        }
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    methods: {
        async update() {
            try {
                const { currency } = this;

                await this.$store.dispatch('USER_UPDATE', { currency });
                this.$emit('close');
                toastr.success('Валюта успешно изменена');
            } catch (e) {

            }
        }
    }
}
</script>
