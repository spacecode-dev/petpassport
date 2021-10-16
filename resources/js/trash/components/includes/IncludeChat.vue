<template>
    <div class="e-box chat" :class="{ minimized }">
        <div class="chat-title">
            <div class="e-avatar" @click.prevent="minimized = false">
                <a :href="chat.recipient.link" class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + chat.recipient.avatar + '\')' }" style="position: relative;">
                    <div class="bg-green" style="width: .5em; height: .5em; border-radius: 50%; position: absolute; right: 0px; bottom: 0px;"></div>
                </a>
                <div class="e-avatar--content">
                    <a :href="chat.recipient.link" class="e-box--title" style="margin: 0px;">
                        {{ chat.recipient.name }}
                    </a>
                </div>
            </div>
            <div class="chat-acts">
                <i class="fa fa-fw fa-chevron-down" aria-hidden="true" @click="minimized = true"></i>
                <i class="fa fa-fw fa-times" aria-hidden="true" @click="$root.$emit('chat:close', chat)"></i>
            </div>
        </div>
        <div class="chat-messages">
            <div class="chat-load-more size--13" v-if="messages.length < total" @click="loadMessages">
                Загрузить предыдущие
            </div>
            <IncludeChatMessage
                v-for="message in messages"
                :message="message"
                :key="message.id"
            />
        </div>
        <textarea class="chat-input size--13" v-model="body" rows="1" placeholder="Введите сообщение..." @keydown.enter.prevent="sendMessage"></textarea> 
    </div>
</template>

<script>
import toastr from 'toastr';
import axios from 'axios';

import IncludeChatMessage from './IncludeChatMessage';

export default {
    components: {
        IncludeChatMessage
    },
    props: {
        chat: Object
    },
    data() {
        return {
            minimized: false,
            messages: [],
            total: 0,
            body: null
        }
    },
    async created() {
        this.$root.$on('chat:maximize', chat => {
            if (this.chat == chat) {
                this.minimized = false;
            }
        });

        this.$root.$on('echo:message.created', message => {
            if (message.sender_id != this.chat.recipient_id || message.sender_type != this.chat.recipient_type) return;

            if (this.minimized) {
                toastr.info('<img src="' + message.sender.avatar + '" alt="" class="avatar"><a href="' + message.sender.link + '"><b>' + message.sender.name + '</b></a><br>' + message.body, null, {
                    positionClass: 'toast-bottom-left',
                    iconClass: 'toast-user'
                });
            }
            this.messages.push(message);
            this.total++;
            this.$nextTick(() => this.scrollBottom());
        });

        await this.loadMessages();
        this.$nextTick(() => this.scrollBottom());
    },
    methods: {
        async loadMessages() {
            const { recipient_id, recipient_type } = this.chat;
            const { data } = await axios.get('/api/messages', {
                params: {
                    recipient_id,
                    recipient_type,
                    offset: this.messages.length,
                    //limit: 2
                }
            });
            this.messages = data.messages.reverse().concat(this.messages);
            this.total = data.total;
        },
        async sendMessage() {
            const { body } = this;
            const { recipient_id, recipient_type } = this.chat;

            this.body = null;

            const { data } = await axios.post('/api/messages', {
                recipient_id,
                recipient_type,
                body
            });

            this.messages.push(data);

            this.$nextTick(() => this.scrollBottom());
        },
        scrollBottom() {
            const $s = $(this.$el).find('.chat-messages').last();
            $s.scrollTop($s[0].scrollHeight);
        }
    }
}
</script>

<style lang="scss" scoped>
.chat {
    margin: 0;
    width: 250px;
    height: 350px;
    max-height: 75vh;
    box-shadow: 0 0 5px rgba(19, 38, 56, .5);
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;

    .chat-title {
        padding: 1em 1.2em;
        display: flex;
        align-items: center;
        justify-content: space-between;

        .e-avatar--photo {
            width: 1.5em;
            height: 1.5em;
        }
        .fa {
            cursor: pointer;
            opacity: .5;
            transition: all 200ms ease-in;

            &:hover {
                opacity: 1;
            }
        }
    }

    &.minimized {
        width: 50px;
        height: 40px;
        overflow: hidden;
        padding: 0;
        cursor: pointer;

        .chat-title {
            padding: 0;
        }

        &:hover {
            background: #EEE;
        }

        .e-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 40px;
        }
        .e-avatar--content,
        .fa {
            display: none;
        }
    }
}
.e-box--title {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 100px;
    display: inline-block;
}
.chat-messages {
    padding: 0 1.2em .5em;
    flex: 1;
    overflow: auto;
}
.chat-input {
    border: none;
    border-top: 1px solid #DDD;
    width: 100%;
    min-height: 40px;
    padding: .8em 1.2em;
}
.chat-load-more {
    cursor: pointer;
    color: var(--c-gray);
    text-align: center;
    padding: .5em 0;
}
</style>
