<template>
    <div class="video-container">
        <div class="video" v-if="video.source_type == 0">
            <video style="width: 100%; height: 100%;" :src="video.source" :poster="video.thumbnail">
                <source :src="video.source" type="video/mp4">
            </video>
        </div>
        <div class="video" v-if="video.source_type == 1">
            <!--
            <video style="width: 100%; height: 100%;" :poster="video.thumbnail">
                <source :src="'https://youtube.com/watch?v=' + video.source" type="video/youtube">
            </video>
            -->
            <iframe :src="'https://www.youtube.com/embed/' + video.source" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="video" v-if="video.source_type == 2">
            <!--
            <video style="width: 100%; height: 100%;" :poster="video.thumbnail">
                <source :src="'http://vimeo.com/' + video.source" type="video/vimeo">
            </video>
            -->
            <iframe :src="'https://player.vimeo.com/video/' + video.source /*+ '?color=4D23B3'*/" allow="autoplay; fullscreen" allowfullscreen></iframe>
        </div>
    </div>
</template>

<script>
import 'mediaelement';
import 'mediaelement/build/mediaelementplayer.min.css';

export default {
    props: {
        video: Object
    },
    data() {
        return {
            player: null
        }
    },
    created() {
        this.$emit('x-created');
    },
    mounted() {
        const video = this.$el.querySelector('video');
        if (video) {
            const { MediaElementPlayer } = global;

            this.player = new MediaElementPlayer(video, {
                //pluginPath: "/path/to/shims/",
                // When using `MediaElementPlayer`, an `instance` argument
                // is available in the `success` callback
                success: function(mediaElement, originalNode, instance) {
                    //alert('success')
                }
            });
        }
    }
}
</script>

<style>
.video .mejs__container,
.video video {
    max-width: 100%;
    max-height: 100%;
}
</style>

<style lang="scss" scoped>
.video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */

    .video {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;

        iframe {
            border: 0;
            width: 100%;
            height: 100%;
        }
    }
}
</style>
