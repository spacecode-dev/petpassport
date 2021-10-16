<template>
    <LayoutMain white-header hidden-sidebar>
        <div class="cn-shop cn-shop--page">
            <div class="cn-shop--inner">
                <IncludeHeaderShop/>
                <PageShopAnnouncements v-if="shop.type == 1"/>
                <PageShopMoving v-if="shop.type == 2"/>
                <PageShopClinic v-if="shop.type == 3"/>
                <PageShopHotel v-if="shop.type == 4"/>
                <PageShopPhotograph v-if="shop.type == 5"/>
                <PageShopTraining v-if="shop.type == 6"/>
            </div>
        </div>
    </LayoutMain>
</template>

<script>
import NProgress from 'nprogress';
import { mapState } from 'vuex';

import store from '../../../store';

export default {
    computed: {
        ...mapState({
            shop: state => state.shops.shop
        })
    },
    async beforeRouteEnter(to, from, next) {
        NProgress.start();
        await store.dispatch('SHOP_SHOW', to.params.id);
        NProgress.done();
        next();
    }
}
</script>
