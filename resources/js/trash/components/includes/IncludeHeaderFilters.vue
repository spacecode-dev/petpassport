<template>
    <ul class="h-menu">
        <li>
            <IncludeDropdown>
                <template v-slot:toggle>
                    <div class="h-menu--gossip size--14">
                        <span class="weight--700" v-if="selectedSection == 'market'">
                            Маркет
                        </span>
                        <span v-else>
                            Раздел
                        </span>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </template>
                <ul class="dropdown-menu-custom style--uppercase">
                    <li>
                        <router-link active-class="active" to="/market/announcements">
                            Маркет
                        </router-link>
                    </li>
                    <li>
                        <router-link active-class="active" to="/" exact>
                            Сообщество
                        </router-link>
                    </li>
                    <li>
                        <router-link active-class="active" to="/" exact>
                            База данных
                        </router-link>
                    </li>
                </ul>
            </IncludeDropdown>
        </li>
        <li :class="{ inactive: !selectedSection }">
            <IncludeDropdown>
                <template v-slot:toggle>
                    <div class="h-menu--gossip size--14">
                        <span class="weight--700" v-if="selectedCategory">
                            {{ selectedCategory.name }}
                        </span>
                        <span v-else>
                            Категория
                        </span>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </template>
                <ul class="dropdown-menu-custom style--uppercase">
                    <li>
                        <router-link active-class="active" :to="queryRemove(['category_id'])" exact>
                            Любая
                        </router-link>
                    </li>
                    <li v-for="category in categories" :key="category.id">
                        <router-link active-class="active" :to="queryAppend({ category_id: category.id })" exact>
                            {{ category.name }}
                        </router-link>
                    </li>
                </ul>
            </IncludeDropdown>
        </li>
        <li :class="{ inactive: !selectedSection }">
            <IncludeDropdown>
                <template v-slot:toggle>
                    <div class="h-menu--gossip size--14">
                        <span class="weight--700" v-if="selectedCountry">
                            {{ selectedCountry.name }}
                        </span>
                        <span v-else>
                            Страна
                        </span>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </template>
                <div class="sr-prefab">
                    <button class="sr-prefab--button"></button>
                    <input class="sr-prefab--input size--13" type="text" placeholder="Поиск" v-model="filterCountries">
                </div>
                <ul class="dropdown-menu-custom style--uppercase" style="min-width: 250px;">
                    <li v-if="!filterCountries">
                        <router-link active-class="active" :to="queryRemove(['country_id'])" exact>
                            Любая
                        </router-link>
                    </li>
                    <li v-for="country in filteredCountries" :key="country.id">
                        <router-link active-class="active" :to="queryAppend({ country_id: country.id })" exact>
                            {{ country.name }}
                        </router-link>
                    </li>
                </ul>
            </IncludeDropdown>
        </li>
        <li :class="{ inactive: !selectedCountry }">
            <IncludeDropdown>
                <template v-slot:toggle>
                    <div class="h-menu--gossip size--14">
                        <span class="weight--700" v-if="selectedCity">
                            {{ selectedCity.name }}
                        </span>
                        <span v-else>
                            Город
                        </span>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </template>
                <div class="sr-prefab">
                    <button class="sr-prefab--button"></button>
                    <input class="sr-prefab--input size--13" type="text" placeholder="Поиск" v-model="filterCities">
                </div>
                <ul class="dropdown-menu-custom style--uppercase" style="min-width: 250px;">
                    <li v-if="!filterCities">
                        <router-link active-class="active" :to="queryRemove(['city_id'])" exact>
                            Любой
                        </router-link>
                    </li>
                    <li v-for="city in filteredCity" :key="city.id">
                        <router-link active-class="active" :to="queryAppend({ city_id: city.id })" exact>
                            {{ city.name }}
                        </router-link>
                    </li>
                </ul>
            </IncludeDropdown>
        </li>
    </ul>
</template>

<script>
import axios from 'axios';
import { mapCacheActions } from 'vuex-cache';

export default {
    props: ['countries', 'countriesClone'],
    data() {
        return {
            thisCountries:  JSON.parse(JSON.stringify(this.countriesClone)),
            filteredCountries:  JSON.parse(JSON.stringify(this.countries)),
            cities: [],
            filteredCity: [],
            filterCountries: null,
            filterCities: null
        }
    },
    computed: {
        sortedCities() {
            return this.sortByName(this.cities);
        },
        filteredCities() {
            // if (!this.filterCities) {
            //     return this.sortedCities;
            // }
            // return this.sortedCities.filter(c => {
            //     return c.name.toLowerCase().includes(this.filterCities.toLowerCase());
            // });
        },
        selectedSection() {
            switch (this.$route.path) {
                case '/market/announcements':
                    return 'market';
            }
        },
        selectedCategory() {
            return this.categories.find(c => c.id == this.$route.query.category_id);
        },
        selectedCountry() {
                return this.thisCountries.find(c => c.id == this.$route.query.country_id);
        },
        selectedCity() {
            return this.cities.find(c => c.id == this.$route.query.city_id);
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
        if (this.$route.query.country_id) {
            this.filteredCity = await this.getCities(this.$route.query.country_id);
            this.cities = JSON.parse(JSON.stringify(this.filteredCity));
        }
    },
    methods: {
        ...mapCacheActions([
            'getCountries',
            'getCities',
            'MARKET_CATEGORIES_GET'
        ]),
        /*
        ordered(unordered) {
            const ordered = {};
            Object.keys(unordered).sort().forEach(key => {
                ordered[key] = unordered[key];
            });
            return ordered;
        },
        */
        sortByName(arr) {
            if (arr && arr.length) {
                return arr.sort((a, b) => {
                    if (a.name < b.name) {
                        return -1;
                    }
                    if (a.name > b.name) {
                        return 1;
                    }
                    return 0;
                });
            }
        }
    },
    watch: {
        '$route.query.country_id': async function(newId, oldId) {
            if (this.$route.query.city_id) {
                this.$router.replace(this.queryRemove(['city_id']));
            }
            this.cities = [];
            if (this.$route.query.country_id) {
                this.filteredCity = await this.getCities(this.$route.query.country_id);
                this.cities = JSON.parse(JSON.stringify(this.filteredCity));
            }
        },
        filterCountries(value) {
            this.filteredCountries = JSON.parse(JSON.stringify(this.countries));
            let sort = this.sortByName( JSON.parse(JSON.stringify(this.countries))).filter(c => {
                return c.name.toLowerCase().includes(value.toLowerCase());
            });

            while(this.filteredCountries.length > 0) {this.filteredCountries.pop();}
            sort.forEach(country =>
                this.filteredCountries.push(country)
            );
        },
        filterCities(value) {
            this.filteredCity = JSON.parse(JSON.stringify(this.cities));
            let sort = this.sortByName( JSON.parse(JSON.stringify(this.cities))).filter(c => {
                return c.name.toLowerCase().includes(value.toLowerCase());
            });

            while(this.filteredCity.length > 0) {this.filteredCity.pop();}


            sort.forEach(city =>
                this.filteredCity.push(city)
            );

        },
        countries: function () {
            this.thisCountries= JSON.parse(JSON.stringify(this.countriesClone));

            if (!this.filteredCountries.length) {
                this.filteredCountries = JSON.parse(JSON.stringify(this.countries));
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.h-menu {
    display: flex;
    align-items: center;
    justify-content: center;

    & > li {
        margin: 0 1.1em;

        &.inactive {
            opacity: .5;
            pointer-events: none;
        }

        .sr-prefab {
            border-bottom: 1px solid #f2f2f2;
            margin: 5px 5px 0;
            padding-bottom: 5px;
        }

        .dropdown-menu-custom {
            max-height: 170px;
            overflow: auto;
        }
    }
}
</style>
