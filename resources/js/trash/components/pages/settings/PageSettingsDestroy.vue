<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">
            Удалить аккаунт
        </h3>
        <form class="e-box e-box--padding" @submit.prevent="feedback">
            <h4 class="size--16 weight--700">
                Нам очень жаль, что Вы решили уйти :(
            </h4>
            <p class="size--13 margin--top-25 margin--bottom-25">
                Дайте нам шанс! Если у Вас возникли трудности при работе с сайтом, опишите Вашу проблему, и мы постараемся помочь Вам в кратчайшие сроки:
            </p>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Ваше сообщение
                    </span>
                </div>
                <div>
                    <textarea class="form--control form--textarea form--control-gray size--13" rows="4" placeholder="Ваше сообщение" v-model="message" :disabled="processing" maxlength="1000"></textarea>
                    <div class="size--12 margin--top-5 color--regent-gray">
                        Осталось символов: {{ 1000 - (message ? message.length : 0) }}
                    </div>
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing || !this.message" :class="{ loading: processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Отправить сообщение
                    </button>
                </div>
            </div>
        </form>
        <form class="e-box e-box--padding" @submit.prevent="destroy">
            <h4 class="size--16 weight--700 margin--bottom-25">
                Если вы по прежнему хотите удалить свой аккаунт...
            </h4>
            <div class="e-field">
                <div>
                    <span class="size--13">Введите Ваш текущий пароль</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Ваш текущий пароль" type="password" required v-model="password" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" style="background: #fa6251;" type="submit" :disabled="processing || !this.password" :class="{ loading: processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Удалить аккаунт
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import toastr from 'toastr';
import axios from 'axios';
import querystring from 'querystring';
import { mapGetters } from 'vuex';

import ModalUserDestroy from '../../includes/modals/ModalUserDestroy';

export default {
    data() {
        return {
            processing: false,
            message: null,
            password: null
        }
    },
    computed: {
        ...mapGetters([
            'user'
        ])
    },
    methods: {
        feedback() {
            this.processing = true;

            this.processing = false;
            this.message = null;

            toastr.success('Ваше сообщение отправлено');
        },
        async destroy() {
            this.processing = true;

            const { password } = this;
            const { login } = this.user;

            try {
                const response = await (axios.post('/api/auth/login', querystring.stringify({
                    login,
                    password
                })));

                this.$modal.show(ModalUserDestroy, {
                    password
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                });
            } catch (e) {
                if (e.response.status == 422) {
                    toastr.error('Неверный пароль');
                }
            }

            this.processing = false;
        }
    }
}
</script>
