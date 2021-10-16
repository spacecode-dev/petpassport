<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">
                    Название работы
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Название работы" type="text" required v-model="profile.work_name" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Место работы
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Место работы" type="text" required v-model="profile.work_place" :disabled="processing" maxlength="255">
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
            profile: {}
        }
    },
    created() {
        this.profile = Object.assign({}, this.$store.getters.selfProfile);
    },
    methods: {
        async update() {
            this.processing = true;

            const {
                work_name,
                work_place
            } = this.profile;

            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    work_name,
                    work_place
                });
                toastr.success('Данные о работе обновлены');
            } catch (e) {

            }

            this.processing = false;
        }
    }
}
</script>
