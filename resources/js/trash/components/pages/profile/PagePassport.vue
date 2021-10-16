<template>
    <div class="passport" v-if="!loading">
        <router-link :to="profile.link">
            <img class="passport-photo" :src="profile.avatar" :alt="profile.name">
        </router-link>
        <h1>
            <router-link :to="profile.link" class="c-black">
                {{ profile.name }}
            </router-link>
        </h1>
        <h2 class="mt-3 mb-2">
            Описание / Main information
        </h2>
        <div class="row py-2">
            <div class="col">
                Кличка / Vet name
            </div>
            <div class="col style--right">
                {{ profile.name }}
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Дата Рождения / Date of birth
            </div>
            <div class="col style--right">
                <template v-if="profile.birthday">
                    {{ profile.birthday }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Пол / Sex
            </div>
            <div class="col style--right">
                <template v-if="profile.gender == 1">
                    Мужской
                </template>
                <template v-else-if="profile.gender == 2">
                    Женский
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Порода / Breed
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.breed">
                    {{ profile.passport.breed }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Окрас / Colour
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.colour">
                    {{ profile.passport.colour }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Особые приметы / Distinguishing marks
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.dist_marks">
                    {{ profile.passport.dist_marks }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Номер карточки животного / Animal card number 
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.animal_card_number">
                    {{ profile.passport.animal_card_mumber }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Номер родословной / Pedigree number
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.pedigree_number">
                    {{ profile.passport.pedigree_number }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Номер клейма / Tatoo (tag) number
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.tag_number">
                    {{ profile.passport.tag_number }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Свидетельство / Certificate
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.certificate">
                    {{ profile.passport.certificate }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <h2 class="mt-3 mb-2">
            Идентификация / Identification
        </h2>
        <div class="row py-2">
            <div class="col">
                Номер микрочипа / Microchip number
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.chip_number">
                    {{ profile.passport.chip_number }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Локализация / Localization
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.localization">
                    {{ profile.passport.localization }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Дата чипирования / Date of chiping
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.chip_date">
                    {{ profile.passport.chip_date }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <h2 class="mt-3 mb-2">
            Сведения о регистрации / Registration data
        </h2>
        <div class="row py-2">
            <div class="col">
                Номер паспорта / Passport number
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.reg_number">
                    {{ profile.passport.reg_number }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Ветеринарная клиника / Vet clinic
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.reg_clinic">
                    {{ profile.passport.reg_clinic }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Номер по журналу / RS in journal
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.reg_journal_number">
                    {{ profile.passport.reg_journal_number }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Дата регистрации / Register date
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.reg_date">
                    {{ profile.passport.reg_date }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Имя ветеринара / Vet name
            </div>
            <div class="col style--right">
                <template v-if="profile.passport.reg_vet_name">
                    {{ profile.passport.reg_vet_name }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <h2 class="mt-3 mb-2">
            Заводчик / Breeder
        </h2>
        <div class="row py-2">
            <div class="col">
                Заводчик / Breeder
            </div>
            <div class="col style--right">
                <router-link :to="breeder.link">
                    {{ breeder.name }}
                </router-link>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Адрес / Address
            </div>
            <div class="col style--right">
                <template v-if="breeder.address">
                    {{ breeder.address }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Телефон / Phone
            </div>
            <div class="col style--right">
                <template v-if="breeder.phone">
                    <a :href="'tel:' + breeder.phone">
                        {{ breeder.phone }}
                    </a>
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Почта / E-mail
            </div>
            <div class="col style--right">
                <template v-if="breeder.email">
                    <a :href="'mailto:' + breeder.email">
                        {{ breeder.email }}
                    </a>
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <h2 class="mt-3 mb-2">
            Владелец / Owner
        </h2>
        <div class="row py-2">
            <div class="col">
                Владелец / Owner
            </div>
            <div class="col style--right">
                <router-link :to="owner.link">
                    {{ owner.name }}
                </router-link>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Адрес / Address
            </div>
            <div class="col style--right">
                <template v-if="owner.address">
                    {{ owner.address }}
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Телефон / Phone
            </div>
            <div class="col style--right">
                <template v-if="owner.phone">
                    <a :href="'tel:' + owner.phone">
                        {{ owner.phone }}
                    </a>
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <div class="row py-2">
            <div class="col">
                Почта / E-mail
            </div>
            <div class="col style--right">
                <template v-if="owner.email">
                    <a :href="'mailto:' + owner.email">
                        {{ owner.email }}
                    </a>
                </template>
                <span class="c-gray" v-else>
                    Нет данных
                </span>
            </div>
        </div>
        <h2 class="mt-3 mb-2">
            Вакцинация от бешенства / Vaccination against rabbies
        </h2>
        <table v-if="drugs_rabbies.length">
            <thead>
                <tr>
                    <th class="p-2">
                        Дата / Date
                    </th>
                    <th class="p-2">
                        Вид вакцины / Vaccine used
                    </th>
                    <th class="p-2">
                        № серии / Batch №
                    </th>
                    <th class="p-2">
                        Врач / Veterinarian
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in drugs_rabbies">
                    <td class="p-2">
                        {{ d.date }}
                    </td>
                    <td class="p-2">
                        {{ d.drug }}
                    </td>
                    <td class="p-2">
                        {{ d.batch }}
                    </td>
                    <td class="p-2">
                        {{ d.doctor }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="c-gray style--center py-3" v-else>
            Нет данных
        </div>
        <h2 class="mt-3 mb-2">
            Вакцинация / Vaccination
        </h2>
        <table v-if="drugs_vaccination.length">
            <thead>
                <tr>
                    <th class="p-2">
                        Дата / Date
                    </th>
                    <th class="p-2">
                        Вид вакцины / Vaccine used
                    </th>
                    <th class="p-2">
                        № серии / Batch №
                    </th>
                    <th class="p-2">
                        Врач / Veterinarian
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in drugs_vaccination">
                    <td class="p-2">
                        {{ d.date }}
                    </td>
                    <td class="p-2">
                        {{ d.drug }}
                    </td>
                    <td class="p-2">
                        {{ d.batch }}
                    </td>
                    <td class="p-2">
                        {{ d.doctor }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="c-gray style--center py-3" v-else>
            Нет данных
        </div>
        <h2 class="mt-3 mb-2">
            Тесты / Tests
        </h2>
        <table v-if="drugs_tests.length">
            <thead>
                <tr>
                    <th class="p-2">
                        Дата / Date
                    </th>
                    <th class="p-2">
                        Вид вакцины / Vaccine used
                    </th>
                    <th class="p-2">
                        № серии / Batch №
                    </th>
                    <th class="p-2">
                        Врач / Veterinarian
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in drugs_tests">
                    <td class="p-2">
                        {{ d.date }}
                    </td>
                    <td class="p-2">
                        {{ d.drug }}
                    </td>
                    <td class="p-2">
                        {{ d.batch }}
                    </td>
                    <td class="p-2">
                        {{ d.doctor }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="c-gray style--center py-3" v-else>
            Нет данных
        </div>
        <h2 class="mt-3 mb-2">
            Дегельментизация / Deworming
        </h2>
        <table v-if="drugs_deworming.length">
            <thead>
                <tr>
                    <th class="p-2">
                        Дата / Date
                    </th>
                    <th class="p-2">
                        Препарат / Treatment
                    </th>
                    <th class="p-2">
                        Доза / Dose
                    </th>
                    <th class="p-2">
                        Примечания / Comments
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in drugs_deworming">
                    <td class="p-2">
                        {{ d.date }}
                    </td>
                    <td class="p-2">
                        {{ d.drug }}
                    </td>
                    <td class="p-2">
                        {{ d.dose }}
                    </td>
                    <td class="p-2">
                        {{ d.comments }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="c-gray style--center py-3" v-else>
            Нет данных
        </div>
        <h2 class="mt-3 mb-2">
            Обработка от клещей / Tick treatment
        </h2>
        <table v-if="drugs_tick.length">
            <thead>
                <tr>
                    <th class="p-2">
                        Дата / Date
                    </th>
                    <th class="p-2">
                        Препарат / Treatment
                    </th>
                    <th class="p-2">
                        Доза / Dose
                    </th>
                    <th class="p-2">
                        Примечания / Comments
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in drugs_tick">
                    <td class="p-2">
                        {{ d.date }}
                    </td>
                    <td class="p-2">
                        {{ d.drug }}
                    </td>
                    <td class="p-2">
                        {{ d.dose }}
                    </td>
                    <td class="p-2">
                        {{ d.comments }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="c-gray style--center py-3" v-else>
            Нет данных
        </div>
        <h2 class="mt-3 mb-2">
            Таблица родов / Parturition table
        </h2>
        <table v-if="profile.parturitions.length">
            <thead>
                <tr>
                    <th class="p-2">
                        Дата течки / Heat date
                    </th>
                    <th class="p-2">
                        Pairing date
                    </th>
                    <th class="p-2">
                        Дата родов / Parturition date
                    </th>
                    <th class="p-2">
                        Приплод / Litter
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="p in profile.parturitions">
                    <td class="p-2">
                        {{ p.heat_date }}
                    </td>
                    <td class="p-2">
                        {{ p.pairing_date }}
                    </td>
                    <td class="p-2">
                        {{ p.parturition_date }}
                    </td>
                    <td class="p-2">
                        {{ p.litter }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="c-gray style--center py-3" v-else>
            Нет данных
        </div>
        <button class="btn btn-boder btn-white weight--600 size--14 btn-round btn-bigger btn-wider d-block my-3 mx-auto" @click.prevent="print">
            <i class="fa fa-print" aria-hidden="true"></i>
            Печать
        </button>
    </div>
</template>

<script>
import axios from 'axios';
import NProgress from 'nprogress';

export default {
    data() {
        return {
            loading: false,
            profile: {
                owners: [],
                drugs: [],
                parturitions: []
            }
        }
    },
    computed: {
        owner() {
            return this.profile.owners.length ? this.profile.owners[0] : {};
        },
        breeder() {
            return this.owner;
        },
        drugs_rabbies() {
            return this.profile.drugs.filter(d => d.type == 1);
        },
        drugs_vaccination() {
            return this.profile.drugs.filter(d => d.type == 2);
        },
        drugs_tests() {
            return this.profile.drugs.filter(d => d.type == 3);
        },
        drugs_deworming() {
            return this.profile.drugs.filter(d => d.type == 4);
        },
        drugs_tick() {
            return this.profile.drugs.filter(d => d.type == 5);
        }
    },
    created() {
        this.load()
    },
    methods: {
        async load() {
            this.loading = true;
            NProgress.start();
            const { data } = await axios.get('/api/profiles/' + this.$route.params.slug + '/passport');
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
.passport {
    max-width: 650px;
    margin: 0 auto;

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

    table,
    table td,
    table th {
        border: 1px solid var(--c-gray);
    }

    table td {
        background: var(--c-white);
    }
}
.passport-photo {
    display: block;
    width: 200px;
    margin: 2rem auto;
    border-radius: 50%;
}
</style>
