<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field">
            <div>
                <span class="size--13">
                    Отец
                </span>
            </div>
            <IncludeInputSearchProfile v-model="pedigree.father" :query="{ type: 3, gender: 1 }"/>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Мать
                </span>
            </div>
            <IncludeInputSearchProfile v-model="pedigree.mother" :query="{ type: 3, gender: 2 }"/>
        </div>
        <div class="e-field">
            <div></div>
            <div>
                <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Обновить
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import toastr from 'toastr';

export default {
    data() {
        return {
            processing: false,
            profile: {},
            pedigree: {
                father: null,
                mother: null
            }
        }
    },
    created() {
        this.profile = Object.assign({}, this.$store.getters.selfProfile);
        this.pedigree.father = this.profile.parents.find(p => p.gender == 1);
        this.pedigree.mother = this.profile.parents.find(p => p.gender == 2);
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    methods: {
        async update() {
            this.processing = true;

            const { father, mother } = this.pedigree;

            const parents = [];

            if (father) {
                parents.push(father.user_id);
            }

            if (mother) {
                parents.push(mother.user_id);
            }

            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    parents: parents.join(',')
                });
                toastr.success('Данные родословной обновлены');
            } catch (e) {

            }

            this.processing = false;
        }
    }
}
</script>
