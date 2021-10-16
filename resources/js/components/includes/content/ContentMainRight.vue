<template>
    <div class="content--main--right">
        <div class="content--main--features">
            <div class="columns">
                <div class="column">
                    <PostTextarea/>
                </div>
                <div class="column">
                    <div class="card shop">
                        <header class="card-header">
                            <p class="card-header-title">Магазин</p>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                Подавайте объявления, делитесь информацией, отвечайте на вопросы, откройте свой магазин, предложите услуги. Воспользуйтесь продвижением, повышайте эффективность размещения обьявлений.
                            </div>
                        </div>
                        <footer class="card-footer">
                            <div class="card-footer-item">
                                <div class="buttons">
                                    <b-button type="is-white">Открыть магазин</b-button>
                                    <b-button type="is-success">Разместить обьявление</b-button>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
        <div class="content--main--entity">
            <div class="columns">
                <div class="column">
                    <ContentPosts>
                        <template v-slot:title>
                            Недавние обновления
                        </template>
                    </ContentPosts>
                </div>
                <div class="column">
                    111
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PostTextarea from "./post/PostTextarea"
    import ContentPosts from "./ContentPosts"

    export default {
        components: {
            PostTextarea,
            ContentPosts
        }
    }
</script>
