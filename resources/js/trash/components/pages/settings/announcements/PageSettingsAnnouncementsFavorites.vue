<template>
    <div>
        <IncludeSettingsAnnouncement v-for="announcement in announcements" :key="announcement.id" :announcement="announcement" reason="liked"/>
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
            announcements: []
        }
    },
    created() {
        this.$on('announcement:delete', id => {
            this.announcements = this.announcements.filter(a => a.id != id);
        });
    },
    async beforeRouteEnter(to, from, next) {
        NProgress.start();
        const data = (await axios.get('/api/announcements?reason=liked')).data;
        NProgress.done();
        next(vm => {        
            // TODO: mass assign
            vm.announcements = data;
        });
    }
}
</script>
