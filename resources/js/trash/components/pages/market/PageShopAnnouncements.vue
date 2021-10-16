<template>
    <div class="cn-shop--gray cn-shop--wrap cn-shop--split">
        <div>
            <div class="simple s-menu e-box">
                <router-link active-class="active" :to="queryRemove(['category_id'])" exact>
                    <span>
                        <span class="s-menu--text">
                            Все товары
                        </span>
                    </span>
                </router-link>
            </div>
            <div class="simple s-menu e-box">
                <router-link
                    active-class="_active"
                    :to="queryAppend({ category_id: c.id })"
                    exact
                    v-for="c in categories"
                    :key="c.id"
                    :class="{
                        active: category && (category.id == c.id || category.parent_id == c.id)
                    }"
                >
                    <span>
                        <span class="s-menu--text">
                            {{ c.name }}
                        </span>
                    </span>
                </router-link>
            </div>
        </div>
        <div>
            <div class="sp-info">
                <h4 class="weight--700">{{ shop.name }}</h4>
                <p class="size--13 line-height--1_6">{{ shop.description }}</p>
            </div>
            <div class="e-box e-box--padding sp-tags line-height--1_6" v-if="subcategories.length">
                <router-link
                    active-class="active"
                    :to="queryAppend({ category_id: c.id })"
                    exact
                    v-for="c in subcategories"
                    :key="c.id"
                >
                    {{ c.name }}
                </router-link>
            </div>
            <div class="sp-view">
                <IncludeDropdown class="dropdown-right dropdown-inline">
                    <template v-slot:toggle>
                        <span class="size--13">
                            Сортировать по:
                            <span class="c-violet">
                                {{ order.name }}
                            </span>
                            <!--<i class="blue light medium prefab--arrow-down"></i>-->
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </span>
                    </template>
                    <ul class="dropdown-menu-custom separated" style="text-align: left;">
                        <li v-for="o in orders" :class="{ selected: $route.query.order == o.value }">
                            <router-link
                                active-class="active"
                                :to="o.value ? queryAppend({ order: o.value }) : queryRemove(['order'])"
                                exact
                            >
                                {{ o.name }}
                            </router-link>
                        </li>
                    </ul>
                </IncludeDropdown>
                <IncludeDropdown class="dropdown-right dropdown-inline">
                    <template v-slot:toggle>
                        <span class="size--13">
                            Показать по:
                            <span class="c-violet">
                                {{ limit }}
                            </span>
                            <!--<i class="blue light medium prefab--arrow-down"></i>-->
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </span>
                    </template>
                    <ul class="dropdown-menu-custom separated" style="text-align: left;">
                        <li v-for="l in [16, 32, 64]" :class="{ selected: limit == l }">
                            <router-link
                                active-class="active"
                                :to="queryAppend({ limit: l, page: 1 })"
                                exact
                            >
                                {{ l }}
                            </router-link>
                        </li>
                    </ul>
                </IncludeDropdown>
                <div class="e-view" v-if="false">
                    <a class="active" href="">
                        <i class="ico ico--grid"></i>
                    </a>
                    <a href="">
                        <i class="ico ico--line"></i>
                    </a>
                </div>
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
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapState, mapActions } from 'vuex';

export default {
    data() {
        return {
            announcements: [],
            total: 0,
            loading: false,
            orders: [
                {
                    name: 'дате'
                }, {
                    name: 'возрастанию цены',
                    value: 'price-asc'
                }, {
                    name: 'убыванию цены',
                    value: 'price-desc'
                }
            ],
            subcategories: []
        }
    },
    computed: {
        ...mapState({
            shop: state => state.shops.shop
        }),
        limit() {
            return this.$route.query.limit || 16;
        },
        offset() {
            return ((this.$route.query.page || 1) - 1) * this.limit;
        },
        order() {
            return this.orders.find(o => this.$route.query.order == o.value);
        },
        category() {
            let c = this.categories.find(c => c.id == this.$route.query.category_id);
            if (!c) {
                c = this.subcategories.find(c => c.id == this.$route.query.category_id);
            }
            return c;
        },
    },
    asyncComputed: {
        categories: {
            async get() {
                return await this.MARKET_CATEGORIES_GET({
                    owner_id: this.shop.id,
                    owner_type: 'shop'
                });
            },
            default: []
        }
    },
    created() {
        this.load();
    },
    methods: {
        ...mapActions([
            'MARKET_CATEGORIES_GET'
        ]),
        async load() {
            if (!this.shop.id) return;

            this.loading = true;
            const params = {
                reason: 'search',
                limit: this.limit,
                offset: this.offset,
                owner_id: this.shop.id,
                owner_type: 'shop',
                ...this.$route.query
            };
            const response = await axios.get('/api/announcements', {
                params
            });
            this.announcements = response.data.announcements;
            this.total = response.data.total;
            this.subcategories = response.data.categories || [];
            this.loading = false;
        },
    },
    watch: {
        shop() {
            this.load();
        },
        '$route.query': function() {
            this.load();
        }
    }
}
</script>

