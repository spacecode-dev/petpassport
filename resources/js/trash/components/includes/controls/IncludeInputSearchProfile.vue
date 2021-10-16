<template>
    <div class="user-input">
        <div class="user-input--user size--13" v-if="value" @click="updateValue(null)">
            <img :src="value.avatar" :alt="value.name">
            {{ value.name }}
        </div>
        <template v-else>
            <input class="form--control form--control-gray size--13" placeholder="ID аккаунта, логин, или ссылка на профиль" type="text" maxlength="255" v-model="search">
            <ul v-if="profiles.length">
                <li class="user-input--user size--13" v-for="p in profiles" :key="p.user_id" @click="updateValue(p)">
                    <img :src="p.avatar" :alt="p.name">
                    {{ p.name }}
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
            profiles: []
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
                this.profiles = [];
                return;
            }

            const data = (await axios.get('/api/profiles', {
                params: {
                    reason: 'search',
                    limit: 10,
                    q: this.search,
                    ...this.query
                }
            })).data;

            this.profiles = data.profiles;
        }
    }
}
</script>
