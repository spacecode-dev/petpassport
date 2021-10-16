<template>
    <LayoutMain>
        <template v-slot:header>
            <IncludeHeaderCommunity/>
        </template>
        <template v-slot:sidebar-header>
            <div class="b-user" :style="{ 'background-image': 'url(\'' + community.cover + '\')' }">
                <div class="b-user--inner">
                    <h3 class="b-user--rap">
                        {{ community.name }}
                    </h3>
                    <div class="e-avatar--65 e-avatar">
                        <a href="#" class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + community.avatar + '\')' }">
                            <span @click="selectAvatar" v-if="community.user_role == 1">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                            </span>
                        </a>
                        <div class="e-avatar--content">
                            <span class="size--14 color--white">
                                {{ community.name }}
                            </span>
                        </div>
                    </div>
                    <p class="b-user--say">
                        <template v-if="community.type == 1">
                            Группа
                        </template>
                        <template v-if="community.type == 2">
                            Питомник
                        </template>
                        <template v-if="community.type == 3">
                            Страница
                        </template>
                        <template v-if="community.type == 4">
                            Порода
                        </template>
                    </p>
                </div>
            </div>
        </template>
        <template v-slot:sidebar-content>
            <div>
                <div v-if="community.about" class="sb-descr style--center e-more padding--bottom-30" :class="{ showed: aboutFull }">
                    <span class="size--13 sb-descr--speech">
                        <!--
                        <span>
                            {{ profile.profile.about }}
                        </span>
                        <span class="e-more--show">
                            &nbsp;
                        </span>
                        -->
                        <span>
                            {{ about }}
                        </span>
                    </span>
                    <i class="gray prefab--arrow-down e-more--button" @click.stop="aboutFull = !aboutFull" v-if="community.about && community.about.length > 300"></i>
                </div>
                <div class="text-center">
                    <a href="#" class="c-black size--13 d-inline-flex" style="height: 20px; line-height: 20px;" @click.prevent="showRoles">
                        <span class="sb-who--be c-white" style="width: 20px; height: 20px; line-height: 20px;">
                            {{ community.roles_count }}
                        </span>
                        <span>Команда</span>
                    </a>
                </div>
                <!--
                <div v-if="community.type == 3">
                    <div class="padding--top-45">
                        <div class="style--center">
                            <div class="pretty p-switch p-slim" @click.capture.stop.prevent="switchInfoHidden" >
                                <input type="checkbox" v-model="profile.profile.info_hidden">
                                <div class="state">
                                    <label>
                                        <span class="size--13">
                                            Скрыть информацию
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
            </div>
            <template v-if="community.profile_nursery">
                <ul class="sb-info size--13 mt-3">
                    <li v-if="community.profile_nursery.certificate">
                        Сертификат:
                        {{ community.profile_nursery.certificate }}
                    </li>
                    <li v-if="community.profile_nursery.owner">
                        Владелец:
                        <router-link :to="community.profile_nursery.owner.link">
                            {{ community.profile_nursery.owner.name }}
                        </router-link>
                    </li>
                    <li v-for="p in linked_coowners">
                        Совладелец:
                        <router-link :to="p.link">
                            {{ p.name }}
                        </router-link>
                    </li>
                    <li v-for="p in linked_breeders">
                        Заводчик:
                        <router-link :to="p.link">
                            {{ p.name }}
                        </router-link>
                    </li>
                    <li v-if="community.profile_nursery.address">
                        Адрес:
                        {{ community.profile_nursery.address }}
                    </li>
                    <li v-if="community.profile_nursery.phone">
                        Телефон:
                        {{ community.profile_nursery.phone }}
                    </li>
                    <li v-if="community.profile_nursery.email">
                        E-mail:
                        <a :href="'mailto:' + community.profile_nursery.email">
                            {{ community.profile_nursery.email }}
                        </a>
                    </li>
                    <li v-if="community.profile_nursery.site">
                        Сайт:
                        <a :href="profile_nursery_site" target="_blank">
                            {{ profile_nursery_site_hostname }}
                        </a>
                    </li>
                </ul>
                <div class="e-box--with-offset" v-if="community.profile_nursery.history">
                    <h4 class="e-box--title style--inline">
                        История питомника
                    </h4>
                    <div class="size--13">
                        {{ community.profile_nursery.history }}
                    </div>
                </div>
            </template>
            <template v-if="community.profile_breed">
                <div class="e-box--with-offset" v-if="community.profile_breed.history">
                    <h4 class="e-box--title style--inline">
                        История породы
                    </h4>
                    <div class="size--13">
                        {{ community.profile_breed.history }}
                    </div>
                </div>
                <div class="e-box--with-offset" v-if="community.profile_breed.standard">
                    <h4 class="e-box--title style--inline">
                        Стандарт породы
                    </h4>
                    <div class="size--13">
                        {{ community.profile_breed.standard }}
                    </div>
                </div>
                <div class="e-box--with-offset" v-if="community.profile_breed.terminology">
                    <h4 class="e-box--title style--inline">
                        Терминлогия
                    </h4>
                    <div class="size--13">
                        {{ community.profile_breed.terminology }}
                    </div>
                </div>
            </template>
            <div class="e-box--with-offset" v-if="linked_groups.length">
                <h4 class="e-box--title style--inline">
                    Связанные группы
                </h4>
                <div>
                    <div class="e-avatar--65 _e-add--user e-avatar" v-for="c in linked_groups">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }" :to="c.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="c.link">
                                {{ c.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="c.link + '/members'">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ c.members_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="linked_nurseries.length">
                <h4 class="e-box--title style--inline">
                    Связанные питомники
                </h4>
                <div>
                    <div class="e-avatar--65 _e-add--user e-avatar" v-for="c in linked_nurseries">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }" :to="c.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="c.link">
                                {{ c.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="c.link + '/members'">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ c.members_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="linked_pages.length">
                <h4 class="e-box--title style--inline">
                    Связанные страницы
                </h4>
                <div>
                    <div class="e-avatar--65 _e-add--user e-avatar" v-for="c in linked_pages">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }" :to="c.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="c.link">
                                {{ c.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="c.link + '/members'">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                {{ c.likes_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="linked_breeds.length">
                <h4 class="e-box--title style--inline">
                    Связанные породы
                </h4>
                <div>
                    <div class="e-avatar--65 _e-add--user e-avatar" v-for="c in linked_breeds">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }" :to="c.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="c.link">
                                {{ c.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="c.link + '/members'">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                {{ c.likes_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="e-box--with-offset" v-if="linked_breeders.length">
                <h4 class="e-box--title style--inline">
                    Заводчики
                </h4>
                <div>
                    <div class="grid grid--three">
                        <div class="e-frend" v-for="p in linked_breeders" :key="p.user_id">
                            <router-link class="prefab--ava e-frend--photo" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }" :to="p.link"></router-link>
                            <span class="size--13 style--block">
                                {{ p.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="linked_pets.length">
                <h4 class="e-box--title style--inline">
                    Питомцы
                </h4>
                <div>
                    <div class="grid grid--three">
                        <div class="e-frend" v-for="p in linked_pets" :key="p.user_id">
                            <router-link class="prefab--ava e-frend--photo" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }" :to="p.link"></router-link>
                            <span class="size--13 style--block">
                                {{ p.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="linked_graduates.length">
                <h4 class="e-box--title style--inline">
                    Выпускники
                </h4>
                <div>
                    <div class="grid grid--three">
                        <div class="e-frend" v-for="p in linked_graduates" :key="p.user_id">
                            <router-link class="prefab--ava e-frend--photo" :style="{ 'background-image': 'url(\'' + p.avatar + '\')' }" :to="p.link"></router-link>
                            <span class="size--13 style--block">
                                {{ p.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="e-box--with-offset" v-if="community.pets_count">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="community.link + '/pets'">
                        Питомцы
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ community.pets_count }}
                </span>
                <div>
                    <ul class="sb-similar size--13">
                        <li v-for="p in top_pets" :key="p.user_id">
                            <i class="ico ico--sex-male" v-if="p.gender == 1"></i>
                            <i class="ico ico--sex-fem" v-else-if="p.gender == 2"></i>
                            <i class="ico" v-else></i>
                            <router-link :to="p.link">
                                {{ p.name }}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="community.graduates_count">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="community.link + '/graduates'">
                        Выпускники
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ community.graduates_count }}
                </span>
                <div>
                    <ul class="sb-similar size--13">
                        <li v-for="p in top_graduates" :key="p.user_id">
                            <i class="ico ico--sex-male" v-if="p.gender == 1"></i>
                            <i class="ico ico--sex-fem" v-else-if="p.gender == 2"></i>
                            <i class="ico" v-else></i>
                            <router-link :to="p.link">
                                {{ p.name }}
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="community.photos_count">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="community.link + '/photos'">
                        Фотографии
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ community.photos_count }}
                </span>
                <div>
                    <div class="grid grid--three">
                        <div class="e-photo" v-for="photo in community.top_photos">
                            <a :href="community.link + '/photos/' + photo.id" class="d-block" style="padding-top: 100%; background-size: cover; background-position: center;" :style="{ 'background-image': 'url(\'' + photo.thumb_180 + '\')' }" @click="showPhoto(photo)"></a>
                            <!--<img class="img-fluid e-photo--img" :src="photo.thumb_180" alt="">-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="community.members_count">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="community.link + '/members'">
                        Участники
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ community.members_count }}
                </span>
                <div>
                    <div class="grid grid--three">
                        <div class="e-frend" v-for="member in top_members" :key="member.user_id">
                            <router-link class="prefab--ava e-frend--photo" :style="{ 'background-image': 'url(\'' + member.avatar + '\')' }" :to="member.link"></router-link>
                            <span class="size--13 style--block">
                                {{ member.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="community.likes_count">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="community.link + '/likes'">
                        Кому нравится
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ community.likes_count }}
                </span>
                <div>
                    <div class="grid grid--three">
                        <div class="e-frend" v-for="liker in top_likers" :key="liker.user_id">
                            <router-link class="prefab--ava e-frend--photo" :style="{ 'background-image': 'url(\'' + liker.avatar + '\')' }" :to="liker.link"></router-link>
                            <span class="size--13 style--block">
                                {{ liker.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <router-view></router-view>
    </LayoutMain>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapState, mapGetters } from 'vuex';

import store from '../../../store';
import ModalSelectPhotos from '../../includes/modals/ModalSelectPhotos';
import ModalMediaView from '../../includes/modals/ModalMediaView';
import ModalCommunityRoles from '../../includes/modals/ModalCommunityRoles';

export default {
    data() {
        return {
            //petInfoHidden: true,
            aboutFull: false,
            sos: false
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        ...mapState({
            community: state => state.communities.community,
            counters: state => state.communities.counters,
            flags: state => state.communities.flags
        }),
        top_likers() {
            if (!this.community.top_likers) {
                return null;
            }
            return this.community.top_likers.slice(0, 9);
        },
        top_members() {
            if (!this.community.top_members) {
                return null;
            }
            return this.community.top_members.slice(0, 9);
        },
        top_pets() {
             if (!this.community.top_pets) {
                return null;
            }
            return this.community.top_pets.slice(0, 9);
        },
        top_graduates() {
             if (!this.community.top_graduates) {
                return null;
            }
            return this.community.top_graduates.slice(0, 9);
        },
        /*
        ...mapState({
            counters: state => state.counters.counters
        }),
        */
        /*
        profile() {
            return this.$store.state.profiles.profiles.find(p => p.profile.slug == this.$route.params.slug);
        },
        */
        about() {
            if (this.community.about) {
                if (this.community.about.length <= 300 || this.aboutFull) {
                    return this.community.about;
                }
                const substr = this.community.about.substring(0, 300);
                const space = substr.lastIndexOf(' ') || 300;
                return substr.substring(0, space);
            }
        },
        community_site() {
            if (this.community.site.startsWith('http://') ||
                this.community.site.startsWith('https://')) {
                return this.community.site;
            }
            return 'http://' + this.community.site;
        },
        community_site_hostname() {
            return (new URL(this.community_site)).hostname;
        },
        profile_nursery_site() {
            if (!this.community.profile_nursery || !this.community.profile_nursery.site) {
                return 'http://';
            }
            if (this.community.profile_nursery.site.startsWith('http://') ||
                this.community.profile_nursery.site.startsWith('https://')) {
                return this.community.profile_nursery.site;
            }
            return 'http://' + this.community.profile_nursery.site;
        },
        profile_nursery_site_hostname() {
            return (new URL(this.profile_nursery_site)).hostname;
        },
        linked_groups() {
            return this.community.linked_communities.filter(c => c.type == 1);
        },
        linked_nurseries() {
            return this.community.linked_communities.filter(c => c.type == 2);
        },
        linked_pages() {
            return this.community.linked_communities.filter(c => c.type == 3);
        },
        linked_breeds() {
            return this.community.linked_communities.filter(c => c.type == 4);
        },
        linked_breeders() {
            return this.community.linked_users.filter(p => p.type == 1).map(p => p.user);
        },
        linked_pets() {
            return this.community.linked_users.filter(p => p.type == 2).map(p => p.user);
        },
        linked_graduates() {
            return this.community.linked_users.filter(p => p.type == 3).map(p => p.user);
        },
        linked_coowners() {
            return this.community.linked_users.filter(p => p.type == 4).map(p => p.user);
        }
    },
    async beforeRouteEnter(to, from, next) {
        await store.dispatch('COMMUNITY_SHOW', to.params.slug);
        next();
    },
    async beforeRouteUpdate(to, from, next) {
        console.log('FROM ' + from.params.slug + ' TO ' + to.params.slug);
        if (from.params.slug == to.params.slug || this.community.id == from.params.slug) {
            next();
            return;
        }
        await this.$store.dispatch('COMMUNITY_SHOW', to.params.slug);
        $('.cn-sitebar--scrollbar').scrollTop(0);
        next();
    },
    created() {
        this.validateAddress();
    },
    methods: {
        validateAddress() {
            if (!this.$route.path.startsWith(this.community.link)) {
                const parts = this.$route.path.split('/');
                parts.splice(0, 3);
                const parts_link = this.community.link.split('/');
                this.$router.replace(parts_link.concat(parts).join('/'));
            }
        },
        selectAvatar() {
            this.$modal.show(ModalSelectPhotos, {
                owner_id: this.community.id,
                owner_type: 'community',
                section: 2,
                count: 1
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        },
        showPhoto(object) {
            this.$modal.show(ModalMediaView, {
                object,
                object_type: 'photo',
                object_set: this.profile.top_photos
            }, {
                classes: '',
                width: '100%',
                height: '100%',
                maxWidth: 2880,
                adaptive: true
            });
        },
        showRoles() {
            this.$modal.show(ModalCommunityRoles, null, {
                classes: '',
                maxWidth: 800,
                height: 'auto',
                adaptive: true,
                scrollable: true
            });
        }
    },
    watch: {
        community() {
            this.validateAddress();
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
