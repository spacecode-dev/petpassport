<template>
    <div>
        <div class="e-box e-box--padding e-history" v-for="transaction in transactions">
            <div>
                <i class="ico ico--plus" v-if="transaction.amount > 0"></i>
                <i class="ico ico--minus" v-if="transaction.amount < 0"></i>
                <span class="color--mirage size--14 weight--700">
                    {{ (Math.abs(transaction.amount) / 100) | price }}
                </span>
                <i class="fa fa-ruble-sign color--mirage size--12" v-if="transaction.currency == 1"></i>
                <i class="fa fa-dollar-sign color--mirage size--12" v-if="transaction.currency == 2"></i>
                <i class="fa fa-euro-sign color--mirage size--12" v-if="transaction.currency == 3"></i>
            </div>
            <span class="color--regent-gray size--13 weight--600" style="margin-left: auto; margin-right: 20px;">
                <template v-if="transaction.opcode == 1">
                    Пополнение банковской картой
                </template>
                <template v-if="transaction.opcode == 101">
                    Изменение валюты кошелька
                </template>
                <template v-if="transaction.opcode == 201">
                    Выделение объявления
                    <router-link :to="'/market/announcements/' + transaction.data.announcement_id" v-if="transaction.data">
                        #{{ transaction.data.announcement_id }}
                    </router-link>
                </template>
                <template v-if="transaction.opcode == 202">
                    Закрепление объявления
                    <router-link :to="'/market/announcements/' + transaction.data.announcement_id" v-if="transaction.data">
                        #{{ transaction.data.announcement_id }}
                    </router-link>
                </template>
                <template v-if="transaction.opcode == 203">
                    Поднятие объявления
                    <router-link :to="'/market/announcements/' + transaction.data.announcement_id" v-if="transaction.data">
                        #{{ transaction.data.announcement_id }}
                    </router-link>
                </template>
            </span>
            <span class="color--regent-gray size--13">
                {{ transaction.created_at | timestamp }}
            </span>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            transactions: []
        }
    },
    async beforeRouteEnter(to, from, next) {
        const data = (await axios.get('/api/user/transactions')).data;
        next(vm => {
            vm.transactions = data.transactions;
        });
    }
}
</script>
