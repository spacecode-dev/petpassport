<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box">
                <div class="e-avatar--65 e-avatar">
                    <router-link class="e-avatar--photo" :to="'/' + profile.slug" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></router-link>
                    <div class="e-avatar--content">
                        <template v-if="profile.phone">
                            <p class="margin--bottom-5">
                                {{ profile.name }}
                            </p>
                            <a class="size--18 weight--600 color--mirage" :href="'tel:' + profile.phone">
                                {{ profile.phone }}
                            </a>
                        </template>
                        <p v-else>
                            {{ profile.name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-box-gray modal-box">
                <p class="color--black weight--600 margin--bottom-10">
                    Связаться с {{ profile.name }}
                </p>
                <textarea class="form--control form--control-gray form--textarea size--13 margin--bottom-20" rows="4" placeholder="Ваше сообщение" v-model="body"></textarea>
                <button class="btn btn-blue-border-style btn-wider" @click="send">
                    Отправить
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

export default {
    props: {
        profile: Object
    },
    data() {
        return {
            body: null
        }
    },
    mounted() {

    },
    methods: {
        async send() {
            const { data } = await axios.post('/api/messages', {
                recipient_id: this.profile.user_id,
                recipient_type: 'profile',
                body: this.body
            });

            this.$emit('close');
            toastr.success('Ваше сообщение отправлено');
        }
    }
}
</script>
