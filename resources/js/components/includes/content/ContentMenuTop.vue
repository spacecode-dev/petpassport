<template>
    <nav class="navbar content--menu--top" role="navigation" aria-label="contentMenuTop navigation">
        <div class="navbar-menu">
            <div v-if="$store.getters.authenticated" class="navbar-end">
                <a class="navbar-item" href="#">Добавить в друзья</a>
                <a class="navbar-item" href="#">Подписаться</a>
                <a class="navbar-item" href="#">Сообщение</a>
                <b-navbar-dropdown class="last" arrowless right>
                    <template slot="label">
                        <b-icon icon="dots-horizontal"/>
                    </template>
                    <b-navbar-item href="#">About</b-navbar-item>
                    <b-navbar-item href="#">Contact</b-navbar-item>
                </b-navbar-dropdown>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        //
    }
</script>