<template>
    <div>
        <!--
        <h3 class="style--center color--daisy-bush size--24 margin--bottom-20">
            Похожие обьявления
        </h3>
        -->
        <div class="filters">
            <div>
                <div class="pretty p-default p-curve">
                    <input type="checkbox" v-model="filters.liked" :disabled="loading">
                    <div class="state">
                        <label>
                            <span class="size--13">Избранные</span>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <div class="pretty p-default p-curve">
                    <input type="checkbox" v-model="filters.similar" :disabled="loading">
                    <div class="state">
                        <label>
                            <span class="size--13">Похожие</span>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <div class="pretty p-default p-curve">
                    <input type="checkbox" v-model="filters.popular" :disabled="loading">
                    <div class="state">
                        <label>
                            <span class="size--13">Популярные</span>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <div class="pretty p-default p-curve">
                    <input type="checkbox" v-model="filters.promotion" :disabled="loading || true">
                    <div class="state">
                        <label>
                            <span class="size--13">Со скидкой</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="c-gray text-center" v-if="loading">
            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            Загрузка...
        </div>
        <div v-else>
            <IncludeAnnouncement v-for="ann in announcements" :announcement="ann" :key="ann.id" />
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        announcement: Object
    },
    data() {
        return {
            loading: false,
            announcements: [],
            filters: {
                liked: false,
                similar: true,
                popular: false,
                promotion: false
            }
        }
    },
    created() {
        this.load();
    },
    methods: {
        async load() {
            this.loading = true;

            this.announcements = (await axios.get('/api/announcements', {
                params: {
                    reason: 'aside',
                    announcement_id: this.announcement.id,
                    liked: +this.filters.liked,
                    similar: +this.filters.similar,
                    popular: +this.filters.popular,
                    promotion: +this.filters.promotion
                }
            })).data;

            this.loading = false;
        }
    },
    watch: {
        filters: {
            handler() {
                this.load();
            },
            deep: true
        }
    }
}
</script>

<style lang="scss" scoped>
.filters {
    display: flex;
    flex-wrap: wrap;
    padding-bottom: 25px;

    & > div {
        width: 50%;
        padding: 10px;
    }
}
</style>
