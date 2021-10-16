<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Добавить мероприятие
            </h3>
            <form class="e-box e-box--padding" @submit.prevent="create">
                <div class="e-field">
                    <div>
                        <span class="size--13">Название</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" type="text" required placeholder="Название" v-model="event.name" :disabled="processing">
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">
                            Описание
                        </span>
                    </div>
                    <div>
                        <textarea class="form--control form--control-gray size--13" rows="4" placeholder="Описание" v-model="event.description" :disabled="processing" maxlength="1000"></textarea>
                        <div class="size--12 margin--top-5 color--regent-gray">
                            Осталось символов: {{ 1000 - (event.description ? event.description.length : 0) }}
                        </div>
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">Начало</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13 input-date" type="text" required placeholder="Дата и время начала" v-model="event.start_at" :disabled="processing">
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">Окончание</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13 input-date" type="text" required placeholder="Дата и время окончания" v-model="event.end_at" :disabled="processing">
                    </div>
                </div>
                <div class="e-field">
                    <div></div>
                    <div>
                        <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                            <div class="loader">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </div>
                            Добавить
                        </button>
                    </div>
                </div>
            </form>
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
            processing: false,
            event: {}
        }
    },
    async created() {
    },
    async mounted() {
        $(this.$el).find('.input-date').datepicker({
            minDate: new Date(),
            timepicker: true,
            dateFormat: 'yyyy-mm-dd',
            onSelect(fd, date, inst) {
                inst.el.dispatchEvent(new Event('input', { 'bubbles': true }));
            }
        });
    },
    computed: {
        ...mapState({
            community: state => state.communities.community,
            counters: state => state.counters.counters
        })
    },
    methods: {
        async create() {
            this.processing = true;

            let { start_at, end_at } = this.event;

            start_at += ':00';
            end_at += ':00';

            await axios.post('/api/community_events', {
                community_id: this.community.id,
                ...this.event,
                start_at,
                end_at
            })

            toastr.success('Мероприятие добавлено');

            this.$router.push(this.community.link + '/events');
        }
    }
}
</script>
