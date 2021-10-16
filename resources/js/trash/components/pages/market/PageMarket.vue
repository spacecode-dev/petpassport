<template>
    <LayoutMain white-header hidden-sidebar>
        <div class="sp-head">
            <div class="sp-head--item">
                <div class="sp-head--report">
                    <a class="sp-head--exile" href="">
                        Магазины
                    </a>
                    <router-link class="sp-head--exile" active-class="active" to="/market">
                        Ярмарка
                    </router-link>
                    <a class="sp-head--exile" href="">
                        Форум
                    </a>
                    <router-link class="sp-head--exile" to="/">
                        Сообщество
                    </router-link>
                    <a class="sp-head--exile" href="">
                        KissMyPet
                    </a>
                </div>
            </div>
        </div>
        <div class="cn-shop">
            <div class="cn-shop--inner">
                <div class="cn-shop--white cn-shop--wrap">
                    <div class="sp-do">
                        <router-link class="sp-do--unite" to="/settings/shops/create">
                            <span class="sp-do--utter" style="background-image: url(/img/do/1.jpg)"></span>
                            <span class="sp-do--have">Открыть магазин</span>
                        </router-link>
                        <router-link class="sp-do--unite" to="/settings/announcements/create">
                            <span class="sp-do--utter" style="background-image: url(/img/do/2.jpg)"></span>
                            <span class="sp-do--have">Подать объявление</span>
                        </router-link>
                        <a class="sp-do--unite" href="">
                            <span class="sp-do--utter" style="background-image: url(/img/do/3.jpg)"></span>
                            <span class="sp-do--have">Популярное</span>
                        </a>
                        <a class="sp-do--unite" href="">
                            <span class="sp-do--utter" style="background-image: url(/img/do/4.jpg)"></span>
                            <span class="sp-do--have">Продвигать</span>
                        </a>
                        <router-link class="sp-do--unite" to="/">
                            <span class="sp-do--utter" style="background-image: url(/img/do/5.jpg)"></span>
                            <span class="sp-do--have">Профиль</span>
                        </router-link>
                    </div>
                    <div class="grid grid--gap grid--four">
                        <IncludeMarketCategory v-for="category in categories8" :category="category" :key="category.id" />
                    </div>
                    <div class="style--center padding--top-40 padding--bottom-30">
                        <router-link class="btn btn-blue-style btn-wider" to="/market/categories">
                            Все категории
                        </router-link>
                    </div>
                </div>
                <div class="cn-shop--gray cn-shop--wrap">
                    <h4 class="size--18 weight--700 margin--bottom-20 margin--top-30">
                        Популярные объявления
                    </h4>
                    <div class="grid grid--gap grid--five">
                        <IncludeAnnouncement v-for="pann in popular" :announcement="pann" :key="pann.id"/>
                    </div>
                    <div class="sp-more e-box e-box--padding margin--top-20">
                        <!--
                        <a class="sp-more--wash" href="">
                            <span class="size--13 color--mirage">Показать еще</span>
                        </a>
                        -->
                        <div></div>
                        <div class="sp-more--word">
                            <IncludePagination :limit="popular_limit" :total="popular_total" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutMain>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
import { mapCacheActions } from 'vuex-cache';

export default {
    data() {
        return {
            popular: [],
            popular_total: 0,
            popular_limit: 10
        }
    },
    computed: {
        popular_offset() {
            return ((this.$route.query.page || 1) - 1) * this.popular_limit;
        },
        categories8() {
            return this.categories.slice(0, 8);
        }
    },
    asyncComputed: {
        categories: {
            async get() {
                return await this.MARKET_CATEGORIES_GET();
            },
            default: []
        }
    },
    async created() {
        //NProgress.start();
        this.loadPopular();
        //NProgress.done();
    },
    methods: {
        ...mapCacheActions([
            'MARKET_CATEGORIES_GET'
        ]),
        async loadPopular() {
            const data = (await axios.get('/api/announcements?reason=popular&limit=' + this.popular_limit)).data;
            this.popular = data.announcements;
            this.popular_total = data.total;
        }
    }
}
</script>
