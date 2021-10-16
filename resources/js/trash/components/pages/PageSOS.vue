<template>
    <LayoutMain hidden-sidebar>
        <template v-slot:header-middle>
            <div class="h-middle" style="background-image: url('/img/background/head.jpg');">
                <div class="h-middle--shebang">
                </div>
                <div class="h-middle--item">
                    <div class="h-middle--guide style--center">
                        <a href="" v-if="false">
                            <img class="img-fluid h-middle--code" src="/img/other/qrcode.png" alt="">
                        </a>
                        <a class="h-middle--floor" href="" v-if="false">
                            Рейтинг: 0
                        </a>
                    </div>
                    <div class="h-middle--piece">
                        <h4 class="h-middle--utter">
                            Emergency button
                            <i class="ico ico--accepted" title="Проверенная страница"></i>
                        </h4>
                    </div>
                </div>
            </div>
        </template>
        <template v-slot:header-bottom>
            <div class="h-bottom">
                <div class="h-bottom--object style--center">
                    <p class="size--18" v-if="false">
                        Статус:
                    </p>
                    <div class="h-bottom--unite" v-if="false">
                        <a class="h-bottom--have color--mirage" href="">
                            <span class="sb-who--be"></span>
                            <span class="size--13">Помощь</span>
                        </a>
                    </div>
                </div>
                <div class="h-bottom--report">
                    <ul class="h-bottom--term" v-if="false">
                        <li>
                            <a class="h-bottom--wash" href="#">
                                Отменить запрос
                            </a>
                        </li>
                        <li class="mdrop--wrap mdrop--toggle">
                            <a class="h-bottom--lead" href="">
                                <i></i><i></i><i></i>
                            </a>
                            <div class="mdrop mdrop--align-right">
                                <div>
                                    <ul class="style--uppercase">
                                        <li><a class="active" href="">Выбрать</a></li>
                                        <li><a href="">Выбрать</a></li>
                                        <li><a href="">Выбрать</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="h-bottom--word"></div>
                    <ul class="h-bottom--menu" style="justify-content: flex-start;">
                        <li style="margin-right: 1.5em;">
                            <router-link class="h-bottom--rumor" active-class="active" to="/sos" exact>
                                Подать объявление
                            </router-link>
                        </li>
                        <li style="margin-right: 1.5em;">
                            <router-link class="h-bottom--rumor" active-class="active" to="/sos/new">
                                Мои объявления
                            </router-link>
                        </li>
                        <li style="margin-right: 1.5em;">
                            <router-link class="h-bottom--rumor" active-class="active" to="/sos/new">
                                Мои подписки
                            </router-link>
                        </li>
                        <!--
                        <li class="mdrop--wrap mdrop--toggle">
                            <a class="h-bottom--say" href="#">
                                <span class="size--14">Еще</span>
                                <i class="prefab--arrow-down"></i>
                            </a>
                            <div class="mdrop mdrop--align-right">
                                <div>
                                    <ul class="style--uppercase">
                                        <li><a class="active" href="">Выбрать</a></li>
                                        <li><a href="">Выбрать</a></li>
                                        <li><a href="">Выбрать</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    -->
                    </ul>
                </div>
            </div>
        </template>
        <template v-slot:sidebar-header>
            <div class="b-user" style="background-image: url('/img/background/head.jpg');">
                <div class="b-user--inner">
                    <h3 class="b-user--rap">
                        Emergency button
                    </h3>
                    <div class="e-avatar--65 e-avatar">
                        <router-link class="e-avatar--photo" to="/sos" style="background: #fa6251;"></router-link>
                        <div class="e-avatar--content">
                            <span class="size--14 color--white">
                                SOS
                            </span>
                        </div>
                    </div>
                    <p class="b-user--say">
                        &nbsp;
                    </p>
                </div>
            </div>
        </template>
        <template v-slot:sidebar-content>
            <div>
                <div class="sb-descr style--center e-more">
                    <span class="size--13 sb-descr--speech">
                        <span v-if="false">
                            {{ about }}
                        </span>
                    </span>
                </div>
                <div v-if="false">
                    <div class="padding--top-45">
                        <div class="style--center">
                            <div class="pretty p-switch p-slim" @click.capture.stop.prevent="switchInfoHidden" >
                                <input type="checkbox" v-model="profile.profile.info_hidden">
                                <div class="state">
                                    <label>
                                        <span class="size--13">
                                            Скрыть информацию
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <router-link class="btn btn-block btn-blue-border-style margin--bottom-40" to="/settings" v-if="false">
                    Сменить владельца
                </router-link>
                <ul class="sb-info size--13">
                    <li v-if="false">
                        <ul class="e-list e-list--dot">
                            <li>
                                <router-link :to="'/' + profile.profile.slug + '/pedigree'">
                                    Родословная
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="'/' + profile.profile.slug + '/passport'">
                                    Паспорт
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="false">
                        Титулы:
                        {{ profile.profile.titles }}
                    </li>
                    <li v-if="false">
                        Потомство:
                        <ul class="style--uppercase sb-similar">
                            <li>
                                <i class="ico ico--sex-fem"></i>
                                <router-link :to="'/pet'">
                                    HUOLETON CAPRICORNUS
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="false">
                        <i class="ico ico--feed"></i>
                        <span>Читают: </span>
                        <router-link :to="'/' + profile.profile.slug + '/friends/subscribers'">
                            {{ profile.counters.subscribers }} пользователей
                        </router-link>
                    </li>
                </ul>
                <button class="btn btn-block btn-blue-border-style" v-if="false">
                    Контактная информация
                </button>
            </div>
        </template>
        <div class="cn-main">
            <div class="cn-main--left">
                <div class="e-box--with-sep e-box e-box--padding">
                    <h4 class="e-box--title">
                        Поиск объявлений
                    </h4>
                    <form>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control">
                                <option value="1">Россия</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control">
                                <option value="0">Москва</option>
                                <option value="1">Мужской</option>
                                <option value="3">Женский</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control">
                                <option value="1">Собаки</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control">
                                <option value="1">Такса</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                        </div>
                        <button class="btn btn-block size--13 btn-border-blue btn-round weight--600 btn-bigger">
                            Найти объявления
                        </button>
                    </form>
                </div>
            </div>
            <div class="cn-main--content">
                <div class="row cn-top--new" v-if="profile">
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <IncludePostForm :wall_id="profile.user_id" :sos="true"/>
                    </div>
                    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12" v-if="true">
                        <div class="e-box e-box--padding e-post--new">
                            <div class="e-card-shop--exile">
                                <p class="size--13 style--center e-post--text">
                                    Подпишитесь на результаты текущего поиска, и получайте уведомления о новых объявлениях на тему:<br><b>Россия - Москва - Собаки - Такса</b>
                                </p>
                            </div>
                            <div class="e-card-shop--subject">
                                <router-link class="btn btn-round btn-bigger size--12 weight--600 btn-boder btn-gray" to="/settings/shops">
                                    Отменить все подписки
                                </router-link>
                                <router-link class="btn btn-round btn-bigger size--12 weight--600 btn-blue btn-green" to="/settings">
                                    Подписаться
                                </router-link>
                                <div class="mdrop--wrap mdrop--toggle">
                                    <div class="btn-round size--12 weight--600 btn-boder btn-more">
                                        <i class="ico ico--more"></i>
                                    </div>
                                    <div class="mdrop mdrop--list">
                                        <div>
                                            <ul>
                                                <li><a href="">Редактировать</a></li>
                                                <li><a href="">Продать</a></li>
                                                <li><a href="">Удалить</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row cn-main--inner">
                    <div class="col-xl-6 __cn-main--body">
                        <IncludePosts :request="postsRequest">
                            <template v-slot:title>
                                Недавние просьбы о помощи
                            </template>
                        </IncludePosts>
                    </div>
                </div>
            </div>
        </div>
    </LayoutMain>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapState, mapGetters } from 'vuex';

import store from '../../store';
import LayoutMain from '../layouts/LayoutMain';
import IncludePosts from '../includes/IncludePosts';
import IncludePostForm from '../includes/IncludePostForm';

export default {
    components: {
        LayoutMain,
        IncludePosts,
        IncludePostForm
    },
    data() {
        return {
            postsRequest: {
                reason: 'sos'
            }
        }
    },
    computed: {
        ...mapState({
            counters: state => state.counters.counters
        }),
        ...mapGetters({
            profile: 'selfProfile'
        }),
    },
    created() {

    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    methods: {

    }
}
</script>

<style>

</style>
