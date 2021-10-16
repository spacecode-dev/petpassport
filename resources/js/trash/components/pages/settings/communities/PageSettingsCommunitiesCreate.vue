<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">
            Создание
            <template v-if="$route.query.type == 1">
                группы
            </template>
            <template v-else-if="$route.query.type == 2">
                питомника
            </template>
            <template v-else-if="$route.query.type == 3">
                страницы
            </template>
            <template v-else-if="$route.query.type == 4">
                страницы породы
            </template>
            <template v-else>
                сообщества
            </template>
        </h3>
        <form class="e-box e-box--padding" @submit.prevent="create">
            <div class="e-field" v-if="!this.$route.query.type">
                <div>
                    <span class="size--13">Тип сообщества</span>
                </div>
                <div>
                    <select class="form--control-gray wide form--control" v-model="community.type" :disabled="processing">
                        <option value="1">Группа</option>
                        <option value="2">Питомник</option>
                        <option value="3">Страница</option>
                        <option value="4">Страница породы</option>
                    </select>
                </div>
            </div>
            <div class="e-field" v-if="[1, 3].includes(community.type)">
                <div>
                    <span class="size--13">Тематика</span>
                </div>
                <div>
                    <select class="form--control-gray wide form--control" v-model="community.theme" :disabled="processing">
                        <option value="1">Товары и услуги</option>
                        <option value="2">Сообщество владельцев</option>
                        <option value="3">Волонтерская организация</option>
                        <option value="4">Юмор и развлечения</option>
                    </select>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Название</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" type="text" required placeholder="Название" v-model="community.name" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Адрес страницы</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Адрес страницы" type="text" required v-model="community.slug" :disabled="processing">
                </div>
                <div>
                    <span class="size--12 c-gray">Можно использовать только латиницу</span>
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Создать
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { slugify } from 'transliteration';

export default {
    data() {
        return {
            processing: false,
            community: {
                type: 1,
                theme: 1,
                name: null,
                slug: null
            }
        }
    },
    created() {
        if (this.$route.query.type) {
            this.community.type = this.$route.query.type;
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
        },
        'community.name': function() {
            //if (this.community.name && !this.community.slug) {
                this.community.slug = slugify(this.community.name, {
                    lowercase: false,
                    separator: '_'
                });
            //}
        }
    },
    methods: {
        async create() {
            this.processing = true;
            try {
                const community = (await axios.post('/api/communities', this.community)).data;

                toastr.success('Сообщество успешно создано');
                this.$router.push(community.link);
            } catch (e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Невозможно использовать указанный адрес страницы');
                        break;
                    case 2:
                        toastr.error('Адрес страницы может содержать только латинские буквы, цифры, и символ подчеркивания');
                        break;
                    case 3:
                        toastr.error('Адрес страницы уже занят');
                        break;
                    case 4:
                        toastr.error('Название страницы уже занято');
                        break;
                    default:
                        toastr.error('Произошла ошибка при создании сообщества');
                }

                this.processing = false;
            }
        }
    }
}
</script>
