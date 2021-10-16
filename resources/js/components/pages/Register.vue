<template>
    <AuthLayout>
        <form @submit.prevent="doRegister">
            <b-field
                    :type="validation.type.type"
                    :message="validation.type.message"
            >
                <b-select
                        placeholder="Выберите тип аккаунта"
                        v-model="user.type"
                        :disabled="processing"
                        @change="typing('type')"
                        expanded
                >
                    <option
                            v-for="type in userTypes"
                            :value="type.id"
                            :key="type.id"
                    >
                        {{ type.name }}
                    </option>
                </b-select>
            </b-field>
            <b-field
                    :type="validation.name.type"
                    :message="validation.name.message"
            >
                <input
                        v-model="user.name"
                        :disabled="processing"
                        :placeholder="user.type === 3 ? 'Кличка' : 'Имя'"
                        type="text"
                        @input="typing('name')"
                />
            </b-field>
            <b-field
                    v-if="user.type === 3"
                    :type="validation.pet_type.type"
                    :message="validation.pet_type.message"
            >
                <b-select
                        placeholder="Выберите вид питомца"
                        v-model="user.pet_type"
                        :disabled="processing"
                        @change="typing('pet_type')"
                        expanded
                >
                    <option
                            v-for="category in categories"
                            :key="category.id"
                    >
                        {{ category.name }}
                    </option>
                </b-select>
            </b-field>
            <b-field
                    :type="validation.login.type"
                    :message="validation.login.message"
            >
                <input
                        v-model="user.login"
                        :disabled="processing"
                        placeholder="Логин"
                        type="text"
                        @focus="removeReadOnly($event)"
                        @blur="setReadOnly($event)"
                        @input="typing('login')"
                        readonly
                />
            </b-field>
            <div class="columns">
                <div class="column">
                    <b-field
                            :type="validation.password.type"
                            :message="validation.password.message"
                    >
                        <b-input
                                v-model="user.password"
                                :disabled="processing"
                                placeholder="Пароль"
                                type="password"
                                @focus="removeReadOnly($event)"
                                @blur="setReadOnly($event)"
                                @input="typing('password')"
                                password-reveal
                                readonly
                        />
                    </b-field>
                </div>
                <div class="column">
                    <b-field>
                        <b-input
                                v-model="user.password_confirmation"
                                :disabled="processing"
                                placeholder="Подтвердите пароль"
                                type="password"
                                @focus="removeReadOnly($event)"
                                @blur="setReadOnly($event)"
                                password-reveal
                                readonly
                        />
                    </b-field>
                </div>
            </div>
            <b-field
                    v-if="user.type !== 3"
                    :type="validation.email.type"
                    :message="validation.email.message"
            >
                <input
                        v-model="user.email"
                        :disabled="processing"
                        placeholder="Email"
                        type="email"
                        @focus="removeReadOnly($event)"
                        @blur="setReadOnly($event)"
                        @input="typing('email')"
                        readonly
                />
            </b-field>
            <b-button
                    type="is-primary"
                    native-type="submit"
                    :disabled="processing"
                    :loading="processing"
                    expanded
            >
                Создать профиль
            </b-button>
            <div class="auth--say">
                <span>Есть аккаунт?</span>
                <router-link to="/login">Войти</router-link>
            </div>
        </form>
    </AuthLayout>
</template>

<script>
    let transferData = JSON.parse(window.transferData);
    import AuthLayout from '../layouts/AuthLayout';
    import { slugify } from 'transliteration';

    export default {
        components: {
            AuthLayout
        },
        data() {
            return {
                processing: false,
                categories: transferData.petCategories,
                userTypes: transferData.userTypes,
                user: {
                    type: 2,
                    name: null,
                    login: null,
                    password: null,
                    password_confirmation: null,
                    email: null,
                    pet_type: null
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
                    name: {
                        type: null,
                        message: null
                    },
                    type: {
                        type: null,
                        message: null
                    },
                    pet_type: {
                        type: null,
                        message: null
                    }
                }
            }
        },
        methods: {
            typing(name) {
                this.validation[name].type = null;
                this.validation[name].message = null;
            },
            dangerValidation(name, value) {
                this.validation[name].type = 'is-danger';
                this.validation[name].message = value;
            },
            removeReadOnly(event) {
                event.target.removeAttribute('readonly');
            },
            setReadOnly(event) {
                event.target.setAttribute('readonly', 'readonly');
            },
            async doRegister() {
                this.processing = true;
                const user = this.user;
                let data = {
                    type: user.type,
                    name: user.name,
                    login: user.login,
                    password: user.password,
                    password_confirmation: user.password_confirmation,
                    email: user.email
                };
                if (user.type === 3) {
                    delete data.email;
                    data.pet_type = user.pet_type;
                }
                try {
                    await this.$store.dispatch('AUTH_REGISTER', data);
                    this.$router.go(0);
                } catch (error) {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        for (let [key, value] of Object.entries(error.response.data.errors)) {
                            this.dangerValidation(key, value[0]);
                        }
                    }
                    this.processing = false;
                }
            }
        },
        watch: {
            'user.name': function() {
                this.user.login = slugify(this.user.name, {
                    lowercase: true,
                    separator: '_'
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    ::v-deep form {
        padding-top: 1em;

        .columns {
            margin-bottom: 0;
            p.help {
                position: absolute;
            }
        }

        .field {
            p.help {
                text-align: left;
                font-size: .65rem;
            }
            .control .icon {
                top: 9px;
                width: 1.6rem;
                i {
                    color: var(--pink-swan);
                    &:before {
                        font-size: 18px;
                    }
                }
            }
        }

        input, input.input {
            background-color: transparent;
            border: 1px solid transparent;
            border-bottom-color: var(--pink-swan);
            box-shadow: none;
            border-radius: 0;
            padding: 1rem 0 1rem 4px;
            height: auto;
            font-size: 0.8em;
            width: 100%;
        }

        .select {
            height: auto;

            select {
                background-color: transparent;
                border: 1px solid transparent;
                border-bottom-color: var(--pink-swan);
                box-shadow: none;
                border-radius: 0;
                padding: 1rem 0;
                height: auto;
                font-size: 0.8em;

                option {
                    padding: 0;
                }
            }

            &:not(.is-multiple):not(.is-loading):after {
                height: 0.4em;
                width: 0.4em;
                right: 20px;
                border-width: 2px;
                margin-top: -.25rem;
            }
        }

        [type="submit"] {
            font-size: .8rem;
            padding: .5rem 0;
            height: auto;
            margin-top: 2rem;
        }

        .auth--say {
            margin: .7rem 0;
            font-size: .75rem;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
    }
</style>
