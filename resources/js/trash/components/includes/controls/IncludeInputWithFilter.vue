<template>
    <div class="select-with-filter">
        <div class="form--control size--13 selected" :class="inputClass" @click="refocus" v-if="selected">
            {{ selected[filterBy] }}
        </div>
        <template v-else>
            <input class="form--control size--13" :class="inputClass" :placeholder="placeholder" type="text" maxlength="255" v-model="filter" @focus="focus" @_blur="blur" @input="input">
            <ul class="dropdown" v-if="focused">
                <li class="size--13" v-for="result in results" :key="result[keyBy]" @click="select(result)">
                    {{ result[filterBy] }}
                </li>
            </ul>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        value: String | Number,
        data: {
            type: Array,
            default: []
        },
        keyBy: {
            type: String,
            default: 'id'
        },
        orderBy: String,
        filterBy: String,
        caseSensitive: {
            type: Boolean,
            default: false
        },
        placeholder: String,
        inputClass: {
            type: String,
            default: 'form--control-gray'
        }
    },
    data() {
        return {
            focused: false,
            filter: null,
            valueInternal: null
        }
    },
    created() {
        this.valueInternal = this.value;
        document.addEventListener('click', e => {
            if (!e.path.includes(this.$el)) {
                this.blur();
            }
        });
    },
    computed: {
        sortedData() {
            if (this.orderBy) {
                return this.data.slice().sort((a, b) => {
                    if (a[this.orderBy] < b[this.orderBy]) {
                        return -1;
                    }
                    if (a[this.orderBy] > b[this.orderBy]) {
                        return 1;
                    }
                    return 0;
                });
            }
            return this.data;
        },
        results() {
            if (this.filter) {
                return this.sortedData.filter(o => {
                    if (this.caseSensitive) {
                        return o[this.filterBy].startsWith(this.filter);
                    } else {
                        return o[this.filterBy].toLowerCase().startsWith(this.filter.toLowerCase());
                    }
                });
            }
            return this.sortedData;
        },
        selected() {
            if (this.data) {
                return this.data.find(o => o[this.keyBy] == this.valueInternal);
            }
            return null;
        }
    },
    methods: {
        focus() {
            this.focused = true;
        },
        blur() {
            //setTimeout(() => {
                this.focused = false;
            //}, 100);
            this.filter = null;
        },
        input() {
            this.valueInternal = null;
        },
        select(item) {
            this.valueInternal = item[this.keyBy];
            this.focused = false;
            this.filter = null;
            //this.$emit('input', this.valueInternal);
        },
        async refocus() {
            this.valueInternal = null;
            this.focused = true;
            await this.$nextTick();
            this.$el.querySelector('input').focus();
        },
        unselect() {
            this.valueInternal = null;
        }
    },
    watch: {
        filter() {
            if (this.filter && this.results.length == 1) {
                //this.select(this.results[0]);
                const p = this.results[0][this.filterBy];
                if ((this.caseSensitive && p == this.filter) ||
                    (!this.caseSensitive && p.toLowerCase() == this.filter.toLowerCase())) {
                    this.select(this.results[0]);
                }
            }
        },
        value() {
            this.valueInternal = this.value;
        },
        valueInternal() {
            //console.log('valueInternal', this.valueInternal)
            this.$emit('input', this.valueInternal);
        }
    }
}
</script>

<style lang="scss" scoped>
.select-with-filter {
    position: relative;

    .selected {
        line-height: normal;
    }

    .dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 10em;
        z-index: 9999;
        overflow: auto;
        border: 1px solid #EAEAEA;
        border-radius: 0 0 5px 5px;

        li {
            padding: .51em .86em;
            background: #FAFAFA;
            cursor: default;

            &:hover {
                background: #EAEAEA;
            }
        }
    }
}
</style>
