<template>
    <div class="cn-main">
        <div class="cn-main--left">
            <div class="e-box--with-sep e-box e-box--padding" style="opacity: .2;">
                <h4 class="e-box--title">
                    Рекомендуемые пользователи
                </h4>
                <div>
                    <div class="e-avatar--50 e-add--users e-avatar" v-for="i in 5">
                        <a class="e-avatar--photo" href="" style="background-image: url(/img/other/it.jpg)"></a>
                        <div class="e-avatar--content">
                            <a class="e-add--floor" href="">
                                BAMBELBI GOOD BETTER
                            </a>
                            <a class="e-add--refer" href="">Добавить в друзья</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-sep e-box e-box--padding" style="opacity: .2;">
                <h4 class="e-box--title">
                    Рекомендуемые группы
                </h4>
                <div>
                    <div class="e-avatar--50 e-add--users e-avatar" v-for="i in 5">
                        <a class="e-avatar--photo" href="" style="background-image: url(/img/other/it.jpg)"></a>
                        <div class="e-avatar--content">
                            <a class="e-add--floor" href="">HUSKY HAVEN</a>
                            <a class="e-add--refer" href="">Вступить в группу</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-sep e-box e-box--padding" style="opacity: .2;">
                <h4 class="e-box--title">
                    Лучшие магазины
                </h4>
                <div>
                    <div class="e-item" v-for="i in 3">
                        <div class="e-item--term">
                            <div class="e-num">
                                <span class="e-num--utter">1</span>
                            </div>
                        </div>
                        <div class="e-item--wash">
                            <a class="e-item--the" href="">Petshop.ru</a>
                            <p class="e-item--floor">6500 товаров</p>
                        </div>
                     </div>
                </div>
            </div>
            <div class="e-box--with-sep e-box e-box--padding" style="opacity: .2;">
                <h4 class="e-box--title">
                    Популярные товары
                </h4>
                <div>
                    <div class="e-item" v-for="i in 3">
                        <div class="e-item--term">
                            <img class="e-item--guide" src="/img/other/shp.jpg" alt="">
                        </div>
                        <div class="e-item--wash">
                            <a class="e-item--the" href="">Чистые лапки</a>
                            <p class="e-item--floor">Наполнитель "Тройная защита"</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-sep e-box e-box--padding" style="opacity: .2;">
                <h4 class="e-box--title">
                    Предлагаемые страницы
                </h4>
                <div>
                    <div class="e-avatar--50 e-add--like e-avatar" v-for="i in 5">
                        <a class="e-avatar--photo" href="" style="background-image: url(/img/other/it.jpg)"></a>
                        <div class="e-avatar--content">
                            <a class="e-add--floor" href="">BAMBELBI GOOD BETTER</a>
                            <a class="e-add--refer" href="">Нравится</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-sep e-box e-box--padding" style="opacity: .2;">
                <h4 class="e-box--title">
                    Рекомендуемые питомники
                </h4>
                <div>
                    <div class="e-avatar--50 e-add--like e-avatar" v-for="i in 2">
                        <a class="e-avatar--photo" href="" style="background-image: url(/img/other/it.jpg)"></a>
                        <div class="e-avatar--content">
                            <a class="e-add--floor" href="">BAMBELBI GOOD BETTER</a>
                            <a class="e-add--refer" href="">Нравится</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Друзья
            </h3>
            <ul class="left e-tab--nav">
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/friends'" exact>
                    <span class="size--14" v-if="flags.self">
                        Мои друзья
                    </span>
                    <span class="size--14" v-else>
                        Друзья
                    </span>
                    <span class="color--regent-gray size--14" v-if="counters.friends">
                        {{ counters.friends }}
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/friends/subscribers'">
                    <span class="size--14">Подписчики</span>
                    <span class="color--regent-gray size--14" v-if="counters.subscribers">
                        {{ counters.subscribers }}
                    </span>
                </router-link>
                <router-link tag="li" class="label-show" active-class="active" :to="profile.link + '/friends/subscriptions'">
                    <span class="size--14" v-if="flags.self">
                        Читаю
                    </span>
                    <span class="size--14" v-else>
                        Читает
                    </span>
                </router-link>
                <router-link tag="li" active-class="active" :to="profile.link + '/friends/requests'" v-if="flags.self">
                    <span class="size--14">Запросы о дружбе</span>
                    <span class="prefab--label" v-if="selfCounters.friend_requests">
                        {{ selfCounters.friend_requests }}
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
