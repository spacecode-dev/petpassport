<template>
    <div class="card messages">
        <div class="card-content">
            <div class="content">
                <div class="text">
                    <img :src="getAvatar" alt=""/>
                    <b-field>
                        <b-input maxlength="500" v-model="post.body" type="textarea" :placeholder="'Что нового, ' + profile.name + '?'"/>
                    </b-field>
                </div>
                <div class="photos" v-if="photos.length">
                    <figure v-for="photo in photos" class="image is-48x48">
                        <button @click="removePhotoFormArray(photo.id)">
                            <b-icon icon="close"/>
                        </button>
                        <img :src="photo.path" alt=""/>
                    </figure>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="card-footer-item">
                <div class="icons">
                    <button @click.prevent="toggleFilemanagerModal()">
                        <b-icon icon="camera-plus"/>
                    </button>
                    <button @click.prevent="toggleEmoji()">
                        <b-icon icon="emoticon"/>
                    </button>
                    <VEmojiPicker @select="selectEmoji" :class="{show: post.showEmoji}" :showSearch="false" />
                </div>
                <div class="buttons">
                    <b-field>
                        <b-select v-model="post.type">
                            <option value="1" :selected="1 === post.type">Публичный</option>
                            <option value="2" :selected="2 === post.type">Только мне</option>
                            <option value="3" :selected="3 === post.type">Друзья</option>
                        </b-select>
                    </b-field>
                    <b-button type="is-primary" :loading="posting" :disabled="posting" @click.prevent="publish">Опубликовать</b-button>
                </div>
            </div>
        </footer>
        <modalFileManager :userId="profile.user_id"/>
    </div>
</template>

<script>
    import axios from "axios";
    import store from "../../../../store";
    import EventBus from "../../../../util/event-bus";
    import {mapGetters, mapState} from "vuex";
    import modalFileManager from "../../../../util/filemanager/components/ModalFileManager";
    import VEmojiPicker from "v-emoji-picker";

    export default {
        data() {
            return {
                posting: false,
                post: {
                    body: null,
                    type: 1,
                    owner_type: 'profile',
                    privacy: 0,
                    showEmoji: false
                }
            }
        },
        components: {
            VEmojiPicker,
            modalFileManager
        },
        computed: {
            ...mapGetters({
                profile: 'selfProfile'
            }),
            ...mapState({
                storage: state => state.settings.storage.path,
                showModal: state => state.settings.filemanager.showModal,
                photos: state => state.settings.filemanager.selectedFiles
            }),
            getAvatar() {
                return this.storage + this.profile.avatar;
            }
        },
        methods: {
            async publish() {
                this.posting = true;
                const data = this.post;
                data.wall_id = this.profile.user_id.toString();
                data.wall_type = 'profile';
                data.owner_id = this.profile.user_id;
                // data.sos = + this.sos;
                data.photos = this.photos;
                const post = (await axios.post('/api/posts', data)).data;
                post.owner = this.profile;
                post.likes_count = 0;
                post.liked = false;
                post.reposts_count = 0;
                post.reposted = false;

                // post.sos = this.sos;

                store.commit('POSTS_UNSHIFT', post);
                this.post.body = null;
                this.removePhotoFormArray(null);
                this.posting = false;
            },
            toggleFilemanagerModal() {
                store.dispatch('MODAL_FILEMANAGER_TOGGLE');
            },
            toggleEmoji() {
                this.post.showEmoji = !this.post.showEmoji;
            },
            selectEmoji(emoji) {
                this.post.body = this.post.body.concat(emoji.data);
            },
            removePhotoFormArray(id) {
                if(!id || this.photos.length < 2) {
                    store.dispatch('MODAL_FILEMANAGER_CLEAR_SELECTED');
                    EventBus.$emit('removeSelectedInModal', []);
                } else {
                    let array = this.photos.filter(x => {
                        return x.id !== id;
                    });
                    store.dispatch('MODAL_FILEMANAGER_PUT_SELECTED', array);
                    EventBus.$emit('removeSelectedInModal', array);
                }
            }
        }
    }
</script>
