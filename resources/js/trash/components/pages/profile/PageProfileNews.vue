<template>
    <div class="cn-main">
        <div class="cn-main--left">

        </div>
        <div class="cn-main--content">
            <div class="row cn-main--inner">
                <div class="col-xl-6 __cn-main--body">
                    <IncludePosts :request="postsRequest">
                        <template v-slot:title>
                            Последние новости
                        </template>
                    </IncludePosts>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

import IncludePosts from '../../includes/IncludePosts';

export default {
    components: {
        IncludePosts
    },
    data() {
        return {
            postsRequest: {
                reason: 'news'
            }
            //posting: false,
            /*
            post: {
                body: null,
                type: 1,
                wall_type: 1,
                owner_type: 1
            },
            */
        }
    },
    computed: {
        ...mapState({
            profile: state => state.profiles.profile
        })/*,
        sos() {
            return this.$parent.$parent.sos;
        }*/
    },
    created() {

    },
    mounted() {
        //$(this.$el).find('select').niceSelect();
    },
    watch: {
        /*
        sos() {
            if (this.sos) {
                this.$nextTick(() => {
                    $(this.$el).find('textarea')[0].focus();
                });
            }
        }
        */
    },
    methods: {
        
    }
}
</script>

