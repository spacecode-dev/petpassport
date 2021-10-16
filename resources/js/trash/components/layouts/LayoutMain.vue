<template>
    <div>
        <div class="wrap"></div>
        <div class="body" :class="{ 'sidebar-colapse': (hiddenSidebar || withoutSidebar) }">
            <section class="section h-layer">
                <div class="h-layer--top">
                    <IncludeHeader :class="{ 'h-top--white': whiteHeader }" :without-sidebar="withoutSidebar" />
                    <IncludeHeaderMobile/>
                </div>
                <slot name="header"></slot>
            </section>
            <slot></slot>
            <IncludeFooter/>
            <div class="cn-sitebar" v-if="!withoutSidebar">
                <div class="scrollbar-box scrollbar-inner cn-sitebar--scrollbar">
                    <div>
                        <slot name="sidebar-header"></slot>
                        <div class="cn-sitebar--content">
                            <slot name="sidebar-content"></slot>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cn-sitebar--background" v-if="!withoutSidebar"></div>
        </div>
    </div>
</template>

<script>
import IncludeHeader from '../includes/IncludeHeader';
import IncludeHeaderMobile from '../includes/IncludeHeaderMobile';
import IncludeFooter from '../includes/IncludeFooter';

export default {
    props: {
        whiteHeader: Boolean,
        hiddenSidebar: Boolean,
        withoutSidebar: Boolean
    },
    components: {
        IncludeHeader,
        IncludeHeaderMobile,
        IncludeFooter
    },
    mounted() {
        $(this.$el).find('.cn-sitebar--scrollbar').scrollbar();
        $(this.$el).find('.cn-sitebar select').niceSelect();
    },
    methods: {

    }
}
</script>
