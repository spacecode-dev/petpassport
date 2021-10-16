<template>
    <div>
        <router-view></router-view>
        <IncludeChatContainer/>
    </div>
</template>

<script>
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
     broadcaster: 'pusher',
     key: process.env.MIX_PUSHER_APP_KEY,
     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
     encrypted: true
});

import { mapGetters } from 'vuex';
import toastr from 'toastr';
import { Howl, Howler } from 'howler';

import IncludeChatContainer from './components/includes/IncludeChatContainer';

export default {
    components: {
        IncludeChatContainer
    },
    data() {
        return {
            sound: new Howl({
                src: [
                    '/notification.wav'
                ]
            })
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        })
    },
    created() {
        this.bindChannels();

        const vm = this;

        $(document).on('click', '.toast a', function(e) {
            e.preventDefault();
            vm.$router.push($(this).attr('href'));
        });
    },
    methods: {
        bindChannels() {
            if (this.profile.user_id) {
                window.Echo.private('user.' + this.profile.user_id)
                    .listen('.friendship.received', e => {
                        this.$root.$emit('echo:friendship.received', e);
                        toastr.info('<img src="' + e.user.avatar + '" alt="" class="avatar"><a href="' + e.user.link + '"><b>' + e.user.name + '</b></a> хочет добавить Вас в друзья', null, {
                            positionClass: 'toast-bottom-left',
                            /*
                            hideDuration: false,
                            closeOnHover: false,
                            timeOut: 0,
                            extendedTimeOut: 0,
                            */
                            iconClass: 'toast-user'
                        });
                        this.sound.play();
                    })
                    .listen('.friendship.accepted', e => {
                        this.$root.$emit('echo:friendship.accepted', e);
                        toastr.info('<img src="' + e.user.avatar + '" alt="" class="avatar"><a href="' + e.user.link + '"><b>' + e.user.name + '</b></a> принял Вашу заявку в друзья', null, {
                            positionClass: 'toast-bottom-left',
                            iconClass: 'toast-user'
                        });
                        this.sound.play();
                    })
                    .listen('.like.created', e => {
                        this.$root.$emit('echo:like.created', e);
                        let object = '';
                        if (e.object_type == 'post') {
                            object = 'Вашей публикации';
                        }
                        if (e.object_type == 'photo') {
                            object = 'Вашей фотографии';
                        }
                        if (e.object_type == 'video') {
                            object = 'Вашему видео';
                        }

                        toastr.info('<img src="' + e.user.avatar + '" alt="" class="avatar"><a href="' + e.user.link + '"><b>' + e.user.name + '</b></a> поставил отметку "нравится" ' + object, null, {
                            positionClass: 'toast-bottom-left',
                            iconClass: 'toast-user'
                        });
                        this.sound.play();
                    })
                    .listen('.message.created', e => {
                        this.$root.$emit('echo:message.created', e.message);
                    });
            }
        }
    },
    watch: {
        'profile.user_id': function() {
            this.bindChannels();
        }
    }
}
</script>

<style lang="scss">
.toast-user {
    background: var(--c-white);
    opacity: 1;
    border-left: 5px solid var(--c-violet);

    .toast-message {
        color: var(--c-black);

        a {
            color: var(--c-violet);
        }
    }

    .avatar {
        position: absolute;
        left: 10px;
        top: 50%;
        width: 30px;
        height: 30px;
        margin-top: -15px;
        border-radius: 50%;
        box-shadow: 0 0 3px 0 rgba(0, 0, 0, .5);
    }
}
</style>
