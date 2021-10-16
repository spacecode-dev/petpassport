<template>
    <b-navbar key="header" :class="['header', type]" spaced>
        <template slot="brand">
            <b-navbar-item tag="router-link" :to="{ path: profile.link }">
                <img :src="getMainLogo" alt="Pet Passport"/>
            </b-navbar-item>
        </template>
        <template slot="start">
            <div v-if="sidebar" class="sidebar-button">
                <button @click.prevent="toggleSidebar">
                    <b-icon icon="menu"/>
                </button>
            </div>
            <div class="menu">
                <b-navbar-dropdown label="Раздел">
                    <b-navbar-item href="#">About</b-navbar-item>
                    <b-navbar-item href="#">Contact</b-navbar-item>
                </b-navbar-dropdown>
                <b-navbar-dropdown label="Категория">
                    <b-navbar-item href="#">About</b-navbar-item>
                    <b-navbar-item href="#">Contact</b-navbar-item>
                </b-navbar-dropdown>
                <b-navbar-dropdown label="Страна">
                    <b-navbar-item href="#">About</b-navbar-item>
                    <b-navbar-item href="#">Contact</b-navbar-item>
                </b-navbar-dropdown>
                <b-navbar-dropdown label="Город">
                    <b-navbar-item href="#">About</b-navbar-item>
                    <b-navbar-item href="#">Contact</b-navbar-item>
                </b-navbar-dropdown>
            </div>
        </template>
        <template slot="end">
            <b-dropdown position="is-bottom-left" aria-role="menu">
                <a class="navbar-item" slot="trigger" @click="toggleSearch" role="button">
                    <b-icon icon="magnify"/>
                </a>
                <b-dropdown-item
                        aria-role="menu-item"
                        :focusable="false"
                        custom
                        paddingless
                >
                    <form action="">
                        <div class="modal-card" style="width:300px;">
                            <section class="modal-card-body">
                                <b-field label="Email">
                                    <b-input
                                            type="email"
                                            placeholder="Your email"
                                            required>
                                    </b-input>
                                </b-field>
                                <b-field label="Password">
                                    <b-input
                                            type="password"
                                            password-reveal
                                            placeholder="Your password"
                                            required>
                                    </b-input>
                                </b-field>
                                <b-checkbox>Remember me</b-checkbox>
                            </section>
                            <footer class="modal-card-foot">
                                <button class="button is-primary">Login</button>
                            </footer>
                        </div>
                    </form>
                </b-dropdown-item>
            </b-dropdown>
            <b-navbar-dropdown right class="button is-rounded">
                <template slot="label">
                    {{ settings.lang.selected }}
                </template>
                <b-navbar-item @click.prevent>Русский</b-navbar-item>
                <b-navbar-item @click.prevent>English</b-navbar-item>
            </b-navbar-dropdown>
            <b-navbar-dropdown right class="dots">
                <template slot="label">
                    <div class="dotted">
                        <span/>
                        <span class="red"/>
                        <span/>
                        <span/>
                    </div>
                </template>
                <b-navbar-item href="#">About</b-navbar-item>
                <b-navbar-item href="#">Contact</b-navbar-item>
            </b-navbar-dropdown>
            <b-navbar-dropdown v-if="$store.getters.authenticated" right class="profile">
                <template slot="label">
                    <img :src="getAvatar" :alt="'Логотип ' + profile.name"/>
                    <span>{{ profile.name }}</span>
                </template>
                <router-link :to="profile.link" class="navbar-item">Профиль</router-link>
                <router-link to="/settings/breeder" class="navbar-item">Заводчик</router-link>
                <router-link to="/settings" class="navbar-item">Настройки</router-link>
                <router-link to="/settings/filemanager" class="navbar-item">Менеджер файлов</router-link>
                <router-link to="/settings/communities/create&type=1" class="navbar-item">Создать группу</router-link>
                <router-link to="/settings/communities/create&type=2" class="navbar-item">Создать питомник</router-link>
                <router-link to="/settings/communities/create&type=3" class="navbar-item">Создать страницу</router-link>
                <router-link to="/settings/shops/create" class="navbar-item">Создать магазин</router-link>
                <router-link to="/settings/announcements/create" class="navbar-item">Создать обьявление</router-link>
                <b-navbar-item @click.prevent="logout">Выход</b-navbar-item>
            </b-navbar-dropdown>
            <router-link v-else class="navbar-item login" to="/login">Войти</router-link>
        </template>
    </b-navbar>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import store from '../../store';

    export default {
        props: {
            type: {
                type: String,
                default: ''
            },
            sidebar: {
                type: Boolean,
                default: true
            }
        },
        computed: {
            ...mapGetters([
                'user'
            ]),
            ...mapGetters({
                profile: 'selfProfile'
            }),
            ...mapState({
                settings: state => state.settings,
                storage: state => state.settings.storage.path,
            }),
            getAvatar() {
                return this.storage + this.profile.avatar;
            },
            getMainLogo() {
                return this.storage + '/custom/logo.png';
            }
        },
        methods: {
            toggleSidebar() {
                store.dispatch('SIDEBAR_TOGGLE');
            },
            toggleSearch() {
                store.dispatch('SEARCH_TOGGLE');
                if(this.settings.search.show) {
                    console.log('TODO Search')
                }
            },
            async logout() {
                await store.dispatch('AUTH_LOGOUT');
            },
        }
    }
</script>

<style lang="scss" scoped>
    nav::v-deep {
        &.navbar.header {
            left: 0;
            height: 72px;
            position: fixed;
            top: 0;
            right: 0;
            z-index: 999;
            background: linear-gradient(90deg, hsla(0, 0%, 100%, .6) 15.04%, rgba(0, 0, 0, .5) 59.21%);

            &.is-white {
                background: white;
                box-shadow: 1px 1px 5px 0 rgba(30,38,56,.36);
                .navbar-menu {
                    .navbar-start {
                        .sidebar-button button .icon {
                            color: black;
                        }
                        .menu .navbar-item .navbar-link {
                            color: inherit;
                            &:not(.is-arrowless):after {
                                border-color: initial;
                            }
                        }
                    }
                    .navbar-end {
                        & > .dropdown .navbar-item {
                            color: black;
                        }
                        & > .navbar-item {
                            &.button {
                                border-color: var(--pink-swan);
                                .navbar-link {
                                    color: black;
                                }
                            }
                            &.dots .navbar-link .dotted span {
                                background: black;
                            }
                            &.profile .navbar-link {
                                span {
                                    color: black;
                                }
                                &:after {
                                    border-color: black;
                                }
                            }
                        }
                    }
                }
            }

            .navbar-brand {
                width: 16.7rem;
                align-items: center;
                justify-content: center;
                position: relative;
                min-height: 2.4rem;
                padding-right: 2rem;

                .navbar-item {
                    padding: 0;
                    width: 20px;
                    background-color: transparent;
                }

                &:before {
                    content: '';
                    position: absolute;
                    width: 1px;
                    height: 39px;
                    background: rgba(30, 38, 56, .21);
                    right: 0;
                    top: 50%;
                    transform: translate(0, -50%);
                }
            }
            .navbar-menu {
                margin-left: 1.5rem;
                .navbar-start {
                    margin: 0;
                    flex-shrink: 0;
                    flex-grow: 1;
                    .sidebar-button {
                        button {
                            color: inherit;
                            border: 0;
                            box-shadow: none;
                            background: transparent;
                            padding: 0;
                            cursor: pointer;
                            .icon {
                                color: white;
                            }
                        }
                    }
                    .menu {
                        display: flex;
                        width: 100%;
                        justify-content: center;
                        .navbar-item {
                            .navbar-link {
                                background: transparent;
                                position: relative;
                                letter-spacing: -0.02rem;
                                color: white;
                                opacity: .7;
                                font-size: .9rem;
                                transition: 0.25s opacity cubic-bezier(0.785, 0.135, 0.15, 0.86);
                                &:not(.is-arrowless):after {
                                    transform: rotate(-45deg) scale(.7);
                                    margin-top: -.3em;
                                    border-color: white;
                                }
                                & + .navbar-dropdown {
                                    transform: translateY(22px);
                                    border-radius: 0;
                                    background: rgba(255, 255, 255, .9);
                                    font-weight: 400;
                                }
                                &:hover {
                                    opacity: 1;
                                }
                            }
                        }
                    }
                }
                .navbar-end {
                    margin: 0;
                    & > .dropdown {
                        .navbar-item {
                            background: transparent;
                            color: white;
                            padding: 0 1rem;
                        }
                    }
                    & > .navbar-item {
                        background: transparent;
                        color: white;
                        padding: 0 1rem;
                        .navbar-link {
                            & + .navbar-dropdown {
                                transform: translateY(20.5px);
                                border-radius: 0;
                                background: rgba(255, 255, 255, .9);
                            }
                        }
                        &.button {
                            padding: 0;
                            margin: 2px 0 2px 1.5rem;
                            height: 36px;
                            width: 36px;
                            border-color: white;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            .navbar-link {
                                background: transparent;
                                color: white;
                                padding: .6rem;
                                font-size: .85rem;
                                font-weight: 400;
                                & + .navbar-dropdown {
                                    transform: translateY(23px);
                                    font-weight: 400;
                                }
                                &:after {
                                    display: none;
                                }
                            }
                        }
                        &.login {
                            padding: 0;
                            margin-left: 2rem;
                            font-size: .85rem;
                        }
                        &.dots {
                            padding: 0;
                            margin-left: 2rem;
                            height: 40px;
                            .navbar-link {
                                background: transparent;
                                padding: 0;
                                color: white;
                                .dotted {
                                    display: flex;
                                    flex-wrap: wrap;
                                    width: 26px;
                                    span {
                                        width: 10px;
                                        height: 10px;
                                        background: white;
                                        display: flex;
                                        border-radius: 50rem;
                                        margin: 1px;
                                        &.red {
                                            position: relative;
                                            background: transparent;
                                            &:before {
                                                content: '';
                                                position: absolute;
                                                background: var(--red);
                                                width: 13px;
                                                height: 13px;
                                                bottom: 0;
                                                left: 0;
                                                border-radius: 50rem;
                                            }
                                        }
                                    }
                                }
                                &:after {
                                    display: none;
                                }
                            }
                        }
                        &.profile {
                            padding-right: 0;
                            padding-left: 3rem;
                            height: 40px;
                            .navbar-link {
                                background: transparent;
                                color: white;
                                padding: 0 1rem 0 0;
                                &:hover {
                                    span {
                                        opacity: 1;
                                    }
                                    &:after {
                                        opacity: 1;
                                    }
                                }
                                &:after {
                                    transform: rotate(-45deg) scale(.7);
                                    right: 0;
                                    opacity: 0.7;
                                    border-color: white;
                                    margin-top: -0.3em;
                                    transition: 0.25s opacity cubic-bezier(0.785, 0.135, 0.15, 0.86);
                                }
                                img {
                                    border-radius: 50rem;
                                    margin-right: .7rem;
                                    height: 2.4rem;
                                    width: 2.4rem;
                                    object-fit: cover;
                                    max-height: 2.4rem;
                                }
                                span {
                                    color: white;
                                    opacity: 0.7;
                                    font-size: .85rem;
                                    transition: 0.25s opacity cubic-bezier(0.785, 0.135, 0.15, 0.86);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
