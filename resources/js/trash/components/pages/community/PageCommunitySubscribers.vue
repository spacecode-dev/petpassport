<template>
    <div class="cn-main">
        <div class="cn-main--left">
            
        </div>
        <div class="cn-main--content">
            <h3 class="size--18 weight--700 e-title--page">
                Подписчики
            </h3>
            <!--
            <ul class="left e-tab--nav">
                <router-link tag="li" class="label-show" active-class="active" :to="'/' + profile.profile.slug + '/friends/subscribers'">
                    <span class="size--14">Подписчики</span>
                    <span class="color--regent-gray size--14" v-if="false">
                        0
                    </span>
                </router-link>
            </ul>
            -->
            <IncludeSubscribers/>
        </div>
    </div>
</template>
