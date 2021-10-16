<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Подумайте еще раз
                </p>
                <p class="size--13 weight--600 color--persimmon margin--top-25">
                    Это последнее предупреждение!<br>
                    После нажатия на кнопку ниже, произойдет выход из системы, и Ваш аккаунт будет безвозвратно удален.
                </p>
                <p class="size--13 margin--top-20">
                    Обратите внимание, что даже после удаления аккаунта некоторые данные (такие как отзывы и имена в родословных) продолжат отображаться на сайте
                </p>
            </div>
            <div class="modal-sep"></div>
            <div class="modal-box style--center">
                <button class="btn btn-blue-border-style btn-wider" @click="destroy" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader" style="background: #FFF;">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Я хорошо
                    <template v-if="profile.type !== 3 && profile.gender == 2">
                        подумала,
                    </template>
                    <template v-else>
                        подумал,
                    </template>
                    удалите мой аккаунт
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
    props: {
        password: String
    },
    data() {
        return {
            processing: false
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
    },
    methods: {
        async destroy() {
            this.processing = true;

            await axios.delete('/api/user');

            this.$store.commit('AUTH_LOGOUT');
            this.$router.go();
        }
    }
}
</script>

<style lang="scss" scoped>
.btn {
    border-color: #fa6251;
    color: #fa6251;

    &:hover {
        background: #fa6251;
        color: #FFF;
    }
}
</style>
