<template>
    <div class="cd-review">
        <div class="e-avatar">
            <router-link class="e-avatar--photo" :to="review.user.link" :style="{ 'background-image': 'url(\'' + review.user.avatar + '\')' }"></router-link>
            <div class="e-avatar--content" style="padding-left: .8em;">
                <router-link class="d-block color--regent-gray size--13 margin--bottom-5" :to="review.user.link">
                    {{ review.user.name }}
                </router-link>
                <IncludeStars :value="review.stars"/>
            </div>
        </div>
        <!--
        <div class="e-icow e-icow--bigger">
            <div class="e-icow--refer">
                <i class="ico--user ico"></i>
            </div>
            <div class="e-icow--note">
                <p class="color--regent-gray size--13 margin--bottom-5">
                    {{ review.owner.name }}
                </p>
                <IncludeStars :value="review.stars"/>
            </div>
        </div>
        -->
        <div class="cd-review--body">
            <p class="size--14">
                {{ review.body }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        review: Object
    }
}
</script>

<style lang="scss" scoped>
.cd-review {
    margin-right: 1em; /* for scrollbar */
}
</style>
