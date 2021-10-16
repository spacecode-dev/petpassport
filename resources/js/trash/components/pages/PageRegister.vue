<template>
    <LayoutAuth>
        <form @submit.prevent="register">
            <select class="form--border form--group wide form--control size--13"  v-model="user.type" :disabled="processing">
                <option disabled>Выберите тип аккаунта</option>
                <option v-for="type in userTypes" v-bind:value="type.id" v-bind:key="type.id">{{ type.name }}</option>
            </select>
            <input class="form--control form--border form--group size--13" type="text" placeholder="Кличка" v-model="user.name" :disabled="processing" v-if="user.type == 3">
            <input class="form--control form--border form--group size--13" type="text" placeholder="Имя" v-model="user.name" :disabled="processing" v-else>
            <select class="form--border form--group wide form--control size--13" v-model="user.pet_type" :disabled="processing" v-if="user.type == 3">
                <option value="null" disabled>Выберите вид питомца</option>
                <option v-for="category in categories" :key="category.id" value="1">{{ category.name }}</option>
            </select>
            <input class="form--control form--border form--group size--13" type="text" placeholder="Логин (латиницей, без пробелов)" v-model="user.login">
            <div class="row">
                <div class="col-lg-6">
                    <input class="form--control form--border form--group size--13" type="password" placeholder="Пароль" v-model="user.password" :disabled="processing">
                </div>
                <div class="col-lg-6">
                    <input class="form--control form--border form--group size--13" type="password" placeholder="Подтвердите пароль" v-model="user.password_confirmation" :disabled="processing">
                </div>
            </div>
            <input class="form--control form--border form--group size--13" type="email" placeholder="Email" v-model="user.email">
            <div class="auth--say">
                <button class="btn-blue-style btn btn-block" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Создать профиль
                </button>
                <div class="size--13 style--center auth--sector">
                    <span>Есть аккаунт?</span>
                    <router-link to="/login">Войти</router-link>
                </div>
            </div>
        </form>
    </LayoutAuth>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { slugify } from 'transliteration';

import LayoutAuth from '../layouts/LayoutAuth';

export default {
    components: {
        LayoutAuth
    },
    data() {
        return {
            processing: false,
            categories: window.transferData.petCategories,
            userTypes: window.transferData.userTypes,
            user: {
                type: 2,
                name: null,
                login: null,
                password: null,
                password_confirmation: null,
                email: null,
                pet_type: null
            },
            password_confirmation: null
        }
    },
    methods: {
        async register() {
            $('.toast.toast-error').remove();

            if (!this.user.name ||
                !this.user.login ||
                !this.user.password ||
                !this.user.email ||
                !this.user.password_confirmation) {
                toastr.error('Заполнены не все поля');
                return;
            }

            if (this.user.password != this.user.password_confirmation) {
                toastr.error('Пароли не совпадают');
                return;
            }

            this.processing = true;

            let result = await axios.post('/api/auth/register', this.user)
                        .then(response => {
                            if (response.data.success) {
                                toastr.success('Ваш аккаунт успешно создан');

                                return true;
                            }
                        })
                        .catch(errors =>  {
                            if (errors.response.data && errors.response.data.errors) {
                                Object.entries(errors.response.data.errors).forEach(error => {
                                    toastr.error(error[1][0]);
                                });
                            } else {
                                this.processing = false;
                                toastr.error('Произошла ошибка при создании аккаунта');
                            }
                        });

            if (result) {
                const { login, password } = this.user;
                await this.$store.dispatch('AUTH_REQUEST', { login, password });
                this.$router.push('/');
            }

            this.processing = false;

        }
    },
    watch: {
        'user.name': function() {
            //if (this.user.name && !this.user.login) {
                this.user.login = slugify(this.user.name, {
                    lowercase: false,
                    separator: '_'
                });
            //}
        },
        'user.type': function() {
            $(this.$el).find('select').niceSelect('destroy');
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect();
            });
        }
    }
}
</script>
