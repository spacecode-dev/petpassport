<template>
    <div>
        <div class="grid grid--gap grid--four">
            <IncludeAnnouncement
                v-for="announcement in announcements"
                :key="announcement.id"
                :announcement="announcement"
            />
        </div>
        <a class="e-box e-box--padding style--center btn-block e-mo" :disabled="loading" @click="load" v-if="hasMore">
            <i class="ico ico--reload" :class="{ 'fa-spin': loading }"></i>
            <span class="size--13 color--mirage">
                Показать еще
            </span>
        </a>
    </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';

export default {
    data() {
        return {
            loading: false,
            announcements: [],
            total: 0
        }
    },
    computed: {
        ...mapState({
            profile: state => state.profiles.profile
        }),
        hasMore() {
            return this.announcements.length < this.total;
        }
    },
    async created() {
        this.load();
    },
    methods: {
        async load() {
            this.loading = true;

            const data = (await axios.get('/api/announcements', {
                params: {
                    reason: 'owner',
                    owner_id: this.profile.user_id,
                    owner_type: 'profile',
                    offset: this.announcements.length
                }
            })).data;

            this.announcements = this.announcements.concat(data.announcements);
            this.total = data.total;

            this.loading = false;
        }
    },
    watch: {
        profile() {
            this.announcements = [];
            this.load();
        }
    }
}
</script>
