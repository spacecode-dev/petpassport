<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field e-field--wide">
            <div>
                <span class="size--13">Пароль</span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Старый пароль" type="password" required v-model="current_password" :disabled="processing">
            </div>
        </div>
        <div class="e-field e-field--password">
            <div></div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Новый пароль" type="password" required v-model="password" :disabled="processing">
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Повторите пароль" type="password" required v-model="password_confirmation" :disabled="processing">
            </div>
        </div>
        <div class="e-field">
            <div></div>
            <div>
                <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Обновить
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import toastr from 'toastr';

export default {
    data() {
        return {
            processing: false,
            password_confirmation: null,
            password: null,
            password_repeat: null,
            current_password: null
        }
    },
    methods: {
        async update() {
            // if (this.password !== this.password_repeat) {
            //     return;
            // }

            this.processing = true;

            const { password_confirmation, password, current_password} = this;

            let response  = await this.$store.dispatch('USER_UPDATE', {current_password, password_confirmation, password });

            if (response.result) {
                toastr.success('Пароль успешно обновлен', 'Пароль обновлен');
            } else if (response.status === 422 && response.data.errors) {
               toastr.error(response.data.errors[Object.keys(response.data.errors)[0]][0]);
            }

            this.processing = false;
        }
    }
}
</script>
