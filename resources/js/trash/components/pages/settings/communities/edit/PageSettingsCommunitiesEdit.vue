<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">
            Редактирование
            <template v-if="community.type == 1">
                группы
            </template>
            <template v-else-if="community.type == 2">
                питомника
            </template>
            <template v-else-if="community.type == 3">
                страницы
            </template>
            <template v-else-if="community.type == 4">
                страницы породы
            </template>
            <template v-else>
                сообщества
            </template>
        </h3>
        <ul class="left e-tab--nav">
            <router-link tag="li" class="label-show" active-class="active" :to="'/settings/communities/' + community.id + '/edit'" exact>
                <span class="size--14">
                    Основное
                </span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" :to="'/settings/communities/' + community.id + '/edit/communities'">
                <span class="size--14">
                    Связанные сообщества
                </span>
            </router-link>
            <router-link tag="li" class="label-show" active-class="active" :to="'/settings/communities/' + community.id + '/edit/profiles'">
                <span class="size--14">
                    Связанные профили
                </span>
            </router-link>
        </ul>
        <router-view></router-view>
    </div>
</template>

<script>
import store from '../../../../../store';

export default {
    data() {
        return {
            community: {}
        }
    },
    async beforeRouteEnter(to, from, next) {
        const community = await store.dispatch('COMMUNITY_GET', {
            slug: to.params.id
        });
        next(vm => {
            vm.community = community;
        });
    }
}
</script>
