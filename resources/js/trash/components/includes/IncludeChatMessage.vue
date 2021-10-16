<template>
    <div class="chat-message">
        <div class="e-avatar">
            <router-link class="e-avatar--photo" :to="message.sender.link" :style="{ 'background-image': 'url(\'' + message.sender.avatar + '\')' }"></router-link>
            <div class="e-avatar--content">
                <router-link class="e-article--floor" :to="message.sender.link">
                    {{ message.sender.name }}
                </router-link>
                <p class="size--14">{{ message.body }}</p>
                <div class="e-article--utter">
                    <!--
                    <span class="e-article--exile" :title="message.created_at">
                        {{ created_at }}
                    </span>
                -->
                    <!--
                    <a class="e-bwn--like e-bwn" :class="{ like: comment.liked }" href="#" @click.prevent="toggleLike">
                        <span class="e-bwn--faith">
                            {{ comment.likes_count }}
                        </span>
                    </a>
                    -->
                </div>
            </div>
            <!--
            <IncludeDropdown class="dropdown-right">
                <template v-slot:toggle>
                    <div class="btn btn-round size--13 __btn-boder btn-more c-gray">
                        <i class="fa fa-chevron-down m-0" aria-hidden="true"></i>
                    </div>
                </template>
                <ul class="dropdown-menu separated" style="text-align: left;">
                    <li v-if="false">
                        <a href="#">
                            <i class="fa fa-fw fa-pencil-alt" aria-hidden="true"></i>
                            Редактировать
                        </a>
                    </li>
                    <li v-if="false">
                        <a href="#">
                            <i class="fa fa-fw fa-flag" aria-hidden="true"></i>
                            Пожаловаться
                        </a>
                    </li>
                    <li>
                        <a href="#" @click.prevent="destroy" v-if="owner_self">
                            <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
                            Удалить
                        </a>
                    </li>
                </ul>
            </IncludeDropdown>
            -->
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: Object
    }
}
</script>

<style scoped>
.chat-message {
    margin: .5em 0;
}
.e-avatar {
    align-items: flex-start;
}
</style>
