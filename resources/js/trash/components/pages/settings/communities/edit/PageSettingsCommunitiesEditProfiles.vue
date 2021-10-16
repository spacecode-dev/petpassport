<template>
    <div>
        <form class="e-box e-box--padding" @submit.prevent="add">
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Тип
                    </span>
                </div>
                <div>
                    <select class="form--control-gray wide form--control" v-model="newProfileType" :disabled="processing">
                        <option value="1">Заводчик</option>
                        <!--
                        <option value="2">Питомец</option>
                        <option value="3">Выпускник</option>
                        -->
                        <option value="4">Совладелец</option>
                    </select>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Профиль
                    </span>
                </div>
                <div>
                    <IncludeInputSearchProfile v-model="newProfile" :query="{ types: '1,2' /*[1, 4].includes(newProfileType) ? '1,2' : '3'*/ }" />
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Добавить
                    </button>
                </div>
            </div>
        </form>
        <template v-if="breeders.length">
            <h4 class="weight--600 e-title--content">
                Заводчики
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="p in breeders" :key="p.user_id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="p.link" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="p.link">
                                    {{ p.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(p, 1)" :disabled="p.processing">
                            Отвязать заводчика
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <!--
        <template v-if="pets.length">
            <h4 class="weight--600 e-title--content">
                Питомцы
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="p in pets" :key="p.user_id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="p.link" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="p.link">
                                    {{ p.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(p, 2)" :disabled="p.processing">
                            Отвязать питомца
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-if="graduates.length">
            <h4 class="weight--600 e-title--content">
                Выпускники
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="p in graduates" :key="p.user_id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="p.link" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="p.link">
                                    {{ p.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(p, 3)" :disabled="p.processing">
                            Отвязать выпускника
                        </button>
                    </div>
                </div>
            </div>
        </template>
        -->
        <template v-if="coowners.length">
            <h4 class="weight--600 e-title--content">
                Совладельцы
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="p in coowners" :key="p.user_id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="p.link" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="p.link">
                                    {{ p.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(p, 4)" :disabled="p.processing">
                            Отвязать совладельца
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

export default {
    data() {
        return {
            processing: false,
            profiles: [],
            newProfile: null,
            newProfileType: 1
        }
    },
    computed: {
        community() {
            return this.$parent.community;
        },
        breeders() {
            return this.profiles.filter(p => p.type == 1).map(p => p.user);
        },
        /*
        pets() {
            return this.profiles.filter(p => p.type == 2).map(p => p.user);
        },
        graduates() {
            return this.profiles.filter(p => p.type == 3).map(p => p.user);
        }
        */
        coowners() {
            return this.profiles.filter(p => p.type == 4).map(p => p.user);
        }
    },
    created() {
        if (this.community && this.community.id) {
            this.load();
        }
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    watch: {
        community() {
            this.load();
        }
    },
    methods: {
        async load() {
            const { data } = await axios.get('/api/community_users', {
                params: {
                    community_id: this.community.id
                }
            });

            this.profiles = data;
        },
        async add() {
            try {
                await axios.post('/api/community_users', {
                    community_id: this.community.id,
                    user_id: this.newProfile.user_id,
                    type: this.newProfileType
                });
            } catch (e) {
                switch (e.response.data.code) {
                    case 2:
                        toastr.error('Данный профиль уже привязан');
                        break;
                }
                return;
            }

            this.profiles.push({
                type: this.newProfileType,
                user: this.newProfile
            });

            this.newProfile = null;

            toastr.success('Профиль привязан');
        },
        async remove(profile, type) {
            const confirmed = confirm('Вы действительно хотите отвязать профиль "' + profile.name + '?');

            if (!confirmed) return;

            await axios.delete('/api/community_users', {
                data: {
                    community_id: this.community.id,
                    user_id: profile.user_id,
                    type
                }
            });

            this.profiles = this.profiles.filter(p => !(p.type == type && p.user.user_id == profile.user_id));

            toastr.success('Профиль отвязан');
        }
    }
}
</script>
