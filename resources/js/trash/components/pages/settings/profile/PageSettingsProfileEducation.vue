<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">
                    Название заведения
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Название заведения" type="text" required v-model="profile.edu_name" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Группа/Класс
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Группа/класс" type="text" required v-model="profile.edu_group" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Статус/Уровень
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Статус/Уровень" type="text" required v-model="profile.edu_degree" :disabled="processing" maxlength="255">
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
                edu_name,
                edu_group,
                edu_degree
            } = this.profile;

            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    edu_name,
                    edu_group,
                    edu_degree
                });
                toastr.success('Данные о образовании обновлены');
            } catch (e) {

            }

            this.processing = false;
        }
    }
}
</script>
