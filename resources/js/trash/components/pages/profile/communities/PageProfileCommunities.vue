<template>
    <div class="cn-main">
        <div class="cn-main--left">

        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                <template v-if="this.$route.params.type == 'groups'">
                    Группы
                </template>
                <template v-if="this.$route.params.type == 'nurseries'">
                    Питомники
                </template>
                <template v-if="this.$route.params.type == 'pages'">
                    Понравившиеся страницы
                </template>
            </h3>
            <ul class="left e-tab--nav">
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/groups'" v-if="this.$route.params.type == 'groups'">
                    <span class="size--14" v-if="flags.self">
                        Мои группы
                    </span>
                    <span class="size--14" v-else>
                        Группы
                    </span>
                    <span class="color--regent-gray size--14" v-if="counters.groups">
                        {{ counters.groups }}
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/nurseries'" v-if="this.$route.params.type == 'nurseries'">
                    <span class="size--14" v-if="flags.self">
                        Мои питомники
                    </span>
                    <span class="size--14" v-else>
                        Питомники
                    </span>
                    <span class="color--regent-gray size--14" v-if="counters.nurseries">
                        {{ counters.nurseries }}
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/pages'" v-if="this.$route.params.type == 'pages'">
                    <span class="size--14" v-if="flags.self">
                        Мои страницы
                    </span>
                    <span class="size--14" v-else>
                        Страницы
                    </span>
                    <span class="color--regent-gray size--14" v-if="counters.pages">
                        {{ counters.pages }}
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/groups/invites'" v-if="false">
                    <span class="size--14">Приглашения</span>
                    <span class="color--regent-gray size--14" v-if="counters.community_invites">
                        {{ counters.community_invites }}
                    </span>
                </router-link>
            </ul>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    data() {
        return {

        }
    },
    computed: {
        ...mapState({
            counters: state => state.profiles.counters,
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        })
    }
}
</script>
