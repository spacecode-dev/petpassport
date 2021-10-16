<template>
    <section>
        <ProfileHeader type="is-white" :sidebar="false"/>
        <vue-custom-scrollbar class="scroll-area" tagname="div" :settings="settings">
            <div class="content">
                <SettingsSidebar/>
                <router-view/>
            </div>
        </vue-custom-scrollbar>
    </section>
</template>

<script>
    import vueCustomScrollbar from 'vue-custom-scrollbar';
    import ProfileHeader from '../includes/ProfileHeader';
    import SettingsSidebar from '../includes/SettingsSidebar';
    import {mapGetters, mapState} from 'vuex';

    export default {
        components: {
            vueCustomScrollbar,
            ProfileHeader,
            SettingsSidebar
        },
        computed: {
            ...mapState({
                settings: state => state.settings.scroll.settings
            }),
            ...mapGetters([
                'user'
            ]),
            ...mapGetters({
                profile: 'selfProfile'
            })
        }
    }
</script>

<style lang="scss" scoped>
    ::v-deep {
        & > .content {
            display: flex;
            background: #e9eaee;
            height: 100vh;
            margin: 0;
            padding: 102px 30px 20px 30px;
            .menu {
                flex-shrink: 0;
                width: 16.85rem;
                margin-right: 20px;
                .menu-list {
                    margin: 0 !important;
                    list-style: none;
                    background: white !important;
                    box-shadow: 0 1px 1px rgba(30,38,56,.25),0 2px 5px rgba(30,38,56,.15);
                    border-radius: 4px;
                    li {
                        margin: 0;
                        padding: 0 1.12rem;
                        a {
                            padding: 1.05rem 0;
                            border-bottom: 1px solid #ddd;
                            background: transparent;
                            border-radius: 0;
                            font-size: .8rem;
                            font-weight: 700;
                            display: flex;
                            align-items: center;
                            position: relative;
                            &:before {
                                content: '';
                                position: absolute;
                                left: -18px;
                                top: 0;
                                bottom: 0;
                                width: 3px;
                                background: transparent;
                            }
                            &.is-active, &:hover {
                                background: transparent;
                                color: var(--violet);
                                span.icon {
                                    opacity: 1;
                                }
                            }
                            &.is-active {
                                &:before {
                                    background: var(--violet);
                                }
                            }
                            span.icon {
                                opacity: .5;
                                margin-right: 1rem;
                                i {
                                    font-size: 1.1rem;
                                    line-height: 1;
                                }
                            }
                        }
                    }
                }
            }
            .content--main {
                flex-grow: 1;
                h3 {
                    font-size: 1.1rem;
                    font-weight: 700;
                    margin-top: 2rem;
                    color: var(--mirage);
                }
                .b-tabs {
                    nav.tabs {
                        margin-bottom: 1rem;
                        ul {
                            margin: 1rem 0 0 0;
                            font-size: .85rem;
                            font-weight: 600;
                            li {
                                &.is-active a {
                                    border-bottom-color: var(--violet);
                                }
                                a {
                                    padding: 0 0 .7rem 0;
                                    margin-right: 1.4rem;
                                    border-width: 3px;
                                    border-bottom-color: transparent;
                                }
                            }
                        }
                    }
                    .tab-content {
                        padding: 0;
                    }
                }
            }
        }
        .card {
            box-shadow: 0 1px 1px rgba(30,38,56,.25),0 2px 5px rgba(30,38,56,.15);
            border-radius: 4px;
            margin-bottom: 20px;
            &.filemanager {
                margin-top: 1.5rem;
                .card-content {
                    height: calc(100vh - 210px);
                }
                .scroll-area {
                    height: calc(100vh - 366px);
                }
            }
            .card-content {
                .content {
                    display: flex;
                    .left {
                        margin-right: 3rem;
                        font-size: .85rem;
                        flex-basis: calc(30% - 20px);
                        small {
                            color: var(--manatee);
                        }
                    }
                    .right {
                        flex-basis: calc(35% - 20px);
                        margin-top: .5rem;
                        .button {
                            padding: .55rem 2rem;
                            height: auto;
                            margin-top: .5rem;
                        }
                        .field {
                            &:not(:last-child) {
                                margin-bottom: 2rem;
                            }
                            .control {
                                .help.counter {
                                    position: absolute;
                                    right: 8px;
                                    bottom: 3px;
                                    font-size: .6rem;
                                    margin: 0;
                                }
                                .select {
                                    height: 2.5rem;
                                    select {
                                        font-size: .85rem;
                                        height: 2.5rem;
                                    }
                                    &:after {
                                        transform: rotate(-45deg) scale(.7);
                                        margin-top: -.3em;
                                    }
                                }
                                span.icon {
                                    transform: scale(.8);
                                    right: 3px;
                                }
                                input {
                                    box-shadow: none;
                                }
                                input, span.icon {
                                    font-size: .85rem;
                                    height: 2.5rem;
                                }
                            }
                            .checkbox {
                                .control-label {
                                    font-size: .85rem;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
