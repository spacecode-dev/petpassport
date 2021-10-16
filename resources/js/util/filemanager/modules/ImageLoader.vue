<template>
    <transition name="fade">
        <div @click.prevent="clickStrategy" class="card">
            <div v-if="file.mime !== 'image'" v-html="file.thumb" class="mime-icon"/>
            <div v-if="file.mime === 'image'" ref="image" class="image-block"/>
            <div v-if="!showModal" :class="['actions-grid', {'is-select': multiSelecting}]">
                <b-checkbox v-if="multiSelecting" v-model="selected"/>
                <div v-else>
                    <b-icon v-if="deletePermission" @click.native.prevent="deleteFile($event)" icon="delete-sweep" class="trash"/>
                    <b-icon v-if="renamePermission" @click.native.prevent="renameFile($event)" icon="square-edit-outline"/>
                </div>
            </div>
            <div v-if="showModal" class="actions-grid is-select is-modal">
                <b-checkbox v-model="selected"/>
            </div>
            <div class="name">
                {{ file.name | truncate(25) }}
            </div>
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
        computed: {
            ...mapState({
                showModal: state => state.settings.filemanager.showModal
            }),
            selected() {
                if(this.showModal) {
                    return (findIndex(this.selectedFiles, {id: this.file.id, mime: this.file.mime, path: this.file.asset}) >= 0);
                } else {
                    return (findIndex(this.selectedFiles, {type: this.file.type, path: this.file.path}) >= 0);
                }
            },
        },
        mounted() {
            if (this.file.mime === 'image') {
                let imageDiv = document.createElement('div');
                imageDiv.style.backgroundImage = "url('" + this.file.thumb + "')";
                imageDiv.className = 'block-grid';
                imageDiv.draggable = false;
                this.$refs.image.appendChild(imageDiv);
            }
            EventBus.$on('removeSelectedInModal', (arg) => {
                this.selectedFiles = arg;
            });
        },
        methods: {
            clickStrategy() {
                if(this.showModal) {
                    return this.select()
                } else {
                    return this.multiSelecting ? this.select() : this.showInfo();
                }
            },

            select() {
                if(this.showModal) {
                    this.$emit('select', {
                        id: this.file.id,
                        mime: this.file.mime,
                        path: this.file.asset,
                    });
                } else {
                    this.$emit('select', {
                        type: this.file.type,
                        path: this.file.path,
                    });
                }
            },

            showInfo() {
                this.$emit('showInfo', this.file);
            },

            deleteFile(e) {
                this.stopDefaultActions(e);
                EventBus.$emit('openModal', 'delete');
                EventBus.$emit('delete', 'file', this.file.path);
            },

            renameFile(e) {
                this.stopDefaultActions(e);
                EventBus.$emit('openModal', 'rename');
                EventBus.$emit('rename', 'file', this.file.path);
            },

            stopDefaultActions(e) {
                e.preventDefault();
                e.stopPropagation();
            },
        },
        filters: {
            truncate: function (text, stop, clamp) {
                return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '');
            },
        },
    };
</script>
