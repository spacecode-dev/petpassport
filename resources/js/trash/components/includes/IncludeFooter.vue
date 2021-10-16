<template>
    <footer class="section f-layer">
        <div class="f-layer--body">
            <div class="f-menu">
                <div>
                    <h4 class="f-menu--note">Структура</h4>
                    <div class="f-menu--floor">
                        <router-link class="f-menu--faith" to="/community">
                            Сообщество
                        </router-link>
                        <router-link class="f-menu--faith" to="/market">
                            Рынок
                        </router-link>
                        <router-link class="f-menu--faith" to="/database">
                            База данных
                        </router-link>
                        <router-link class="f-menu--faith" to="/market/shops">
                            Магазины
                        </router-link>
                    </div>
                </div>
                <div>
                    <h4 class="f-menu--note">Объявления</h4>
                    <div class="f-menu--floor">
                        <router-link class="f-menu--faith" to="/">
                            Категории
                        </router-link>
                        <router-link class="f-menu--faith" to="/">
                            Популярное
                        </router-link>
                        <router-link class="f-menu--faith" to="/">
                            Разместить
                        </router-link>
                        <router-link class="f-menu--faith" to="/">
                            Избранное
                        </router-link>
                    </div>
                </div>
                <div>
                    <h4 class="f-menu--note">Язык сайта</h4>
                    <div class="f-menu--floor f-menu--double">
                        <router-link active-class="weight--700" v-for="lang in ['English', 'Deutsch', 'Français', 'Español', 'Русский', 'Português', '日本語', '한국어']" class="f-menu--faith" :class="{ 'weight--700': lang == 'Русский' }" to="/" :key="lang">
                            {{ lang }}
                        </router-link>
                    </div>
                </div>
                <div>
                    <h4 class="f-menu--note">Услуги</h4>
                    <div class="f-menu--floor">
                        <router-link class="f-menu--faith" _active-class="weight--700" to="/">
                            Продвижение
                        </router-link>
                        <router-link class="f-menu--faith" _active-class="weight--700" to="/">
                            Реклама
                        </router-link>
                        <router-link class="f-menu--faith" _active-class="weight--700" to="/">
                            Оформление
                        </router-link>
                        <router-link class="f-menu--faith" _active-class="weight--700" to="/">
                            Администрирование
                        </router-link>
                    </div>
                </div>
                <div>
                    <h4 class="f-menu--note">Информация</h4>
                    <div class="f-menu--floor">
                        <router-link class="f-menu--faith" active-class="weight--700" to="/about">
                            О нас
                        </router-link>
                        <router-link class="f-menu--faith" active-class="weight--700" to="/privacy">
                            Политика сайта
                        </router-link>
                        <router-link class="f-menu--faith" active-class="weight--700" to="/contacts">
                            Контакты
                        </router-link>
                        <router-link class="f-menu--faith" active-class="weight--700" to="/login">
                            Вход
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="f-layer--search">
                <form class="sr-footer margin--bottom-15">
                    <input class="sr-footer--speech" placeholder="Поиск" type="text" required>
                    <button class="sr-footer--button"></button>
                </form>
            </div>
            <div class="f-bottom">
                <div>
                    <img class="f-bottom--logo logo" src="/img/logo.png" alt="PetPassport">
                    <span class="size--12">Petpassport.online ©</span>
                    <span class="size--12 color--manatee">2017-2019.</span>
                    <span class="size--11">Все права защищены</span>
                </div>
                <div class="f-bottom--talk">
                    <span class="size--11">Оплачивая услуги на сайте, Вы принимаете</span>
                    <router-link class="size--11" to="/offer">публичную оферту</router-link>
                </div>
                <div class="f-bottom--social">
                    <span class="size--11 style--italic">Мы в сообществах:</span>
                    <div class="e-social">
                        <a target="_blank" class="e-social--vk" href=""></a>
                        <a target="_blank" class="e-social--facebook" href=""></a>
                        <a target="_blank" class="e-social--insta" href=""></a>
                        <a target="_blank" class="e-social--youtube" href=""></a>
                    </div>
                </div>
                <div>
                    <a class="e-up" href="#"></a>
                </div>
            </div>
        </div>
        <div class="f-layer--cookie">
            <span class="size--12">
                Как большинство сайтов, мы используем cookies, веб-маячки и похожие технологии, в целях обеспечения максимально быстрого и безопасного сервиса
            </span>
        </div>
    </footer>
</template>

