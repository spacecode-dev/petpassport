<template>
    <div class="content--bg">
        <img class="bg" v-if="profile.cover" :src="getBackground" alt=""/>
        <div class="content--bg--buttons">
            <button v-if="$store.getters.authenticated" @click.prevent="changeBackground" class="change">
                <b-icon icon="camera"/>
            </button>
            <b-button v-if="$store.getters.authenticated" class="update" type="is-light" tag="router-link" to="/settings/profile" outlined>Обновить</b-button>
        </div>
        <div class="content--bg--title">
            <div v-if="!profile.noavatar" class="logo">
                <img :src="getAvatar" alt=""/>
            </div>
            <h4>{{ profile.name }}</h4>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        computed: {
            ...mapState({
                profile: state => state.profiles.profile,
                storage: state => state.settings.storage.path
            }),
            getBackground() {
                return this.storage + this.profile.cover;
            },
            getAvatar() {
                return this.storage + this.profile.avatar;
            }
        },
        methods: {
            changeBackground() {
                console.log('TODO changeBackground')
            }
        }
    }
</script>
