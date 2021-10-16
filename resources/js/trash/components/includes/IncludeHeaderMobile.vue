<template>
    <div class="mobile-over">
        <div class="mobile" id="mobile-menu">
            <div class="mobile-head">
                <img class="mobile-logo" src="/img/logo.png" alt="PetPassport">
                <div class="mdrop--wrap mdrop--toggle">
                    <div class="h-lang--ico">
                        <span class="h-lang--term">Ru</span>
                    </div>
                    <div class="mdrop">
                        <div>
                            <ul class="style--uppercase">
                                <li>
                                    <router-link active-class="active" to="/lang/ru" class="active">
                                        Русский
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-body">
                <form class="sr-footer margin--bottom-15">
                    <input class="sr-footer--speech" placeholder="Поиск" type="text" required>
                    <button class="sr-footer--button"></button>
                </form>
                <div class="mobile-user" v-if="$store.getters.authenticated">
                    <div class="h-user mdrop--wrap mdrop--toggle e-avatar--65 e-avatar">
                        <router-link class="e-avatar--photo" :to="'/' + profile.slug" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <span class="size--14 color--white">{{ profile.name }}</span>
                            <i class="prefab--arrow-down"></i>
                            <div class="mdrop mdrop--align-right">
                                <div>
                                    <ul class="style--uppercase">
                                        <li>
                                            <router-link active-class="active" :to="'/' + profile.slug" exact>
                                                Профиль
                                            </router-link>
                                        </li>
                                        <li v-if="profile.type != 3">
                                            <router-link active-class="active" to="/settings/breeder">
                                                Заводчик
                                            </router-link>
                                        </li>
                                        <li v-else>
                                            <a href="#" @click.prevent="$root.loginOwner">
                                                Заводчик
                                            </a>
                                        </li>
                                        <li>
                                            <router-link active-class="active" to="/settings" exact>
                                                Настройки
                                            </router-link>
                                        </li>
                                        <li>
                                            <a href="#" @click.prevent="$root.logout">Выход</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <router-link to="/login" v-else>
                    Войти
                </router-link>
                <ul class="mobile-mmenu">
                    <li>
                        <a href="#">Раздел</a>
                        <ul>
                            <li>
                                <router-link active-class="active" to="/market">
                                    Маркет
                                </router-link>
                            </li>
                            <li>
                                <router-link active-class="active" to="/community">
                                    Сообщество
                                </router-link>
                            </li>
                            <li>
                                <router-link active-class="active" to="/database">
                                    База данных
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Категория</a>
                        <ul>
                            <li v-for="(category, i) in ['Собаки', 'Кошки', 'Птицы', 'Лошади', 'Хорьки', 'Рыбы', 'Улитки']">
                                <router-link active-class="active" :to="'/categories/' + (i + 1)">
                                    {{ category }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Страна</a>
                        <ul>
                            <li v-for="(country, i) in ['Австралия', 'Япония', 'Австрия']">
                                <router-link active-class="active" :to="'/countries/' + (i + 1)">
                                    {{ country }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Город</a>
                        <ul>
                            <li v-for="(city, i) in ['Австралия', 'Япония', 'Австрия']">
                                <router-link active-class="active" :to="'/cities/' + (i + 1)">
                                    {{ city }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
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
