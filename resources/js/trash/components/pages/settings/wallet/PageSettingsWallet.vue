<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">
            Кошелек
        </h3>
        <ul class="left e-tab--nav">
            <router-link tag="li" class="label-show" active-class="active" to="/settings/wallet" exact>
                <span class="size--14">
                    Пополнить счет
                </span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/wallet/history">
                <span class="size--14">
                    История
                </span>
            </router-link>
        </ul>
        <router-view></router-view>
    </div>
</template>
