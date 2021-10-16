<template>
    <div class="content--main">
        <h3>Настройки аккаунта</h3>
        <b-tabs v-model="activeTab" :animated="false" @change="changeTab">
            <b-tab-item label="Логин">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
<!--                            <div class="left">-->
<!--                                <p>Логин</p>-->
<!--                                <small>Можно использовать только латиницу</small>-->
<!--                            </div>-->
                            <div class="right">
                                <b-field label="Логин" label-position="on-border" :type="validation.login.type" :message="validation.login.message">
                                    <b-input :disabled="loginProcessing" @input="typing('login')" maxlength="255" required v-model="login"/>
                                </b-field>
                                <b-button :disabled="loginProcessing" :loading="loginProcessing" type="is-primary" @click.prevent="updateUser('login')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item label="Электронная почта">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
<!--                            <div class="left">-->
<!--                                <p>Адрес электронной почты</p>-->
<!--                            </div>-->
                            <div class="right">
                                <b-field label="Электронная почта" label-position="on-border" :type="validation.email.type" :message="validation.email.message">
                                    <b-input :disabled="emailProcessing" type="email" @input="typing('email')" v-model="email" maxlength="255" required/>
                                </b-field>
                                <b-button :disabled="emailProcessing" :loading="emailProcessing" type="is-primary" @click.prevent="updateUser('email')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
            <b-tab-item label="Пароль">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <div class="right">
                                <b-field label="Старый пароль" label-position="on-border" :type="validation.current_password.type" :message="validation.current_password.message">
                                    <b-input :disabled="password.processing" type="password" @input="typing('password.current_password')" v-model="password.current_password" required/>
                                </b-field>
                                <b-field label="Новый пароль" label-position="on-border" :type="validation.password.type" :message="validation.password.message">
                                    <b-input :disabled="password.processing" type="password" @input="typing('password.password')" v-model="password.password" maxlength="255" required/>
                                </b-field>
                                <b-field label="Повторите новый пароль" label-position="on-border" :type="validation.password_confirmation.type" :message="validation.password_confirmation.message">
                                    <b-input :disabled="password.processing" type="password" @input="typing('password.password_confirmation')" v-model="password.password_confirmation" maxlength="255" required/>
                                </b-field>
                                <b-button :disabled="password.processing" :loading="password.processing" type="is-primary" @click.prevent="updateUser('password')">
                                    Обновить
                                </b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-tab-item>
        </b-tabs>
    </div>
</template>

<script>
    import store from '../../../store';

    export default {
        data() {
            return {
                activeTab: 0,
                loginProcessing: false,
                emailProcessing: false,
                email: null,
                login: null,
                password: {
                    processing: false,
                    current_password: null,
                    password: null,
                    password_confirmation: null
                },
                validation: {
                    login: {
                        type: null,
                        message: null
                    },
                    email: {
                        type: null,
                        message: null
                    },
                    password: {
                        type: null,
                        message: null
                    },
                    current_password: {
                        type: null,
                        message: null
                    },
                    password_confirmation: {
                        type: null,
                        message: null
                    }
                }
            }
        },
        created() {
            this.email = store.getters.user.email;
            this.login = store.getters.user.login;
        },
        methods: {
            changeTab() {
                for (let [key, value] of Object.entries(this.validation)) {
                    this.typing(key);
                    if(key === 'password')
                        this.password.password = null;
                    if(key === 'current_password')
                        this.password.current_password = null;
                    if(key === 'password_confirmation')
                        this.password.password_confirmation = null;
                }
            },
            typing(name) {
                if(name.indexOf('.') !== -1) {
                    this.validation[name.split('.')[1]].type = null;
                    this.validation[name.split('.')[1]].message = null;
                } else {
                    this.validation[name].type = null;
                    this.validation[name].message = null;
                }
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
                if (type === 'login') {
                    this.loginProcessing = true;
                    const {login} = this;
                    let response = await store.dispatch('USER_UPDATE', {login});
                    if (typeof response !== 'undefined' && response.status === 422) {
                        for (let [key, value] of Object.entries(response.data.errors)) {
                            this.dangerValidation(key, value[0]);
                        }
                    } else {
                        this.successValidation(type, response.message);
                    }
                    this.loginProcessing = false;
                } else if (type === 'email') {
                    this.emailProcessing = true;
                    const {email} = this;
                    let response = await store.dispatch('USER_UPDATE', {email});
                    if (typeof response !== 'undefined' && response.status === 422) {
                        for (let [key, value] of Object.entries(response.data.errors)) {
                            this.dangerValidation(key, value[0]);
                        }
                    } else {
                        this.successValidation(type, response.message);
                    }
                    this.emailProcessing = false;
                } else if (type === 'password') {
                    this.typing('password');
                    this.typing('current_password');
                    this.typing('password_confirmation');
                    this.password.processing = true;
                    const {password, current_password, password_confirmation} = this.password;
                    let response = await store.dispatch('USER_UPDATE', {password, current_password, password_confirmation});
                    if (typeof response !== 'undefined' && response.status === 422) {
                        for (let [key, value] of Object.entries(response.data.errors)) {
                            this.dangerValidation(key, value[0]);
                        }
                    } else {
                        this.successValidation(type, response.message);
                    }
                    this.password.processing = false;
                }
            }
        }
    }
</script>
