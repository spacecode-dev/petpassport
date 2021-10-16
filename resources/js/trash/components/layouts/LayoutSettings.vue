<template>
    <LayoutMain white-header without-sidebar>
        <div class="cn-main cn-main--page">
            <div class="cn-main--left">
                <div class="profile s-menu e-box">
                    <router-link active-class="active" to="/settings/breeder" v-if="profile.type != 3">
                        <span>
                            <i class="menu s-menu--ico"></i>
                            <span class="s-menu--text">Меню заводчика</span>
                        </span>
                    </router-link>
                    <a href="#" @click.prevent="$root.loginOwner" v-else>
                        <span>
                            <i class="menu s-menu--ico"></i>
                            <span class="s-menu--text">Меню заводчика</span>
                        </span>
                    </a>
                    <router-link active-class="active" to="/settings/account">
                        <span>
                            <i class="settings s-menu--ico"></i>
                            <span class="s-menu--text">Настройка аккаунта</span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/profile">
                        <span>
                            <i class="user s-menu--ico"></i>
                            <span class="s-menu--text">Настройка профиля</span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/privacy" style="opacity: .2;">
                        <span>
                            <i class="lock s-menu--ico"></i>
                            <span class="s-menu--text">Конфиденциальность</span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/security" style="opacity: .2;">
                        <span>
                            <i class="security s-menu--ico"></i>
                            <span class="s-menu--text">Безопасность</span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/lock" style="opacity: .2;">
                        <span>
                            <i class="ban s-menu--ico"></i>
                            <span class="s-menu--text">Блокировка</span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/announcements">
                        <span>
                            <i class="papers s-menu--ico"></i>
                            <span class="s-menu--text">Объявления</span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/shops" v-if="profile.type != 3">
                        <span>
                            <i class="folders s-menu--ico"></i>
                            <span class="s-menu--text">Магазины<!-- (2)--></span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/wallet">
                        <span>
                            <i class="walet s-menu--ico"></i>
                            <span class="s-menu--text">
                                Кошелек
                                <span class="color--mirage weight--700 mx-2">
                                    {{ (user.balance / 100) | price }}
                                    <template v-if="user.currency == 1">₽</template>
                                    <template v-if="user.currency == 2">$</template>
                                    <template v-if="user.currency == 3">€</template>
                                </span>
                            </span>
                        </span>
                    </router-link>
                    <router-link active-class="active" to="/settings/destroy">
                        <span>
                            <i class="remove s-menu--ico"></i>
                            <span class="s-menu--text">Удалить аккаунт</span>
                        </span>
                    </router-link>
                </div>
            </div>
            <div class="cn-main--content">
                <router-view></router-view>
            </div>
        </div>
    </LayoutMain>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters([
            'user'
        ]),
        ...mapGetters({
            profile: 'selfProfile'
        }),
    }
}
</script>
