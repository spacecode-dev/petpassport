<template>
    <div class="modal">
        <div class="info" v-if="profile" :class="{ 'info--male': profile.gender == 1, 'info--female': profile.gender == 2 }">
            <h3 class="info__name">
                {{ profile.name }}
            </h3>
            <div class="info__point">
                <div class="info__shebang">
                    <div class="info__photo" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></div>
                </div>
                <div class="info__entry">
                    <div class="info__lead">
                        <template v-if="profile.passport && profile.passport.colour">
                            {{ profile.passport.colour }}
                        </template>
                    </div>
                    <div class="info__gage">
                        <span v-if="birth_year">
                            {{ birth_year }}
                        </span>
                        <span v-if="profile.birth_country_id">
                            {{ profile_birth_country_name }}
                        </span>
                    </div>
                </div>
                <div class="info__shebang info__query">
                    <div class="info__gender"></div>
                </div>
            </div>
            <div class="info__average">
                <p v-if="profile.pet_profile && profile.pet_profile.titles">
                    Титулы: {{ profile.pet_profile.titles }}
                </p>
            </div>
            <div class="info__paper">
                <span>
                    <!--Лиссабон, Португалия-->
                    <template v-if="profile.city_id">
                        {{ profile_city_name }},
                    </template>
                    <template v-if="profile.country_id">
                        {{ profile_country_name }}
                    </template>
                </span>
                <div class="status" :class="{ 'status--active': profile.mating, 'status--close': !profile.mating }">
                    <span>
                        <template v-if="profile.mating">
                            открыт
                        </template>
                        <template v-else>
                            закрыт
                        </template>
                        для вязки
                    </span>
                    <div class="status__clause"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as moment from 'moment';
import { mapCacheActions } from 'vuex-cache';

export default {
    props: {
        profile: Object
    },
    asyncComputed: {
        async profile_country_name() {
            if (!this.profile || !this.profile.country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id == this.profile.country_id).name;
        },
        async profile_city_name() {
            if (!this.profile || !this.profile.country_id || !this.profile.city_id) return;
            const cities = await this.getCities(this.profile.country_id);
            return cities.find(c => c.id == this.profile.city_id).name;
        },
        async profile_birth_country_name() {
            if (!this.profile || !this.profile.birth_country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id == this.profile.birth_country_id).name;
        }
    },
    computed: {
        birth_year() {
            if (!this.profile || !this.profile.birthday) return;

            return moment(this.profile.birthday).format('YYYY');
        }
    },
    methods: {
        ...mapCacheActions([
            'getCountries',
            'getCities'
        ])
    }
}
</script>

<style>
/*
.blocker {
    background: none !important;
    z-index: 10;
}

@media all and (max-width: 575px) {
    .blocker {
        padding-left: 0;
        padding-right: 0;
    }
}
*/
</style>

<style scoped>
.modal {
    /*max-width: 29.65em;*/
    padding: 1.64em 2.18em;
    /*border: 1px solid #C4C4C4;*/
    /*box-sizing: border-box;*/
    /*box-shadow: 0px 4px 26px rgba(0, 0, 0, .78);*/
    border-radius: 10px;
}

.info__photo {
    width: 6.2em;
    height: 6.2em;
    background-color: #DDD;
    border-radius: 100%;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-size: cover;
}
.info__gender {
    display: inline-block;
    width: 3.34em;
    height: 4.82em;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-size: contain;
}
.info__point {
    display: flex;
    margin-bottom: 1.9em;
}
.info__lead {
    font-size: 1em;
}
.info__name {
    color: var(--c-dark-blue);
    font-size: 1.38em;
    text-align: center;
    margin-bottom: 1em;
}
.info__average {
    font-size: .81em;
    text-align: center;
    margin-bottom: 2.4em;
}
.info__paper {
    font-size: .88em;
    display: flex;
    justify-content: space-between;
}
.info__entry {
    flex-grow: 1;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding-top: .7em;
    padding-bottom: .7em;
}
.info__shebang {
    width: 25%;
}
.info__query {
    text-align: right;
    align-self: center;
}
.info__gage > * + * {
    margin-left: 1.1em;
}
.info--male .info__gender {
    background-image: url('/img/icons/sex-male.svg')
}
.info--female .info__gender {
    background-image: url('/img/icons/sex-fem.svg');
}
.info--female .info__name {
    color: var(--c-red);
}

.status {
    display: inline-block
}
.status__clause {
    display: inline-block;
    background-color: #3e3e3e;
    border-radius: 100%;
    width: .9em;
    height: .9em;
    vertical-align: middle;
}
.status--active .status__clause {
    background-color: #9AA610;
}
.status--close .status__clause {
    background-color: #ff6056;
}

@media all and (max-width: 460px) {
    .modal {
        padding-left: .88em;
        padding-right: .88em;
    }

    .info__point {
        font-size: .72em;
    }
    .info__name {
        font-size: 1.24em;
    }
    .info__average {
        font-size: .69em;
    }
    .info__paper {
        font-size: .76em;
    }
}
</style>
