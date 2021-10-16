<template>
    <form class="e-box e-box--padding" @submit.prevent="update">
        <div class="e-field" v-if="false">
            <div>
                <span class="size--13">Тип сообщества</span>
            </div>
            <div>
                <select class="form--control-gray wide form--control" v-model="community.type" :disabled="processing">
                    <option value="1">Группа</option>                        <option value="2">Питомник</option>
                    <option value="3">Страница</option>
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
        <template v-if="community.profile_nursery">
            <div class="e-field">
                <div>
                    <span class="size--13">Сертификат</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" type="text" placeholder="Сертификат" v-model="community.profile_nursery.certificate" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Владелец
                    </span>
                </div>
                <div>
                    <IncludeInputSearchProfile v-model="community.profile_nursery.owner" :query="{ types: '1,2' }" />
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Адрес</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" type="text" placeholder="Адрес" v-model="community.profile_nursery.address" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Телефон</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" type="text" placeholder="Телефон" v-model="community.profile_nursery.phone" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">E-mail</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" type="text" placeholder="E-mail" v-model="community.profile_nursery.email" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Сайт</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" type="text" placeholder="Сайт" v-model="community.profile_nursery.site" :disabled="processing">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        История питомника
                    </span>
                </div>
                <div>
                    <textarea class="form--control form--control-gray size--13" rows="4" placeholder="История питомника" v-model="community.profile_nursery.history" :disabled="processing" maxlength="1000"></textarea>
                    <div class="size--12 margin--top-5 color--regent-gray">
                        Осталось символов: {{ 1000 - (community.profile_nursery.history ? community.profile_nursery.history.length : 0) }}
                    </div>
                </div>
            </div>
        </template>
        <template v-if="community.profile_breed">
            <div class="e-field">
                <div>
                    <span class="size--13">
                        История породы
                    </span>
                </div>
                <div>
                    <textarea class="form--control form--control-gray size--13" rows="4" placeholder="История породы" v-model="community.profile_breed.history" :disabled="processing" maxlength="5000"></textarea>
                    <div class="size--12 margin--top-5 color--regent-gray">
                        Осталось символов: {{ 5000 - (community.profile_breed.history ? community.profile_breed.history.length : 0) }}
                    </div>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Стандарт породы
                    </span>
                </div>
                <div>
                    <textarea class="form--control form--control-gray size--13" rows="4" placeholder="Стандарт породы" v-model="community.profile_breed.standard" :disabled="processing" maxlength="5000"></textarea>
                    <div class="size--12 margin--top-5 color--regent-gray">
                        Осталось символов: {{ 5000 - (community.profile_breed.standard ? community.profile_breed.standard.length : 0) }}
                    </div>
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">
                        Терминология
                    </span>
                </div>
                <div>
                    <textarea class="form--control form--control-gray size--13" rows="4" placeholder="Терминология" v-model="community.profile_breed.terminology" :disabled="processing" maxlength="5000"></textarea>
                    <div class="size--12 margin--top-5 color--regent-gray">
                        Осталось символов: {{ 5000 - (community.profile_breed.terminology ? community.profile_breed.terminology.length : 0) }}
                    </div>
                </div>
            </div>
        </template>
        <div class="e-field">
            <div></div>
            <div>
                <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit" :disabled="processing" :class="{ loading: processing }">
                    <div class="loader">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                    </div>
                    Сохранить
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

export default {
    data() {
        return {
            processing: false,
            community: {}
        }
    },
    created() {
        this.community = this.$parent.community;
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
        '$parent.community': function() {
            this.community = this.$parent.community;
        }
    },
    methods: {
        async update() {
            this.processing = true;

            const { name, slug } = this.community;

            let profile = {};

            if (this.community.profile_nursery) {
                profile = this.community.profile_nursery;
                profile.owner_id = this.community.profile_nursery.owner ? this.community.profile_nursery.owner.user_id : null;
                profile.owner = null;
            }

            if (this.community.profile_breed) {
                profile = this.community.profile_breed;
            }

            try {
                const community = (await axios.put('/api/communities/' + this.community.id, {
                    name,
                    slug,
                    ...profile
                })).data;

                toastr.success('Сообщество успешно отредактировано');
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
                        toastr.error('Произошла ошибка при редактировании сообщества');
                }
            }
            this.processing = false;
        }
    }
}
</script>
