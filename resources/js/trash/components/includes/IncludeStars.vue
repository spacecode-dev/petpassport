<template>
    <div class="stars" :class="{ 'stars-input': input }">
        <template v-for="i in count">
            <i class="fas fa-fw fa-star" aria-hidden="true" v-if="stars >= i" v-on="input ? { click: () => setValue(i) } : {}"></i>
            <span class="stars-stack fa-fw" v-else-if="stars >= (i - 0.5)" v-on="input ? { click: () => setValue(i) } : {}">
                <i class="fas fa-fw fa-star-half" aria-hidden="true"></i>
                <i class="far fa-fw fa-star" aria-hidden="true"></i>
            </span>
            <i class="far fa-fw fa-star" aria-hidden="true" v-else v-on="input ? { click: () => setValue(i) } : {}"></i>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: String | Number,
            default: 0
        },
        count: {
            type: Number,
            default: 5
        },
        input: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            inputValue: 0
        }
    },
    computed: {
        stars() {
            return this.input ? this.inputValue : this.value;
        }
    },
    methods: {
        setValue(stars) {
            this.inputValue = stars;
            this.$emit('changed', this.inputValue);
        }
    }
}
</script>

<style lang="scss" scoped>
.stars {
    display: inline-flex;
    margin: 0 -.1em;

    & > * {
        box-sizing: content-box;
        padding: 0 .1em;
    }

    .fas {
        color: var(--c-violet);
    }

    .far {
        color: var(--c-gray);
    }

    .stars-stack {
        display: inline-block;
        position: relative;
        height: 1em;

        .fas,
        .far {
            position: absolute;
            left: .1em;
            top: 0;
            z-index: 1;
        }

        .fas {
            z-index: 2;
        }
    }

    &.stars-input {
        cursor: pointer;

        &:hover {
            .fas,
            .far {
                color: var(--c-violet);

                &:hover ~ * {
                    color: var(--c-gray);
                }
            }
        }
    }
}
</style>
