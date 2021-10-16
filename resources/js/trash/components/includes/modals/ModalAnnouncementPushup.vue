<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Поднятие объявления
                </p>
                <p class="size--13 margin--top-25">
                    Ваше объявление будет поднято в началов результатов поиска, и отобразится сразу после закрепленных объявлений
                </p>
            </div>
            <div class="modal-sep"></div>
            <IncludeAnnouncementPromoteModal :announcement="announcement" :opcode="203" :price="500" />
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
