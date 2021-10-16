<template>
    <section>
        <ProfileHeader/>
        <vue-custom-scrollbar class="scroll-area" tagname="div" :settings="settings">
            <div :class="['content', {fullWidth: !show}]">
                <ContentBackground/>
                <div class="content--menu">
                    <ContentMenuTop/>
                    <ContentMenuBottom/>
                </div>
                <router-view/>
                <ProfileSidebar/>
            </div>
        </vue-custom-scrollbar>
    </section>
</template>

<script>
    import vueCustomScrollbar from 'vue-custom-scrollbar';
    import ProfileHeader from '../includes/ProfileHeader';
    import ContentBackground from '../includes/content/ContentBackground';
    import ContentMenuTop from '../includes/content/ContentMenuTop';
    import ContentMenuBottom from '../includes/content/ContentMenuBottom';
    import ProfileSidebar from '../includes/ProfileSidebar';
    import {mapState} from 'vuex';
    import store from "../../store";

    export default {
        components: {
            vueCustomScrollbar,
            ProfileHeader,
            ContentBackground,
            ContentMenuTop,
            ContentMenuBottom,
            ProfileSidebar
        },
        computed: {
            ...mapState({
                settings: state => state.settings.scroll.settings,
                show: state => state.settings.sidebar.show
            })
        },
        async beforeRouteEnter(to, from, next) {
            await store.dispatch('PROFILE_SHOW', to.params.slug);
            next();
        },
    }
</script>

<style lang="scss" scoped>
    ::v-deep {
        article.notification.notify-help {
            min-height: 100px;
            display: flex;
            align-items: center;
        }
        .content {
            margin: 0;

            &.fullWidth {
                .content--bg {
                    .content--bg--buttons {
                        padding-left: 30px;
                    }

                    .content--bg--title {
                        padding-left: 30px;

                        .logo {
                            margin: 1.8rem 20px -90px 0;

                            img {
                                width: 16.85rem;
                                height: 16.85rem;
                            }
                        }
                    }
                }
            }

            .content--bg {
                position: relative;
                height: 400px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                box-shadow: 0 -16px 246px -30px rgba(0, 0, 0, .5) inset;

                .bg {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    object-fit: cover;
                    z-index: -1;
                    right: 0;
                    bottom: 0;
                }

                .content--bg--buttons {
                    padding-left: 325px;
                    transition: 0.25s padding cubic-bezier(0.785, 0.135, 0.15, 0.86);
                    z-index: 40;
                    display: flex;
                    justify-content: space-between;
                    margin-top: 90px;
                    margin-right: 30px;
                    height: 33px;

                    .change {
                        font-size: .9rem;
                        padding: 0;
                        border: 0;
                        background: transparent;
                        color: white;
                        opacity: .7;
                        margin-left: -2px;
                        cursor: pointer;
                        transition: 0.25s opacity cubic-bezier(0.785, 0.135, 0.15, 0.86);

                        &:hover {
                            opacity: 1;
                        }
                    }

                    .update {
                        font-size: .9rem;
                        background-color: transparent;
                        border-color: white;
                        color: white;
                    }
                }

                .content--bg--title {
                    width: 100%;
                    position: relative;
                    padding-left: 320px;
                    display: flex;
                    align-items: end;
                    transition: .25s padding cubic-bezier(0.785, 0.135, 0.150, 0.860);
                    z-index: 40;

                    .logo {
                        display: flex;
                        margin: 0 1.5rem -2rem 0;
                        transition: .25s margin cubic-bezier(0.785, 0.135, 0.150, 0.860);

                        img {
                            width: 200px;
                            height: 200px;
                            object-fit: cover;
                            transition: .25s width cubic-bezier(0.785, 0.135, 0.150, 0.860), .25s height cubic-bezier(0.785, 0.135, 0.150, 0.860);
                        }
                    }

                    h4 {
                        color: white;
                        font-size: 1.5rem;
                        margin-bottom: 1.5rem;
                        font-weight: 600;
                        text-transform: uppercase;
                    }
                }
            }

            .content--menu {
                .navbar {
                    &.content--menu--top {
                        z-index: 31;
                        margin-left: 100px;
                        padding: 0 30px;
                    }

                    &.content--menu--top, &.content--menu--bottom {
                        border-bottom: 1px solid rgba(30, 38, 56, 0.21);

                        .navbar-menu {
                            .navbar-end {
                                .last {
                                    padding-right: 0 !important;

                                    &:before {
                                        display: none;
                                    }
                                }

                                .navbar-item {
                                    font-weight: 600;
                                    font-size: 0.85rem;
                                    background: transparent;
                                    position: relative;
                                    padding: .5rem 1.5rem;
                                    letter-spacing: -.02rem;
                                    color: var(--mirage);

                                    &:hover {
                                        color: var(--violet);
                                    }

                                    .navbar-link {
                                        background: transparent;

                                        &.is-arrowless {
                                            padding: .5rem 0;
                                        }
                                    }

                                    &:before {
                                        position: absolute;
                                        content: '';
                                        width: 1px;
                                        height: 20px;
                                        background: rgba(30, 38, 56, 0.21);
                                        right: 0;
                                        top: 50%;
                                        transform: translate(0, -50%);
                                    }
                                }
                            }
                        }
                    }

                    &.content--menu--bottom {
                        padding: .1rem 30px;

                        .navbar-menu .navbar-end .navbar-item {
                            font-weight: 500;
                            font-size: .9rem;

                            &.has-dropdown {
                                .navbar-link {
                                    padding-right: 1.5rem;
                                    padding-left: 0;

                                    &:after {
                                        right: 3px;
                                        margin-top: -.4em;
                                    }
                                }
                            }

                            &:before {
                                display: none;
                            }
                        }
                    }
                }
            }

            .content--main {
                display: flex;
                background: #e9eaee;
                padding: 30px;

                .content--main--left {
                    flex-shrink: 0;
                    width: 16.85rem;
                    margin-right: 20px;
                }

                .content--main--right {
                    flex-grow: 1;

                    .content--main--features {
                        .columns {
                            .column {
                                align-items: stretch;
                                display: flex;

                                .card {
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                    width: 100%;

                                    &.shop {
                                        .card-content {
                                            padding-top: 0;
                                            text-align: center;
                                        }

                                        header {
                                            p {
                                                font-size: 1.2rem;
                                                justify-content: center;
                                            }
                                        }

                                        footer {
                                            .card-footer-item {
                                                display: flex;
                                                justify-content: space-between;
                                                align-items: center;

                                                .buttons {
                                                    display: flex;
                                                    justify-content: space-between;
                                                    width: 100%;
                                                    margin: 0;

                                                    .button {
                                                        height: 36px;
                                                        margin-bottom: 0;
                                                        width: 220px;
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    &.messages {
                                        .card-content {
                                            .content {
                                                display: flex;
                                                flex-direction: column;

                                                .text {
                                                    display: flex;
                                                    flex-direction: row;

                                                    img {
                                                        border-radius: 50rem;
                                                        object-fit: cover;
                                                        height: 3rem;
                                                        width: 3rem;
                                                        margin-right: .5rem;
                                                    }

                                                    .field {
                                                        flex-grow: 1;

                                                        textarea {
                                                            border: 0;
                                                            box-shadow: none;
                                                            resize: none;
                                                        }
                                                    }
                                                }

                                                .photos {
                                                    display: flex;
                                                    flex-direction: row;

                                                    figure {
                                                        margin: 0 1rem 0 0;
                                                        display: flex;
                                                        position: relative;

                                                        button {
                                                            position: absolute;
                                                            border: 0;
                                                            width: 48px;
                                                            height: 48px;
                                                            padding: 0;
                                                            margin: 0;
                                                            left: 0;
                                                            top: 0;
                                                            background: rgba(0, 0, 0, .3);
                                                            color: white;
                                                            cursor: pointer;
                                                            opacity: 0;
                                                            transition: .25s opacity cubic-bezier(0.785, 0.135, 0.150, 0.860);

                                                            &:hover {
                                                                opacity: 1;
                                                            }
                                                        }

                                                        img {
                                                            display: flex;
                                                            object-fit: cover;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        footer {
                                            .card-footer-item {
                                                display: flex;
                                                justify-content: space-between;
                                                align-items: center;

                                                .icons {
                                                    margin-left: .5rem;

                                                    #EmojiPicker {
                                                        position: absolute;
                                                        top: 43px;
                                                        left: 0;
                                                        opacity: 0;
                                                        visibility: hidden;
                                                        transition: 0.25s opacity cubic-bezier(0.785, 0.135, 0.15, 0.86);

                                                        &.show {
                                                            opacity: 1;
                                                            visibility: visible;
                                                        }
                                                    }
                                                }

                                                .buttons {
                                                    margin: 0;
                                                    flex-grow: 1;
                                                    justify-content: end;

                                                    .field {
                                                        margin: 0;
                                                    }

                                                    select {
                                                        background: transparent;
                                                        border-color: var(--pink-swan);
                                                        font-size: .85rem;
                                                        height: 36px;
                                                    }

                                                    .button {
                                                        margin-bottom: 0;
                                                        width: 240px;
                                                        height: 36px;
                                                        margin-left: 1rem;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    .content--main--entity {
                        .columns {
                            .column {
                                align-items: stretch;
                                display: flex;

                                .posts {
                                    width: 100%;

                                    .b-filter {
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        padding: 0 1rem 1rem 1rem;
                                        h6 {
                                            margin: 0;
                                        }
                                        .b-filter--talk {
                                            display: flex;
                                            align-items: center;
                                            & > span.icon {
                                                color: gray;
                                            }
                                            .dropdown {
                                                button {
                                                    border: 0;
                                                    background: 0;
                                                    display: flex;
                                                    margin-left: 1rem;
                                                    cursor: pointer;
                                                    align-items: center;
                                                    padding: 0;
                                                    span.icon {
                                                        transform: scale(.7);
                                                    }
                                                }
                                                .dropdown-menu {
                                                    min-width: 8.42rem;
                                                    .dropdown-item {
                                                        padding-right: 1rem;
                                                        padding-left: 1rem;
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    .card {
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: space-between;
                                        width: 100%;

                                        &.post {
                                            .card-top {
                                                display: flex;
                                                align-items: center;
                                                justify-content: space-between;
                                                margin: 0;
                                                padding: 1rem 1.5rem 0 1.5rem;
                                                div.first {
                                                    display: flex;
                                                    align-items: center;
                                                    a figure {
                                                        margin: 0 1rem 0 0;
                                                    }
                                                    .media-content .content {
                                                        font-size: .85rem;
                                                        div {
                                                            &.globe {
                                                                color: var(--gray);
                                                            }
                                                            .dropdown {
                                                                button {
                                                                    padding: 0;
                                                                    background: transparent;
                                                                    border: 0;
                                                                    cursor: pointer;
                                                                    margin-left: .3rem;
                                                                    color: var(--gray);
                                                                    span.icon {
                                                                        &:first-child {
                                                                            width: 16px;
                                                                        }
                                                                        &:last-child {
                                                                            width: 10px;
                                                                        }
                                                                        i:before {
                                                                            font-size: 1rem;
                                                                        }
                                                                    }
                                                                }
                                                                .dropdown-menu {
                                                                    .dropdown-item {
                                                                        padding-right: 1rem;
                                                                        padding-left: 1rem;
                                                                        .media {
                                                                            display: flex;
                                                                            align-items: center;
                                                                            padding: 0;
                                                                            border: 0;
                                                                            span.icon {
                                                                                margin-right: .5rem;
                                                                                i:before {
                                                                                    font-size: 16px;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                div.second {
                                                    .dropdown {
                                                        &.is-active {
                                                            button {
                                                                background: #e9eaee;
                                                            }
                                                        }
                                                        button {
                                                            cursor: pointer;
                                                            border: 0;
                                                            background: transparent;
                                                            color: var(--gray);
                                                            height: 30px;
                                                            width: 30px;
                                                            padding: 0;
                                                            display: flex;
                                                            align-items: center;
                                                            justify-content: center;
                                                            border-radius: 4px;
                                                            transition: 0.25s background cubic-bezier(0.785, 0.135, 0.15, 0.86);
                                                            &:hover {
                                                                background: #e9eaee;
                                                            }
                                                        }
                                                        .dropdown-menu {
                                                            .dropdown-item {
                                                                background-color: transparent;
                                                                color: #0a0a0a;
                                                                &:hover {
                                                                    background-color: #f5f5f5;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            }
                                            .card-content {
                                                padding-bottom: 0;
                                                .editable {
                                                    margin-bottom: 1rem;
                                                    .field {
                                                        margin: 0;
                                                    }
                                                }
                                                .body {
                                                    padding: 0 0 1.5rem 0;
                                                }
                                                .image {
                                                    img {
                                                        margin: 0 auto;
                                                        display: block;
                                                        width: auto;
                                                    }
                                                }
                                                .carousel {
                                                    .carousel-indicator {
                                                        padding-left: 0;
                                                        padding-right: 0;
                                                        .indicator-item {
                                                            &.is-active .al img {
                                                                filter: grayscale(0%);
                                                            }
                                                            .al img {
                                                                filter: grayscale(100%);
                                                                width: 100px;
                                                                height: 70px;
                                                                object-fit: cover;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            .comments {
                                                border-top: 1px solid #e6e9ee;
                                                .collapse-content {
                                                    & > div {
                                                        padding: 0 1rem .5rem 1rem;
                                                    }
                                                }
                                                .notify-help {
                                                    background: transparent;
                                                    margin: 0;
                                                }
                                                .comment-form {
                                                    display: flex;
                                                    align-items: center;
                                                    a {
                                                        margin-top: -2rem;
                                                        margin-right: 1rem;
                                                        figure {
                                                            margin: 0;
                                                        }
                                                    }
                                                    .field {
                                                        width: 100%;
                                                        .control {
                                                            textarea {
                                                                border: 0;
                                                                box-shadow: none;
                                                                resize: none;
                                                            }
                                                            .help.counter {
                                                                float: right;
                                                                margin-left: .5em;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            footer {
                                                background: transparent;
                                                border-top: 1px solid #e6e9ee;

                                                .card-footer-item {
                                                    display: flex;
                                                    justify-content: space-between;
                                                    align-items: center;

                                                    .one, .two {
                                                        display: flex;
                                                        align-items: center;
                                                        button {
                                                            display: flex;
                                                            align-items: center;
                                                        }
                                                    }

                                                    .one {
                                                        margin-left: 0.5rem;
                                                        button {
                                                            margin-right: .7rem;
                                                            span.icon {
                                                                transition: 0.25s color cubic-bezier(0.785, 0.135, 0.15, 0.86);
                                                                &.like {
                                                                    color: var(--red);
                                                                }
                                                            }
                                                        }
                                                    }

                                                    .two {
                                                        margin-right: 0.5rem;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                .card {
                    margin-bottom: 1.5rem;
                    box-shadow: 0 0 3px rgba(10, 10, 10, .1), 0 0 0 0 rgba(10, 10, 10, .1);
                    border-radius: .15rem;

                    header {
                        box-shadow: none;
                        padding: 1.5rem 1.5rem 0 1.5rem;

                        p {
                            font-weight: 600;
                            color: black;
                            font-size: 0.85rem;
                            padding: 0;
                        }
                    }

                    footer {
                        background: #f0f0f0;
                        border: 0;

                        .card-footer-item {
                            .icons {
                                color: var(--manatee);
                                position: relative;

                                button {
                                    border: 0;
                                    background: transparent;
                                    color: inherit;
                                    padding: 0;
                                }

                                .icon {
                                    margin: 0 .2rem;
                                    cursor: pointer;

                                    i {
                                        line-height: 1;

                                        &:before {
                                            font-size: 20px;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    .card-content {
                        .media {
                            align-items: center;

                            &:not(:last-child) {
                                margin-bottom: 1rem;
                            }

                            figure {
                                margin: 0;
                            }

                            .media-content {
                                .title {
                                    font-size: 0.9rem;
                                    font-weight: 400;
                                    color: black;
                                    display: block;
                                    line-height: 1;
                                }

                                .subtitle {
                                    color: var(--manatee);
                                    display: flex;
                                    align-items: center;
                                    margin-top: -1rem;
                                    font-size: .7rem;

                                    .icon {
                                        margin-right: .3rem;

                                        i {
                                            font-size: 1rem;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
