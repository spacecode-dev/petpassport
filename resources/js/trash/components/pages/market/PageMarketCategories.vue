<template>
    <LayoutMain white-header hidden-sidebar>
        <div class="cn-shop cn-shop--page">
            <div class="cn-shop--inner">
                <div class="cn-shop--white cn-shop--wrap">
                    <h4 class="size--24 weight--700 margin--top-25 margin--bottom-15">
                        Категории
                    </h4>
                    <div class="grid grid--gap grid--four">
                        <template v-for="category in categories">
                            <IncludeMarketCategory :category="category" v-if="category.id != 17" />
                        </template>
                    </div>
                    <div class="padding--top-20">
                        <div class="sp-article-cat sp-article-cat--combine">
                            <router-link to="/market/announcements?category_id=17">
                                <img class="sp-article-cat--subject img-fluid" src="/img/cat/17.png" alt="">
                            </router-link>
                            <div class="sp-article-cat--be">
                                <router-link class="size--14 weight--600 sp-article-cat--term" to="/market/announcements?category_id=17">
                                    Другие животные
                                </router-link>
                                <p class="size--13 sp-article-cat--exile">
                                    Различные животные, часто - экзотические. Обезьянки и еноты, ёжики и суррикаты, минипиги и козочки. И многие другие, которым не нашлось места в других разделах.
                                </p>
                            </div>
                            <router-link to="/market/announcements?category_id=17">
                                <img class="sp-article-cat--subject img-fluid" src="/img/cat/18.png" alt="">
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </LayoutMain>
</template>

<script>
import { mapCacheActions } from 'vuex-cache';

export default {
    asyncComputed: {
        categories: {
            async get() {
                return await this.MARKET_CATEGORIES_GET();
            },
            default: []
        }
    },
    methods: {
        ...mapCacheActions([
            'MARKET_CATEGORIES_GET'
        ])
    }
}
</script>
