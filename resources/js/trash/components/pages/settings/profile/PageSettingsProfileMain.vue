<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field" v-if="profile.type == 3">
            <div>
                <span class="size--13">
                    Официальная кличка / Official Name
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Официальная кличка" type="text" required v-model="profile.name" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field" v-else>
            <div>
                <span class="size--13">
                    Имя
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Имя" type="text" required v-model="profile.name" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field" v-if="profile.home_name !== undefined">
            <div>
                <span class="size--13">
                    Кличка
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Кличка" type="text" v-model="profile.home_name" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Пол
                </span>
            </div>
            <div>
                <select class="form--control-gray wide form--control size--13" v-model="profile.gender" :disabled="processing">
                    <option value="null">Не указан</option>
                    <option value="1">Мужской</option>
                    <option value="2">Женский</option>
                </select>
            </div>
        </div>
        <div class="e-field" v-if="profile.type == 3">
            <div>
                <span class="size--13">
                    Вид
                </span>
            </div>
            <div>
                <select class="form--control-gray wide form--control size--13" v-model="profile.pet_type" :disabled="processing">
                    <option value="null">Не указан</option>
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
        <div class="e-field" v-if="profile.type == 3">
            <div>
                <span class="size--13">
                    Заводчик
                </span>
            </div>
            <div>
                <IncludeInputSearchProfile v-model="profile.breeder" :query="{ types: '1,2' }" />
            </div>
        </div>
        <!--
        <div class="e-field" v-if="profile.type == 3" style="opacity: .2;">
            <div></div>
            <div>
                <a class="btn btn-boder btn-round btn-gray btn-bigger size--13 btn-block" href="#">
                    Добавить заводчика
                </a>
            </div>
        </div>
        `-->
        <div class="e-field" v-if="profile.type == 3">
            <div>
                <span class="size--13">
                    Владелец
                </span>
            </div>
            <div>
                <IncludeInputSearchProfile v-model="profile.owner" :query="{ types: '1,2' }" />
            </div>
        </div>
        <div class="e-field" v-if="profile.type == 3">
            <div>
                <span class="size--13">
                    Питомник рождения
                </span>
            </div>
            <div>
                <IncludeInputSearchCommunity v-model="profile.born_nursery" :query="{ type: 2 }" />
            </div>
        </div>
        <div class="e-field" v-if="profile.type == 3">
            <div>
                <span class="size--13">
                    Питомник пребывания
                </span>
            </div>
            <div>
                <IncludeInputSearchCommunity v-model="profile.nursery" :query="{ type: 2 }" />
            </div>
        </div>
        <div class="e-field" v-if="profile.inbreeding !== undefined">
            <div>
                <span class="size--13">
                    Инбридинг
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Инбридинг" type="text" v-model="profile.inbreeding" :disabled="processing">
            </div>
        </div>
        <div class="e-field" v-if="profile.korung !== undefined">
            <div>
                <span class="size--13">Кёрунг</span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Кёрунг" type="text" v-model="profile.korung" :disabled="processing">
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Дата рождения
                </span>
            </div>
            <div class="e-field e-field--three e-field--no-margin e-field--date">
                <select class="form--control-gray wide form--control size--13" v-model="profile_birth_day" :disabled="processing">
                    <option value="null" disabled>День</option>
                    <option v-for="day in 31" :value="day">{{ day }}</option>
                </select>
                <select class="form--control-gray wide form--control size--13" v-model="profile_birth_month" :disabled="processing">
                    <option value="null" disabled>Месяц</option>
                    <option v-for="(month, i) in ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']" :value="i + 1">{{ month }}</option>
                </select>
                <select class="form--control-gray wide form--control size--13" v-model="profile_birth_year" :disabled="processing" id="select-year">
                    <option value="null" disabled>Год</option>
                    <option v-for="i in 100" :value="(year - 100) + i">{{ (year - 100) + i }}</option>
                </select>
            </div>
        </div>
        <div class="e-field" v-if="profile.type != 3">
            <div>
                <span class="size--13">
                    Семейное положение
                </span>
            </div>
            <div>
                <select class="form--control-gray wide form--control size--13" v-model="profile.marital_status" :disabled="processing">
                    <option value="null">Не указано</option>
                    <option value="1">
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
                    </option>
                    <option value="2">
                        <template v-if="profile.gender == 1">
                            Женат
                        </template>
                        <template v-else-if="profile.gender == 2">
                            Замужем
                        </template>
                        <template v-else>
                            Женат/Замужем
                        </template>
                    </option>
                </select>
            </div>
        </div>
        <div class="e-field" v-if="profile.weight !== undefined">
            <div>
                <span class="size--13">
                    Вес
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Вес" type="text" v-model="profile.weight" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field" v-if="profile.size !== undefined">
            <div>
                <span class="size--13">
                    Размер
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Размер" type="text" v-model="profile.size" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field" v-if="profile.titles !== undefined">
            <div>
                <span class="size--13">
                    Титулы
                </span>
            </div>
            <div>
                <textarea class="form--control form--control-gray size--13" rows="4" placeholder="Титулы" v-model="profile.titles" :disabled="processing" maxlength="1000"></textarea>
                <div class="size--12 margin--top-5 color--regent-gray">
                    Осталось символов: {{ 1000 - (profile.titles ? profile.titles.length : 0) }}
                </div>
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Обо мне
                </span>
            </div>
            <div>
                <textarea class="form--control form--textarea form--control-gray size--13" rows="4" placeholder="Расскажите пару слов о себе" v-model="profile.about" :disabled="processing" maxlength="1000"></textarea>
                <div class="size--12 margin--top-5 color--regent-gray">
                    Осталось символов: {{ 1000 - (profile.about ? profile.about.length : 0) }}
                </div>
            </div>
        </div>
        <div class="e-field">
            <div>
                <span class="size--13">
                    Сайт
                </span>
            </div>
            <div>
                <input class="form--control form--control-gray size--13" placeholder="Сайт" type="text" v-model="profile.site" :disabled="processing" maxlength="255">
            </div>
        </div>
        <div class="e-field" v-if="profile.type == 3">
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
        <div class="e-field">
            <div></div>
            <div>
                <div class="pretty p-default p-curve">
                    <input type="checkbox" v-model="profile.noavatar" :disabled="processing">
                    <div class="state">
                        <label>
                            <span class="size--13">Отключить отображение аватара</span>
                        </label>
                    </div>
                </div>
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
</template>

<script>
import toastr from 'toastr';

export default {
    data() {
        return {
            processing: false,
            profile: {},
            profile_birth_day: null,
            profile_birth_month: null,
            profile_birth_year: null
        }
    },
    computed: {
        year() {
            return new Date().getFullYear();
        }
    },
    created() {
        this.profile = Object.assign({}, this.$store.getters.selfProfile);

        if (this.profile.birthday) {
            const birthday = this.profile.birthday.split('-');
            this.profile_birth_day = + birthday[2];
            this.profile_birth_month = + birthday[1];
            this.profile_birth_year = + birthday[0];
        }
    },
    mounted() {
        $(this.$el).find('select').niceSelect();
        const sel = $('#select-year').next().find('.list');
        sel.scrollTop(sel[0].scrollHeight);
    },
    methods: {
        async update() {
            this.processing = true;

            const {
                name,
                gender,
                pet_type,
                home_name,
                marital_status,
                inbreeding,
                korung,
                weight,
                size,
                titles,
                about,
                site,
                memory,
                noavatar
            } = this.profile;

            let birthday = null;

            if (this.profile_birth_day && this.profile_birth_month && this.profile_birth_year) {
                birthday = this.profile_birth_year + '-'
                         + (this.profile_birth_month + '').padStart(2, '0') + '-'
                         + (this.profile_birth_day + '').padStart(2, '0');
            }

            try {
                await this.$store.dispatch('PROFILE_UPDATE', {
                    name,
                    gender,
                    pet_type,
                    home_name,
                    birthday,
                    marital_status,
                    inbreeding,
                    korung,
                    weight,
                    size,
                    titles,
                    about,
                    site,
                    memory,
                    noavatar,
                    owner_id: this.profile.owner ? this.profile.owner.user_id : null,
                    breeder_id: this.profile.breeder ? this.profile.breeder.user_id : null,
                    nursery_id: this.profile.nursery ? this.profile.nursery.id : null,
                    born_nursery_id: this.profile.born_nursery ? this.profile.born_nursery.id : null
                });
                toastr.success('Профиль успешно обновлен');
            } catch (e) {

            }

            this.processing = false;
        }
    },
    watch: {
        'profile.gender': function() {
            $(this.$el).find('select').niceSelect('destroy');
            this.$nextTick(() => {
                $(this.$el).find('select').niceSelect();
            });
        }
    }
}
</script>
