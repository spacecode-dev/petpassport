<template>
    <div class="cn-shop--gray cn-shop--wrap cn-shop--split">
        <div>
            <div class="simple s-menu e-box">
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Клиника
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Сотрудники
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Услуги и цены
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Расписание
                        </span>
                    </span>
                </a>
                <a href="">
                    <span>
                        <span class="s-menu--text">
                            Статьи
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
                Ветеринарные услуги
            </h4>
            <div class="grid grid--gap grid--four">
                <div class="sp-article--simple sp-article e-box" v-for="i in 4">
                    <div class="sp-article--faith">
                        <a class="sp-article--image" href="">
                            <img class="sp-article--term" src="/img/cat/1.jpg" alt="">
                        </a>
                    </div>
                    <div class="e-box--padding sp-article--have">
                        <div class="sp-article--gossip">
                            <a class="size--14 weight--600 color--mirage" href="">
                                Дерматология
                            </a>
                        </div>
                    </div>
                    <a class="sp-article--link" href=""></a>
                </div>
            </div>
            <div class="style--center padding--top-10 margin--bottom-50">
                <a class="btn btn-blue-border-style btn-wider" href="">
                    Все услуги
                </a>
            </div>
            <h4 class="size--24 weight--700 style--uppercase style--center margin--bottom-15">
                Лечим животных с 1922 года
            </h4>
            <p class="line-height--1_6 style--center margin--bottom-50">
                Ветеринарная клиника «{{ shop.name }}» — одна из первых частных клиник в Москве. С начала 90-х годов мы ведем круглосуточный прием животных в уютном особняке в историческом центре Москвы — на Цветном бульваре, рядом со Старым московским цирком. В этом же здании лечили животных с начала прошлого века.
            </p>
            <h4 class="size--24 weight--700 style--uppercase style--center margin--bottom-15">
                Наши специалисты
            </h4>
            <div class="grid grid--gap grid--four">
                <div class="sp-article--simple sp-article e-box" v-for="i in 4">
                    <div class="sp-article--faith">
                        <a class="sp-article--image" href="">
                            <img class="sp-article--term" src="/img/cat/1.jpg" alt="">
                        </a>
                    </div>
                    <div class="e-box--padding sp-article--have">
                        <div class="sp-article--gossip">
                            <a class="size--14 weight--600 color--mirage" href="">
                                Дерматология
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
                    Все специалисты
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
