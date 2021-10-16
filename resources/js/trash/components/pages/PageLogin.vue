<template>
    <LayoutAuth>
        <form @submit.prevent="doLogin">
            <input class="form--control form--border form--group size--13" type="text" required placeholder="Логин" v-model="login" :disabled="processing">
            <input class="form--control form--border form--group size--13" type="password" required placeholder="Пароль" v-model="password" :disabled="processing">
            <div class="auth--cry">
                <!-- Form-checkbox start -->
                <div class="pretty p-default p-curve">
                    <input type="checkbox" :disabled="processing">
                    <div class="state">
                        <label>
                            <span class="size--13">Запомнить меня</span>
                        </label>
                    </div>
                </div>
                <!-- Form-checkbox end -->
                <a class="size--13" href="">Забыли пароль?</a>
            </div>
            <div class="auth--say">
                <button class="btn btn-block btn-blue btn-round btn-bigger size--12 weight--600" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Войти
                </button>
                <div class="size--13 style--center auth--sector">
                    <span>Еще не зарегистрированы?</span>
                    <router-link to="/register">Создать аккаунт</router-link>
                </div>
            </div>
        </form>
    </LayoutAuth>
</template>

<script>
import toastr from 'toastr';

import LayoutAuth from '../layouts/LayoutAuth';

export default {
    data() {
        return {
            processing: false,
            login: null,
            password: null
        }
    },
    components: {
        LayoutAuth
    },
    methods: {
        async doLogin() {
            this.processing = true;
            const { login, password } = this;
            try {
                await this.$store.dispatch('AUTH_REQUEST', { login, password });
                this.$router.push('/');
            } catch (e) {
                if (e.response.status === 422) {
                    toastr.error('Неверный логин или пароль', 'Войти не удалось');
                } else {
                    toastr.error('Неизвестная ошибка', 'Войти не удалось');
                }
                this.processing = false;
            }
        }
    }
}
</script>
