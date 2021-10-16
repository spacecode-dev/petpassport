<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">Настройки профиля</h3>
        <ul class="left e-tab--nav">
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/main">
                <span class="size--14">Основное</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/work" v-if="profile.type != 3">
                <span class="size--14">Работа</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/contacts">
                <span class="size--14">Контакты</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/education" v-if="profile.type != 3">
                <span class="size--14">Образование</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/market" v-if="profile.type != 3">
                <span class="size--14">Маркет</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/passport" v-if="profile.type == 3">
                <span class="size--14">Паспорт</span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" to="/settings/profile/pedigree" v-if="profile.type == 3">
                <span class="size--14">Родословная</span>
            </router-link> 
        </ul>
        <router-view></router-view>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
    }
}
</script>
