<template>
    <nav class="navbar content--menu--bottom" role="navigation" aria-label="contentMenuBottom navigation">
        <div class="navbar-menu">
            <div class="navbar-end">
                <router-link class="navbar-item" :to="profile.link">Профиль</router-link>
                <router-link class="navbar-item" :to="profile.link + '/news'">Новости<span class="badge">12</span></router-link>
                <a class="navbar-item" href="#">Рынок</a>
                <router-link class="navbar-item" :to="profile.link + '/photos'">Фото</router-link>
                <router-link class="navbar-item" :to="profile.link + '/videos'">Видео</router-link>
                <router-link class="navbar-item" :to="profile.link + '/friends'">Друзья</router-link>
                <router-link class="navbar-item" :to="profile.link + '/pages'">Страницы</router-link>
                <router-link class="navbar-item" :to="profile.link + '/groups'">Группы</router-link>
                <router-link class="navbar-item" :to="profile.link + '/nurseries'">Питомники</router-link>
                <router-link class="navbar-item" :to="profile.link + '/announcements'">Обьявления</router-link>
                <router-link class="navbar-item" :to="profile.link + '/promote'">Продвижение</router-link>
                <b-navbar-dropdown label="Ещё" right class="last">
                    <b-navbar-item href="#">About</b-navbar-item>
                    <b-navbar-item href="#">Contact</b-navbar-item>
                </b-navbar-dropdown>
            </div>
        </div>
    </nav>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        computed: {
            ...mapGetters({
                profile: 'selfProfile'
            }),
        }
    }
</script>
