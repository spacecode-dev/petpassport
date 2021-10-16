<template>
    <div class="sp-nav">
        <router-link class="sp-nav--arrow sp-nav--prev" to="/" v-if="hasPrev">
            <i></i>
        </router-link>
        <span class="sp-nav--arrow sp-nav--prev" v-else>
            <i></i>
        </span>
        <div class="sp-nav--center">
            <router-link :class="{ active: current == 1 }" :to="pageLink(1)" exact v-if="hasFirst">1</router-link>
            <span v-if="hasFirst">...</span>
            <router-link v-for="page in pages" :key="page" :class="{ active: current == page }" :to="pageLink(page)" exact>{{ page }}</router-link>
            <span v-if="hasLast">...</span>
            <router-link :class="{ active: current == totalPages }" :to="pageLink(totalPages)" exact v-if="hasLast">{{ totalPages }}</router-link>
        </div>
        <router-link class="sp-nav--arrow sp-nav--next" to="/" v-if="hasNext">
            <i></i>
        </router-link>
        <span class="sp-nav--arrow sp-nav--next" v-else>
            <i></i>
        </span>
    </div>
</template>

<script>
import querystring from 'querystring';

export default {
    props: {
        limit: {
            type: Number,
            default: 20
        },
        total: Number,
        pageRange: {
            type: Number,
            default: 2
        }
    },
    computed: {
        current() {
            return this.$route.query.page || 1;
        },
        pages() {
            const pages = [];

            for (let i = this.rangeStart; i <= this.rangeEnd; i++) {
                pages.push(i);
            }

            return pages;
        },
        rangeStart() {
            const start = this.current - this.pageRange;

            return (start > 0) ? start : 1;
        },
        rangeEnd() {
            const end = this.current + this.pageRange;

            return (end < this.totalPages) ? end : this.totalPages;
        },
        totalPages() {
            return Math.ceil(this.total / this.limit);
        },
        nextPage() {
            return this.current + 1;
        },
        prevPage() {
            return this.current - 1;
        },
        hasFirst() {
            return this.rangeStart !== 1;
        },
        hasLast() {
            return this.rangeEnd < this.totalPages;
        },
        hasPrev() {
            return this.current > 1;
        },
        hasNext() {
            return this.current < this.totalPages;
        }
    },
    methods: {
        pageLink(page) {
            const query = {
                ...this.$route.query,
                page
            };
            return document.location.pathname + '?' + querystring.stringify(query);
        }
    },
    created() {

    }
}
</script>
