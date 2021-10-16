<template>
    <transition name="fade" mode="out-in">
        <div v-if="post" class="card post">
            <div class="card-top media">
                <div class="first">
                    <router-link :to="post.owner.link">
                        <figure class="media-left">
                            <div class="image is-48x48">
                                <img class="is-rounded" :src="getAvatar" alt=""/>
                            </div>
                        </figure>
                    </router-link>
                    <div class="media-content">
                        <div class="content">
                            <div>
                                <router-link :to="post.owner.link">{{ profile.name }}</router-link>
                                <span v-if="announcement">{{ post.owner.gender === 2 ? 'разместила' : 'разместил' + ' объявление' }}</span>
                                <span v-if="post.type === 2">{{ post.owner.gender === 2 ? 'обновила' : 'обновил' + ' аватар ' + getOwnerType }}</span>
                                <span v-if="post.type === 3">{{ post.owner.gender === 2 ? 'обновила' : 'обновил' + ' фото стены ' + getOwnerType }}</span>
                            </div>
                            <div class="globe">
                                <span :title="post.created_at">{{ created_at }}</span>
                                <b-dropdown aria-role="list" v-model="post.privacy" @change="updatePrivacy">
                                    <button slot="trigger" slot-scope="{ active }">
                                        <b-icon v-if="!post.privacy" icon="earth"/>
                                        <b-icon v-if="post.privacy === 1" icon="account-supervisor"/>
                                        <b-icon v-if="post.privacy === 2" icon="lock"/>
                                        <b-icon v-if="owner_self" :icon="active ? 'chevron-up' : 'chevron-down'"/>
                                    </button>
                                    <b-dropdown-item :value="0" :class="{'is-active': !post.privacy}" aria-role="listitem">
                                        <div class="media">
                                            <b-icon class="media-left" icon="earth"/>
                                            <div class="media-content">
                                                <p>Публичный</p>
                                            </div>
                                        </div>
                                    </b-dropdown-item>
                                    <b-dropdown-item :value="1" :class="{'is-active': post.privacy === 1}" aria-role="listitem">
                                        <div class="media">
                                            <b-icon class="media-left" icon="account-supervisor"/>
                                            <div class="media-content">
                                                <p>Друзья</p>
                                            </div>
                                        </div>
                                    </b-dropdown-item>
                                    <b-dropdown-item :value="2" :class="{'is-active': post.privacy === 2}" aria-role="listitem">
                                        <div class="media">
                                            <b-icon class="media-left" icon="lock"/>
                                            <div class="media-content">
                                                <p>Только мне</p>
                                            </div>
                                        </div>
                                    </b-dropdown-item>
                                </b-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second">
                    <b-dropdown aria-role="list" @change="toggleRightChevron">
                        <button slot="trigger" slot-scope="{ active }">
                            <b-icon :icon="active ? 'chevron-up' : 'chevron-down'"></b-icon>
                        </button>
                        <b-dropdown-item v-if="owner_self && post.body" value="edit" aria-role="listitem">Редактировать</b-dropdown-item>
                        <b-dropdown-item v-if="false" aria-role="listitem">Пожаловаться</b-dropdown-item>
                        <b-dropdown-item v-if="owner_self" value="destroy" aria-role="listitem">Удалить</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>
            <div class="card-content">
                <template v-if="editing">
                    <div class="editable">
                        <b-field>
                            <b-input maxlength="500" v-model="edit.body" autofocus type="textarea" :disabled="updating"/>
                        </b-field>
                        <b-button type="is-primary" @click.prevent="update" :disabled="updating" :loading="updating">Сохранить</b-button>
                        <b-button type="is-secondary" @click.prevent="editing = !editing" :disabled="updating" :loading="updating">Отмена</b-button>
                    </div>
                </template>
                <template v-if="!editing">
                    <div v-if="post.body && !videos.length" class="body">
                        <p v-html="post.body" v-linkified/>
                    </div>
                    <!--TODO post.origin-->
                    <div v-if="photos.length === 1" :key="photos[0].id" @click="showPhoto(photos[0])" class="image">
                        <img :src="getUrl(photos[0].original)" alt=""/>
                    </div>
                    <div v-if="photos.length > 1">
                        <b-carousel :indicator-inside="false" :autoplay="false" >
                            <b-carousel-item v-for="photo in photos" :key="photo.id">
                                <span class="image">
                                  <img :src="getUrl(photo.original)" alt="">
                                </span>
                            </b-carousel-item>
                            <template slot="indicators" slot-scope="props">
                                <span class="al image">
                                    <img :src="getUrl(photos[props.i].thumb_180)" alt="">
                                </span>
                            </template>
                        </b-carousel>
                    </div>
                </template>
            </div>
            <footer class="card-footer">
                <div class="card-footer-item">
                    <div class="icons one">
                        <button @click.prevent="toggleLike()">
                            <b-icon icon="heart" :class="{ like: post.liked }"/>
                            {{ post.likes_count }}
                        </button>
                        <button @click.prevent="repost()">
                            <b-icon icon="share"/>
                            {{ post.reposts_count }}
                        </button>
                    </div>
                    <div class="icons two">
                        <button @click.prevent="showComments()">
                            <b-icon icon="message-reply"/>
                            {{ post.comments_count }}
                        </button>
                    </div>
                </div>
            </footer>
            <b-collapse :open="commentsShow" :aria-id="'post-' + post.id + '-comment'" class="comments">
                <PostComments v-if="commentsShow" :object_id="post.id" object_type="post" :first_limit="3" />
            </b-collapse>
        </div>
    </transition>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import * as moment from "moment";
    import PostComments from "./PostComments";
    import axios from "axios";
    import store from "../../../../store"
    import {getToast} from "../../../../util/helper";

    export default {
        props: {
            post: Object
        },
        components: {
            PostComments
        },
        data() {
            return {
                tempChevron: '',
                commentsShow: false,
                created_at: null,
                origin_created_at: null,
                editing: false,
                updating: false,
                edit: {
                    body: null
                },
                photos: [],
                videos: [],
                announcement: null,
                swiper: null
            }
        },
        computed: {
            ...mapState({
                storage: state => state.settings.storage.path,
                wall_id: state => state.profiles.profile.user_id
            }),
            ...mapGetters({
                profile: 'selfProfile'
            }),
            wall_self() {
                return this.wall_id === this.profile.user_id;
            },
            owner_self() {
                return this.post.owner_type === 'profile' && this.post.owner_id === this.profile.user_id;
            },
            getAvatar() {
                return this.storage + this.profile.avatar;
            },
            getOwnerType() {
                if(this.post.owner_type === 'profile') {
                    return 'профиля';
                } else if (post.owner_type === 'community') {
                    return 'сообщества';
                }
            }
        },
        created() {
            for (let attachment of this.post.attachments) {
                switch (attachment.attachment_type) {
                    case 'photo':
                        this.photos.push(attachment.attachment);
                        break;
                    case 'video':
                        this.videos.push(attachment.attachment);
                        break;
                    case 'announcement':
                        this.announcement = attachment.attachment;
                        break;
                }
            }
            // if (this.photos.length) {
            //     this.$root.$on('photo:update', payload => {
            //         let index = this.photos.findIndex(p => p.id === payload.id);
            //         if (index !== -1) {
            //             this.$set(this.photos, index, {
            //                 ...this.photos[index],
            //                 ...payload
            //             });
            //         }
            //     });
            // }
            // if (this.videos.length) {
            //     this.$root.$on('video:update', payload => {
            //         let index = this.videos.findIndex(p => p.id === payload.id);
            //         if (index !== -1) {
            //             this.$set(this.videos, index, {
            //                 ...this.videos[index],
            //                 ...payload
            //             });
            //         }
            //     });
            // }
            this.created_at = moment(this.post.created_at).fromNow();
            setInterval(() => {
                this.created_at = moment(this.post.created_at).fromNow();
            }, 30000);
            if (this.post.origin) {
                this.origin_created_at = moment(this.post.origin.created_at).fromNow();
                setInterval(() => {
                    this.origin_created_at = moment(this.post.origin.created_at).fromNow();
                }, 30000);
            }
            this.edit.body = this.post.body;
        },
        mounted() {

        },
        methods: {
            async toggleLike() {
                const request = {
                    object_id: this.post.id,
                    object_type: 'post'
                };
                if (this.post.liked) {
                    await store.dispatch('DISLIKE', request);
                    store.commit('POSTS_UPDATE', {
                        id: this.post.id,
                        liked: false,
                        likes_count: this.post.likes_count - 1
                    });
                } else {
                    await store.dispatch('LIKE', request);
                    store.commit('POSTS_UPDATE', {
                        id: this.post.id,
                        liked: true,
                        likes_count: this.post.likes_count + 1
                    });
                }
            },
            async repost() {
                if (this.wall_self) {
                    getToast(this, 'danger', 'Невозможно поделиться публикацией с своей же стены.');
                } else if (this.post.reposted) {
                    getToast(this, 'danger', 'Вы уже поделились этой публикацией ранее.');
                } else {
                    this.$buefy.snackbar.open({
                        message: 'Вы действительно хотите поделиться этой публикацией?',
                        type: 'is-success',
                        position: 'is-top',
                        actionText: 'Да',
                        duration: 20000,
                        onAction: async () => {
                            const post = {
                                type: 1,
                                wall_id: this.profile.user_id,
                                wall_type: 'profile',
                                owner_id: this.profile.user_id,
                                owner_type: 'profile',
                                origin_id: this.post.origin_id ? this.post.origin_id : this.post.id
                            };
                            await axios.post('/api/posts', post);
                            store.commit('POSTS_UPDATE', {
                                id: this.post.id,
                                reposted: true,
                                reposts_count: !this.post.origin_id ? (this.post.reposts_count + 1) : this.post.reposts_count
                            });
                            getToast(this, 'success', 'Публикация отправлена на вашу страницу.');
                        }
                    });
                }
            },
            async updatePrivacy(value) {
                await axios.put('/api/posts/' + this.post.id, {privacy: parseInt(value)});
                store.commit('POSTS_UPDATE', {id: this.post.id, privacy: parseInt(value)});
                getToast(this, 'success', 'Видимость публикации успешно изменена.');
            },
            async update() {
                this.updating = true;
                const { body } = this.edit;
                await axios.put('/api/posts/' + this.post.id, {body});
                store.commit('POSTS_UPDATE', {id: this.post.id, body});
                this.editing = false;
                this.updating = false;
            },
            async destroy() {
                this.$buefy.snackbar.open({
                    message: 'Вы действительно хотите удалить эту публикацию?',
                    type: 'is-success',
                    position: 'is-top',
                    actionText: 'Да',
                    duration: 20000,
                    onAction: async () => {
                        await axios.delete('/api/posts/' + this.post.id);
                        store.commit('POSTS_DELETE', this.post.id);
                        getToast(this, 'success', 'Публикация успешно удалена.');
                    }
                });
            },
            toggleRightChevron(value) {
                this.tempChevron = '';
                if(value === 'edit') {
                    this.editing = !this.editing;
                } else if (value === 'destroy') {
                    this.destroy();
                }
            },
            async showComments() {
                this.commentsShow = !this.commentsShow;
            },
            async showPhoto(photo) {
                // this.$modal.show(ModalMediaView, {
                //     object: photo,
                //     object_type: 'photo',
                //     object_set: this.photos
                // }, {
                //     classes: '',
                //     width: '100%',
                //     height: '100%',
                //     maxWidth: 2880,
                //     adaptive: true
                // }, {
                //     'index-changed': index => {
                //         this.swiper.slideTo(index);
                //     }
                // });
            },
            getUrl(img) {
                return location.origin + img;
            }
        }
    }
</script>
