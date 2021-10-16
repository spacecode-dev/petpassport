<template>
    <div class="dropdown" :class="{ opened }">
        <div class="toggle" @click="opened = !opened">
            <slot name="toggle"></slot>
        </div>
        <div class="content" v-if="opened" @click="contentClick">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            opened: false
        }
    },
    created() {
        document.addEventListener('click', e => {
            if (!e.path.includes(this.$el)) {
                this.opened = false;
            }
        });
    },
    methods: {
        contentClick(e) {
            if (e.target.tagName == 'A' || e.target.tagName == 'LI') {
                this.opened = false;
            }
        }
    },
    watch: {
        '$route': function() {
            this.opened = false;
        }
    }
}
</script>

<style lang="scss" scoped>
.dropdown {
    position: relative;
    display: flex;
    justify-content: center;

    &.dropdown-left {
        justify-content: flex-start;
    }

    &.dropdown-right {
        justify-content: flex-end;    
    }

    &.dropdown-inline {
        display: inline-flex;
    }

    .toggle {
        cursor: pointer;
        user-select: none;
        width: 100%;

        .fa-chevron-down {
            margin-left: .5em;
            transition: all 190ms;
        }
    }

    .content {
        position: absolute;
        top: 100%;
        background: var(--c-white);
        box-shadow: 1px 3px 5px 0 rgba(0, 0, 0, .3);
        border-radius: 5px;
        z-index: 99999;
    }

    &.opened {
        .toggle .fa-chevron-down {
            transform: rotateX(180deg);
        }
    }
}
</style>
