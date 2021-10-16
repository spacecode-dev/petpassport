<template>
    <div class="modal">
        <div class="modal-wrap">
            <div class="modal-box modal-box-gray">
                <p class="size--18 weight--700">
                    Выделение объявления цветом
                </p>
                <p class="size--13 margin--top-25">
                    Ваше объявление будет выделено в общем списке, чем привлечет внимание потенциальных покупателей.
                </p>
                <!--
                <p class="size--13">
                    Посмотрите, как будет выглядеть Ваше объявление:
                </p>
                -->
                <div class="margin--top-25">
                    <div style="display: flex; margin: -15px;">
                        <div style="flex: 1; margin: 15px">
                            <div class="size--14 weight--600 style--center margin--bottom-20">
                                До:
                            </div>
                            <IncludeAnnouncement :announcement="example_default" class="m-0" />
                        </div>
                        <div style="flex: 1; margin: 15px;">
                            <div class="size--14 weight--600 style--center margin--bottom-20">
                                После:
                            </div>
                            <IncludeAnnouncement :announcement="example_colored" class="m-0" />
                        </div>    
                    </div>
                </div>
            </div>
            <div class="modal-sep"></div>
            <IncludeAnnouncementPromoteModal :announcement="announcement" :opcode="201" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        announcement: Object
    },
    computed: {
        example_default() {
            return {
                ...this.announcement,
                colored: false
            }
        },
        example_colored() {
            return {
                ...this.announcement,
                colored: true
            }
        }
    }
}
</script>
