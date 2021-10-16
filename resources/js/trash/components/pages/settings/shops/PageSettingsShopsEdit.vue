<template>
    <div>
        <div class="e-title--space e-title--page">
            <h3 class="size--18 weight--700">Редактирование магазина {{ shop.name }}</h3>
            <router-link class="color--manatee size--13" to="/settings/shops">Вернуться к списку магазинов</router-link>
        </div>
        <form class="e-box e-box--padding" @submit.prevent="update">
            <div class="e-field">
                <div>
                    <span class="size--13">Название магазина</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Название магазина" type="text" required v-model="shop.name">
                </div>
            </div>
            <div class="e-field" style="opacity: .2;">
                <div>
                    <span class="size--13">Контактное лицо</span>
               </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Контактное лицо" type="text">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Номер телефона</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Номер телефона" type="text" required v-model="shop.phone">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Email</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Email" type="text" required v-model="shop.email">
                </div>
            </div>
            <div class="e-field e-field--align-up e-field--first">
                <div>
                    <span class="size--13"></span>
                </div>
                <div class="grid grid--gap e-field--files" style="opacity: .2;">
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
            <div class="e-field">
                <div>
                    <span class="size--13">Подпись под логотипом</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Подпись под логотипом" type="text" required v-model="shop.sign">
                </div>
            </div>
            <div class="e-field">
                <div>
                    <span class="size--13">Описание магазина</span>
                </div>
                <div>
                    <textarea class="form--control form--textarea form--control-gray size--13" rows="4" placeholder="Описание магазина" v-model="shop.description"></textarea>
                </div>
            </div>
            <div class="e-field" style="opacity: .2;">
                <div>
                    <span class="size--13">Добавить второе контактное лицо?<br>(введите ID пользователя сервиса)</span>
                </div>
                <div>
                    <input class="form--control form--control-gray size--13" placeholder="Второе контактное лицо" type="text">
                </div>
            </div>
            <div class="e-field e-field--next e-field--no-margin">
                <div></div>
                <div class="style--right">
                    <button class="btn btn-blue size--12 weight--600 btn-bigger btn-round btn-wider" type="submit">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import querystring from 'querystring';
import toastr from 'toastr';

export default {
    data() {
        return {
            shop: {}
        }
    },
    async beforeRouteEnter(to, from, next) {
        const shop = (await axios.get('/api/user/shops/' + to.params.id)).data;
        next(vm => vm.shop = shop);
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
        async update() {
            try {
                await axios.put('/api/user/shops/' + this.shop.id, querystring.stringify(this.shop));

                toastr.success('Магазин успешно отредактирован');
                this.$router.push('/settings/shops');
            } catch (e) {
                
            }
        }
    }
}
</script>
