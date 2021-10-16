<template>
    <div ref="card">
        <img v-if="preview" :src="file.image" :key="file.id" alt="">
    </div>
</template>

<script>
    export default {
        props: {
            file: {
                type: Object,
                default: function () {
                    return {name: ''};
                },
                required: true,
            },
            preview: {
                type: Boolean,
                default: false,
                required: false,
            },
        },

        data() {
            return {
                images: []
            }
        },

        methods: {
            closePreview(e) {
                e.preventDefault();
                e.stopPropagation();
            },
        },

        mounted() {
            if (this.preview) {
                this.images.push(this.file.image);
            }
        },
    };
</script>

<style lang="scss" scoped>
    .card {
        border-radius: 0;
        border: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        width: 100%;
        box-shadow: none !important;
        img {
            max-width: 100%;
            max-height: 80vh;
            height: auto;
            width: auto;
        }
    }
</style>
