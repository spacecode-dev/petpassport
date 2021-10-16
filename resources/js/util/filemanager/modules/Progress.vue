<template>
    <div style="margin-top: .5rem;">
        <b-progress v-if="type === 'files'" type="is-primary" size="is-small" />
        <b-progress v-else type="is-primary" size="is-small" />
    </div>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'files',
                required: false,
            }
        }
    };
</script>
