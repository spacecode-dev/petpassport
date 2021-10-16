<template>
    <div class="e-box--padding comment">
        <div class="e-avatar">
            <router-link class="e-avatar--photo" :to="comment.owner.link" :style="{ 'background-image': 'url(\'' + comment.owner.avatar + '\')' }"></router-link>
            <div class="e-avatar--content">
                <router-link class="e-article--floor" :to="comment.owner.link">
                    {{ comment.owner.name }}
                </router-link>
                <p class="comment-body size--14">{{ comment.body }}</p>
                <div class="e-article--utter">
                    <span class="e-article--exile" :title="comment.created_at">
                        {{ created_at }}
                    </span>
                    <a class="e-bwn--like e-bwn" :class="{ like: comment.liked }" href="#" @click.prevent="toggleLike">
                        <span class="e-bwn--faith">
                            {{ comment.likes_count }}
                        </span>
                    </a>
                </div>
            </div>
            <IncludeDropdown class="dropdown-right">
                <template v-slot:toggle>
                    <div class="btn btn-round size--13 __btn-boder btn-more c-gray">
                        <i class="fa fa-chevron-down m-0" aria-hidden="true"></i>
                    </div>
                </template>
                <ul class="dropdown-menu-custom separated" style="text-align: left;">
                    <li v-if="false">
                        <a href="#">
                            <i class="fa fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Редактировать
                        </a>
                    </li>
                    <li v-if="false">
                        <a href="#">
                            <i class="fa fa-fw fa-flag" aria-hidden="true"></i>
                            Пожаловаться
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="destroy" v-if="owner_self">
                            <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
                            Удалить
                        </a>
                    </li>
                </ul>
            </IncludeDropdown>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import * as moment from 'moment';
import 'moment/locale/ru';
import toastr from 'toastr';
import { mapGetters, mapActions } from 'vuex';

export default {
    props: {
        comment: Object
    },
    data() {
        return {
            likeProcessing: false,
            created_at: null
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        owner_self() {
            return this.comment.owner_type == 'profile' && this.comment.owner_id == this.profile.user_id;
        }
    },
    created() {
        this.created_at = moment(this.comment.created_at).fromNow();
        setInterval(() => {
            this.created_at = moment(this.comment.created_at).fromNow();
        }, 30000);
    },
    methods: {
        ...mapActions([
            'LIKE',
            'DISLIKE',
            'COMMENTS_DELETE'
        ]),
        async toggleLike() {
            if (this.likeProcessing) return;
            this.likeProcessing = true;

            const request = {
                object_id: this.comment.id,
                object_type: 'comment'
            };

            if (this.comment.liked) {
                await this.DISLIKE(request);
                this.comment.likes_count--;
                this.comment.liked = false;
            } else {
                await this.LIKE(request);
                this.comment.likes_count++;
                this.comment.liked = true;
            }

            this.likeProcessing = false;
        },
        async destroy() {
            const confirmed = confirm('Вы действительно хотите удалить этот комментарий?');

            if (!confirmed) return;

            await this.COMMENTS_DELETE(this.comment.id);

            this.$parent.$emit('comment:delete', this.comment.id);

            toastr.success('Комментарий успешно удален');
        },
    }
}
</script>

<style lang="scss" scoped>
.comment {
    border-bottom: 1px solid #E6E9EE;

    &:last-child {
        border-bottom: none;
    }

    .e-avatar {
        align-items: flex-start;
    }

    .e-avatar--content {
        flex-direction: column;
        flex: 1;

        .comment-body {
            white-space: pre-wrap;
            line-height: 1.38;
            margin: .3em 0 .1em;
        }

        .e-bwn--like {
            margin-left: .3em;
            background-size: 55%;
            padding-left: 1.3em;

            .e-bwn--faith {
                font-size: .75em;
            }
        }
    }
}
</style>
