<template>
    <router-link class="market-card" :to="'/market/announcements?category_id=' + category.id">
        <div class="market-card-img" :style="{ 'background-image': 'url(\'' + category.image + '\')' }"></div>
        <div class="market-card-body">
            <div class="market-card-title size--14 weight--600">
                {{ category.name }}
            </div>
            <p class="market-card-desc size--13">
                {{ category.description }}
            </p>
        </div>
    </router-link>
</template>

<script>
export default {
    props: {
        category: Object
    }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/_market-card';

.market-card-title {
    text-transform: uppercase;
}
</style>
