<template>
    <LayoutMain>
        <template v-slot:header>
            <IncludeHeaderProfile
                @sos="sos = !sos"
            />
        </template>
        <template v-slot:sidebar-header>
            <div class="b-user" :style="{ 'background-image': 'url(\'' + profile.cover + '\')' }">
                <div class="b-user--inner">
                    <h3 class="b-user--rap">
                        <template v-if="profile.home_name">
                            {{ profile.home_name }}
                        </template>
                        <template v-else>&nbsp;</template>
                    </h3>
                    <div class="e-avatar--65 e-avatar">
                        <a href="#" class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }">
                            <span @click="selectAvatar" v-if="flags.self">
                                <i class="fa fa-camera" aria-hidden="true"></i>
                            </span>
                        </a>
                        <div class="e-avatar--content">
                            <span class="size--14 c-white">
                                {{ profile.name }}
                            </span>
                        </div>
                    </div>
                    <p class="b-user--say">
                        &nbsp;<!--Из питомника «С ВОЛЧЬЕЙ РЕКИ»-->
                    </p>
                </div>
            </div>
        </template>
        <template v-slot:sidebar-content>
            <div v-if="profile.about || (flags.self && profile.type == 3)">
                <div class="sb-descr style--center e-more" :class="{ showed: aboutFull }">
                    <span class="size--13 sb-descr--speech">
                        <!--
                        <span>
                            {{ profile.profile.about }}
                        </span>
                        <span class="e-more--show">
                            &nbsp;
                        </span>
                        -->
                        <span>
                            {{ about }}
                        </span>
                    </span>
                    <i class="gray prefab--arrow-down e-more--button" @click.stop="aboutFull = !aboutFull" v-if="profile.about && profile.about.length > 300"></i>
                </div>
                <div v-if="profile.type == 3">
                    <div class="padding--top-45">
                        <div class="style--center">
                            <div class="pretty p-switch p-slim" @click.capture.stop.prevent="switchInfoHidden" >
                                <input type="checkbox" v-model="profile.info_hidden">
                                <div class="state">
                                    <label>
                                        <span class="size--13">
                                            Скрыть информацию
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <router-link class="btn btn-block btn-blue-border-style margin--bottom-40" to="/settings" v-if="flags.self && profile.type == 3">
                    Сменить владельца
                </router-link>
                <ul class="sb-info size--13">
                    <li v-if="profile.type == 3 && !profile.info_hidden">
                        <ul class="e-list e-list--dot">
                            <li>
                                <router-link :to="profile.link + '/pedigree'">
                                    Родословная
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="profile.link + '/passport'">
                                    Паспорт
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="profile.titles">
                        Титулы:
                        {{ profile.titles }}
                    </li>
                    <!--<li>Порода:</li>-->
                    <li v-if="profile.country_id">
                        Страна:
                        {{ profile_country_name }}
                    </li>
                    <li v-if="profile.city_id">
                        Город:
                        {{ profile_city_name }}
                    </li>
                    <li v-if="profile.birth_country_id">
                        Страна рождения:
                        {{ profile_birth_country_name }}
                    </li>
                    <li v-if="profile.birthday">
                        Дата рождения:
                        {{ profile.birthday }}
                    </li>
                    <li v-if="profile.gender">
                        Пол:
                        <template v-if="profile.gender == 1">
                            Мужской
                        </template>
                        <template v-else-if="profile.gender == 2">
                            Женский
                        </template>
                    </li>
                    <li v-if="profile.marital_status">
                        Семейное положение:
                        <template v-if="profile.marital_status == 1">
                            Не
                            <template v-if="profile.gender == 1">
                                женат
                            </template>
                            <template v-else-if="profile.gender == 2">
                                замужем
                            </template>
                            <template v-else>
                                женат/Не замужем
                            </template>
                        </template>
                        <template v-if="profile.marital_status == 2">
                            <template v-if="profile.gender == 1">
                                Женат
                            </template>
                            <template v-else-if="profile.gender == 2">
                                Замужем
                            </template>
                            <template v-else>
                                Женат/Замужем
                            </template>
                        </template>
                    </li>
                    <li v-if="profile.weight">
                        Вес:
                        {{ profile.weight }}
                    </li>
                    <li v-if="profile.size">
                        Размер:
                        {{ profile.size }}
                    </li>
                    <!--<li>Цвет:</li>-->
                    <!--<li>Приметы:</li>-->
                    <li v-if="profile.breeder">
                        Заводчик:
                        <router-link :to="profile.breeder.link">
                            {{ profile.breeder.name }}
                        </router-link>
                    </li>
                    <li v-if="profile.owner">
                        Владелец:
                        <router-link :to="profile.owner.link">
                            {{ profile.owner.name }}
                        </router-link>
                    </li>
                    <li v-if="profile.nursery">
                        Питомник:
                        <router-link :to="profile.nursery.link">
                            {{ profile.nursery.name }}
                        </router-link>
                    </li>
                    <li v-if="profile.born_nursery">
                        Питомник рождения:
                        <router-link :to="profile.born_nursery.link">
                            {{ profile.born_nursery.name }}
                        </router-link>
                    </li>
                    <!--<li>Отец: <a href="">Не указано</a></li>-->
                    <!--<li>Мать: <a href="">Не указано</a></li>-->
                    <li v-if="profile.inbreeding">
                        Инбридинг:
                        {{ profile.inbreeding }}
                    </li>
                    <li v-if="profile.korung">
                        Кёрунг:
                        {{ profile.korung }}
                    </li>
                    <li v-if="profile.site">
                        Сайт:
                        <a :href="profile_site" target="_blank">
                            {{ profile_site_hostname }}
                        </a>
                    </li>
                    <li v-if="profile.parents && profile.parents.length">
                        Родители:
                        <ul class="__style--uppercase sb-similar">
                            <li v-for="parent in profile.parents" :key="parent.user_id">
                                <i class="ico ico--sex-male" v-if="parent.gender == 1"></i>
                                <i class="ico ico--sex-fem" v-else-if="parent.gender == 2"></i>
                                <i class="ico" v-else></i>
                                <router-link :to="parent.link">
                                    {{ parent.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="profile.relatives && profile.relatives.length">
                        Родственники:
                        <ul class="__style--uppercase sb-similar">
                            <li v-for="relative in profile.relatives" :key="relative.user_id">
                                <i class="ico ico--sex-male" v-if="relative.gender == 1"></i>
                                <i class="ico ico--sex-fem" v-else-if="relative.gender == 2"></i>
                                <i class="ico" v-else></i>
                                <router-link :to="relative.link">
                                    {{ relative.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="profile.childrens && profile.childrens.length">
                        Потомство:
                        <ul class="__style--uppercase sb-similar">
                            <li v-for="children in profile.childrens" :key="children.user_id">
                                <i class="ico ico--sex-male" v-if="children.gender == 1"></i>
                                <i class="ico ico--sex-fem" v-else-if="children.gender == 2"></i>
                                <i class="ico" v-else></i>
                                <router-link :to="children.link">
                                    {{ children.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <i class="fa fa-rss c-violet" aria-hidden="true"></i>
                        <!--<i class="ico ico--feed"></i>-->
                        <span>Читают: </span>
                        <router-link :to="profile.link + '/friends/subscribers'">
                            {{ counters.subscribers }} пользователей
                        </router-link>
                    </li>
                </ul>
                <button class="btn btn-block btn-blue-border-style" @click="showModal('contact')" v-if="profile.type != 3 && !flags.self">
                    Контактная информация
                </button>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_shops.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/shops'">
                        Магазины
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ profile.shops_count }}
                </span>
                <div>
                    <div class="e-item" v-for="(shop, i) in profile.top_shops" :key="shop.id">
                        <!--
                        <div class="e-item--term">
                            <div class="e-num">
                                <span class="e-num--utter">
                                    {{ i + 1 }}
                                </span>
                            </div>
                        </div>
                        -->
                        <div class="e-item--term">
                            <router-link :to="shop.link" style="display: block; width: 50px; height: 50px; background-size: cover;" :style="{ 'background-image': 'url(\'' + shop.avatar + '\')' }"></router-link>
                            <!--<img class="e-item--guide" src="/img/other/shp.jpg" alt="">-->
                        </div>
                        <div class="e-item--wash">
                            <router-link class="e-item--the" :to="'/market/shops/' + shop.id">
                                {{ shop.name }}
                            </router-link>
                            <p class="e-item--floor">
                                {{ shop.announcements_count }}
                                {{ shop.announcements_count | plural(['товар', 'товара', 'товаров']) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_announcements.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/announcements'">
                        Объявления
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ profile.announcements_count }}
                </span>
                <div>
                    <div class="e-item" v-for="announcement in profile.top_announcements">
                        <div class="e-item--term">
                            <router-link :to="'/market/announcements/' + announcement.id" style="display: block; width: 50px; height: 50px; background-size: cover;" :style="{ 'background-image': 'url(\'' + announcement.photo.thumb_180 + '\')' }" v-if="announcement.photo"></router-link>
                            <router-link :to="'/market/announcements/' + announcement.id" class="d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; background: #C3C3C3;" v-else>
                                <i class="fa fa-image c-white" aria-hidden="true"></i>
                            </router-link>
                            <!--<img class="e-item--guide" src="/img/other/shp.jpg" alt="">-->
                        </div>
                        <div class="e-item--wash">
                            <router-link class="e-item--the" :to="'/market/announcements/' + announcement.id">
                                {{ announcement.title }}
                            </router-link>
                            <p class="e-item--floor">
                                {{ announcement.price | price }}
                                <i class="fa fa-ruble-sign" v-if="announcement.currency == 1"></i>
                                <i class="fa fa-dollar-sign" v-if="announcement.currency == 2"></i>
                                <i class="fa fa-euro-sign" v-if="announcement.currency == 3"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="profile.type != 3">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/reviews'">
                        Отзывы
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ profile.reviews_count }}
                </span>
                <div class="style--inline" style="float: right; margin-top: 3px;" v-if="!flags.self">
                    <i class="ico ico--comment"></i>
                    <a href="#" class="size--12 color--regent-gray" @click="showModal('review-add')">
                        Написать отзыв
                    </a>
                </div>
                <div>
                    <div class="sb-review" v-for="review in profile.top_reviews">
                        <div class="sb-review--word line-height--1_4">
                            <span class="size--13">
                                {{ review.body }}
                            </span>
                        </div>
                        <span class="c-gray size--13">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <!--<i class="ico ico--user"></i>-->
                            <router-link class="c-gray" :to="review.user.link">
                                {{ review.user.name }}
                            </router-link>
                        </span>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="!profile.memory && profile.gender !== 0">
                <div class="style--center">
                    <template>
                        <template v-if="profile.type == 3">
                            <i class="ico ico--couple" :class="{ 'ico--couple-disable': !profile.mating }" :style="{ 'cursor': flags.self ? 'pointer' : 'default' }" @click="switchMating" v-if="flags.self"></i>
                            <i class="ico ico--couple" :class="{ 'ico--couple-disable': !profile.mating }" v-else></i>
                        </template>
                        <template v-else>
                            <i class="couple-switch-genderless" :class="{ active: profile.mating }" @click="switchMating" v-if="flags.self"></i>
                            <i class="couple-switch-genderless disabled" :class="{ active: profile.mating }" v-else></i>
                        </template>

                        <p class="size--14 elem-unite">
                            <template v-if="profile.type == 3">
                                Сейчас питомец
                                <template v-if="profile.mating">
                                    открыт
                                </template>
                                <template v-else>
                                    закрыт
                                </template>
                                для вязки
                            </template>
                            <template v-else>
                                Владелец аккаунта
                                <template v-if="profile.mating">
                                    открыт
                                </template>
                                <template v-else>
                                    закрыт
                                </template>
                                для знакомств
                            </template>
                        </p>
                    </template>
                    <h4 class="e-box--title style--uppercase">
                        Найти
                        <template v-if="profile.type == 3">
                            пару
                        </template>
                        <template v-else>
                            партнера
                        </template>
                    </h4>
                </div>
                <form @submit.prevent="searchMating">
                    <template v-if="profile.type == 3">
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.pet_type">
                                <option value="null">Вид</option>
                                <option value="1">Собаки</option>
                                <option value="2">Кошки</option>
                                <option value="3">Птицы</option>
                                <option value="4">Грызуны</option>
                                <option value="5">Хорьки</option>
                                <option value="6">Лошади</option>
                                <option value="7">Рыбки</option>
                                <option value="8">Рептилии</option>
                                <option value="9">Улитки</option>
                                <option value="10">Пауки</option>
                                <option value="11">Насекомые</option>
                                <option value="12">Кролики</option>
                                <option value="13">Дикие животные</option>
                                <option value="17">Другие животные</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.gender">
                                <option value="null">Пол</option>
                                <option value="1">Мужской</option>
                                <option value="2">Женский</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control" disabled>
                                <option value="null">Порода</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <!--
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.country" disabled>
                                <option value="null">Страна</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                            -->
                            <IncludeInputWithFilter class="form--control-gray _size--13 _wide _form--control" v-model="mating.country_id" :data="countries" order-by="name" filter-by="name" placeholder="Начните вводить название страны" />
                        </div>
                        <div class="form--group">
                            <!--
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.country" disabled>
                                <option value="null">Город</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                            -->
                            <IncludeInputWithFilter class="form--control-gray _size--13 _wide _form--control" v-model="mating.city_id" :data="cities" order-by="name" filter-by="name" placeholder="Начните вводить название города" v-if="mating.country_id" />
                            <input class="form--control-gray size--13 _wide form--control" placeholder="Сначала выберите страну" disabled v-else>
                        </div>
                    </template>
                    <template v-else>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.gender">
                                <option value="null">Пол</option>
                                <option value="1">Мужской</option>
                                <option value="2">Женский</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <input type="number" class="form--control-gray size--13 wide form--control" min="1" v-model="mating.age" placeholder="Возраст">
                        </div>
                        <div class="form--group">
                            <!--
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.country" disabled>
                                <option value="null">Страна</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                            -->
                            <IncludeInputWithFilter class="form--control-gray _size--13 _wide _form--control" v-model="mating.country_id" :data="countries" order-by="name" filter-by="name" placeholder="Начните вводить название страны" />
                        </div>
                        <div class="form--group">
                            <!--
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.country" disabled>
                                <option value="null">Город</option>
                                <option value="2">Значение 1</option>
                                <option value="3">Значение 2</option>
                            </select>
                            -->
                            <IncludeInputWithFilter class="form--control-gray _size--13 _wide _form--control" v-model="mating.city_id" :data="cities" order-by="name" filter-by="name" placeholder="Начните вводить название города" v-if="mating.country_id" />
                            <input class="form--control-gray size--13 _wide form--control" placeholder="Сначала выберите страну" disabled v-else>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.pet_type">
                                <option value="null">Вид питомцев</option>
                                <option value="1">Собаки</option>
                                <option value="2">Кошки</option>
                                <option value="3">Птицы</option>
                                <option value="4">Грызуны</option>
                                <option value="5">Хорьки</option>
                                <option value="6">Лошади</option>
                                <option value="7">Рыбки</option>
                                <option value="8">Рептилии</option>
                                <option value="9">Улитки</option>
                                <option value="10">Пауки</option>
                                <option value="11">Насекомые</option>
                                <option value="12">Кролики</option>
                                <option value="13">Дикие животные</option>
                                <option value="17">Другие животные</option>
                            </select>
                        </div>
                        <div class="form--group">
                            <select class="form--control-gray size--13 wide form--control" v-model="mating.pets_count">
                                <option value="null">Количество питомцев</option>
                                <option value="1-2">1-2</option>
                                <option value="3-5">3-5</option>
                                <option value="5-10">5-10</option>
                                <option value="10">&gt; 10</option>
                            </select>
                        </div>
                    </template>
                    <button type="submit" class="btn btn-block size--13 btn-border-blue btn-round weight--600 btn-bigger">
                        Найти
                        <template v-if="profile.type == 3">
                            пару
                        </template>
                        <template v-else>
                            партнера
                        </template>
                    </button>
                </form>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_friends.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/friends'">
                        Друзья
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ counters.friends }}
                </span>
                <div>
                    <div class="grid grid--three">
                        <div class="e-frend" v-for="friend in profile.top_friends" :key="friend.user_id">
                            <router-link class="prefab--ava e-frend--photo" :style="{ 'background-image': 'url(\'' + friend.avatar + '\')' }" :to="friend.link"></router-link>
                            <span class="size--13 style--block">
                                {{ friend.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_photos.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/photos'">
                        Фотографии
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ profile.photos_count }}
                </span>
                <div>
                    <div class="grid grid--three">
                        <div class="e-photo" v-for="photo in profile.top_photos">
                            <a :href="profile.link + '/photos/' + photo.id" class="d-block" style="padding-top: 100%; background-size: cover; background-position: center;" :style="{ 'background-image': 'url(\'' + photo.thumb_180 + '\')' }" @click.prevent="showPhoto(photo)"></a>
                            <!--<img class="img-fluid e-photo--img" :src="photo.thumb_180" alt="">-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_pages.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/pages'">
                        Страницы
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ counters.pages }}
                </span>
                <div>
                    <div class="_e-add--like e-avatar--65 e-avatar" v-for="page in profile.top_pages">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + page.avatar + '\')' }" :to="page.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="page.link">
                                {{ page.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="page.link">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                {{ page.likes_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_groups.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/groups'">
                        Группы
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ counters.groups }}
                </span>
                <div>
                    <div class="e-avatar--65 _e-add--user e-avatar" v-for="group in profile.top_groups">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + group.avatar + '\')' }" :to="group.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="group.link">
                                {{ group.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="group.link + '/members'">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ group.members_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-box--with-offset" v-if="profile.top_nurseries.length">
                <h4 class="e-box--title style--inline">
                    <router-link class="c-black" :to="profile.link + '/nurseries'">
                        Питомники
                    </router-link>
                </h4>
                <span class="bigger prefab--label">
                    {{ counters.nurseries }}
                </span>
                <div>
                    <div class="e-avatar--65 _e-add--user e-avatar" v-for="nursery in profile.top_nurseries">
                        <router-link class="e-avatar--photo" :style="{ 'background-image': 'url(\'' + nursery.avatar + '\')' }" :to="nursery.link"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="e-add--floor" :to="nursery.link">
                                {{ nursery.name }}
                            </router-link>
                            <router-link class="e-add--refer" :to="nursery.link + '/members'">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ nursery.members_count }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <router-view></router-view>
    </LayoutMain>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapState } from 'vuex';
import { mapCacheActions } from 'vuex-cache';

import store from '../../../store';
import ModalSelectPhotos from '../../includes/modals/ModalSelectPhotos';
import ModalReviewAdd from '../../includes/modals/ModalReviewAdd';
import ModalUserContact from '../../includes/modals/ModalUserContact';
import ModalMediaView from '../../includes/modals/ModalMediaView';

export default {
    data() {
        return {
            petInfoHidden: true,
            aboutFull: false,
            sos: false,
            mating: {
                pet_type: null,
                gender: null,
                country_id: null,
                city_id: null,
                age: null,
                pets_count: null
            },
            countries: [],
            cities: []
        }
    },
    asyncComputed: {
        async profile_country_name() {
            if (!this.profile.country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id === this.profile.country_id).name;
        },
        async profile_city_name() {
            if (!this.profile.country_id || !this.profile.city_id) return;
            const cities = await this.getCities(this.profile.country_id);
            return cities.find(c => c.id === this.profile.city_id).name;
        },
        async profile_birth_country_name() {
            if (!this.profile.birth_country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id === this.profile.birth_country_id).name;
        }
    },
    computed: {
        ...mapState({
            counters: state => state.profiles.counters,
            profile: state => state.profiles.profile,
            flags: state => state.profiles.flags
        }),
        about() {
            if (this.profile.about) {
                if (this.profile.about.length <= 300 || this.aboutFull) {
                    return this.profile.about;
                }
                const substr = this.profile.about.substring(0, 300);
                const space = substr.lastIndexOf(' ') || 300;
                return substr.substring(0, space);
            }
        },
        profile_site() {
            if (this.profile.site.startsWith('http://') ||
                this.profile.site.startsWith('https://')) {
                return this.profile.site;
            }
            return 'http://' + this.profile.site;
        },
        profile_site_hostname() {
            return (new URL(this.profile_site)).hostname;
        }
    },
    async beforeRouteEnter(to, from, next) {
        await store.dispatch('PROFILE_SHOW', to.params.slug);
        next();
    },
    async beforeRouteUpdate(to, from, next) {
        console.log('FROM ' + from.params.slug + ' TO ' + to.params.slug);
        if (from.params.slug === to.params.slug) {
            next();
            return;
        }
        await this.$store.dispatch('PROFILE_SHOW', to.params.slug);
        $('.cn-sitebar--scrollbar').scrollTop(0);
        next();
    },
    async created() {
        //console.dir(this.$route);

        setInterval(() => {
            this.petInfoHidden = !this.petInfoHidden;
        }, 1000);

        this.countries = await this.getCountries();
        if (this.mating.country_id) {
            this.cities = await this.getCities(this.mating.country_id);
        }
    },
    methods: {
        ...mapCacheActions([
            'getCountries',
            'getCities'
        ]),
        async switchMating() {
            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    mating: !this.profile.mating
                });

            } catch (e) {
                console.log(e)
            }
        },
        async switchInfoHidden() {
            await this.$store.dispatch('PROFILE_UPDATE', {
                info_hidden: !this.profile.info_hidden
            });
        },
        showModal(name) {
            if (name == 'contact') {
                this.$modal.show(ModalUserContact, {
                    profile: this.profile
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                });
            }

            if (name == 'review-add') {
                this.$modal.show(ModalReviewAdd, {
                    owner: this.profile,
                    owner_id: this.profile.user_id,
                    owner_type: 'profile'
                }, {
                    classes: '',
                    height: 'auto',
                    maxWidth: 800,
                    adaptive: true,
                    scrollable: true
                }, {
                    'review-stored': this.reviewStored
                });
            }
        },
        showPhoto(object) {
            this.$modal.show(ModalMediaView, {
                object,
                object_type: 'photo',
                object_set: this.profile.top_photos
            }, {
                classes: '',
                width: '100%',
                height: '100%',
                maxWidth: 2880,
                adaptive: true
            });
        },
        reviewStored(response) {
            this.$store.commit('PROFILE_UPDATE', {
                top_reviews: [
                    response.review
                ]
            });
        },
        searchMating() {
            this.$router.push({
                path: '/profiles/search',
                query: {
                    mating: 1,
                    types: this.profile.type == 3 ? '3' : '1,2',
                    ...this.mating
                }
            });
        },
        selectAvatar() {
            this.$modal.show(ModalSelectPhotos, {
                owner_id: this.profile.user_id,
                owner_type: 'profile',
                section: 2,
                count: 1
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        }
    },
    watch: {
        'mating.country_id': async function() {
            this.cities = [];
            if (this.mating.country_id) {
                this.cities = await this.getCities(this.mating.country_id);
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.couple-switch-genderless {
    display: inline-flex;
    cursor: pointer;

    &::before,
    &::after {
        content: '';
        display: block;
        width: 1.2em;
        height: 1.2em;
        border-radius: 50%;
        border: 3px solid var(--c-gray);
        filter: drop-shadow(1px 0 0 var(--c-white)) drop-shadow(-1px 0 0 var(--c-white));
    }

    &::after {
        margin-left: -.6em;
    }

    &.active {
        &::before {
            border-color: var(--c-pink);
        }
        &::after {
            border-color: var(--c-violet);
        }
    }

    &.disabled {
        cursor: default;
        pointer-events: none;
    }
}
</style>
