<template>
    <div class="cn-shop--gray cn-shop--wrap cn-shop--split">
        <div>
            <div class="simple s-menu e-box">
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            О гостинице
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Фото и видео
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            3D-панорамы
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Номера и цены
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Бронирование
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Контакты
                        </span>
                    </span>
                </a>
            </div>
        </div>
        <div>
            <h4 class="size--24 weight--700 style--uppercase style--center margin--bottom-15">
                Гостиница для животных в Москве
            </h4>
            <div class="grid grid--gap grid--four margin--bottom-35">
                <div class="sp-article--simple sp-article e-box" v-for="i in 4">
                    <div class="sp-article--faith">
                        <a class="sp-article--image" href="">
                            <img class="sp-article--term" src="/img/cat/1.jpg" alt="">
                        </a>
                    </div>
                    <div class="e-box--padding sp-article--have">
                        <div class="sp-article--gossip">
                            <a class="size--14 color--mirage" href="">
                                {{ shop.name }} - первая специализированная гостиница для кошек в России. Нам 15 лет
                            </a>
                        </div>
                    </div>
                    <a class="sp-article--link" href=""></a>
                </div>
            </div>
            <h4 class="size--24 weight--700 style--uppercase style--center margin--bottom-15">
                Наши няни
            </h4>
            <div class="grid grid--gap grid--four">
                <div class="sp-article--simple sp-article e-box" v-for="i in 4">
                    <div class="sp-article--faith">
                        <a class="sp-article--image" href="">
                            <img class="sp-article--term" src="/img/other/img_2.png" alt="">
                        </a>
                    </div>
                    <div class="e-box--padding sp-article--have">
                        <div class="sp-article--gossip">
                            <a class="size--14 weight--600 color--mirage" href="">
                                Евгений Куйвашев
                            </a>
                            <p class="size--12 padding--top-15">
                                Терапевт
                            </p>
                        </div>
                    </div>
                    <a class="sp-article--link" href=""></a>
                </div>
            </div>
            <div class="style--center padding--top-10 margin--bottom-50">
                <a class="btn btn-blue-border-style btn-wider" href="">
                    Все няни
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    computed: {
        ...mapState({
            shop: state => state.shops.shop
        })
    }
}
</script>
