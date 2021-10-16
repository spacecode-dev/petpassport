<template>
    <div>
        <div class="py-5 style--center c-gray" v-if="loading">
            <i class="fa fa-circle-notch fa-spin" aria-hidden="true" style="font-size: 50px; margin: 0 0 20px;"></i>
            <!--
            <div class="size--14">
                Загрузка паспорта...
            </div>
            -->
        </div>
        <form class="e-box e-box--padding" @submit.prevent="update" v-else>
            <h4 class="size--16 weight--700 margin--bottom-20">
                Идентификация / Identification
            </h4>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Номер микрочипа / Microchip number
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер микрочипа" type="text" v-model="profile.passport.chip_number" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Локализация / Localization
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Локализация" type="text" v-model="profile.passport.localization" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Дата чипирования / Date of chiping
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Дата чипирования" type="date" v-model="profile.passport.chip_date" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Свидетельство / Certificate
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Свидетельство" type="text" v-model="profile.passport.certificate" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        DNK
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="DNK" type="text" v-model="profile.passport.dnk" :disabled="processing" maxlength="255">
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Сведения о регистрации / Registration data
            </h4>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Номер паспорта / Passport number
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер паспорта" type="text" v-model="profile.passport.reg_number" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Ветеринарная клиника / Vet clinic
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Ветеринарная клиника" type="text" v-model="profile.passport.reg_clinic" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Номер по журналу / RS in journal
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер по журналу" type="text" v-model="profile.passport.reg_journal_number" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Дата регистрации / Register date
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Дата регистрации" type="date" v-model="profile.passport.reg_date" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Имя ветеринара / Vet name
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Имя ветеринара" type="text" v-model="profile.passport.reg_vet_name" :disabled="processing" maxlength="255">
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Описание / Main information
            </h4>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Порода / Breed
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Порода" type="text" v-model="profile.passport.breed" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Окрас / Colour
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Окрас" type="text" v-model="profile.passport.colour" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Особые приметы / Distinguishing marks
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Особые приметы" type="text" v-model="profile.passport.dist_marks" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Номер карточки животного / Animal card number
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер карточки животного" type="text" v-model="profile.passport.animal_card_number" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Номер родословной / Pedigree number
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер родословной" type="text" v-model="profile.passport.pedigree_number" :disabled="processing" maxlength="255">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Номер клейма / Tatoo (tag) number
                    </span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер клейма" type="text" v-model="profile.passport.tag_number" :disabled="processing" maxlength="255">
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-25">
                Вакцинация от бешенства / Vaccination against rabbies
            </h4>
            <table class="margin--bottom-10">
                <thead>
                    <tr>
                        <th class="size--13 padding--bottom-10">
                            Дата / Date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Вид вакцины / Vaccine used
                        </th>
                        <th class="size--13 padding--bottom-10">
                            № серии / Batch №
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Врач / Veterinarian
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="d in drugs_rabbies">
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата" type="date" v-model="d.date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Вид вакцины" type="text" v-model="d.drug" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="№ серии" type="text" v-model="d.batch" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Врач" type="text" v-model="d.doctor" :disabled="processing" maxlength="255">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-boder size--12 weight--600 btn-round" :disabled="processing" @click.prevent="addDrugRow(1)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить вакцину
                    </button>
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Вакцинация / Vaccination
            </h4>
            <table class="margin--bottom-10">
                <thead>
                    <tr>
                        <th class="size--13 padding--bottom-10">
                            Дата / Date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Вид вакцины / Vaccine used
                        </th>
                        <th class="size--13 padding--bottom-10">
                            № серии / Batch №
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Врач / Veterinarian
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="d in drugs_vaccination">
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата" type="date" v-model="d.date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Вид вакцины" type="text" v-model="d.drug" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="№ серии" type="text" v-model="d.batch" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Врач" type="text" v-model="d.doctor" :disabled="processing" maxlength="255">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-boder size--12 weight--600 btn-round" :disabled="processing" @click.prevent="addDrugRow(2)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить вакцину
                    </button>
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Тесты / Tests
            </h4>
            <table class="margin--bottom-10">
                <thead>
                    <tr>
                        <th class="size--13 padding--bottom-10">
                            Дата / Date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Вид вакцины / Vaccine used
                        </th>
                        <th class="size--13 padding--bottom-10">
                            № серии / Batch №
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Врач / Veterinarian
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="d in drugs_tests">
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата" type="date" v-model="d.date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Вид вакцины" type="text" v-model="d.drug" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="№ серии" type="text" v-model="d.batch" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Врач" type="text" v-model="d.doctor" :disabled="processing" maxlength="255">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-boder size--12 weight--600 btn-round" :disabled="processing" @click.prevent="addDrugRow(3)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить тест
                    </button>
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Дегельментизация / Deworming
            </h4>
            <table class="margin--bottom-10">
                <thead>
                    <tr>
                        <th class="size--13 padding--bottom-10">
                            Дата / Date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Препарат / Treatment
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Доза / Dose
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Примечания / Comments
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="d in drugs_deworming">
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата" type="date" v-model="d.date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Препарат" type="text" v-model="d.drug" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Доза" type="text" v-model="d.dose" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Примечания" type="text" v-model="d.comments" :disabled="processing" maxlength="255">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-boder size--12 weight--600 btn-round" :disabled="processing" @click.prevent="addDrugRow(4)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить дегельментизацию
                    </button>
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Обработка от клещей / Tick treatment
            </h4>
            <table class="margin--bottom-10">
                <thead>
                    <tr>
                        <th class="size--13 padding--bottom-10">
                            Дата / Date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Препарат / Treatment
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Доза / Dose
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Примечания / Comments
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="d in drugs_tick">
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата" type="date" v-model="d.date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Препарат" type="text" v-model="d.drug" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Доза" type="text" v-model="d.dose" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Примечания" type="text" v-model="d.comments" :disabled="processing" maxlength="255">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-boder size--12 weight--600 btn-round" :disabled="processing" @click.prevent="addDrugRow(5)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить обработку от клещей
                    </button>
                </div>
            </div>
            <h4 class="size--16 weight--700 margin--bottom-20 margin--top-20">
                Таблица родов / Parturition table
            </h4>
            <table class="margin--bottom-10">
                <thead>
                    <tr>
                        <th class="size--13 padding--bottom-10">
                            Дата течки / Heat date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Pairing date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Дата родов / Parturition date
                        </th>
                        <th class="size--13 padding--bottom-10">
                            Приплод / Litter
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in profile.parturitions">
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата течки" type="date" v-model="p.heat_date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Pairing date" type="date" v-model="p.pairing_date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Дата родов" type="date" v-model="p.parturition_date" :disabled="processing" maxlength="255">
                        </td>
                        <td>
                            <input class="form--control form--control-gray size--13" placeholder="Приплод" type="text" v-model="p.litter" :disabled="processing" maxlength="255">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-boder size--12 weight--600 btn-round" :disabled="processing" @click.prevent="addParturitionRow">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Добавить роды
                    </button>
                </div>
            </div>
            <div class="e-field">
                <div></div>
                <div>
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                        <div class="loader">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                        Обновить
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

export default {
    data() {
        return {
            loading: false,
            processing: false,
            profile: {
                passport: {},
                drugs: [],
                parturitions: []
            }
        }
    },
    computed: {
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
    async created() {
        this.loading = true;
        const id = this.$store.getters.selfProfile.user_id;
        const { data } = await axios.get('/api/profiles/' + id + '/passport');
        if (!data.passport) {
            data.passport = {};
        }
        this.profile = data;
        for (let i = 1; i <= 5; i++) {
            this.addDrugRow(i);
        }
        this.addParturitionRow();
        this.loading = false;
    },
    methods: {
        async update() {
            this.processing = true;

            const {
                passport,
                drugs,
                parturitions
            } = this.profile;

            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    passport: JSON.stringify(passport),
                    drugs: JSON.stringify(drugs),
                    parturitions: JSON.stringify(parturitions)
                });
                toastr.success('Данные паспорта обновлены');
            } catch (e) {

            }

            this.processing = false;
        },
        addDrugRow(type) {
            this.profile.drugs.push({
                type
            });
        },
        addParturitionRow() {
            this.profile.parturitions.push({});
        }
    }
}
</script>
