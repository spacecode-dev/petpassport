<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Отзывы
            </h3>
            <div class="e-box e-box--padding" v-for="review in reviews" :key="review.id">
                <IncludeReview :review="review"/>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';

export default {
    data() {
        return {
            reviews: []
        }
    },
    async created() {
        this.reviews = (await axios.get('/api/reviews', {
            params: {
                owner_id: this.profile.user_id,
                owner_type: 'profile'
            }
        })).data;
    },
    computed: {
        ...mapState({
            profile: state => state.profiles.profile
        })
    }
}
</script>
