<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">
                    Номер телефона
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Номер телефона" type="text" v-model="profile.phone" :disabled="processing" maxlength="20">
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Страна
                </span>
            </div>
            <div>
                <IncludeInputWithFilter v-model="profile.country_id" :data="countries" order-by="name" filter-by="name" placeholder="Начните вводить название страны" />
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Город
                </span>
            </div>
            <div>
                <IncludeInputWithFilter v-model="profile.city_id" :data="cities" order-by="name" filter-by="name" placeholder="Начните вводить название города" v-if="profile.country_id" />
                <input class="form--control form--control-gray size--13" placeholder="Сначала выберите страну" disabled v-else>
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Страна рождения
                </span>
            </div>
            <div>
                <IncludeInputWithFilter v-model="profile.birth_country_id" :data="countries" order-by="name" filter-by="name" placeholder="Начните вводить название страны" />
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
import { mapCacheActions } from 'vuex-cache';

export default {
    data() {
        return {
            processing: false,
            profile: {},
            countries: [],
            cities: []
        }
    },
    computed: {
        year() {
            return new Date().getFullYear();
        }
    },
    async created() {
        this.profile = Object.assign({}, this.$store.getters.selfProfile);
        this.countries = await this.getCountries();
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    methods: {
        ...mapCacheActions([
            'getCountries',
            'getCities'
        ]),
        async update() {
            this.processing = true;

            const {
                phone,
                country_id,
                city_id,
                birth_country_id
            } = this.profile;

            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    phone,
                    country_id,
                    city_id,
                    birth_country_id
                });
                toastr.success('Контакты обновлены');
            } catch (e) {

            }

            this.processing = false;
        }
    },
    watch: {
        'profile.country_id': async function(newId, oldId) {
            this.cities = [];
            if (this.profile.country_id) {
                this.cities = await this.getCities(this.profile.country_id);
            }
        }
    }
}
</script>
