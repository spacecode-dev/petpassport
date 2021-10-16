<template>
    <div>
        <form class="e-box e-box--padding" @submit.prevent="add">
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Привязать сообщество
                    </span>
                </div>
                <div>
                    <IncludeInputSearchCommunity v-model="newCommunity" />
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
        <template v-if="groups.length">
            <h4 class="weight--600 e-title--content">
                Группы
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="c in groups" :key="c.id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="c.link" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="c.link">
                                    {{ c.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(c)" :disabled="c.processing">
                            Отвязать группу
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-if="nurseries.length">
            <h4 class="weight--600 e-title--content">
                Питомники
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="c in nurseries" :key="c.id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="c.link" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="c.link">
                                    {{ c.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(c)" :disabled="c.processing">
                            Отвязать питомник
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-if="pages.length">
            <h4 class="weight--600 e-title--content">
                Страницы
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="c in pages" :key="c.id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="c.link" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="c.link">
                                    {{ c.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(c)" :disabled="c.processing">
                            Отвязать страницу
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-if="breeds.length">
            <h4 class="weight--600 e-title--content">
                Страницы породы
            </h4>
            <div class="grid grid--gap grid--three">
                <div class="e-do" v-for="c in breeds" :key="c.id">
                    <div class="e-do--gossip">
                        <div class="e-avatar--65 e-box--padding e-avatar">
                            <router-link class="e-avatar--photo" :to="c.link" :style="{ 'background-image': 'url(\'' + c.avatar + '\')' }"></router-link>
                            <div class="e-avatar--content">
                                <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="c.link">
                                    {{ c.name }}
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="e-do--foot e-box--padding">
                        <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="remove(c)" :disabled="c.processing">
                            Отвязать страницу
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
            communities: [],
            newCommunity: null
        }
    },
    computed: {
        community() {
            return this.$parent.community;
        },
        groups() {
            return this.communities.filter(c => c.type == 1);
        },
        nurseries() {
            return this.communities.filter(c => c.type == 2);
        },
        pages() {
            return this.communities.filter(c => c.type == 3);
        },
        breeds() {
            return this.communities.filter(c => c.type == 4);
        }
    },
    created() {
        if (this.community && this.community.id) {
            this.load();
        }
    },
    watch: {
        community() {
            this.load();
        }
    },
    methods: {
        async load() {
            const { data } = await axios.get('/api/community_communities', {
                params: {
                    community_id: this.community.id
                }
            });

            this.communities = data;
        },
        async add() {
            if (this.community.id == this.newCommunity.id) {
                toastr.error('Невозможно привязать сообщество к самому себе');
                return;
            }

            try {
                await axios.post('/api/community_communities', {
                    community_id: this.community.id,
                    linked_id: this.newCommunity.id
                });
            } catch (e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Невозможно привязать сообщество к самому себе');
                        break;
                    case 2:
                        toastr.error('Данное сообщество уже привязано');
                        break;
                }
                return;
            }

            this.communities.push(this.newCommunity);
            this.newCommunity = null;

            toastr.success('Сообщество привязано');
        },
        async remove(community) {
            const confirmed = confirm('Вы действительно хотите отвязать сообщество "' + community.name + '?');

            if (!confirmed) return;

            await axios.delete('/api/community_communities', {
                data: {
                    community_id: this.community.id,
                    linked_id: community.id
                }
            });

            this.communities = this.communities.filter(c => c != community);

            toastr.success('Сообщество отвязано');
        }
    }
}
</script>
