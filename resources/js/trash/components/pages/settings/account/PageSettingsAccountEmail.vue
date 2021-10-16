<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">Адрес электронной почты</span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Email" type="email" required v-model="email" :disabled="processing">
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
            email: null
        }
    },
    created() {
        this.email = this.$store.getters.user.email;
    },
    methods: {
        update: async function () {
            const {email} = this;

            this.processing = true;

            let response = await this.$store.dispatch('USER_UPDATE', {email});

            if (response.result) {
                toastr.success('Адрес электронной почты успешно обновлен', 'Email обновлен');
            } else if (response.status === 422 && Array.isArray(response.data.errors.email) && response.data.errors.email[0]) {
                toastr.error(response.data.errors.email[0]);
            }

            this.processing = false;
        }
    }
}
</script>
