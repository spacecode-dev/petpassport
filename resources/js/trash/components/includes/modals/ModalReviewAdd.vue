<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box">
                <div class="e-avatar--65 e-avatar">
                    <router-link class="e-avatar--photo" :to="owner.link" :style="{ 'background-image': 'url(\'' + owner.avatar + '\')' }"></router-link>
                    <div class="e-avatar--content">
                        <template v-if="owner.phone">
                            <p class="margin--bottom-5">
                                {{ owner.name }}
                            </p>
                            <p class="color--regent-gray size--13 margin--bottom-5">
                                на сервисе с {{ owner_created_at }}
                            </p>
                            <span class="size--13">
                                Рейтинг:
                            </span>
                            <span class="color--daisy-bush size--13">
                                {{ owner.rating }}
                            </span>
                            <!--
                            <a class="size--18 weight--600 color--mirage" :href="'tel:' + profile.phone">
                                {{ profile.phone }}
                            </a>
                            -->
                        </template>
                        <p v-else>
                            {{ owner.name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-box-gray modal-box">
                <p class="color--black weight--600 margin--bottom-10">
                    Ваш отзыв о {{ owner.name }}
                </p>
                <textarea class="form--control form--control-gray form--textarea size--13 margin--bottom-20" rows="4" placeholder="Ваш отзыв" v-model="review.body"></textarea>
                <p class="color--black weight--600 margin--bottom-10">
                    Ваша оценка
                </p>
                <div class="margin--bottom-20">
                    <IncludeStars input @changed="starsChanged"/>
                </div>
                <button class="btn btn-blue-border-style btn-wider" @click="store">
                    Отправить
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import * as moment from 'moment';
import 'moment/locale/ru';
import { mapGetters } from 'vuex';

export default {
    props: {
        owner: Object,
        owner_id: Number,
        owner_type: String
    },
    computed: {
        ...mapGetters({
            profile_self: 'selfProfile'
        }),
        owner_created_at() {
            return moment(this.owner.created_at).format('MMM YYYY');
        }
    },
    data() {
        return {
            review: {
                body: null,
                stars: null
            }
        }
    },
    mounted() {

    },
    methods: {
        starsChanged(stars) {
            this.review.stars = stars;
        },
        async store() {
            try {
                const { owner_id, owner_type } = this;
                const response = (await axios.post('/api/reviews', {
                    owner_id,
                    owner_type,
                    ...this.review
                })).data;

                response.user = this.profile_self;

                this.$parent.$emit('review-stored', response);
                this.$emit('close');

                toastr.success('Отзыв успешно размещен', 'Отзыв размещен');
            } catch (e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Невозможно добавить отзыв самому себе');
                        break;
                    case 2:
                        toastr.error('Вы не поставили оценку');
                        break;
                    case 3:
                        let msg = 'Вы уже оставляли отзыв для этого ';
                        if (this.owner_type == 'profile') {
                            msg += 'пользователя';
                        }
                        if (this.owner_type == 'shop') {
                            msg += 'магазина';
                        }
                        toastr.error(msg);
                        break;
                    default:
                        toastr.error('Произошла ошибка при добавлении отзыва');
                }
            }
        }
    }
}
</script>
