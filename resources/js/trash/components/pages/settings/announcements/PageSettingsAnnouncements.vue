<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">
            Объявления
            <template v-if="$route.query.shop_id">
                магазина
            </template>
        </h3>
        <ul class="left add e-tab--nav" v-if="$route.query.shop_id">
            <router-link tag="li" class="label-show" active-class="active" :to="'/settings/announcements?shop_id=' + $route.query.shop_id" exact>
                <span class="size--14">
                    Все объявления
                </span>
            </router-link>
            <li>
                <router-link class="btn btn-blue-style btn-wider" :to="'/settings/announcements/create?shop_id=' + $route.query.shop_id">
                    Добавить объявление
                </router-link>
            </li>
        </ul>
        <ul class="left add e-tab--nav" v-else>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/announcements" exact>
                <span class="size--14">
                    Мои объявления
                </span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/announcements/favorites">
                <span class="size--14">
                    Избранные
                </span>
            </router-link>
            <li>
                <router-link class="btn btn-blue-style btn-wider" to="/settings/announcements/create">
                    Добавить объявление
                </router-link>
            </li>
        </ul>
        <router-view></router-view>
    </div>
</template>
