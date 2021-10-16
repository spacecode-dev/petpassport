<template>
    <div>
        <div class="e-title--space e-title--page">
            <h3 class="size--18 weight--700">
                Добавить объявление
            </h3>
            <router-link class="color--manatee size--13" :to="'/settings/announcements?shop_id=' + $route.query.shop_id" v-if="$route.query.shop_id">
                К списку объявлений магазина
            </router-link>
            <router-link class="color--manatee size--13" to="/settings/announcements" v-else>
                К списку моих объявлений
            </router-link>
        </div>
        <form class="e-box e-box--padding" @submit.prevent="create">
            <div class="__e-field--head e-field">
                <div>
                    <span class="size--13">
                        Категория
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <!--
                    <p class="color--daisy-bush size--13 weight--600">
                        Собаки / Акита-Ину
                    </p>
                    -->
                    <!--
                    <select class="form--control-gray wide form--control" v-model="announcement.category_id" :disabled="processing">
                        <option value="null">Выберите категорию</option>
                        <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                    </select>
                    -->
                    <IncludeInputWithFilter v-model="category_id" :data="categories" order-by="name" filter-by="name" placeholder="Начните вводить название категории" input-class="form--control-gray wide _form--control-shadow _e-box--shadow" />
                </div>
            </div>
            <div class="e-field" v-if="subcategories.length">
                <div></div>
                <div>
                    <IncludeInputWithFilter v-model="subcategory_id" :data="subcategories" order-by="name" filter-by="name" placeholder="Начните вводить название подкатегории" input-class="form--control-gray wide _form--control-shadow _e-box--shadow" />
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Объявление от
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <select  class="form--control-gray wide form--control size--13" v-model="announcement.from" :disabled="processing">
                        <option value="1">Частного пользователя</option>
                        <option value="2">Заводчика</option>
                    </select>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Продажа питомца из сообщества
                    </span>
                </div>
                <div class="user-input">
                    <div class="user-input--user size--13" v-if="selectedPet" @click="petUnselect">
                        <img :src="selectedPet.avatar" :alt="selectedPet.name">
                        {{ selectedPet.name }}
                    </div>
                    <template v-else>
                        <input class="form--control form--control-gray size--13" placeholder="Начните вводить имя питомца" type="text" maxlength="255" v-model="petName" :disabled="processing">
                        <ul class="user-pets-list" v-if="petsByName.length">
                            <li class="user-input--user size--13" v-for="pet in petsByName" :key="pet.user_id" @click="petSelect(pet.user_id)">
                                <img :src="pet.avatar" :alt="pet.name">
                                {{ pet.name }}
                            </li>
                        </ul>
                    </template>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Заголовок объявления
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Заголовок объявления" type="text" maxlength="255"  v-model="announcement.title" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Пол
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <select  class="form--control-gray wide form--control select-gender size--13" v-model="announcement.gender" :disabled="processing">
                        <option value="null" disabled>Выберите пол</option>
                        <option v-for="(gender, index) in genders" v-bind:key="index"  :value="index">{{ gender }}</option>
                    </select>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Дата рождения
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div class="e-field e-field--three e-field--no-margin e-field--date">
                    <select class="form--control-gray wide form--control select-birthday size--13" v-model="announcement_birth_day" :disabled="processing">
                        <option value="null" disabled>День</option>
                        <option v-for="day in 31" :value="day">{{ day }}</option>
                    </select>
                    <select class="form--control-gray wide form--control select-birthday size--13" v-model="announcement_birth_month" :disabled="processing">
                        <option value="null" disabled>Месяц</option>
                        <option v-for="(month, i) in ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']" :value="i + 1">{{ month }}</option>
                    </select>
                    <select class="form--control-gray wide form--control select-birthday size--13" v-model="announcement_birth_year" :disabled="processing" id="select-year">
                        <option value="null" disabled>Год</option>
                        <option v-for="i in 100" :value="(year - 100) + i">{{ (year - 100) + i }}</option>
                    </select>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Ветпаспорт
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <label class="form--toogle">
                        <input type="checkbox" v-model="announcement.vetpassport" :disabled="processing">
                        <div>
                            <span>Да</span>
                            <span>Нет</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Родословная
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <label class="form--toogle">
                        <input type="checkbox" v-model="announcement.pedigree" :disabled="processing">
                        <div>
                            <span>Да</span>
                            <span>Нет</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Договор
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <label class="form--toogle">
                        <input type="checkbox" v-model="announcement.contract" :disabled="processing">
                        <div>
                            <span>Да</span>
                            <span>Нет</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Прививки
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <label class="form--toogle">
                        <input type="checkbox" v-model="announcement.vaccination" :disabled="processing">
                        <div>
                            <span>Да</span>
                            <span>Нет</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Клеймо
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <label class="form--toogle">
                        <input type="checkbox" v-model="announcement.mark" :disabled="processing">
                        <div>
                            <span>Да</span>
                            <span>Нет</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Чип
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <label class="form--toogle">
                        <input type="checkbox" v-model="announcement.chip" :disabled="processing">
                        <div>
                            <span>Да</span>
                            <span>Нет</span>
                        </div>
                    </label>
                </div>
            </div>
            <div class="e-field--align-up e-field--first e-field">
                <div>
                    <span class="size--13">
                        Описание объявления
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <textarea class="form--control form--textarea form--control-gray size--13" rows="4" placeholder="Описание объявления" v-model="announcement.description" :disabled="processing" maxlength="1000"></textarea>
                    <div class="size--12 margin--top-5 color--regent-gray">
                        Осталось символов: {{ 1000 - (announcement.description ? announcement.description.length : 0) }}
                    </div>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Цена
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13 field-decimal" placeholder="Цена" step="0.01" type="number" min="0"  v-model="announcement.price" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Валюта
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
<!--                    <select class="form&#45;&#45;control-gray wide form&#45;&#45;control size&#45;&#45;13" v-model="announcement.currency" :disabled="processing">-->
<!--                        <option v-repeat="templates"-->
<!--                                selected="{{name == item.category}}"-->
<!--                                value="{{name}}">-->
<!--                            {{name}}-->
<!--                        </option>-->
<!--                    </select>-->

                    <select class="form--control-gray wide form--control size--13" v-model="announcement.currency" :disabled="processing">
                        <option v-for="(currency, index) in currencies" v-bind:key="index"  :value="currency.id">{{currency.unicode_symbol_html}} - {{ currency.name }}</option>
<!--                        <option value="1">&#8381; &#45;&#45;&#45;&#45; Рубли</option>-->
<!--                        <option value="2">$ - Доллары</option>-->
<!--                        <option value="3">€ - Евро</option>-->
                    </select>
                </div>
            </div>
            <!--
            <div class="e-field">
                <div></div>
                <div>
                    <div class="pretty p-default p-curve">
                        <input type="checkbox" v-model="announcement.bargain" :disabled="processing">
                        <div class="state">
                            <label>
                                <span class="size--13">Торг уместен</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="e-field e-field--align-up e-field--first">
                <div>
                    <span class="size--13">
                        Загрузите фото
                    </span>
                    <span class="color--persimmon size--13"></span>
                </div>
                <div class="grid grid--gap e-field--upload-photos">
                    <div class="e-upload-photo" v-for="i in 8">
                        <template v-if="previews.length >= i">
                            <div class="exel e-upload-photo--exel" style="display: flex; justify-content: center; align-items: center;">
                                <img :src="previews[i-1]" alt="" style="max-width: 100%; max-height: 100%;">
                            </div>
                            <div class="remove e-upload-photo--remove" style="display: block;" @click="removePhoto(i)"></div>
                        </template>
                        <template v-else>
                            <!--<input class="e-upload-photo--input" type="file" accept="image/*">-->
                            <div class="exel e-upload-photo--exel" @click="selectPhoto"></div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Страна
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <IncludeInputWithFilter v-model="announcement.country_id" :data="countries" order-by="name" filter-by="name" placeholder="Начните вводить название страны" />
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Город
                    </span>
                    <span class="color--persimmon size--13">
                        *
                    </span>
                </div>
                <div>
                    <IncludeInputWithFilter v-model="announcement.city_id" :data="cities" order-by="name" filter-by="name" placeholder="Начните вводить название города" v-if="announcement.country_id" />
                    <input class="form--control form--control-gray size--13" placeholder="Сначала выберите страну" disabled v-else>
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <div class="pretty p-default p-curve">
                        <input type="checkbox" v-model="publish_owner" :disabled="processing">
                        <div class="state">
                            <label>
                                <span class="size--13">Опубликовать на моей странице</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-field" v-if="announcement.pet_id">
                <div></div>
                <div>
                    <div class="pretty p-default p-curve">
                        <input type="checkbox" v-model="publish_pet" :disabled="processing">
                        <div class="state">
                            <label>
                                <span class="size--13">Опубликовать на странице питомца</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="e-field e-field--next e-field--no-margin">
                <div></div>
                <div class="style--right">
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" disabled v-if="uploading">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        <template v-if="uploadedCount != uploads.length">
                            Загрузка {{ uploadedCount + 1 }} фото из {{ uploads.length }}
                        </template>
                    </button>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }" v-else>
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Сохранить
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';
import { mapGetters, mapActions } from 'vuex';
import { mapCacheActions } from 'vuex-cache';

export default {
    data() {
        return {
            processing: false,
            countries: [],
            cities: [],
            pets: [],
            genders: window.transferData.genderList,
            currencies: window.transferData.сurrenciesList,
            announcement: {
                from: 1,
                category_id: null,
                pet_id: null,
                title: null,
                gender: null,
                vetpassport: false,
                pedigree: false,
                contract: false,
                vaccination: false,
                mark: false,
                chip: false,
                description: null,
                price: null,
                currency: 1,
                bargain: false,
                country_id: null,
                city_id: null
            },
            announcement_birth_day: null,
            announcement_birth_month: null,
            announcement_birth_year: null,
            petName: null,
            uploading: false,
            uploads: [],
            previews: [],
            photos: [],
            uploadedCount: 0,
            publish_owner: false,
            publish_pet: false,
            category_id: null,
            subcategory_id: null,
            subcategories: []
        }
    },
    computed: {
        ...mapGetters({
            profile: 'selfProfile'
        }),
        ...mapGetters([
            // 'marketCategories'
        ]),
        year() {
            return new Date().getFullYear();
        },
        petsByName() {
            if (!this.petName) {
                return [];
            }
            const name = this.petName.toLowerCase();



            return this.pets.filter(p => {
                return p.name.toLowerCase().includes(name);
            });
        },
        selectedPet() {
            return this.pets.find(p => p.user_id == this.announcement.pet_id);
        }
    },
    asyncComputed: {
        categories: {
            async get() {
                return await this.MARKET_CATEGORIES_GET();
            },
            default: []
        }
    },
    async beforeRouteEnter(to, from, next) {
        const data = (await axios.get('/api/user/announcements/create')).data;
        const countries = (await axios.get('/api/countries?lang=ru')).data;
        next(vm => {
            vm.pets = data.pets;
            vm.countries = countries;
        });
    },
    created() {
        this.announcement.category_id = this.$route.query.category_id || null;
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
        const sel = $('#select-year').next().find('.list');
        sel.scrollTop(sel[0].scrollHeight);
    },
    watch: {
        pets() {
            $(this.$el).find('select').niceSelect('destroy');
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect();
            });
        },
        categories() {
            $(this.$el).find('select').niceSelect('destroy');
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect();
            });
        },
        'announcement.pet_id': function() {
            if (!this.announcement.pet_id) {
                return;
            }

            const pet = this.pets.find(p => p.user_id == this.announcement.pet_id);

            if (pet.birthday) {
                const birthday = pet.birthday.split('-');
                this.announcement_birth_day = + birthday[2];
                this.announcement_birth_month = + birthday[1];
                this.announcement_birth_year = + birthday[0];
                $(this.$el).find('.select-birthday').niceSelect('destroy');
                this.$nextTick(() => {
                    $(this.$el).find('.select-birthday').niceSelect();
                });
            }
            if (pet.gender) {
                this.announcement.gender = pet.gender;
                $(this.$el).find('.select-gender').niceSelect('destroy');
                this.$nextTick(() => {
                    $(this.$el).find('.select-gender').niceSelect();
                });
            }
        },
        'announcement.country_id': async function(newId, oldId) {
            if (typeof oldId !== 'undefined') {
                this.announcement.city_id = null;
            }
            this.cities = [];
            if (this.announcement.country_id) {
                this.cities = (await axios.get('/api/cities?country_id=' + this.announcement.country_id + '&lang=ru')).data;
            }
        },
        async category_id(parent_id) {
            this.subcategories = [];

            if (!parent_id) return;

            this.subcategories = await this.MARKET_CATEGORIES_GET({
                parent_id
            });
        }
    },
    methods: {
        ...mapActions([
            'PHOTOS_SELECT',
            'PHOTOS_UPLOAD'
        ]),
        ...mapCacheActions([
            'MARKET_CATEGORIES_GET'
        ]),
        // checkPrice(event) {
        //     let fixed = event.target.value.replace(/[^0-9\.]/g, "");
        //     if (fixed.charAt(0) === ".") {
        //         fixed = fixed.slice(1);
        //     }
        //
        //     let pos = fixed.indexOf(".") + 1;
        //     if (pos >= 0) {
        //         //avoid more than one .
        //         fixed = fixed.substr(0, pos) + fixed.slice(pos).replace(".", "");
        //     }
        //     console.log(fixed);
        //     this.announcement.price = fixed;
        // },
        petSelect(id) {
            this.announcement.pet_id = id;
        },
        petUnselect() {
            this.announcement.pet_id = null;
            this.$nextTick(() => {
                $(this.$el).find('.user-input input')[0].focus();
            });
        },
        async create() {
            $('.toast.toast-error').remove();
            this.processing = true;

            const {
                from,
                pet_id,
                title,
                gender,
                description,
                price,
                currency,
                country_id,
                city_id
            } = this.announcement;

            const {
                publish_pet,
                publish_owner
            } = this;

            const vetpassport = + this.announcement.vetpassport;
            const pedigree = + this.announcement.pedigree;
            const contract = + this.announcement.contract;
            const vaccination = + this.announcement.vaccination;
            const mark = + this.announcement.mark;
            const chip = + this.announcement.chip;
            const bargain = + this.announcement.bargain;

            const category_id = this.subcategory_id || this.category_id;

            let birthday = null;

            if (this.announcement_birth_day && this.announcement_birth_month && this.announcement_birth_year) {
                birthday = this.announcement_birth_year + '-'
                         + (this.announcement_birth_month + '').padStart(2, '0') + '-'
                         + (this.announcement_birth_day + '').padStart(2, '0');
            }

            if (this.uploads.length != this.photos.length) {
                this.uploading = true;
                this.uploadedCount = 0;
                let owner_id;
                let owner_type;
                if (this.$route.query.shop_id) {
                    owner_id = this.$route.query.shop_id;
                    owner_type = 'shop';
                } else {
                    owner_id = this.profile.user_id;
                    owner_type = 'profile';
                }
                for (const photo of this.uploads) {
                    const response = await this.PHOTOS_UPLOAD({
                        photo,
                        owner_id,
                        owner_type,
                        section: 5
                    });
                    this.photos.push(response.photo.id);
                    this.uploadedCount++;
                }
                this.uploading = false;
            }

            // try {
                await axios.post('/api/user/announcements', {
                    from,
                    category_id,
                    pet_id,
                    title,
                    gender,
                    birthday,
                    vetpassport,
                    pedigree,
                    contract,
                    vaccination,
                    mark,
                    chip,
                    description,
                    price,
                    currency,
                    bargain,
                    country_id,
                    city_id,
                    photos: this.photos,
                    publish_pet,
                    publish_owner,
                    shop_id: this.$route.query.shop_id
                }).then( response => {
                    if (response.data.id) {
                        toastr.success('Объявление успешно добавлено');

                        if (this.$route.query.shop_id) {
                            this.$router.push('/settings/announcements?shop_id=' + this.$route.query.shop_id);
                        } else {
                            this.$router.push('/settings/announcements');
                        }
                    }
                }).catch(errors => {
                    if (errors.response.data && errors.response.data.errors) {
                        Object.entries(errors.response.data.errors).forEach(error => {
                            toastr.error(error[1][0]);
                        });
                    } else {
                        toastr.error('Ошибка при добавлении объявления');
                        this.processing = false;
                    }
                });

            this.processing = false;
        },
        async selectPhoto() {
            const files = await this.PHOTOS_SELECT(true);

            if (files.length > 8) {
                toastr.error('Максимальное количество фотографий - 8');
                return;
            }

            this.uploads = this.uploads.concat(Array.from(files));

            for (const file of files) {
                const reader = new FileReader();

                reader.onabort = () => {
                    //alert('abort');
                };

                reader.onloadend = () => {
                    this.previews.push(reader.result);
                };

                reader.readAsDataURL(file);
            }
        },
        removePhoto(number) {
            const n = number - 1;
            this.previews.splice(n, 1);
            this.uploads.splice(n, 1);
            if (this.photos[n]) {
                this.photos.splice(n, 1);
            }
        }
    }
}
</script>


<style lang="scss">
    .user-pets-list {
        max-height: 400px;
        overflow-y: auto;
    }
</style>
