<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">Настройки аккаунта</h3>
        <ul class="left e-tab--nav">
            <router-link tag="li" class="label-show" active-class="active" to="/settings/account/login">
                <span class="size--14">Логин</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/account/email">
                <span class="size--14">Электронная почта</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/account/password">
                <span class="size--14">Пароль</span>
            </router-link>
        </ul>
        <router-view></router-view>
    </div>
</template>
