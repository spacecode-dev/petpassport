<template>
    <div class="chat-float">
        <div class="chats">
            <IncludeChat
                v-for="chat in chatsActive"
                :chat="chat"
                :key="chat.recipient_type + '.' + chat.recipient_id"
            />
            <button class="chat-toggle" @click="chatsOpened = !chatsOpened">
                <i class="fa fa-comments" aria-hidden="true"></i>
            </button>
        </div>
        <div class="e-box e-box--padding dialogs" v-if="chatsOpened">
            <div class="e-box--title">
                Диалоги
            </div>
            <ul>
                <li v-for="chat in chats">
                    <div class="e-avatar" @click.prevent="openChat(chat)">
                        <a :href="chat.recipient.link" class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + chat.recipient.avatar + '\')' }" style="position: relative;">
                            <div class="bg-green" style="width: .8em; height: .8em; border-radius: 50%; position: absolute; right: 0px; bottom: 0px;"></div>
                        </a>
                        <div class="e-avatar--content">
                            <a :href="chat.recipient.link" class="e-add--floor" style="margin: 0px;">
                                {{ chat.recipient.name }}
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { Howl, Howler } from 'howler';

import IncludeChat from './IncludeChat';

export default {
    components: {
        IncludeChat
    },
    data() {
        return {
            loaded: false,
            chats: [],
            chatsActive: [],
            chatsOpened: false,
            sound: new Howl({
                src: [
                    '/notification.wav'
                ]
            })
        }
    },
    created() {
        this.$root.$on('chat:open', async (recipient_id, recipient_type, recipient) => {
            if (!this.loaded) {
                await this.loadChats();
            }
            const index = this.chats.findIndex(c => c.recipient_id == recipient_id && c.recipient_type == recipient_type);

            if (index == -1) {
                this.chats.unshift({
                    recipient_id,
                    recipient_type,
                    recipient
                });
                this.openChat(this.chats[0]);
            } else {
                this.openChat(this.chats[index]);
            }
        });
        this.$root.$on('chat:close', chat => {
            this.chatsActive = this.chatsActive.filter(c => c != chat);
        });
        this.$root.$on('echo:message.created', message => {
            const chats_index = this.chats.findIndex(c => c.recipient_id == message.sender_id && c.recipient_type == message.sender_type);

            if (chats_index == -1) {
                const { created_at, updated_at } = message;
                this.chats.unshift({
                    recipient_id: message.sender_id,
                    recipient_type: message.sender_type,
                    recipient: message.sender,
                    created_at,
                    updated_at,
                });
            }

            const index = this.chatsActive.findIndex(c => c.recipient_id == message.sender_id && c.recipient_type == message.sender_type);

            if (index == -1) {
                toastr.info('<img src="' + message.sender.avatar + '" alt="" class="avatar"><a href="' + message.sender.link + '"><b>' + message.sender.name + '</b></a><br>' + message.body, null, {
                    positionClass: 'toast-bottom-left',
                    iconClass: 'toast-user'
                });
            }

            this.sound.play();
        });
    },
    methods: {
        async loadChats() {
            const { data } = await axios.get('/api/conversations');

            this.chats = data;
            this.loaded = true;
        },
        openChat(chat) {
            const index = this.chatsActive.findIndex(c => c.recipient_id == chat.recipient_id && c.recipient_type == chat.recipient_type);

            if (index == -1) {
                this.chatsActive.unshift(chat);
            }

            this.$root.$emit('chat:maximize', chat);
            this.chatsOpened = false;
        }
    },
    watch: {
        chatsOpened() {
            if (this.chatsOpened && !this.chats.length) {
                this.loadChats();
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.chat-float {
    position: fixed;
    right: 30px;
    bottom: 0;
    z-index: 999;
}
.chat-toggle {
    font-size: 24px;
    padding: 0;
    background: #EEE;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    color: var(--c-gray);
    /*border: 1px solid #AAA;*/
    /*border-bottom: none;*/
    /*box-shadow: 0 0 5px rgba(0, 0, 0, .3);*/
    box-shadow: 0 0 5px rgba(19, 38, 56, .5);
    cursor: pointer;
    transition: all 200ms ease-in;
    width: 50px;
    height: 40px;
    text-align: center;

    &:hover {
        background: #CCC;
    }
}
.dialogs {
    position: absolute;
    bottom: 50px;
    right: 0;
    margin: 0;
    width: 250px;
    height: 350px;
    max-height: 75vh;
    box-shadow: 0 0 5px rgba(19, 38, 56, .5);
    overflow: auto;

    ul {
        li + li {
            border-top: 1px solid #DDD;
        }
        .e-avatar {
            padding: .5em 1.2em;
            margin: 0 -1.2em;
            transition: all 200ms ease-in;
            cursor: pointer;

            &:hover {
                background: #EEE;
            }
        }
    }
}
.chats {
    position: absolute;
    bottom: 0;
    right: 0;
    display: flex;
    align-items: flex-end;

    & > * + * {
        margin-left: 10px !important;
    }
}
</style>
