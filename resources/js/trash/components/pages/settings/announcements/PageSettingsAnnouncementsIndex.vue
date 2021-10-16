<template>
    <div>
        <div class="grid grid--gap grid--num margin--bottom-20">
            <div class="mk-num">
                <div class="margin--bottom-10">
                    <span class="color--daisy-bush size--48 weight--700 mk-num--amout">
                        {{ counters.views_today }}
                    </span>
                </div>
                <div>
                    <span class="size--14">
                        Посещений сегодня
                    </span>
                </div>
            </div>
            <div class="mk-num">
                <div class="margin--bottom-10">
                    <span class="color--daisy-bush size--48 weight--700 mk-num--amout">
                        {{ counters.views }}
                    </span>
                </div>
                <div>
                    <span class="size--14">
                        Всего посещений
                    </span>
                </div>
            </div>
            <div class="mk-num" style="opacity: .2;">
                <div class="margin--bottom-10">
                    <span class="color--daisy-bush size--48 weight--700 mk-num--amout">
                        0
                    </span>
                </div>
                <div>
                    <span class="size--14">
                        Заказов
                    </span>
                </div>
            </div>
            <div class="mk-num" style="opacity: .2;">
                <div class="margin--bottom-10">
                    <span class="color--daisy-bush size--48 weight--700 mk-num--amout">
                        0
                    </span>
                    <span class="mk-num--percent">
                        %
                    </span>
                </div>
                <div>
                    <span class="size--14">
                        Видимость профиля
                    </span>
                </div>
            </div>
        </div>
        <div class="e-box e-box--padding mk-filter" style="opacity: .2;">
            <div>
                <span class="color--daisy-bush size--13">
                    Все объявления
                </span>
                <i class="blue light medium prefab--arrow-down"></i>
            </div>
            <div class="mdrop--wrap mdrop--toggle">
                <span class="size--13">
                    Сортировать по:
                </span>
                <span class="color--daisy-bush size--13">
                    дате
                </span>
                <i class="blue light medium prefab--arrow-down"></i>
                <div class="mdrop mdrop--align-right">
                    <div>
                        <ul class="style--uppercase">
                            <li><a class="active" href="">Выбрать</a></li>
                            <li><a href="">Выбрать</a></li>
                            <li><a href="">Выбрать</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mdrop--wrap mdrop--toggle">
                <span class="size--13">
                    Показать по:
                </span>
                <span class="color--daisy-bush size--13">
                    16
                </span>
                <i class="blue light medium prefab--arrow-down"></i>
                <div class="mdrop mdrop--align-right">
                    <div>
                        <ul class="style--uppercase">
                            <li><a class="active" href="">Выбрать</a></li>
                            <li><a href="">Выбрать</a></li>
                            <li><a href="">Выбрать</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <IncludeSettingsAnnouncement v-for="announcement in announcements" :key="announcement.id" :announcement="announcement" reason="self"/>
    </div>
</template>

<script>
import axios from 'axios';
import NProgress from 'nprogress';
import IncludeSettingsAnnouncement from '../../../includes/IncludeSettingsAnnouncement';

export default {
    components: {
        IncludeSettingsAnnouncement
    },
    data() {
        return {
            announcements: [],
            counters: {}
        }
    },
    created() {
        this.$on('announcement:delete', id => {
            this.announcements = this.announcements.filter(a => a.id != id);
        });
    },
    async beforeRouteEnter(to, from, next) {
        NProgress.start();
        const data = (await axios.get('/api/user/announcements', {
            params: {
                shop_id: to.query.shop_id
            }
        })).data;
        NProgress.done();
        next(vm => {        
            // TODO: mass assign
            vm.announcements = data.announcements;
            vm.counters = data.counters;
        });
    }
}
</script>
