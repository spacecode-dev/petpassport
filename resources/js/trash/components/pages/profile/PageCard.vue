<template>
    <div class="petcard" v-if="!loading">
        <div class="main">
            <aside class="p-3">
                <router-link :to="profile.link" class="d-block mb-3">
                    <img class="petcard-photo" :src="profile.avatar" :alt="profile.name">
                </router-link>
                <p class="py-1">
                    <span>
                        Порода:
                    </span>
                    <span v-if="profile.passport.breed">
                        {{ profile.passport.breed }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Страна нахождения:
                    </span>
                    <span v-if="profile.country_id">
                        {{ profile_country_name }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Место рождения:
                    </span>
                    <span v-if="profile.birth_country_id">
                        {{ profile_birth_country_name }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Дата рождения:
                    </span>
                    <span v-if="profile.birthday">
                        {{ profile.birthday }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Пол:
                    </span>
                    <span v-if="profile.gender == 1">
                        Мужской
                    </span>
                    <span v-else-if="profile.gender == 2">
                        Женский
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Вес:
                    </span>
                    <span v-if="profile.pet_profile.weight">
                        {{ profile.pet_profile.weight }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Размер:
                    </span>
                    <span v-if="profile.pet_profile.size">
                        {{ profile.pet_profile.size }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Цвет:
                    </span>
                    <span v-if="profile.passport.colour">
                        {{ profile.passport.colour }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Приметы:
                    </span>
                    <span v-if="profile.passport.dist_marks">
                        {{ profile.passport.dist_marks }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Заводчик:
                    </span>
                    <span>
                        <router-link :to="breeder.link">
                            {{ breeder.name }}
                        </router-link>
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Владелец:
                    </span>
                    <span>
                        <router-link :to="owner.link">
                            {{ owner.name }}
                        </router-link>
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Питомник:
                    </span>
                    <span class="c-gray">
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Отец:
                    </span>
                    <span v-if="father">
                        <router-link :to="father.link">
                            {{ father.name }}
                        </router-link>
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Мать:
                    </span>
                    <span v-if="mother">
                        <router-link :to="mother.link">
                            {{ mother.name }}
                        </router-link>
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Инбридинг:
                    </span>
                    <span v-if="profile.pet_profile.inbreeding">
                        {{ profile.pet_profile.inbreeding }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
                <p class="py-1">
                    <span>
                        Кёрунг:
                    </span>
                    <span v-if="profile.pet_profile.korung">
                        {{ profile.pet_profile.korung }}
                    </span>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </p>
            </aside>
            <main class="p-3 pl-0">
                <div class="my-3 p-3 petcard-logo">
                    <img src="/img/logo.png" alt="PetPassport" class="logo m-2">
                </div>
                <h1 class="style--center my-3">
                    <router-link :to="profile.link" class="c-black">
                        {{ profile.name }}
                    </router-link>
                </h1>
                <div class="style--center">
                    {{ profile.about }}
                </div>
                <div class="divider my-3 mx-auto"></div>
                <div class="style--center">
                    Титулы:
                    <template v-if="profile.pet_profile.titles">
                        {{ profile.pet_profile.titles }}
                    </template>
                    <span class="c-gray" v-else>
                        Нет данных
                    </span>
                </div>
                <div class="px-2 mt-3 mb-2" style="margin-left: 1.6em;">
                    Родственники:
                </div>
                <div class="relatives py-2">
                    <i class="ico ico--sex-male"></i>
                    <span class="mx-2 c-gray">|</span>
                    <template v-if="relatives_male.length">
                        <router-link v-for="r in relatives_male" :key="r.user_id" :to="r.link" class="mx-2">
                            {{ r.name }}
                        </router-link>
                    </template>
                    <span class="mx-2 c-gray" v-else>
                        Нет данных
                    </span>
                </div>
                <div class="relatives py-2">
                    <i class="ico ico--sex-fem"></i>
                    <span class="mx-2 c-gray">|</span>
                    <template v-if="relatives_female.length">
                        <router-link v-for="r in relatives_female" :key="r.user_id" :to="r.link" class="mx-2">
                            {{ r.name }}
                        </router-link>
                    </template>
                    <span class="mx-2 c-gray" v-else>
                        Нет данных
                    </span>
                </div>
                <div class="px-2 mt-3 mb-2" style="margin-left: 1.6em;">
                    Потомство:
                </div>
                <div class="relatives py-2">
                    <i class="ico ico--sex-male"></i>
                    <span class="mx-2 c-gray">|</span>
                    <template v-if="childrens_male.length">
                        <router-link v-for="c in childrens_male" :key="c.user_id" :to="c.link" class="mx-2">
                            {{ c.name }}
                        </router-link>
                    </template>
                    <span class="mx-2 c-gray" v-else>
                        Нет данных
                    </span>
                </div>
                <div class="relatives py-2">
                    <i class="ico ico--sex-fem"></i>
                    <span class="mx-2 c-gray">|</span>
                    <template v-if="childrens_female.length">
                        <router-link v-for="c in childrens_female" :key="c.user_id" :to="c.link" class="mx-2">
                            {{ c.name }}
                        </router-link>
                    </template>
                    <span class="mx-2 c-gray" v-else>
                        Нет данных
                    </span>
                </div>
                <div class="qrcode p-3">
                    <img :src="qrcode" :alt="profile.name">
                </div>
            </main>
        </div>
        <footer class="p-3">
            <router-link class="btn btn-boder btn-gray size--14 btn-round btn-bigger btn-wider mr-3" :to="profile.link">
                Профиль
            </router-link>
            <router-link class="btn btn-boder btn-gray size--14 btn-round btn-bigger btn-wider mr-3" :to="profile.link + '/passport'">
                Паспорт
            </router-link>
            <router-link class="btn btn-boder btn-gray size--14 btn-round btn-bigger btn-wider mr-3" :to="profile.link + '/pedigree'">
                Родословная
            </router-link>
            <div class="style--center">
                personal pet card &copy; petpassport.online
            </div>
            <button class="btn btn-boder btn-gray size--14 btn-round btn-bigger btn-wider ml-3" style="width: 150px; padding-left: 0 !important; padding-right: 0 !important;" @click.prevent="print">
                Печать
            </button>
        </footer>
    </div>
</template>

<script>
import axios from 'axios';
import NProgress from 'nprogress';
import { mapCacheActions } from 'vuex-cache';

export default {
    data() {
        return {
            loading: false,
            profile: {
                owners: []
            }
        }
    },
    asyncComputed: {
        async profile_country_name() {
            if (!this.profile.country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id == this.profile.country_id).name;
        },
        async profile_birth_country_name() {
            if (!this.profile.birth_country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id == this.profile.birth_country_id).name;
        }
    },
    computed: {
        owner() {
            return this.profile.owners.length ? this.profile.owners[0] : {};
        },
        breeder() {
            return this.owner;
        },
        father() {
            return this.profile.parents.find(p => p.gender == 1);
        },
        mother() {
            return this.profile.parents.find(p => p.gender == 2);
        },
        relatives_male() {
            return this.profile.relatives.filter(c => c.gender == 1);
        },
        relatives_female() {
            return this.profile.relatives.filter(c => c.gender == 2);
        },
        childrens_male() {
            return this.profile.childrens.filter(c => c.gender == 1);
        },
        childrens_female() {
            return this.profile.childrens.filter(c => c.gender == 2);
        },
        qrcode() {
            const link = document.location.origin + this.profile.link;
            return 'https://chart.apis.google.com/chart?choe=UTF-8&chld=H|0&cht=qr&chs=300x300&chl=' + link;
        }
    },
    created() {
        this.load()
    },
    methods: {
        ...mapCacheActions([
            'getCountries',
            'getCities'
        ]),
        async load() {
            this.loading = true;
            NProgress.start();
            const { data } = await axios.get('/api/profiles/' + this.$route.params.slug + '/card');
            if (!data.passport) {
                data.passport = {};
            }
            this.profile = data;
            NProgress.done();
            this.loading = false;
        },
        print() {
            window.print();
        }
    }
}
</script>

<style lang="scss" scoped>
.petcard {
    background: var(--c-white);

    .main {
        display: flex;
    }

    aside {
        width: 25vw;
        min-width: 300px;

        p {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
        }
    }

    main {
        flex: 1;
        position: relative;
        padding-bottom: 170px; /*qrcode*/

        .petcard-logo {
            position: absolute;
            right: 0;
            top: 0;
        }

        .divider {
            width: 30%;
            border-bottom: 1px solid #DDD;
        }

        .relatives {
            display: flex;
            align-items: center;
        }

        .qrcode {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 150px;
            box-sizing: content-box;

            img {
                width: 100%;
            }
        }
    }

    footer {
        display: flex;
        align-items: center;
        border-top: 1px solid #DDD;

        .btn {
            text-transform: uppercase;
        }

        div {
            flex: 1;
        }
    }

    h1,
    h2 {
        text-align: center;
    }

    h1 {
        font-size: 2rem;
    }

    h2 {
        font-size: 1.2rem;
        font-weight: 600;
    }
}
.petcard-photo {
    display: block;
    width: 100%;
    border-radius: 50%;
}
</style>
