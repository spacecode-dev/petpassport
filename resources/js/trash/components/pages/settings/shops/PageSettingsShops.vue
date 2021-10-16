<template>
    <div>
        <ul class="left e-tab--nav">
            <router-link tag="li" class="label-show" active-class="active" to="/settings/shops" exact>
                <span class="size--14">
                    Мои магазины
                </span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/shops/favorites">
                <span class="size--14">
                    Избранные
                </span>
            </router-link>
        </ul>
        <router-view></router-view>
    </div>
</template>
