<template>
    <div class="content--main">
        <ContentMainLeft/>
        <ContentMainRight/>
    </div>
</template>

<script>
    import ContentMainLeft from '../../includes/content/ContentMainLeft';
    import ContentMainRight from '../../includes/content/ContentMainRight';

    export default {
        components: {
            ContentMainLeft,
            ContentMainRight
        }
    }
</script>
