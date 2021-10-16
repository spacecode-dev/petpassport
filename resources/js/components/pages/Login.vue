<template>
    <AuthLayout>
        <form @submit.prevent="doLogin">
            <b-field
                    :type="validation.login.type"
                    :message="validation.login.message"
            >
                <input
                        v-model="login"
                        :disabled="processing"
                        placeholder="Логин"
                        type="text"
                        readonly
                        @focus="removeReadOnly($event)"
                        @blur="setReadOnly($event)"
                        @input="typing('login')"
                />
            </b-field>
            <b-field
                    :type="validation.password.type"
                    :message="validation.password.message"
            >
                <b-input
                        v-model="password"
                        :disabled="processing"
                        placeholder="Пароль"
                        type="password"
                        readonly
                        @focus="removeReadOnly($event)"
                        @blur="setReadOnly($event)"
                        @input="typing('password')"
                        password-reveal
                />
            </b-field>
            <div class="auth--help">
                <b-field>
                    <b-checkbox
                            size="is-small"
                            :disabled="processing"
                            :value="remember"
                    >
                        Запомнить меня
                    </b-checkbox>
                </b-field>
                <a href="#" @click.prevent>Забыли пароль?</a>
            </div>
            <b-button
                    type="is-primary"
                    native-type="submit"
                    :disabled="processing"
                    :loading="processing"
                    expanded
            >
                Войти
            </b-button>
            <div class="auth--say">
                <span>Еще не зарегистрированы?</span>
                <router-link to="/register">Создать аккаунт</router-link>
            </div>
        </form>
    </AuthLayout>
</template>

<script>
    import AuthLayout from '../layouts/AuthLayout';
    export default {
        data() {
            return {
                processing: false,
                login: null,
                password: null,
                remember: false,
                validation: {
                    login: {
                        type: null,
                        message: null
                    },
                    password: {
                        type: null,
                        message: null
                    }
                }
            }
        },
        components: {
            AuthLayout
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
            async doLogin() {
                this.processing = true;
                const { login, password, remember } = this;
                try {
                    await this.$store.dispatch('AUTH_REQUEST', { login, password, remember });
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
        }
    }
</script>

<style lang="scss" scoped>
    ::v-deep form {
        padding-top: 1em;
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
        [type="submit"] {
            font-size: .8rem;
            padding: .5rem 0;
            height: auto;
            margin-top: 2rem;
        }
        .auth--help {
            display: flex;
            align-items: center;
            justify-content: space-between;
            .field {
                margin: 0;
            }
            a {
                font-size: .75rem;
            }
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
