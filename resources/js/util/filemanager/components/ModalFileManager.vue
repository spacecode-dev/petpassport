<template>
    <b-modal id="modal-filemanager" :active.sync="showModal" has-modal-card trap-focus :on-cancel.prevent="handleClose">
        <div class="modal-card" style="width: 70vw;">
            <header class="modal-card-head">
                <p class="modal-card-title">Менеджер файлов</p>
            </header>
            <section class="modal-card-body modal-filemanager">
                <manager
                    ref="manager"
                    :files="files"
                    :userId="userId"
                    :path="path"
                    :current="currentPath"
                    :parent="parent"
                    :noFiles="noFiles"
                    :buttons="buttons"
                    :selected-files="selectedFiles"
                    @goToFolderManager="goToFolder"
                    @goToFolderManagerNav="goToFolderNav"
                    @select="select"
                />
            </section>
            <footer class="modal-card-foot">
                <b-button
                    type="is-secondary"
                    @click="handleClose"
                    size="is-normal"
                >
                    Закрыть
                </b-button>
                <b-button
                    :disabled="selectedFiles.length === 0"
                    type="is-success"
                    @click="handlePut"
                    size="is-normal"
                >
                    {{ selectedFiles.length > 0 ? 'Выбрать элементы' : 'Выбрать элемент' }}
                </b-button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
    import _ from 'lodash';
    import Manager from './Manager';
    import EventBus from "../../event-bus";
    import api from "../api";
    import {getToast} from "../../helper";
    import {mapState} from "vuex";
    import store from "../../../store";

    export default {
        name: 'Filemanager',
        props: {
            userId: {
                type: Number,
                default: 0,
                required: true,
            },
        },
        components: {
            manager: Manager
        },
        computed: {
            ...mapState({
                showModal: state => state.settings.filemanager.showModal
            }),
        },
        data() {
            return {
                currentPath: '/',
                files: [],
                parent: {},
                path: [],
                noFiles: false,
                buttons: [],
                selectedFiles: [],
            }
        },
        async created() {
            if (this.$route.query.path) {
                this.currentPath = this.$route.query.path;
            }
            await this.getData(this.currentPath);
        },
        mounted() {
            EventBus.$on('refreshFilemanager', () => {
                this.refreshCurrent();
            });
        },
        methods: {
            getData(pathToList) {
                this.files = [];
                this.parent = {};
                this.path = [];
                this.noFiles = false;
                return api.getData(pathToList, this.userId).then(result => {
                    if (_.size(result.files) === 0) {
                        this.noFiles = true;
                    }
                    this.files = result.files;
                    this.path = result.path;
                    this.parent = result.parent;
                    this.buttons = result.buttons;
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                });
            },
            refreshCurrent() {
                this.getData(this.currentPath);
            },
            goToFolder(path) {
                this.getData(path);
                this.currentPath = path;
                if (this.currentPath === '/') {
                    history.pushState(null, null, location.pathname);
                } else {
                    history.pushState(null, null, location.pathname + '?path=' + path);
                }
            },
            goToFolderNav(path) {
                this.getData(path);
                this.currentPath = path;
                this.selectedFiles = [];
                if (this.currentPath === '/') {
                    history.pushState(null, null, location.pathname);
                } else {
                    history.pushState(null, null, location.pathname + '?path=' + path);
                }
            },
            cancelSelected(selectedFiles) {
                store.dispatch('MODAL_FILEMANAGER_TOGGLE');
                if(!selectedFiles) {
                    store.dispatch('MODAL_FILEMANAGER_CLEAR_SELECTED');
                }
                history.pushState(null, null, location.pathname);
                this.currentPath = '/';
            },
            handleClose(selectedFiles = false) {
                this.cancelSelected(selectedFiles);
            },
            select(file) {
                const findIndex = _.findIndex(this.selectedFiles, file);
                if (findIndex >= 0) {
                    this.selectedFiles.splice(findIndex, 1);
                    return;
                }
                this.selectedFiles.push(file);
            },
            handlePut() {
                store.dispatch('MODAL_FILEMANAGER_PUT_SELECTED', this.selectedFiles);
                this.handleClose(true);
            }
        }
    };
</script>

<style lang="scss">
    #modal-filemanager {
        z-index: 9999;
        .animation-content {
            max-width: 70vw !important;
        }
        .modal-card-head {
            padding: 20px;
            border-bottom: 1px solid #e9eaee;
            p {
                font-size: 1.1rem !important;
                font-weight: 700;
                color: var(--mirage) !important;
            }
        }
        .files {
            & > div {
                justify-content: start;
            }
            .grid {
                margin-right: 2rem;
                margin-bottom: 2rem;
                .file-item {
                    margin: 0;
                    .actions-grid.is-select.is-modal {
                        right: 0;
                        .b-checkbox.checkbox:not(.button) {
                            margin-right: 0;
                        }
                    }
                    .image-block {
                        top: 0;

                        .block-grid {
                            width: 200px;
                            height: 170px;
                        }
                    }
                }
            }
        }
        .manual_upload > input[type='file'] {
            display: none;
        }
        .rotate svg {
            animation: fa-spin 2s infinite linear;
        }
        .loader {
            width: 100%;
            position: absolute;
            right: 0;
            bottom: 0;
            height: unset;
            border-radius: .25rem;
            .loader-wrapper {
                right: 2rem;
                bottom: 2rem;
                transform: scale(.8);
            }
        }
        #filemanager-manager-container {
            padding-left: 0;
            padding-right: 0;
            height: 50vh;
        }
    }
    @keyframes fa-spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }
</style>
