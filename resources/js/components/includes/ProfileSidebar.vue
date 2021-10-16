<template>
    <b-sidebar type="is-light" fullheight :open.sync="settings.sidebar.show" :can-cancel="['x']">
        <vue-custom-scrollbar class="scroll-area" tagname="div" :settings="settings.sidebar.scroll.settings">
            <div class="sidebar--div">
                <div class="sidebar--item sidebar--user--top">
                    <img class="bg" v-if="profile.cover" :src="getBackground" alt=""/>
                    <div class="user">
                        <figure class="image is-64x64">
                            <img class="is-rounded" :src="getAvatar" :alt="'Логотип ' + profile.name">
                        </figure>
                        <span>{{ profile.name }}</span>
                    </div>
                    <div class="type">
                        Питомник "Olga Serova"
                    </div>
                </div>
                <div class="sidebar--item sidebar--user--description">
                    Один из лучших заводчиков Джек-Рассел терьеров одного из лучших питомников - Lovely Orange
                </div>
                <div class="sidebar--item sidebar--user--info content">
                    <ul>
                        <li>Страна: Россия</li>
                        <li>Город: Москва</li>
                        <li>Страна рождения: Россия</li>
                        <li>Дата рождения: 1971-01-28</li>
                        <li>Пол: Женский</li>
                        <li>Семейное положение: Не замужем</li>
                        <li>Сайт: <a href="http://lovely-orange.ru" target="_blank">lovely-orange.ru</a></li>
                        <li>
                            <b-icon icon="rss" size="is-small" type="is-primary"/>
                            Читают: 0 пользователей
                        </li>
                    </ul>
                    <b-button type="is-primary" expanded outlined>Контактная информация</b-button>
                </div>
                <div class="sidebar--item sidebar--shops">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Магазины
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Косточка</a>
                                    <p class="subtitle is-7">14 товаров</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Косточка</a>
                                    <p class="subtitle is-7">14 товаров</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Косточка</a>
                                    <p class="subtitle is-7">14 товаров</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--announcements">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Обьявления
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">GO! корм холистик суперпремиум класса </a>
                                    <p class="subtitle is-7">4300 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">GO! корм холистик суперпремиум класса </a>
                                    <p class="subtitle is-7">4300 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">GO! корм холистик суперпремиум класса </a>
                                    <p class="subtitle is-7">4300 ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--reviews">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Отзывы
                                <span class="badge">12</span>
                            </a>
                        </h4>
                        <b-button type="is-text" icon-left="message-reply-text">
                            Написать отзыв
                        </b-button>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <p class="title is-6">There are two hard things in computer science: cache invalidation, naming things, and off-by-one errors.</p>
                            <a class="subtitle is-7" href="#">
                                <b-icon icon="account" size="is-small"/>
                                Jeff Atwood</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <p class="title is-6">There are two hard things in computer science: cache invalidation, naming things, and off-by-one errors.</p>
                            <a class="subtitle is-7" href="#">
                                <b-icon icon="account" size="is-small"/>
                                Jeff Atwood</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <p class="title is-6">There are two hard things in computer science: cache invalidation, naming things, and off-by-one errors.</p>
                            <a class="subtitle is-7" href="#">
                                <b-icon icon="account" size="is-small"/>
                                Jeff Atwood</a>
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--partners">
                    <div class="title">
                        <div class="circles">
                            <b-icon icon="checkbox-blank-circle-outline" type="is-primary"/>
                            <b-icon icon="checkbox-blank-circle-outline" type="is-danger"/>
                        </div>
                        <p>Владелец аккаунта открыт для знакомств</p>
                        <h4>Найти партнера</h4>
                    </div>
                    <div class="form">
                        <b-field>
                            <b-select placeholder="Пол" v-model="settings.partner.gender" size="is-small" expanded>
                                <option>Мужской</option>
                                <option>Женский</option>
                            </b-select>
                        </b-field>
                        <b-field label="Возраст">
                            <b-numberinput size="is-small" type="is-light" v-model="settings.partner.age" min="16" max="99" controls-rounded/>
                        </b-field>
                        <b-field>
                            <b-autocomplete
                                    v-model="settings.partner.country"
                                    size="is-small"
                                    placeholder="Начните вводить название страны"
                                    open-on-focus
                                    expanded
                            />
                        </b-field>
                        <b-field>
                            <b-autocomplete
                                    v-model="settings.partner.city"
                                    size="is-small"
                                    :placeholder="!settings.partner.country ? 'Сначала выберите страну' : 'Начните вводить название города'"
                                    open-on-focus
                                    expanded
                            />
                        </b-field>
                        <b-field>
                            <b-select placeholder="Вид питомцев" size="is-small" expanded>
                                <option>Собаки</option>
                                <option>Кошки</option>
                            </b-select>
                        </b-field>
                        <b-field>
                            <b-select placeholder="Количество питомцев" size="is-small" expanded>
                                <option>1-2</option>
                                <option>3-5</option>
                                <option>5-10</option>
                                <option>> 10</option>
                            </b-select>
                        </b-field>
                    </div>
                    <b-button type="is-primary" expanded outlined>Найти партнёра</b-button>
                </div>
                <div class="sidebar--item sidebar--friends">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Друзья
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="img-list">
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                            ULTRA TALISMAN BROOKLYN
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                            ULTRA TALISMAN BROOKLYN
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                            ULTRA TALISMAN BROOKLYN
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                            ULTRA TALISMAN BROOKLYN
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                            ULTRA TALISMAN BROOKLYN
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                            ULTRA TALISMAN BROOKLYN
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--photos">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Фотографии
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="img-list">
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                        </div>
                        <div class="img-item">
                            <a href="#">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt=""/>
                                </figure>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--pages">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Страницы
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Туканы</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="heart" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Туканы</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="heart" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Туканы</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="heart" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Туканы</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="heart" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--groups">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Группы
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Записки заводчика</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Записки заводчика</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Записки заводчика</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Записки заводчика</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar--item sidebar--nurseries">
                    <div class="sidebar--item--title">
                        <h4>
                            <a href="#">
                                Питомники
                                <span class="badge">12</span>
                            </a>
                        </h4>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Lovely Orange</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Lovely Orange</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Lovely Orange</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="https://bulma.io/images/placeholders/64x64.png" alt="Placeholder image">
                                        </figure>
                                    </a>
                                </div>
                                <div class="media-content">
                                    <a class="title is-6" href="#">Lovely Orange</a>
                                    <a class="subtitle is-7" href="#">
                                        <b-icon icon="account" size="is-small"/>
                                        12
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </vue-custom-scrollbar>
    </b-sidebar>
</template>

<script>
    import {mapState} from 'vuex';
    import vueCustomScrollbar from 'vue-custom-scrollbar';

    export default {
        components: {
            vueCustomScrollbar
        },
        computed: {
            ...mapState({
                profile: state => state.profiles.profile,
                settings: state => state.settings,
                storage: state => state.settings.storage.path
            }),
            getBackground() {
                return this.storage + this.profile.cover;
            },
            getAvatar() {
                return this.storage + this.profile.avatar;
            }
        }
    }
</script>

<style lang="scss" scoped>
    ::v-deep.b-sidebar {
        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 50rem;
            background: var(--violet);
            color: white;
            margin-left: .2rem;
            position: relative;
            top: -6px;
        }
        .sidebar-content {
            width: 300px;
            margin-top: 72px;
            background: white;
            height: calc(100vh - 72px);

            .scroll-area {
                position: relative;
                margin: auto;
                width: 100%;
                height: calc(100vh - 72px);
            }

            .sidebar--div {
                .sidebar--item {
                    border-top: 1px solid #e6e9ee;
                    padding: 1.5rem 2rem;
                    position: relative;

                    .sidebar--item--title {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;

                        h4 {
                            a {
                                font-weight: 600;
                                color: black;
                                font-size: .9rem;
                            }
                        }

                        .button {
                            background: transparent;
                            color: var(--pink-swan);
                            text-decoration: none;
                            padding: 0;
                            font-size: .75rem;
                            box-shadow: none;
                            font-weight: 400;
                        }
                    }

                    .card {
                        border: 0;
                        box-shadow: none;
                        background: transparent;

                        .card-content {
                            padding: 1rem 0 0 0;

                            & > .title {
                                font-weight: 400;
                                line-height: 1.3;
                                font-size: .85rem;
                                font-style: italic;
                            }

                            & > .subtitle {
                                color: var(--manatee);
                                display: flex;
                                align-items: center;

                                .icon {
                                    margin-right: .3rem;
                                }
                            }

                            .media {
                                .media-content {
                                    .title {
                                        font-size: 0.8rem;
                                        font-weight: 400;
                                        color: black;
                                        display: block;
                                        line-height: 1;
                                        margin-top: .2rem;
                                    }

                                    .subtitle {
                                        color: var(--manatee);
                                        line-height: 1.5;
                                    }
                                }
                            }
                        }
                    }

                    &.sidebar--user--top {
                        border: 0;
                        display: flex;
                        flex-direction: column;
                        padding-bottom: .7rem;

                        .bg {
                            position: absolute;
                            left: 0;
                            top: 0;
                            bottom: 0;
                            right: 0;
                            z-index: -2;
                            height: 100%;
                            width: 100%;
                            object-fit: cover;
                        }

                        &:before {
                            content: '';
                            position: absolute;
                            left: 0;
                            top: 0;
                            bottom: 0;
                            right: 0;
                            z-index: -1;
                            height: 100%;
                            width: 100%;
                            background: rgba(0, 0, 0, .4);
                        }

                        .user {
                            display: flex;
                            align-items: center;
                            color: white;
                            margin-bottom: 1rem;

                            figure {
                                margin-right: 1rem;
                            }
                        }

                        .type {
                            margin-top: auto;
                            text-align: center;
                            color: white;
                            font-size: .9rem;
                            opacity: .8;
                        }
                    }

                    &.sidebar--user--description {
                        border: 0;
                        font-size: .85rem;
                        text-align: center;
                    }

                    &.sidebar--user--info {
                        margin: 0;

                        ul {
                            font-size: .85rem;
                            margin: 0 0 1.5rem 0;
                            list-style: none;

                            li + li {
                                margin-top: .75em;
                            }
                        }
                    }

                    &.sidebar--pages, &.sidebar--groups, &.sidebar--nurseries {
                        .media {
                            align-items: center;

                            .media-content .subtitle {
                                display: block;
                            }
                        }
                    }

                    &.sidebar--partners {
                        .title {
                            .circles {
                                position: relative;
                                height: 34px;
                                width: 34px;
                                margin: 0 auto;

                                .icon {
                                    position: absolute;

                                    &.has-text-primary {
                                        left: 0;
                                    }

                                    &.has-text-danger {
                                        right: 0;
                                    }
                                }
                            }

                            p {
                                font-size: .9rem;
                                font-weight: 400;
                                text-align: center;
                                max-width: 170px;
                                display: block;
                                margin: .5rem auto;
                            }

                            h4 {
                                font-weight: 600;
                                color: black;
                                font-size: 1rem;
                                text-align: center;
                                margin-top: 1rem;
                            }
                        }

                        .form {
                            margin-bottom: 1.5rem;

                            label {
                                font-size: .8rem;
                                color: var(--pink-swan);
                            }
                        }
                    }

                    .img-list {
                        display: flex;
                        flex-wrap: wrap;

                        .img-item {
                            margin-top: 1.5rem;
                            width: calc(100% / 3);
                            text-align: center;
                            font-size: .8rem;
                            line-height: 1.3;

                            figure {
                                margin: 0 auto .5rem auto;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
