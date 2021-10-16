<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Команда сообщества
                </p>
            </div>
            <div class="modal-sep"></div>
            <div class="modal-box">
                <div class="e-user-select" v-for="role in orderedRoles" :key="role.profile.user_id">
                    <div class="e-avatar--50 e-avatar">
                        <router-link :to="role.profile.link" class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + role.profile.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content size--14">
                            <router-link :to="role.profile.link" class="d-block c-black weight--600 margin--bottom-5">
                                {{ role.profile.name }}
                            </router-link>
                            <div class="c-red" v-if="role.role == 1">
                                <i class="fa fa-fw fa-crown" aria-hidden="true"></i>
                                Владелец
                            </div>
                            <div class="c-violet" v-if="role.role == 2">
                                <i class="fa fa-fw fa-certificate" aria-hidden="true"></i>
                                Администратор
                            </div>
                            <div class="c-green" v-if="role.role == 3">
                                <i class="fa fa-fw fa-shield-alt" aria-hidden="true"></i>
                                Модератор
                            </div>
                            <div class="c-gray" v-if="role.role == 4">
                                Заводчик
                            </div>
                            <div class="c-gray" v-if="role.role == 5">
                                Груммер
                            </div>
                            <div class="c-gray" v-if="role.role == 6">
                                Хэндлер
                            </div>
                        </div>
                    </div>
                    <div v-if="community.user_role == 1 && role.role != 1">
                        <button class="c-gray" style="cursor: pointer;" @click="selectProfile(role.profile)">
                            <i class="fa fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        </button>
                        <button class="c-gray" style="cursor: pointer;" @click="deleteRole(role.profile)">
                            <i class="fa fa-fw fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <template v-if="community.user_role == 1">
                <div class="modal-sep"></div>
                <div class="modal-box modal-box-gray">
                    <p class="size--18 weight--700 margin--bottom-25">
                        Установка роли пользователя
                    </p>
                    <p class="weight--600 c-black margin--bottom-10">
                        Выберите пользователя:
                    </p>
                    <div class="margin--bottom-20">
                        <IncludeInputSearchProfile v-model="add.profile" />
                    </div>
                    <p class="weight--600 c-black margin--bottom-10">
                        Выберите роль:
                    </p>
                    <div class="margin--bottom-20">
                        <select class="form--control-gray wide form--control size--13" v-model="add.role">
                            <option value="null">Выберите роль</option>
                            <option value="3">Модератор</option>
                            <option value="2">Администратор</option>
                            <option value="4" v-if="community.type == 2">Заводчик</option>
                            <option value="5" v-if="community.type == 2">Груммер</option>
                            <option value="6" v-if="community.type == 2">Хэндлер</option>
                        </select>
                    </div>
                    <button class="btn btn-blue-border-style btn-wider" @click="addRole" :disabled="!add.profile || !add.role">
                        Установить роль
                    </button>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapState } from 'vuex';

export default {
    data() {
        return {
            roles: [],
            add: {
                profile: null,
                role: null
            }
        }
    },
    computed: {
        ...mapState({
            community: state => state.communities.community,
            counters: state => state.communities.counters,
            flags: state => state.communities.flags
        }),
        orderedRoles() {
            return [...this.roles].sort((a, b) => {
                if (a.role > b.role) {
                    return 1;
                }
                if (a.role < b.role) {
                    return -1;
                }
                return 0;
            });
        }
    },
    mounted() {
        $('select').niceSelect();
    },
    created() {
        this.load();
    },
    watch: {
        community() {
            this.load();
        }
    },
    methods: {
        async load() {
            this.roles = (await axios.get('/api/community_roles', {
                params: {
                    community_id: this.community.id
                }
            })).data;
        },
        selectProfile(profile) {
            this.add.profile = profile;
        },
        async addRole() {
            const { role } = this.add;
            const { user_id } = this.add.profile;

            try {
                const added = (await axios.post('/api/community_roles', {
                    community_id: this.community.id,
                    user_id,
                    role
                })).data;

                this.roles = this.roles.filter(r => r.user_id != user_id);
                this.roles.push(added);

                this.$store.commit('COMMUNITY_UPDATE', {
                    roles_count: this.roles.length
                });

                toastr.success('Пользователь добавлен в команду');
            } catch(e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Невозможно добавить в команду самого себя');
                        break;
                    default:
                        toastr.error('Произошла ошибка при добавлении в команду');
                        break;
                }
            }
        },
        async deleteRole(profile) {
            const confirmed = confirm('Вы действительно хотите исключить "' + profile.name + '" из команды?');

            if (!confirmed) return;

            const { user_id } = profile;

            await axios.delete('/api/community_roles', {
                data: {
                    community_id: this.community.id,
                    user_id
                }
            });

            this.roles = this.roles.filter(r => r.user_id != user_id);

            this.$store.commit('COMMUNITY_UPDATE', {
                roles_count: this.roles.length
            });

            toastr.success('Пользователь исключен из команды');
        }
    }
}
</script>

<style>
.nice-select .list {
    max-height: 100px !important;
}
</style>
