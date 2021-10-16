<template>
    <div>
        <h3 class="size--18 weight--700 e-title--page">
            Добавить питомца
        </h3>
        <ul class="left e-tab--nav">
            <li class="label-show" :class="{ active: tab == 1 }" @click="tab = 1">
                <span class="size--14">
                    Создать аккаунт
                </span>
            </li>
            <li class="label-show" :class="{ active: tab == 2 }" @click="tab = 2">
                <span class="size--14">
                    Добавить существующий
                </span>
            </li>
        </ul>
        <form class="e-box e-box--padding" @submit.prevent="create" v-if="tab == 1">
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Кличка
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Кличка" type="text" required v-model="profile.name" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Логин
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Латиницей, без пробелов" type="text" required v-model="user.login" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Вид питомца
                    </span>
                </div>
                <div>
                    <select class="form--control-gray wide form--control" v-model="profile.pet_type" :disabled="processing">
                        <option value="null" disabled>Выберите вид питомца</option>
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
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Пол
                    </span>
                </div>
                <div>
                    <select class="form--control-gray wide form--control" v-model="profile.gender" :disabled="processing">
                        <option value="null">Не указан</option>
                        <option value="1">Мужской</option>
                        <option value="2">Женский</option>
                        <option value="0">Помёт</option>
                    </select>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Пароль
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Латиницей, без пробелов" type="password" required v-model="user.password" :disabled="processing">
                </div>
            </div>
            <!--
            <div class="e-field">
                <div></div>
                <div>
                    <div class="pretty p-default p-curve">
                        <input type="checkbox" v-model="profile.memory" :disabled="processing">
                        <div class="state">
                            <label>
                                <span class="size--13">Памятный аккаунт</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            -->
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
        <form class="e-box e-box--padding" @submit.prevent="add" v-if="tab == 2">
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Логин
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Логин" type="text" required v-model="user.login" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Пароль
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Пароль" type="password" required v-model="user.password" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Добавить
                    </button>
                </div>
            </div>
        </form>
        <h4 class="size--18 weight--700 e-title--content">
            Список питомцев
        </h4>
        <div class="sr-prefab e-box">
            <button class="sr-prefab--button"></button>
            <input class="sr-prefab--input" type="text" placeholder="Поиск среди питомцев" v-model="search">
        </div>
        <h4 class="weight--600 e-title--content">
            Мужского пола
        </h4>
        <div class="grid grid--gap grid--three" v-if="petsMale.length">
            <div class="e-do" v-for="pet in petsMale" :key="pet.user_id">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="'/' + pet.slug" :style="{ 'background-image': 'url(\'' + pet.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="'/' + pet.slug">
                                {{ pet.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding">
                    <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="login(pet.user_id)" :disabled="pet.processing">
                        Войти
                    </button>
                </div>
            </div>
        </div>
        <div class="e-box e-box--padding e-new" v-else>
            <span class="size--14" v-if="search">
                Не найдены питомцы мужского пола, соотстветствующие поисковому запросу
            </span>
            <span class="size--14" v-else>
                Вы еще не добавили питомцев мужского пола
            </span>
            <button class="btn btn-round btn-blue size--13 weight--600 btn-bigger" @click="createGender(1)">
                Добавить
            </button>
        </div>
        <h4 class="weight--600 e-title--content">
            Женского пола
        </h4>
        <div class="grid grid--gap grid--three" v-if="petsFemale.length">
            <div class="e-do" v-for="pet in petsFemale" :key="pet.user_id">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="'/' + pet.slug" :style="{ 'background-image': 'url(\'' + pet.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="'/' + pet.slug">
                                {{ pet.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding">
                    <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="login(pet.user_id)" :disabled="pet.processing">
                        Войти
                    </button>
                </div>
            </div>
        </div>
        <div class="e-box e-box--padding e-new" v-else>
            <span class="size--14" v-if="search">
                Не найдены питомцы женского пола, соотстветствующие поисковому запросу
            </span>
            <span class="size--14" v-else>
                Вы еще не добавили питомцев женского пола
            </span>
            <button class="btn btn-round btn-blue size--13 weight--600 btn-bigger" @click="createGender(2)">
                Добавить
            </button>
        </div>
        <h4 class="weight--600 e-title--content">
            Помёт
        </h4>
        <div class="grid grid--gap grid--three" v-if="petsBreed.length">
            <div class="e-do" v-for="pet in petsBreed" :key="pet.user_id">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="'/' + pet.slug" :style="{ 'background-image': 'url(\'' + pet.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="'/' + pet.slug">
                                {{ pet.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding">
                    <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="login(pet.user_id)" :disabled="pet.processing">
                        Войти
                    </button>
                </div>
            </div>
        </div>
        <div class="e-box e-box--padding e-new" v-else>
            <span class="size--14" v-if="search">
                Не найден помёт, соотстветствующий поисковому запросу
            </span>
            <span class="size--14" v-else>
                Вы еще не добавили помёт
            </span>
            <button class="btn btn-round btn-blue size--13 weight--600 btn-bigger" @click="createGender(0)">
                Добавить
            </button>
        </div>
        <h4 class="weight--600 e-title--content">
            Память
        </h4>
        <div class="grid grid--gap grid--three" v-if="petsMemory.length">
            <div class="e-do" v-for="pet in petsMemory" :key="pet.user_id">
                <div class="e-do--gossip">
                    <div class="e-avatar--65 e-box--padding e-avatar">
                        <router-link class="e-avatar--photo" :to="'/' + pet.slug" :style="{ 'background-image': 'url(\'' + pet.avatar + '\')' }"></router-link>
                        <div class="e-avatar--content">
                            <router-link class="size--14 weight--600 color--mirage margin--bottom-5 style--inline" :to="'/' + pet.slug">
                                {{ pet.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="e-do--foot e-box--padding">
                    <button class="btn btn-boder btn-round size--12 weight--600 btn-block btn-bigger btn-gray" @click="login(pet.user_id)" :disabled="pet.processing">
                        Войти
                    </button>
                </div>
            </div>
        </div>
        <div class="e-box e-box--padding e-new" v-else>
            <span class="size--14" v-if="search">
                Не найдены питомцы в разделе "Память", соотстветствующие поисковому запросу
            </span>
            <span class="size--14" v-else>
                Вы еще не добавили питомцев в раздел "Память"
            </span>
            <!--
            <button class="btn btn-round btn-blue size--13 weight--600 btn-bigger" @click="createMemory(2)">
                Добавить
            </button>
            -->
        </div>
    </div>
</template>

<script>
import NProgress from 'nprogress';
import axios from 'axios';
import querystring from 'querystring';
import toastr from 'toastr';
import { slugify } from 'transliteration';

export default {
    data() {
        return {
            tab: 1,
            processing: false,
            user: {
                login: null,
                password: null
            },
            profile: {
                name: null,
                pet_type: null,
                gender: null,
                memory: false
            },
            search: null,
            pets: []
        }
    },
    computed: {
        petsByName() {
            return [...this.pets].sort((a, b) => {
                if (a.name > b.name) {
                    return 1;
                }
                if (a.name < b.name) {
                    return -1;
                }
                return 0;
            });
        },
        petsByGender() {
            return [...this.petsByName].sort((a, b) => {
                if (!a.gender || !b.gender) {
                    return -1;
                }
                if (a.gender > b.gender) {
                    return 1;
                }
                if (a.gender < b.gender) {
                    return -1;
                }
                return 0;
            });
        },
        petsMale() {
            return this.petsByName.filter(pet => {
                if (this.search) {
                    if (!pet.name.toLowerCase().includes(this.search.toLowerCase())) {
                        return false;
                    }
                }
                return pet.gender == 1 && !pet.memory;
            });
        },
        petsFemale() {
            return this.petsByName.filter(pet => {
                if (this.search) {
                    if (!pet.name.toLowerCase().includes(this.search.toLowerCase())) {
                        return false;
                    }
                }
                return pet.gender == 2 && !pet.memory;
            });
        },
        petsBreed() {
            return this.petsByName.filter(pet => {
                if (this.search) {
                    if (!pet.name.toLowerCase().includes(this.search.toLowerCase())) {
                        return false;
                    }
                }
                return pet.gender == 0 && !pet.memory;
            });
        },
        petsMemory() {
            return this.petsByGender.filter(pet => {
                if (this.search) {
                    if (!pet.name.toLowerCase().includes(this.search.toLowerCase())) {
                        return false;
                    }
                }
                return pet.memory;
            });
        }/*
        petsMaleMemory() {
            return this.petsByName.filter(pet => {
                if (this.search) {
                    if (!pet.name.toLowerCase().includes(this.search.toLowerCase())) {
                        return false;
                    }
                }
                return pet.gender == 1 && pet.memory;
            });
        },
        petsFemaleMemory() {
            return this.petsByName.filter(pet => {
                if (this.search) {
                    if (!pet.name.toLowerCase().includes(this.search.toLowerCase())) {
                        return false;
                    }
                }
                return pet.gender == 2 && pet.memory;
            });
        }
        */
    },
    async beforeRouteEnter(to, from, next) {
        NProgress.start();
        const data = (await axios.get('/api/user/pets')).data;
        NProgress.done();
        next(vm => vm.pets = data);
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
    },
    watch: {
        'profile.gender': function() {
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect('update');
            });
        },
        'profile.name': function() {
            //if (this.profile.name && !this.user.login) {
                this.user.login = slugify(this.profile.name, {
                    lowercase: false,
                    separator: '_'
                });
            //}
        },
        tab() {
            $(this.$el).find('select').niceSelect('destroy');
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect();
            });
        }
    },
    methods: {
        scrollTop() {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        },
        createGender(gender) {
            this.profile.gender = gender;
            this.profile.memory = false;
            this.scrollTop();
        },
        createMemory(gender) {
            this.profile.gender = gender;
            this.profile.memory = true;
            this.scrollTop();
        },
        async create() {
            if (!this.profile.name ||
                !this.user.login ||
                !this.user.password) {
                toastr.error('Заполнены не все поля');
                return;
            }

            this.processing = true;

            const data = {
                ...this.user,
                ...this.profile
            };

            // Cast to boolean for Laravel validator
            data.memory = + data.memory;

            try {
                const pet = (await axios.post('/api/user/pets', querystring.stringify(data))).data;
                this.pets.push(pet);
                this.profile.name = '';
                this.user.login = '';
                this.user.password = '';
                toastr.success('Аккаунт питомца успешно создан');
            } catch(e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Невозможно использовать указанный логин');
                        break;
                    case 2:
                        toastr.error('Логин может содержать только латинские буквы, цифры, и символ подчеркивания');
                        break;
                    case 3:
                        toastr.error('Логин уже занят');
                        break;
                    default:
                        toastr.error('Произошла ошибка при создании аккаунта');
                        break;
                }
            }

            this.processing = false;
        },
        async add() {
            if (!this.user.login ||
                !this.user.password) {
                toastr.error('Заполнены не все поля');
                return;
            }

            this.processing = true;

            const { login, password } = this.user;

            try {
                const pet = (await axios.post('/api/user/pets/link', {
                    login,
                    password
                })).data;

                this.pets.push(pet);
                this.user.login = null;
                this.user.password = null;

                toastr.success('Аккаунт питомца успешно добавлен');
            } catch(e) {
                switch (e.response.data.code) {
                    case 1:
                        toastr.error('Неверный логин или пароль');
                        break;
                    case 2:
                        toastr.error('Данный аккаунт не является аккаунтом питомца');
                        break;
                    case 3:
                        toastr.error('Данный питомец уже прикреплен к Вашему аккаунту');
                        break;
                    default:
                        toastr.error('Произошла ошибка при добавлении аккаунта');
                        break;
                }
            }

            this.processing = false;
        },
        async login(id) {
            const pet = this.pets.find(pet => pet.user_id == id);
            pet.processing = true;

            try {
                const data = (await axios.post('/api/user/pets/' + id + '/login')).data;

                const user_id = this.$store.getters.user.id;

                await this.$store.dispatch('AUTH_LOGOUT');
                //await this.$store.cache.clear();
                await this.$store.dispatch('AUTH_SET_TOKEN', data.token);

                /*
                const profile = this.$store.getters.profileById(user_id);
                if (profile) {
                    profile.flags.self = false;
                    this.$store.commit('PROFILE_CACHE', profile);
                }
                */
                // TODO test this

                this.$router.push('/');
                toastr.success('Аккаунт успешно сменен', 'Аккаунт сменен');
            } catch (e) {
                toastr.error('Возникла ошибка при смене аккаунтов', 'Ошибка');
                console.log(e);
            }

            pet.processing = false;
        }
    }
}
</script>
