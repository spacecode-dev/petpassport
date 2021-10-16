<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">Логин</span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Логин" type="text" required v-model="login" :disabled="processing">
            </div>
            <div>
                <span class="size--12 color--regent-gray">Можно использовать только латиницу</span>
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
            login: null
        }
    },
    created() {
        this.login = this.$store.getters.user.login;
    },
    methods: {
        async update() {
            this.processing = true;

            const { login } = this;

            let response  = await this.$store.dispatch('USER_UPDATE', { login });

            if (response.result) {
                toastr.success('Логин успешно обновлен', 'Логин обновлен');
            } else if (response.status === 422 && Array.isArray(response.data.errors.login) && response.data.errors.login[0]) {
                toastr.error(response.data.errors.login[0]);
            }

            this.processing = false;
        }
    }
}
</script>
