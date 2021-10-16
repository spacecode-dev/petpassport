<template>
    <transition name="fade">
        <div @click.prevent="clickStrategy">
            <template v-if="file.id === 'folder_back'">
                <b-icon icon="undo-variant" class="main-svg"/>
                <div class="name">Назад</div>
            </template>
            <template v-else>
                <b-icon icon="folder" class="main-svg"/>
                <div v-if="!showModal" :class="['actions-grid', {'is-select': multiSelecting}]">
                    <b-checkbox v-if="multiSelecting" v-model="selected"/>
                    <div v-else>
                        <b-icon v-if="deletePermission" @click.native.prevent="deleteFolder($event)" icon="delete-sweep" class="trash"/>
                        <b-icon v-if="renamePermission" @click.native.prevent="editFolder($event)" icon="square-edit-outline"/>
                    </div>
                </div>
                <div class="name">
                    {{ file.name }}
                </div>
            </template>
        </div>
    </transition>
</template>

<script>
    import findIndex from 'lodash/findIndex';
    import EventBus from "../../event-bus";
    import {mapState} from "vuex";

    export default {
        props: {
            file: {
                type: Object,
                default: function () {
                    return {name: ''};
                },
                required: true,
            },
            multiSelecting: {
                type: Boolean,
                default: false,
                required: false,
            },
            selectedFiles: {
                type: Array,
                default: () => [],
                required: false,
            },
            deletePermission: {
                type: Boolean,
                required: false,
                default: true,
            },
            renamePermission: {
                type: Boolean,
                required: false,
                default: true,
            },
        },

        data() {
            return {
                loading: true,
                missing: false
            }
        },

        mounted() {
            this.loading = false;
        },

        computed: {
            ...mapState({
                showModal: state => state.settings.filemanager.showModal
            }),
            selected() {
                return (
                    findIndex(this.selectedFiles, {type: this.file.type, path: this.file.path}) >= 0
                );
            },
        },

        methods: {
            clickStrategy() {
                return this.multiSelecting ? this.select() : this.goToFolder();
            },

            goToFolder() {
                this.$emit('goToFolderEvent', this.file.path);
            },

            deleteFolder(e) {
                this.stopDefaultActions(e);
                EventBus.$emit('openModal', 'delete');
                EventBus.$emit('delete', 'folder', this.file.path);
            },

            editFolder(e) {
                this.stopDefaultActions(e);
                EventBus.$emit('openModal', 'rename');
                EventBus.$emit('rename', 'folder', this.file.path);
            },

            stopDefaultActions(e) {
                e.preventDefault();
                e.stopPropagation();
            },

            select() {
                this.$emit('select', {
                    type: this.file.type,
                    path: this.file.path,
                });
            },
        },
    };
</script>
