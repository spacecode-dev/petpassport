<template>
    <div class="content--main">
        <h3>Настройки профиля</h3>
        <b-tabs v-model="activeTab" :animated="false" @change="changeTab">
            <b-tab-item label="Основное">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <div class="right">
                                <b-field label="Имя" label-position="on-border" :type="validation.name.type" :message="validation.name.message">
                                    <b-input :disabled="mainProcessing" @input="typing('name')" maxlength="255" required v-model="profile.name"/>
                                </b-field>
                                <b-field label="Пол" label-position="on-border">
                                    <b-select v-model="profile.gender" :disabled="mainProcessing" expanded>
                                        <option :value="null">Не указано</option>
                                        <option value="1">Мужской</option>
                                        <option value="2">Женский</option>
                                    </b-select>
                                </b-field>
                                <b-field label="Дата рождения" label-position="on-border">
                                    <b-datepicker v-model="profile.birthday" :disabled="mainProcessing" placeholder="Нажмите для выбора даты" :min-date="date.minDate" :max-date="date.maxDate"/>
                                </b-field>
                                <b-field label="Семейное положение" label-position="on-border">
                                    <b-select v-model="profile.marital_status" :disabled="mainProcessing || !profile.gender" :placeholder="!profile.gender ? 'Укажите пол для выбора семейного положения' : null" expanded>
                                        <option :value="null">Не указано</option>
                                        <option value="1">{{ profile.gender && profile.gender.toString() === '1' ? 'Не женат' : 'Не замужем' }}</option>
                                        <option value="2">{{ profile.gender && profile.gender.toString() === '1' ? 'Женат' : 'Замужем' }}</option>
                                    </b-select>
                                </b-field>
                                <b-field label="Обо мне" label-position="on-border" :type="validation.about.type" :message="validation.about.message">
                                    <b-input maxlength="1000" required type="textarea" v-model="profile.about" :disabled="mainProcessing"/>
                                </b-field>
                                <b-field label="Сайт" label-position="on-border" :type="validation.site.type" :message="validation.site.message">
                                    <b-input :disabled="mainProcessing" @input="typing('site')" v-model="profile.site" maxlength="255"/>
                                </b-field>
                                <b-field>
                                    <b-checkbox :disabled="mainProcessing" v-model="profile.noavatar">
                                        Отключить отображение аватара
                                    </b-checkbox>
                                </b-field>
                                <b-button :disabled="mainProcessing" :loading="mainProcessing" type="is-primary" @click.prevent="updateUser('main')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item label="Работа">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <div class="right">
                                <b-field label="Название" label-position="on-border">
                                    <b-input :disabled="workProcessing" @input="typing('work_name')" v-model="profile.work_name" maxlength="255" required/>
                                </b-field>
                                <b-field label="Место" label-position="on-border">
                                    <b-input :disabled="workProcessing" @input="typing('work_place')" v-model="profile.work_place" maxlength="255" required/>
                                </b-field>
                                <b-button :disabled="workProcessing" :loading="workProcessing" type="is-primary" @click.prevent="updateUser('work')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item label="Контакты">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <div class="right">
                                <b-field label="Страна рождения" label-position="on-border">
                                    <b-autocomplete v-model="profile.birth_country_id" :disabled="contactsProcessing" placeholder="Начните вводить название страны" open-on-focus expanded/>
                                </b-field>
                                <b-field label="Страна" label-position="on-border">
                                    <b-autocomplete v-model="profile.country_id" :disabled="contactsProcessing" placeholder="Начните вводить название страны" open-on-focus expanded/>
                                </b-field>
                                <b-field label="Город" label-position="on-border">
                                    <b-autocomplete v-model="profile.city_id" :disabled="contactsProcessing" :placeholder="!profile.country_id ? 'Сначала выберите страну' : 'Начните вводить название города'" open-on-focus expanded/>
                                </b-field>
                                <b-field label="Телефон" label-position="on-border">
                                    <b-input @input.native="inputPhone($event)" :value="profile.phone" :disabled="contactsProcessing" v-cleave="phoneMasks"/>
                                </b-field>
                                <b-button :disabled="contactsProcessing" :loading="contactsProcessing" type="is-primary" @click.prevent="updateUser('contacts')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item label="Образование">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <div class="right">
                                <b-field label="Заведение" label-position="on-border">
                                    <b-input :disabled="eduProcessing" @input="typing('edu_name')" v-model="profile.edu_name" maxlength="255" required/>
                                </b-field>
                                <b-field label="Группа/Класс" label-position="on-border">
                                    <b-input :disabled="eduProcessing || !profile.edu_name" @input="typing('edu_group')" v-model="profile.edu_group" maxlength="255" required/>
                                </b-field>
                                <b-field label="Статус/Уровень" label-position="on-border">
                                    <b-input :disabled="eduProcessing || !profile.edu_name || !profile.edu_group" @input="typing('edu_degree')" v-model="profile.edu_degree" maxlength="255" required/>
                                </b-field>
                                <b-button :disabled="eduProcessing" :loading="eduProcessing" type="is-primary" @click.prevent="updateUser('edu')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item label="Маркет" disabled>
                <div class="card">
                    <div class="card-content">
                        <div class="content"></div>
                    </div>
                </div>
            </b-tab-item>
        </b-tabs>
    </div>
</template>

<script>
    import store from '../../../store';
    import * as moment from 'moment';
    import {getToast} from "../../../util/helper";
    import Cleave from 'cleave.js';

    const today = new Date();

    const cleave = {
        name: 'cleave',
        bind(el, binding) {
            const input = el.querySelector('input')
            input._vCleave = new Cleave(input, binding.value)
        },
        unbind(el) {
            const input = el.querySelector('input')
            input._vCleave.destroy()
        }
    }

    export default {
        data() {
            return {
                activeTab: 0,
                mainProcessing: false,
                workProcessing: false,
                contactsProcessing: false,
                eduProcessing: false,
                profile: {},
                rawPhone: '',
                date: {
                    maxDate: new Date(today.getFullYear() - 10, today.getMonth(), today.getDate()),
                    minDate: new Date(today.getFullYear() - 80, today.getMonth(), today.getDate())
                },
                phoneMasks: {
                    delimiters: [' ', '-', '-'],
                    blocks: [3, 3, 2, 2],
                    numericOnly: true
                },
                validation: {
                    name: {
                        type: null,
                        message: null
                    },
                    // gender: {
                    //     type: null,
                    //     message: null
                    // },
                    // birthday: {
                    //     type: null,
                    //     message: null
                    // },
                    // marital_status: {
                    //     type: null,
                    //     message: null
                    // },
                    about: {
                        type: null,
                        message: null
                    },
                    site: {
                        type: null,
                        message: null
                    }
                }
            }
        },
        directives: { cleave },
        created() {
            this.profile = Object.assign({}, store.getters.selfProfile);
            if(this.profile.birthday) {
                this.profile.birthday = moment(this.profile.birthday).toDate();
            }
        },
        watch: {
            'profile.gender': function (val) {
                if (!val) {
                    this.profile.marital_status = null;
                }
            },
            'profile.edu_name': function (val) {
                if (!val) {
                    this.profile.edu_group = null;
                    this.profile.edu_degree = null;
                }
            },
            'profile.edu_group': function (val) {
                if (!val) {
                    this.profile.edu_degree = null;
                }
            },
        },
        methods: {
            inputPhone(event) {
                this.profile.phone = event.target._vCleave.getFormattedValue()
            },
            changeTab() {
                for (let [key, value] of Object.entries(this.validation)) {
                    this.typing(key);
                }
            },
            typing(name) {
                this.validation[name].type = null;
                this.validation[name].message = null;
            },
            dangerValidation(name, value) {
                this.validation[name].type = 'is-danger';
                this.validation[name].message = value;
            },
            successValidation(name, value) {
                this.validation[name].type = 'is-success';
                this.validation[name].message = value;
            },
            async updateUser(type) {
                if (type === 'main') {
                    this.mainProcessing = true;
                    const birthday = this.profile.birthday ? moment(this.profile.birthday).format('YYYY-MM-DD') : null;
                    const {name, gender, marital_status, about, site, noavatar} = this.profile;
                    let response = await store.dispatch('PROFILE_UPDATE', {name, gender, birthday, marital_status, about, site, noavatar});
                    if (typeof response !== 'undefined' && response.status === 422) {
                        for (let [key, value] of Object.entries(response.data.errors)) {
                            this.dangerValidation(key, value[0]);
                        }
                    } else {
                        getToast(this, 'success', response.message);
                    }
                    this.mainProcessing = false;
                }
            }
        }
    }
</script>
