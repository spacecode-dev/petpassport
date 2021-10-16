<template>
    <article class="search-result row">
        <div v-line-clamp:20="1">
            <a class="search-text-result"  target="_blank" v-bind:href="initData['url']" title="">{{ initData['text'] }}</a>
        </div>
    </article>
</template>

<script>
    export default {
        props: {
            initData: {
                type: Object
            },
        },
        data() {
            return {
                // inputValue: 0
            }
        },
        computed: {

        },
        methods: {

        },
        created() {
        }
    }
</script>

<style lang="scss" scoped>
    .search-result {
        margin: 10px 15px 10px;
        max-width: 1000px;
    }
    .search-text-result {
        color: var(--c-black);

        &:hover{
            color: var(--c-violet);
            font-weight: 600;
        }
    }
</style>
