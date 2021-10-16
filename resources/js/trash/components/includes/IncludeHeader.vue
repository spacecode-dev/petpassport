<template>
    <div class="h-top">
        <div class="h-top--term">
            <router-link class="h-top--logo" to="/">
                <img class="logo" src="/img/logo.png" alt="PetPassport">
            </router-link>
        </div>
        <div class="h-top--idem">
            <div class="h-top--have" :style="{ visibility: withoutSidebar ? 'hidden' : 'visible' }">
                <div class="e-toggle--toogle" @click="toggleSidebarMobile"></div>
            </div>
            <div class="h-top--be" :style="{ visibility: withoutSidebar ? 'hidden' : 'visible' }">
                <div class="e-toggle--toogle" @click="toggleSidebar"></div>
            </div>
            <div class="h-top--say">
                <IncludeHeaderFilters v-bind:filtered="filteredCountries"
                                      v-bind:countries-clone="countries"
                                      v-bind:countries="countries"
                                      v-bind:categories="categories"/>
            </div>
            <div class="h-top--talk">
                <div class="h-search">
                    <div class="h-search--toggle" @click="toggleSearch">
<!--                        <router-link style="display: block;width: 100%;height: 100%;" :to="queryAppend({ fast_filter: true })" exact></router-link>-->
                    </div>
                    <div class="h-search--too d-none">
                        <div class="h-search--point" style="padding-bottom: 0">
                            <div class="col-6 col-md-3 col-sm-12">
                                <IncludeDropdown class="custom-filter">
                                    <template v-slot:toggle>
                                        <div class="h-menu--gossip size--14">
                                            <span class="select-text weight--400">
                                                {{ sectionName }}
                                            </span>
                                        </div>
                                    </template>
                                    <ul class="dropdown-menu-custom style--uppercase">
                                        <li v-on:click="selectSection('Раздел', null)" >
                                            <router-link :to="'/' + profile.slug + '?fast_search=true'">
                                                Любой
                                            </router-link>
                                        </li>
                                        <li v-on:click="selectSection('Маркет', 1)" >
                                            <router-link to="/market/announcements?fast_search=true">
                                                Маркет
                                            </router-link>
                                        </li>
                                        <li v-on:click="selectSection('Сообщество', 2)" >
                                            <router-link :to="'/' + profile.slug + '?fast_search=true'">
                                                Сообщество
                                            </router-link>
                                        </li>
                                        <li disabled="true">
                                            Форум
                                        </li>
                                    </ul>
                                </IncludeDropdown>
                            </div>

                            <div class="col-6 col-md-3 col-sm-12">
                                <IncludeDropdown class="custom-filter">
                                    <template v-slot:toggle>
                                        <div class="h-menu--gossip size--14">
                                            <span class="weight--400">
                                                {{ categoryName }}
                                            </span>
                                        </div>
                                    </template>
                                    <ul class="dropdown-menu-custom style--uppercase">
                                        <li v-on:click="selectCategory('Категория', null)">
                                            <router-link active-class="active" :to="queryRemove(['category_id'])" exact>
                                                Любая
                                            </router-link>
                                        </li>
                                        <li v-for="category in categories" v-on:click="selectCategory(category.name, category.id)" :key="category.id">
                                            <router-link :to="queryAppend({ category_id: category.id })" exact>
                                                {{ category.name }}
                                            </router-link>
                                        </li>
                                    </ul>
                                </IncludeDropdown>
                            </div>

                            <div class="col-6 col-md-3 col-sm-12 merge-filter">
                                <IncludeDropdown class="custom-filter">
                                    <template v-slot:toggle>
                                        <div class="h-menu--gossip size--14">
                                            <span class="weight--400">
                                                {{ countryName }}
                                            </span>
                                        </div>
                                    </template>
                                    <div class="sr-prefab">
                                        <button class="sr-prefab--button"></button>
                                        <input class="sr-prefab--input size--13" type="text" placeholder="Поиск" v-model="filterCountries">
                                    </div>
                                    <ul class="dropdown-menu-custom style--uppercase" style="min-width: 200px;">
                                        <li v-on:click="selectCountry('Страна', null)">
                                            <router-link :to="queryRemove(['country_id'])" exact>
                                                Любая
                                            </router-link>
                                        </li>
                                        <li v-for="country in filteredCountries"  v-on:click="selectCountry(country.name, country.id)" :key="country.id">
                                            <router-link :to="queryAppend({ country_id: country.id })" exact>
                                                {{ country.name }}
                                            </router-link>
                                        </li>
                                    </ul>
                                </IncludeDropdown>
                            </div>

                            <div class="col-6 col-md-3 col-sm-12 merge-filter">
                                <IncludeDropdown class="custom-filter">
                                    <template v-slot:toggle>
                                        <div class="h-menu--gossip size--14">
                                            <span class="weight--400">
                                                {{ cityName }}
                                            </span>
                                        </div>
                                    </template>
                                    <div class="sr-prefab" v-if="showCity" >
                                        <button class="sr-prefab--button"></button>
                                        <input class="sr-prefab--input size--13" type="text" placeholder="Поиск" v-model="filterCities">
                                    </div>
                                    <ul v-if="showCity" class="dropdown-menu-custom style--uppercase" style="min-width: 200px;">
                                        <li v-on:click="selectСity('город', null)">
                                            <router-link active-class="active" :to="queryRemove(['city_id'])" exact>
                                                Любой
                                            </router-link>
                                        </li>
                                        <li v-on:click="selectСity(city.name, city.id)" v-for="city in filteredCities" :key="city.id">
                                            <router-link active-class="active" :to="queryAppend({ city_id: city.id })" exact>
                                                {{ city.name }}
                                            </router-link>
                                        </li>
                                    </ul>
                                </IncludeDropdown>
                            </div>
                        </div>
                        <div class="h-search--item">
                            <form class="h-search--talk" style="margin-bottom: 20px" v-on:submit.prevent="search">
                                <input v-on:input="search($event,'input')" v-model="searchData.searchText" required style="background: #eeeeee;color: #383737;height: 55px;" class="h-search--input form--control main-search" type="text" placeholder="Поиск">
                                <button v-on:click="search($event,'click')" type="button" class="h-search--note"></button>
                            </form>
                            <div class="c-black text-center" v-if="searchProcess">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                Загрузка...
                            </div>
                            <div class="result-block">
                                <IncludeGlobalSearchResult v-bind:initData="result" v-bind:key="result.url"  v-for="result in searchResults"></IncludeGlobalSearchResult>
                                <div style="text-align:center" v-if="emptySearchResults">
                                    Нет результатов
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <IncludeDropdown>
                    <template v-slot:toggle>
                        <div class="h-lang--ico">
                            <span class="h-lang--term">Ru</span>
                        </div>
                    </template>
                    <ul class="dropdown-menu-custom style--uppercase">
                        <li>
                            <router-link active-class="active" to="/lang/ru" class="active">
                                Русский
                            </router-link>
                        </li>
                    </ul>
                </IncludeDropdown>
                <IncludeDropdown>
                    <template v-slot:toggle>
                        <div class="h-menu--ico"></div>
                    </template>
                    <ul class="dropdown-menu-custom style--uppercase">
                        <li style="display: flex; justify-content: space-between; align-items: center;">
                            <router-link active-class="active" to="/settings/wallet">
                                <!--<i class="walet s-menu--ico"></i>-->
                                Кошелек
                            </router-link>
                            <span class="color--mirage weight--700" style="margin-left: 1.5em;">
                                {{ (user.balance / 100) | price }}
                                <template v-if="user.currency == 1">₽</template>
                                <template v-if="user.currency == 2">$</template>
                                <template v-if="user.currency == 3">€</template>
                            </span>
                        </li>
                        <li class="separator"></li>
                        <li style="display: flex; justify-content: space-between; align-items: center;">
                            <a href="#" @click.prevent="showCart">
                                Корзина
                            </a>
                            <span style="display: inline-block; width: 1.5em; height: 1.5em; line-height: 1.5em; text-align: center; color: #FFF; background: var(--c-red); border-radius: 50%; margin-left: .5em;">
                                {{ counters.cart }}
                            </span>
                        </li>
                    </ul>
                </IncludeDropdown>
                <div class="h-user mdrop--wrap mdrop--toggle e-avatar" v-if="$store.getters.authenticated">
                    <router-link class="e-avatar--photo" :to="'/' + profile.slug" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></router-link>
                    <div class="e-avatar--content">
                        <IncludeDropdown class="dropdown-right">
                            <template v-slot:toggle>
                                <span class="h-menu--gossip size--14">
                                    <span class="h-username">
                                        {{ profile.name }}
                                    </span>
                                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                </span>
                            </template>
                            <ul class="dropdown-menu-custom style--uppercase">
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
                                <li class="separator"></li>
                                <li>
                                    <router-link active-class="active" to="/settings/communities/create?type=1" exact>
                                        Создать группу
                                    </router-link>
                                </li>
                                <li>
                                    <router-link active-class="active" to="/settings/communities/create?type=2" exact>
                                        Создать питомник
                                    </router-link>
                                </li>
                                <li>
                                    <router-link active-class="active" to="/settings/communities/create?type=3" exact>
                                        Создать страницу
                                    </router-link>
                                </li>
                                 <li>
                                    <router-link active-class="active" to="/settings/shops/create" exact>
                                        Создать магазин
                                    </router-link>
                                </li>
                                <li>
                                    <router-link active-class="active" to="/settings/announcements/create" exact>
                                        Создать объявление
                                    </router-link>
                                </li>
                                <li class="separator"></li>
                                <li>
                                    <a href="#" @click.prevent="showlogout">Выход</a>
                                </li>
                            </ul>
                        </IncludeDropdown>
                    </div>
                </div>
                <router-link class="size--14 color--white" to="/login" v-else>
                    Войти
                </router-link>
            </div>
            <div class="h-top--rap">
                <div class="e-toggle--toogle" id="mobile-menu-toggle"></div>
            </div>
        </div>
    </div>
</template>

<script>
import ModalCart from './modals/ModalCart';
import { mapCacheActions } from 'vuex-cache';
import { mapGetters, mapState } from 'vuex';
import axios from 'axios';
import toastr from "toastr";


export default {
    data() {
        return {
            showCity: false,
            emptySearchResults: false,
            searchProcess: false,
            sectionName: 'Раздел',
            categoryName: 'Категория',
            countryName: 'Страна',
            cityName: 'Город',
            cities: [],
            // urlUser: user.login + '/?fast_search=true',
            filterCountries: null,
            filterCities: null,
            filterSection: null,
            searchResults: [],
            searchData: {
                searchText: localStorage.fastSearch || '',
                filter: {}
            },
        }
    },
    props: {
        withoutSidebar: Boolean,
    },
    asyncComputed: {
        categories: {
            async get() {
                let result = await this.MARKET_CATEGORIES_GET();
                let category = result.find(category => category.id === parseInt(this.$route.query.category_id));

                if (category) {
                    this.categoryName = category.name;
                    this.searchData.filter.category_id = category.id;

                }
                return result;
            },
            default: []
        },
        countries: {
            async get() {
                let result = await this.getCountries();
                let country = result.find(country => country.id === parseInt(this.$route.query.country_id));

                if (this.$route.query.country_id) {
                    this.cities = await this.getCities(this.$route.query.country_id);
                }

                if (country) {
                    this.countryName = country.name;
                    this.searchData.filter.country_id = country.id;
                }

                if (this.$route.query.city_id) {
                    let city = this.cities.find(city => city.id === parseInt(this.$route.query.city_id));

                    if (city) {
                        this.cityName = city.name;
                        this.searchData.filter.city_id = city.id;
                    }
                }


                return result;
            },
            default: []
        }
    },
    computed: {
        sortedCountries() {
            return this.sortByName(this.countries);
        },
        ...mapState({
            counters: state => state.counters.counters
        }),
        ...mapGetters([
            'user'
        ]),
        ...mapGetters({
            profile: 'selfProfile'
        }),
        selectedSection() {
            switch (this.$route.path) {
                case '/market/announcements':
                    return 'market';
            }
        },
        selectedCountry() {
            console.log(this.countries.find(c => c.id == this.$route.query.country_id));

            return this.countries.find(c => c.id == this.$route.query.country_id);
        },
        selectedCategory() {
            console.log(this.categories.find(category => category.id === parseInt(this.$route.query.category_id)));
            this.categories.find(category => category.id === parseInt(this.$route.query.category_id));
        },
        sortedCities() {
            return this.sortByName(this.cities);
        },
        filteredCities() {
            if (!this.filterCities) {
                return this.sortedCities;
            }

            return this.sortedCities.filter(c => {
                return c.name.toLowerCase().includes(this.filterCities.toLowerCase());
            });
        },
        filteredCountries() {
            if (!this.filterCountries) {
                return this.sortedCountries;
            }

            return this.sortedCountries.filter(c => {
                return c.name.toLowerCase().includes(this.filterCountries.toLowerCase());
            });
        }
    },
    created() {
    },
    updated() {
        if (this.$route.query.fast_search) {
            $('.h-search--too').removeClass('d-none');
        }

        if (this.$route.query.country_id) {
            this.showCity = true;
        }

        switch (this.$route.path) {
            case '/market/announcements':
                this.searchData.filter.section_id = 1;
                this.sectionName = 'Маркет';
                break;
            default:
                break;
        }
    },
    watch: {
        'this.$route.query.fast_search': function() {
            if (this.$route.query.fast_search) {
                this.fastSearch('input');
            }
        },
        '$route.query.category_id': function () {
            let category = this.categories.find(category => category.id === parseInt(this.$route.query.category_id));

            if (category) {
                this.categoryName = category.name;
                this.searchData.filter.category_id = category.id;
            } else {
                this.categoryName = 'Категория';
                this.searchData.filter.category_id = null;

            }
        },
        '$route.query.country_id': async function(newId, oldId) {
            let country =  this.countries.find(country => country.id === parseInt(this.$route.query.country_id));
            this.cities = [];

            if (this.$route.query.country_id) {
                this.cities = await this.getCities(this.$route.query.country_id);
            }

            if (country) {
                this.countryName = country.name;
                this.searchData.filter.country_id = country.id;
                this.showCity = true;
            } else {
                this.countryName = 'Страна';
                this.searchData.filter.country_id = null;
                this.showCity = false;
            }
        },
        '$route.query.city_id': async function(newId, oldId) {
            let city = this.cities.find(city => city.id === parseInt(this.$route.query.city_id));

            if (city) {
                this.cityName = city.name;
                this.searchData.filter.city_id = city.id;
            } else {
                this.cityName = 'Город';
                this.searchData.filter.city_id = null;
            }
        },
    },
    methods: {
        async selectSection(name, id) {
            this.searchData.filter.section_id = id;
            this.sectionName = name;
            // await this.fastSearch('input');
        },
        async selectCategory(name,id) {
            this.searchData.filter.category_id = id;
            this.categoryName = name;
            await this.fastSearch('input');
        },
        async selectCountry(name,id) {
            if (id) {
                this.showCity = true;
            } else {
                this.showCity = false;
            }

            this.searchData.filter.country_id = id;
            this.cities = [];
            this.cityName = 'Город';
            this.searchData.filter.city_id = null;
            this.countryName = name;
            this.cities = await this.getCities(id);
            await this.fastSearch('input');
        },
        async selectСity(name, id) {
            this.searchData.filter.city_id = id;
            this.cityName = name;

            await this.fastSearch('input');
        },
        toggleSearch() {
            let fast_search = 'true';

            if ( $('.h-search--too').hasClass('d-none')) {
                this.$router.push({ query: Object.assign({}, this.$route.query, {fast_search}) });
            } else {
                let query = Object.assign({}, this.$route.query);
                delete query.fast_search;
                this.$router.replace({ query });
            }

            this.searchResults = [];
            this.emptySearchResults = false;
            $('.h-search--too').toggleClass('d-none');
        },
        toggleSidebar() {
            $('.body').toggleClass('sidebar-colapse');
        },
        toggleSidebarMobile() {
            if(window.innerWidth > 860) {
                $('.body').removeClass('sidebar-mobile-view').toggleClass('sidebar-colapse');
            } else {
                $('.body').toggleClass('sidebar-mobile-view');
            }
        },
        sortByName(arr) {
            return arr.sort((a, b) => {
                if (a.name < b.name) {
                    return -1;
                }
                if (a.name > b.name) {
                    return 1;
                }
                return 0;
            });
        },
        //TODO rewrite everything
        async search($event,type) {
            this.fastSearch(type);
        },
        async fastSearch(type) {
            if (type === 'input') {
                setTimeout(function() {
                }, 300)
            }

            if (this.searchProcess) {
                return false;
            }

            if (type === 'click' && (!this.searchData.searchText || !this.searchData.searchText.length)) {
                toastr.error('Поле поиска не может быть пустым');
                return false;
            }

            if (type === 'input' && (!this.searchData.searchText || this.searchData.searchText.trim().length < 3 )) {
                this.searchResults = [];
                return false;
            }

            this.searchResults = [];
            this.searchProcess = true;
            this.emptySearchResults = false;

            let data = this.searchData;

            let response = await axios.post('/api/fast-search', data).then(response => {
                return response.data;
            }).catch(err => {});

            let result = [];
            Object.entries(response).forEach(function(value, index) {
                value[1].forEach( function(val,i) {
                    let row = {};

                    switch (value[0]) {
                        case 'posts':
                            row.text = (val.owner['name'] || '') + ' ' + (val.body || '');
                            row.url = null;
                            break;
                        case 'user_profiles':
                            row.text = (val.name || '') + ' ' + (val.about || '');
                            row.url = val.link;
                            break;
                        case 'communities':
                            row.text = val.name || '';
                            row.url = val.link;
                            break;
                        case 'announcements':
                            row.text = (val.title || '') + ' ' + (val.description || '');
                            row.url = '/market/announcements/' + val.id;
                            break;
                        default:
                            break;
                    }

                    result.push(row);
                });
            });

            if (result.length) {
                this.searchResults = result;
            } else {
                this.emptySearchResults = true;
            }

            await this.$nextTick(function () {
                this.searchProcess = false;

            });
        },
        showCart() {
            this.$modal.show(ModalCart, null, {
                classes: '',
                width: 800,
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        },
        ...mapCacheActions([
            'getCountries',
            'getCities',
            'MARKET_CATEGORIES_GET'
        ]),
    },
    destroyed() {
        $('#modal-cart').remove();
    }
}
</script>

<style lang="scss" scoped>
    .result-block {
        max-height: 300px;
        overflow-y: auto;
    }

    .custom-filter {
        width: 100%;
        height: 45px;
        border-radius: 15px;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: rgba(255, 255, 255, 0.63);

        .dropdown-menu-custom {
            li:hover {
                cursor: pointer;
                color: var(--c-violet);
            }

            max-height: 200px;
            overflow-y: auto;

        }

        .h-menu--gossip {
            font-style: normal;
            font-weight: normal;
            font-size: 18px;
            line-height: 21px;
            text-align: center;
            display: block;
            color: #383737;
            text-transform:uppercase;
        }

        .sr-prefab {
            border-bottom: 1px solid #f2f2f2;
        }
    }

    .main-search::-webkit-input-placeholder { /* Edge */
        color: gray;
    }

    .main-search:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: gray;
    }

    .main-search::placeholder {
        color: gray;
    }

.h-username {
    max-width: 150px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    display: inline-block;
    vertical-align: middle;
}
</style>

<style>

.h-search--point {
    box-shadow: none;
}

@media (max-width: 768px) {
    .h-search--point {
        margin-bottom: -10px;
    }
    .merge-filter {
      margin-top: 10px;
    }
}

.h-search--too{
    background: rgba(196, 196, 196, 0.92);
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 22px;
}
.custom-drop {
    color: var(--c-black);
    /*background: rgba(196, 196, 196, 0.92);*/
    /*box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);*/
    /*border-radius: 22px;*/
}
.custom-drop .btn {
    height: 45px;
    font-style: normal;
    font-weight: normal;
    font-size: 18px;
    line-height: 21px;
    color: #383737;
    text-transform: uppercase;
    background: rgba(255, 255, 255, 0.63);
    border-radius: 15px;
    width: 100%;
    height: 45px;
}
.custom-drop .dropdown-menu {
    max-height: 170px;
    overflow: auto;
}
.h-menu--gossip {
    margin: .7em 0;
    color: var(--c-white);
    display: flex;
    align-items: flex-end;
}
.h-top--white .h-menu--gossip {
    color: var(--c-mirage) !important;
}
.h-top--white .h-top--talk > .color--white {
    color: var(--c-mirage);
}
.h-search--too {
    right:40px;
    width: 50%;
}

</style>
