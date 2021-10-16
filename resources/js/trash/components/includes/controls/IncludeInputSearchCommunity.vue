<template>
    <div class="user-input">
        <div class="user-input--user size--13" v-if="value" @click="updateValue(null)">
            <img :src="value.avatar" :alt="value.name">
            {{ value.name }}
        </div>
        <template v-else>
            <input class="form--control form--control-gray size--13" placeholder="ID сообщества, логин, или ссылка на страницу" type="text" maxlength="255" v-model="search">
            <ul v-if="communities.length">
                <li class="user-input--user size--13" v-for="c in communities" :key="c.id" @click="updateValue(c)">
                    <img :src="c.avatar" :alt="c.name">
                    {{ c.name }}
                </li>
            </ul>
        </template>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        query: {
            type: Object,
            default() {
                return {};
            }
        },
        value: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            search: null,
            communities: []
        }
    },
    methods: {
        updateValue(value) {
            this.$emit('input', value);
        }
    },
    watch: {
        async search() {
            if (!this.search) {
                this.communities = [];
                return;
            }

            const data = (await axios.get('/api/communities', {
                params: {
                    reason: 'search',
                    limit: 10,
                    q: this.search,
                    ...this.query
                }
            })).data;

            this.communities = data.communities;
        }
    }
}
</script>
