<template>
    <LayoutMain white-header>
        <div class="cn-shop cn-shop--page">
            <div class="cn-shop--inner">
                <div class="cn-shop--white cn-shop--wrap cn-shop--wrap-widder" v-if="category">
                    <div class="sp-folder">
                        <div class="sp-folder--piece">
                            <div>
                                <h4 class="size--24 weight--700 margin--bottom-10">
                                    {{ category.name }}
                                </h4>
                                <p class="size--14 line-height--1_6 margin--bottom-10">
                                    {{ category.description }}
                                </p>
                            </div>
                            <div>
                                <router-link class="btn btn-wider btn-blue-style" :to="'/settings/announcements/create?category_id=' + category.id">
                                    Подать объявление
                                </router-link>
                            </div>
                        </div>
                        <div class="sp-folder--article" :style="{ 'background-image': 'url(\'' + category.image + '\')' }" style="background-size: contain;"></div>
                    </div>
                </div>
                <div class="cn-shop--gray cn-shop--wrap cn-shop--wrap-widder">
                    <IncludeSearch
                        class="m-0"
                        placeholder="Поиск объявлений"
                        :order="[{
                            name: 'Новые'
                        }, {
                            name: 'Дешевые',
                            value: 'price-asc'
                        }, {
                            name: 'Дорогие',
                            value: 'price-desc'
                        }]"
                    />
                </div>
                <div class="cn-shop--gray cn-shop--wrap cn-shop--split cn-shop--wrap-widder pt-0">
                    <div>
                        <div class="py-5 style--center c-gray" v-if="loading">
                            <i class="fa fa-circle-notch fa-spin" aria-hidden="true" style="font-size: 50px; margin: 0 0 20px;"></i>
                            <!--
                            <div class="size--14">
                                Ищем подходящие объявления...
                            </div>
                            -->
                        </div>
                        <div class="py-5 style--center c-gray" v-else-if="!announcements.length">
                            <i class="far fa-meh" aria-hidden="true" style="font-size: 50px; margin: 0 0 20px;"></i>
                            <div class="size--14">
                                Не найдено объявлений, подходящих под критерии
                            </div>
                        </div>
                        <template v-else>
                            <div class="sp-nav--to-right margin--bottom-15">
                                <IncludePagination :limit="limit" :total="total"/>
                            </div>
                            <div class="grid grid--gap grid--four">
                                <IncludeAnnouncement v-for="announcement in announcements" :announcement="announcement" :key="announcement.id"/>
                            </div>
                            <div>
                                <div class="sp-more e-box e-box--padding margin--top-20">
                                    <!--
                                    <a class="sp-more--wash" href="">
                                        <span class="size--13 color--mirage">Показать еще</span>
                                    </a>
                                    -->
                                    <div></div>
                                    <div class="sp-more--word">
                                        <IncludePagination :limit="limit" :total="total" />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:sidebar-content>
            <div>
                <div class="padding--top-25">
                    <div class="sp-filter" v-if="false">
                        <h4 class="size--13 style--uppercase sp-filter--head">
                            Порода
                        </h4>
                        <div class="sp-filter--box">
                            <div class="sp-filter-search e-box--shadow">
                                <div class="sr-prefab sp-filter-search--field">
                                    <button class="sr-prefab--button"></button>
                                    <input class="sr-prefab--input" type="text" placeholder="Поиск">
                                </div>
                                <div class="scrollbar-box scrollbar-inner sp-filter-search--scroll">
                                    <div class="sp-filter-search--body">
                                        <div class="form--checkbox-wrap" v-for="breed in ['Австралийская овчарка', 'Австралийский терьер', 'Акита-ину', 'Английская овчарка', 'Австралийский шелковистый терьер']">
                                            <div class="pretty p-default">
                                                <input type="checkbox">
                                                <div class="state">
                                                    <label></label>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="size--13">
                                                    {{ breed }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sp-filter">
                        <h4 class="size--13 style--uppercase sp-filter--head">
                            Страна
                        </h4>
                        <div class="sp-filter--box">
                            <IncludeInputWithFilter v-model="query.country_id" :data="countries" order-by="name" filter-by="name" placeholder="Начните вводить название" input-class="form--control-shadow e-box--shadow" />
                        </div>
                    </div>
                    <div class="sp-filter">
                        <h4 class="size--13 style--uppercase sp-filter--head">
                            Город
                        </h4>
                        <div class="sp-filter--box">
                            <IncludeInputWithFilter v-model="query.city_id" :data="cities" order-by="name" filter-by="name" placeholder="Начните вводить название" input-class="form--control-shadow e-box--shadow" v-if="query.country_id" />
                            <input class="form--control form--control-shadow e-box--shadow" placeholder="Сначала выберите страну" disabled v-else>
                        </div>
                    </div>
                    <div class="sp-filter" v-if="false">
                        <h4 class="size--13 style--uppercase sp-filter--head">
                            Откуда собака
                        </h4>
                        <div class="sp-filter--box">
                            <select class="form--control-shadow e-box--shadow wide form--control">
                                <option value="1">Выберите откуда</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="sp-filter">
                        <h4 class="size--13 style--uppercase sp-filter--head">
                            Стоимость
                        </h4>
                        <div class="sp-filter--box">
                            <div class="sp-filter-price e-box--shadow margin--bottom-10">
                                <input class="form--control-shadow form--control" type="number" name="" placeholder="От" min="0" v-model="query.price_from">
                                <input class="form--control-shadow form--control" type="number" name="" placeholder="До" min="1" v-model="query.price_to">
                            </div>
                            <select class="form--control-shadow e-box--shadow wide form--control" v-model="query.currency">
                                <option value="1">₽ - Рубли</option>
                                <option value="2">$ - Доллары</option>
                                <option value="3">€ - Евро</option>
                            </select>
                        </div>
                    </div>
                    <div class="sp-filter">
                        <h4 class="size--13 style--uppercase sp-filter--head">
                            Пол
                        </h4>
                        <div class="sp-filter--box">
                            <select class="form--control-shadow e-box--shadow wide form--control" v-model="query.gender">
                                <option value="null">Выберите пол</option>
                                <option value="1">Мужской</option>
                                <option value="2">Женский</option>
                            </select>
                        </div>
                    </div>
                    <router-link to="/market/announcements" class="btn btn-block btn-blue-style margin--bottom-20" v-if="$route.query.category_id">
                        Все категории
                    </router-link>
                    <button class="e-box--shadow btn btn-block btn-blue-style btn-gray" @click="reset">
                        Сбросить
                    </button>
                </div>
            </div>
        </template>
    </LayoutMain>
</template>

<script>
import axios from 'axios';
import querystring from 'querystring';
import { mapGetters } from 'vuex';
import { mapCacheActions } from 'vuex-cache';

export default {
    data() {
        return {
            //countries: [],
            //cities: [],
            announcements: [],
            total: 0,
            limit: 20,
            loading: false,
            queryDefaults: {
                currency: 1,
                category_id: null,
                country_id: null,
                city_id: null,
                price_from: null,
                price_to: null,
                gender: null,
                order: null
            },
            query: {}
        }
    },
    computed: {
        category() {
            return this.categories.find(c => c.id == this.$route.query.category_id);
        },
        offset() {
            return ((this.$route.query.page || 1) - 1) * this.limit;
        }
    },
    asyncComputed: {
        countries: {
            async get() {
                return await this.getCountries();
            },
            default: []
        },
        cities: {
            async get() {
                return await this.getCities(this.query.country_id);
            },
            default: []
        },
        categories: {
            async get() {
                return await this.MARKET_CATEGORIES_GET();
            },
            default: []
        }
    },
    async created() {
        //this.countries = await this.getCountries();
        this.query = this.unsanitized(this.$route.query);
        this.load();
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    methods: {
        ...mapCacheActions([
            'getCountries',
            'getCities',
            'MARKET_CATEGORIES_GET'
        ]),
        ordered(unordered) {
            const ordered = {};
            Object.keys(unordered).sort().forEach(key => {
                ordered[key] = unordered[key];
            });
            return ordered;
        },
        unsanitized(query) {
            const q = { ...query };
            for (const prop in this.queryDefaults) {
                if (!q[prop]) {
                    q[prop] = this.queryDefaults[prop];
                }
            }
            //console.log(this.queryDefaults)
            //console.log('unsanitized:',q)
            return q;
        },
        sanitized(query) {
            const q = { ...query };
            for (const prop in query) {
                if (!q[prop]) {
                    delete q[prop];
                }
            }
            return q;
        },
        async load() {
            this.loading = true;

            const request = {
                reason: 'search',
                limit: this.limit,
                offset: this.offset,
                ...this.query
            };
            const response = await axios.get('/api/announcements?' + querystring.stringify(request));
            this.announcements = response.data.announcements;
            this.total = response.data.total;
            this.loading = false;
        },
        reset() {
            this.query = this.unsanitized({});
        }
    },
    watch: {
        query: {
            handler() {
                const query = this.ordered(this.sanitized(this.query));
                const route = this.ordered(this.$route.query);
                if (JSON.stringify(route) != JSON.stringify(query)) {
                    //console.log('FROM:', this.$route.query);
                    //console.log('TO:', query);
                    this.$router.replace({
                        query
                    });
                }
            },
            deep: true
        },
        'query.country_id': async function(newId, oldId) {
            if (typeof oldId !== 'undefined') {
                this.query.city_id = null;
            }
            /*
            this.cities = [];
            if (this.query.country_id) {
                this.cities = await this.getCities(this.query.country_id);
            }
            */
        },
        '$route.query': function(to, from) {
            if (to.fast_search === from.fast_search) {
                this.query = this.unsanitized(this.$route.query);
                this.load();
            }
        }
    }
}
</script>
