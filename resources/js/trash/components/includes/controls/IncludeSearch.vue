<template>
    <div class="e-box e-box--padding sr-page">
        <div class="sr-page--field">
            <button class="sr-page--go"></button>
            <input class="sr-page--input size--13" :placeholder="placeholder" v-model="q">
        </div>
        <div class="b-filter--talk" v-if="order.length">
            <IncludeDropdown class="dropdown-right">
                <template v-slot:toggle>
                    <i class="ico ico--menu"></i>
                    <span class="size--13">
                        Сортировка
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </span>
                </template>
                <ul class="dropdown-menu-custom separated" style="text-align: left;">
                    <li v-for="o in order" :class="{ selected: $route.query.order == o.value }">
                        <router-link
                            active-class="active"
                            :to="o.value ? queryAppend({ order: o.value }) : queryRemove(['order'])" exact
                        >
                            {{ o.name }}
                        </router-link>
                    </li>
                </ul>
            </IncludeDropdown>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        placeholder: {
            type: String,
            default: 'Поиск'
        },
        order: {
            type: Array,
            default: () => []
            /*
                {
                    value: 'Значение переменной order',
                    name: 'Название пункта меню'
                }
            */
        }
    },
    data() {
        return {
            q: this.$route.query.q
        }
    },
    created() {
        this.$route.meta.preserveScroll = true;
    },
    watch: {
        q(q) {
            const query = {
                ...this.$route.query,
                q
            };

            if (!query.q && typeof query.q != 'undefined') {
                //delete query.q;
            }

            this.$router.replace({
                query
            });
        },
        '$route.query.q': function() {
            //console.log('query changed');
            this.q = this.$route.query.q;
        }
    }
}
</script>
