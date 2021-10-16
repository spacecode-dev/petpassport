<template>
    <div class="e-box mk-post">
        <router-link class="__mk-post--query ann-photo" :to="'/market/announcements/' + announcement.id" :style="{ 'background-image': 'url(\'' + (
            announcement.photo ? announcement.photo.thumb_largest : 'https://via.placeholder.com/290x220/fafafa/818996/?text=%D0%9D%D0%B5%D1%82%20%D1%84%D0%BE%D1%82%D0%BE'
        ) + '\')' }">
        </router-link>
        <div class="mk-post--gage">
            <div class="mk-post--unite">
                <router-link class="mk-post--be" :to="'/market/announcements/' + announcement.id">
                    {{ announcement.title }}
                </router-link>
                <p class="mk-post--cry">
                    {{ announcement.description }}
                </p>
                <div class="margin--top-30 size--12 color--regent-gray">
                    <div class="margin--top-10" v-if="announcement.colored">
                        <i class="fas fa-fw fa-paint-roller color--daisy-bush"" aria-hidden="true"></i>
                        Выделено цветом на {{ colored_until }}
                    </div>
                    <div class="margin--top-10" v-if="announcement.pinned">
                        <i class="fas fa-fw fa-thumbtack color--daisy-bush"" aria-hidden="true"></i>
                        Закреплено вверху на {{ pinned_until }}
                    </div>
                </div>
            </div>
            <div class="mk-post--lead">
                <div>
                    <span class="color--black size--16 weight--700">
                        {{ announcement.price }}
                    </span>
                    <span class="color--black size--12 weight--700">
                        <template v-if="announcement.currency == 1">₽</template>
                        <template v-if="announcement.currency == 2">$</template>
                        <template v-if="announcement.currency == 3">€</template>
                    </span>
                    <!--<span class="size--13">/ за единицу</span>-->
                </div>
                <div class="mk-post--utter">
                    <template v-if="reason == 'self'">
                        <router-link :to="'/settings/announcements/' + announcement.id + '/edit'">
                            <i class="ico ico--edit"></i>
                            <span class="c-gray size--12">
                                Редактировать
                            </span>
                        </router-link>
                        <a href="#" @click.prevent="announcementDelete">
                            <i class="ico ico--remove"></i>
                            <span class="c-gray size--12">
                                Удалить
                            </span>
                        </a>
                    </template>
                    <template v-if="reason == 'liked'">
                        <a href="#" @click.prevent="dislike">
                            <i class="ico ico--remove"></i>
                            <span class="c-gray size--12">
                                Удалить из избранных
                            </span>
                        </a>
                    </template>
                </div>
            </div>
            <a class="btn mk-post--motto" href="" v-if="reason == 'self'">Продвижение</a>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import * as moment from 'moment';
import 'moment/locale/ru';

export default {
    props: {
        announcement: Object,
        reason: String
    },
    computed: {
        colored_until() {
            return moment(this.announcement.colored_until).fromNow(true);
        },
        pinned_until() {
            return moment(this.announcement.pinned_until).fromNow(true);
        }
    },
    methods: {
        async announcementDelete() {
            const confirmed = confirm('Вы действительно хотите удалить это объявление?');
            if (!confirmed) {
                return;
            }
            await axios.delete('/api/user/announcements/' + this.announcement.id);
            this.$parent.$emit('announcement:delete', this.announcement.id);
            toastr.success('Объявление успешно удалено', 'Объявление удалено');
        },
        async dislike() {
            const confirmed = confirm('Вы действительно хотите удалить это объявление из списка избранных?');
            if (!confirmed) {
                return;
            }
            await axios.delete('/api/announcements/' + this.announcement.id + '/like');
            this.$parent.$emit('announcement:delete', this.announcement.id);
            toastr.success('Объявление успешно удалено', 'Объявление удалено');
        }
    }
}
</script>

<style lang="scss" scoped>
.ann-photo {
    width: 290px;
    height: 220px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fafafa;
    background-size: cover;
    background-position: center center;
}
</style>
