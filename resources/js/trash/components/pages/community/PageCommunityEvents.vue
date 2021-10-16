<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Мероприятия
                <router-link class="btn btn-blue-style btn-wider" :to="community.link + '/events/create'" style="float: right; margin-top: -1em;" v-if="community.user_role == 1">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    Добавить мероприятие
                </router-link>
            </h3>
            <!--
            <ul class="left e-tab--nav add">
                <li>
                    <router-link class="btn btn-blue-style btn-wider" :to="community.link + '/events/create'">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить мероприятие
                    </router-link>
                </li>
            </ul>
            -->
            <div class="e-box e-box--padding" v-for="event in events" :key="event.id">
                <h4 class="weight--600 margin--bottom-10">
                    {{ event.name }}
                </h4>
                <div class="margin--bottom-15 size--13" v-if="event.description">
                    {{ event.description }}
                </div>
                <div class="size--12 c-gray">
                    с {{ event.start_at | datetime }} по {{ event.end_at | datetime }}
                    <span v-if="Date.parse(event.end_at) < Date.now()">
                        (окончено)
                    </span>
                </div>
                <div class="margin--top-15" v-if="community.user_role == 1">
                    <a href="#" @click.prevent="eventDelete(event)">
                        <i class="ico ico--remove"></i>
                        <span class="c-gray size--12">
                            Удалить мероприятие
                        </span>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';
import toastr from 'toastr';

export default {
    data() {
        return {
            events: []
        }
    },
    async created() {
        this.events = (await axios.get('/api/community_events', {
            params: {
                community_id: this.community.id
            }
        })).data;
    },
    computed: {
        ...mapState({
            community: state => state.communities.community,
            counters: state => state.counters.counters
        })
    },
    methods: {
        async eventDelete(event) {
            const confirmed = confirm('Вы действительно хотите удалить это мероприятие?');
            if (!confirmed) {
                return;
            }

            await axios.delete('/api/community_events/' + event.id);

            toastr.success('Мероприятие удалено');

            this.events = this.events.filter(e => e != event);
        }
    }
}
</script>
