<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Закрепление объявления
                </p>
                <p class="size--13 margin--top-25">
                    Ваше объявление будет закреплено вверху, и останется на виду у пользователей
                </p>
            </div>
            <div class="modal-sep"></div>
            <IncludeAnnouncementPromoteModal :announcement="announcement" :opcode="202" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        announcement: Object
    }
}
</script>
