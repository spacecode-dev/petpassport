<template>
    <div class="content--main">
        <ContentMainLeft/>
        <ContentPhotosRight/>
    </div>
</template>

<script>
    import ContentMainLeft from '../../includes/content/ContentMainLeft';
    import ContentPhotosRight from '../../includes/content/ContentPhotosRight';

    export default {
        components: {
            ContentMainLeft,
            ContentPhotosRight
        }
    }
</script>
