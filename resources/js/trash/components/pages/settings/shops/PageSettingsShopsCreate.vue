<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">Создание магазина</h3>
        <form class="e-box" @submit.prevent="create">
            <ul class="steps e-tab--nav">
                <li class="label-show" :class="{ active: step == 1 }">
                    <span class="size--14">1 шаг</span>
                </li>
                <li class="label-show" :class="{ active: step == 2 }">
                    <span class="size--14">2 шаг</span>
                </li>
                <li class="label-show" :class="{ active: step == 3 }">
                    <span class="size--14">3 шаг</span>
                </li>
            </ul>
            <div class="e-box--padding" v-if="step == 1">
                <div class="e-field">
                    <div>
                        <span class="size--13">Категория</span>
                    </div>
                    <div>
                        <select class="form--control-gray wide form--control size--13" v-model="shop.category_id">
                            <option value="1">Категория 1</option>
                            <option value="2">Категория 2</option>
                            <option value="3">Категория 3</option>
                        </select>
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">Тип страницы</span>
                    </div>
                    <div>
                        <select class="form--control-gray wide form--control size--13" v-model="shop.type">
                            <option value="1">Товары, услуги, объявления</option>
                            <option value="2">Перевозка животных</option>
                            <option value="3">Ветеринарная клиника</option>
                            <option value="4">Гостиница</option>
                            <option value="5">Фотоуслуги</option>
                            <option value="6">Дрессировка</option>
                        </select>
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">Название магазина</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" type="text" required placeholder="Название магазина" v-model="shop.name">
                    </div>
                </div>
                <div class="e-field" style="opacity: .2;">
                    <div>
                        <span class="size--13">Контактное лицо</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" type="text" required placeholder="Контактное лицо" v-model="contact_person">
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">Номер телефона</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" type="text" required placeholder="Номер телефона" v-model="shop.phone">
                    </div>
                </div>
                <div class="e-field">
                    <div>
                        <span class="size--13">Email</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" type="email" required placeholder="Email" v-model="shop.email">
                    </div>
                </div>
                <div class="e-field" style="opacity: .2;">
                    <div>
                        <span class="size--13">Добавить второе контактное лицо?<br>(введите ID пользователя сервиса</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" type="text" v-model="contact_person_2">
                    </div>
                </div>
                <div class="e-field--align-up e-field" style="opacity: .2">
                    <div>
                        <span class="size--13">Добавить участников<br>(начните вводить имя пользователя)</span>
                    </div>
                    <div>
                        <div class="sr-prefab--wrap">
                            <div class="sr-prefab">
                                <button class="sr-prefab--button"></button>
                                <input class="sr-prefab--input" type="text" placeholder="Поиск">
                            </div>
                            <div class="sr-prefab--drop">
                                <ul class="e-coincidence">
                                    <li>
                                        <i class="ico ico--del"></i>
                                        <span class="color--daisy-bush size--13">Ольга Серова</span>
                                    </li>
                                    <li>
                                        <i class="ico ico--del"></i>
                                        <span class="color--daisy-bush size--13">Ольга Серова</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="e-field e-field--next e-field--no-margin">
                    <div>
                        <a class="color--manatee size--13" href="">Нужна помощь?</a>
                    </div>
                    <div class="style--right">
                        <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" @click.prevent="step++">
                            Далее
                        </button>
                    </div>
                </div>
            </div>
            <div class="e-box--padding" v-if="step == 2">
                <!--
                <div class="e-field e-field--align-up e-field--first" style="opacity: .2;">
                    <div>
                        <span class="size--13">Добавить файлы</span>
                    </div>
                    <div class="grid grid--gap e-field--files">
                        <div class="e-file">
                            <input type="file">
                            <span class="e-file--sector">Логотип</span>
                            <div class="e-file--lead">
                                <div class="e-file--utter">
                                    <span class="e-file--be">Загрузить</span>
                                </div>
                                <div class="e-file--exile">
                                    <i class="ico ico--del"></i>
                                    <span class="e-file--be">logo.png</span>
                                </div>
                            </div>
                        </div>
                        <div class="e-file">
                            <input type="file">
                            <span class="e-file--sector">Баннер</span>
                            <div class="e-file--lead">
                                <div class="e-file--utter">
                                    <span class="e-file--be">Загрузить</span>
                                </div>
                                <div class="e-file--exile">
                                    <i class="ico ico--del"></i>
                                    <span class="e-file--be">logo.png</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <div class="e-field">
                    <div>
                        <span class="size--13">Подпись под логотипом</span>
                    </div>
                    <div>
                        <input class="form--control form--control-gray size--13" placeholder="Например, PetVille" type="text" required v-model="shop.sign">
                    </div>
                </div>
                <div class="e-field--align-up e-field">
                    <div>
                        <span class="size--13">Описание магазина</span>
                    </div>
                    <div>
                        <textarea class="form--control form--textarea form--control-gray size--13" rows="4" v-model="shop.description"></textarea>
                    </div>
                </div>
                <div class="e-field e-field--next e-field--no-margin">
                    <div>
                        <a class="color--manatee size--13" href="" @click.stop.prevent="step--">Вернуться к предыдущему шагу</a>
                    </div>
                    <div class="style--right">
                        <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" @click.prevent="step++">
                            Далее
                        </button>
                    </div>
                </div>
            </div>
            <div class="e-box--padding" v-if="step == 3">
                <h4 class="weight--700 margin--bottom-10">Улучшите свой магазин</h4>
                <div class="e-field--cards">
                    <label class="form--card">
                        <input type="radio" name="package">
                        <div>
                            <h4 class="size--14 weight--600 margin--bottom-10">Пакет #1</h4>
                            <p class="size--13 line-height--1_6 margin--bottom-10">Сверхпроводник, несмотря на то, что в воскресенье некоторые станции метро закрыты</p>
                            <p class="color--daisy-bush">250 i</p>
                        </div>
                    </label>
                    <label class="form--card">
                        <input type="radio" name="package">
                        <div>
                            <h4 class="size--14 weight--600 margin--bottom-10">Пакет #2</h4>
                            <p class="size--13 line-height--1_6 margin--bottom-10">Сверхпроводник, несмотря на то, что в воскресенье некоторые станции метро закрыты</p>
                            <p class="color--daisy-bush">500 i</p>
                        </div>
                    </label>
                </div>
                <div class="e-field e-field--next e-field--no-margin">
                    <div>
                        <a class="color--manatee size--13" href="" @click.stop.prevent="step--">Вернуться к предыдущему шагу</a>
                    </div>
                    <div class="style--right">
                        <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit">Создать</button>
                     </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import querystring from 'querystring';
import toastr from 'toastr';

export default {
    data() {
        return {
            step: 1,
            shop: {
                category_id: 1,
                type: 1,
                name: null,
                phone: null,
                email: null,
                sign: null,
                description: null
            },
            contact_person_1: null,
            contact_person_2: null
        }
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    watch: {
        step() {
            $(this.$el).find('select').niceSelect('destroy');
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect();
            });
        }
    },
    methods: {
        async create() {
            try {
                await axios.post('/api/user/shops', querystring.stringify(this.shop));

                toastr.success('Магазин успешно создан', 'Магазин создан');
                this.$router.push('/settings/shops');
            } catch (e) {
                
            }
        }
    }
}
</script>
