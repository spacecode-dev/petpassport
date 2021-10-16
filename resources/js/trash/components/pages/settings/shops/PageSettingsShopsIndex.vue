<template>
    <div class="grid grid--gap grid--three">
        <div class="e-card-shop e-box e-box--padding" v-for="shop in shops" :key="shop.id">
            <div class="e-card-shop--exile">
                <h4 class="weight--600 margin--bottom-5">{{ shop.name }}</h4>
                <p class="size--13 line-height--1_6">{{ shop.sign }}</p>
            </div>
            <div class="e-card-shop--subject">
                <router-link class="btn btn-round btn-bigger size--13 weight--600 btn-boder btn-gray" :to="'/market/shops/' + shop.id">
                    В магазин
                </router-link>
                <a class="btn btn-round btn-bigger size--13 weight--600 btn-blue">Продвинуть</a>
                <IncludeDropdown class="dropdown-right">
                    <template v-slot:toggle>
                        <div class="btn-round size--13 weight--600 btn-boder btn-more">
                            <i class="ico ico--more"></i>
                        </div>
                    </template>
                    <ul class="dropdown-menu-custom separated" style="text-align: left;">
                        <li>
                            <router-link :to="'/settings/announcements?shop_id=' + shop.id">
                                Объявления
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="'/settings/shops/' + shop.id + '/edit'">
                                Редактировать
                            </router-link>
                        </li>
                        <li><a @click.prevent="deleteShop(shop.id)">Удалить</a></li>
                    </ul>
                </IncludeDropdown>
                <!--
                <div class="mdrop--wrap mdrop--toggle">
                    <div class="btn-round size--12 weight--600 btn-boder btn-more">
                        <i class="ico ico--more"></i>
                    </div>
                    <div class="mdrop mdrop--list">
                        <div>
                            <ul>
                                <li>
                                    <router-link :to="'/settings/shops/' + shop.id + '/edit'">
                                        Редактировать
                                    </router-link>
                                </li>
                                <li><a href="#">Продать</a></li>
                                <li><a @click.prevent="deleteShop(shop.id)">Удалить</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                -->
            </div>
        </div>
        <router-link class="e-card-shop e-box e-box--padding e-card-shop--create" to="/settings/shops/create">
            <i class="ico ico--create"></i>
            <p class="size--13 weight--600 color--black margin--top-20">Создать магазин</p>
        </router-link>
    </div>
</template>

<script>
import axios from 'axios';
import toastr from 'toastr';

export default {
    data() {
        return {
            shops: []
        }
    },
    async beforeRouteEnter(to, from, next) {
        const shops = (await axios.get('/api/user/shops')).data;
        next(vm => vm.shops = shops);
    },
    /*
    async beforeRouteUpdate(to, from, next) {
        this.shops = null;
        this.shops = (await axios.get('/api/shops')).data;
    }
    */
    methods: {
        async deleteShop(id) {
            let confirmed = confirm('Вы действительно хотите удалить этот магазин?\nДанное действие необратимо');
            if (confirmed) {
                await axios.delete('/api/user/shops/' + id);
                this.shops = this.shops.filter(shop => shop.id != id);
                toastr.success('Магазин успешно удален', 'Магазин удален');
            }
        }
    }
}
</script>
