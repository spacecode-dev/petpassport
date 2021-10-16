<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Объявления
            </h3>
            <ul class="left e-tab--nav">
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/announcements'" exact>
                    <span class="size--14" v-if="flags.self">
                        Мои объявления
                    </span>
                    <span class="size--14" v-else>
                        Объявления
                    </span>
                    <!--
                    <span class="color--regent-gray size--14" v-if="counters.friends">
                        {{ counters.friends }}
                    </span>
                    -->
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/announcements/favorites'">
                    <span class="size--14">
                        Избранные
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
            selfCounters: state => state.counters.counters,
            counters: state => state.profiles.counters,
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        })
    }
}
</script>
