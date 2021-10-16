<template>
    <b-menu>
        <b-menu-list>
            <b-menu-item icon="view-grid" label="Меню заводчика" tag="router-link" to="/settings/breeder"/>
            <b-menu-item icon="cog" label="Настройка аккаунта" tag="router-link" to="/settings/account"/>
            <b-menu-item icon="account" label="Настройка профиля" tag="router-link" to="/settings/profile"/>
            <b-menu-item icon="file-tree" label="Менеджер файлов" tag="router-link" to="/settings/filemanager"/>
            <b-menu-item icon="lock" label="Конфиденциальность" tag="router-link" to="/settings/privacy" disabled/>
            <b-menu-item icon="security" label="Безопасность" tag="router-link" to="/settings/security" disabled/>
            <b-menu-item icon="cancel" label="Блокировка" tag="router-link" to="/settings/lock" disabled/>
            <b-menu-item icon="file-multiple" label="Объявления" tag="router-link" to="/settings/announcements"/>
            <b-menu-item icon="store" label="Магазины" tag="router-link" to="/settings/shops"/>
            <b-menu-item icon="wallet" label="Кошелёк" tag="router-link" to="/settings/wallet"/>
            <b-menu-item icon="delete" label="Удалить аккаунт" tag="router-link" to="/settings/destroy"/>
        </b-menu-list>
    </b-menu>
</template>

<script>
    export default {
        //
    }
</script>

<style lang="scss" scoped>
    ::v-deep {

    }
</style>
