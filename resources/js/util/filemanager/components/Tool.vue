<template>
    <div class="content--main">
        <h3>Менеджер файлов</h3>
        <create-folder :current="currentPath" :active="modal.create_folder" :userId="user.id"/>
        <rename-modal :active="modal.rename" :userId="user.id"/>
        <confirm-modal-delete :active="modal.delete" :userId="user.id"/>
        <confirm-modal-multi-delete :selected-files="selectedFiles" :active="modal.multidelete" :userId="user.id"/>
        <div class="card filemanager" id="filemanager-manager">
            <div class="card-content">
                <div class="content">
                    <div class="buttons">
                        <b-button type="is-primary" :class="{'rotate': loadingfiles}" @click="refreshCurrent" class="load">
                            <b-icon icon="sync" size="is-normal"/>
                        </b-button>
                        <label v-if="buttons.upload_button" class="manual_upload">
                            <div @click="showUpload = !showUpload" class="button is-primary">
                                Загрузить
                            </div>
                            <input type="file" @change="uploadFilesByButton" multiple/>
                        </label>
                        <b-button type="is-primary" v-if="buttons.create_folder" @click.prevent="modal.create_folder = !modal.create_folder">
                            Создать папку
                        </b-button>
                        <b-button type="is-primary" v-if="buttons.select_multiple" @click="multiSelecting = !multiSelecting" class="multiselect">
                            <b-icon icon="folder-plus" size="is-normal"/>
                            <small v-if="selectedFiles.length > 0">{{ selectedFiles.length }}</small>
                        </b-button>
                        <b-button type="is-danger" v-if="multiSelecting && selectedFiles.length > 0" @click.prevent="modal.multidelete = !modal.multidelete" class="removing">
                            <b-icon icon="delete" size="is-normal"/>
                        </b-button>
                    </div>
                    <manager
                        ref="manager"
                        :files="files"
                        :userId="user.id"
                        :path="path"
                        :current="currentPath"
                        :parent="parent"
                        :noFiles="noFiles"
                        :search="search"
                        :filters="filteredExtensions"
                        :multi-selecting="multiSelecting"
                        :selected-files="selectedFiles"
                        :buttons="buttons"
                        @goToFolderManager="goToFolder"
                        @goToFolderManagerNav="goToFolderNav"
                        @uploadFiles="uploadFiles"
                        @showInfoItem="showInfoItem"
                        @select="select"
                    />
                    <DetailPopup
                        ref="detailPopup"
                        :info="info"
                        :active="modal.info"
                        @closePreview="closePreview"
                    />
                    <UploadProgress ref="uploader" :current="currentPath" @removeFile="removeFileFromUpload" :userId="user.id"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import api from '../api';
    import CreateFolderModal from './CreateFolderModal';
    import ConfirmModalDelete from './ConfirmModalDelete';
    import ConfirmModalMultiDelete from './ConfirmModalMultiDelete';
    import RenameModal from './RenameModal';
    import {mapGetters, mapState} from "vuex";
    import DetailPopup from './DetailPopup';
    import UploadProgress from './UploadProgress';
    import Manager from './Manager';
    import {getToast} from "../../helper";
    import EventBus from "../../event-bus";

    export default {
        name: 'Filemanager',
        components: {
            'create-folder': CreateFolderModal,
            'rename-modal': RenameModal,
            'confirm-modal-delete': ConfirmModalDelete,
            'confirm-modal-multi-delete': ConfirmModalMultiDelete,
            manager: Manager,
            DetailPopup: DetailPopup,
            UploadProgress: UploadProgress,
        },
        data() {
            return {
                modal: {
                    create_folder: false,
                    multidelete: false,
                    rename: false,
                    delete: false,
                    info: false,
                },
                loadingfiles: false,
                showUpload: false,
                currentPath: '/',
                files: [],
                parent: {},
                path: [],
                noFiles: false,
                info: {},
                filesToUpload: [],
                uploadType: null,
                folderUploadedName: null,
                search: '',
                filters: [],
                filterBy: '',
                filteredExtensions: [],
                showFilters: false,
                multiSelecting: false,
                selectedFiles: [],
                buttons: []
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
            EventBus.$on('closeModal', (arg) => {
                this.modal[arg] = false;
            });
            EventBus.$on('openModal', (arg) => {
                this.modal[arg] = true;
            });
        },
        computed: {
            ...mapGetters([
                'user'
            ])
        },
        methods: {
            getData(pathToList) {
                this.files = [];
                this.parent = {};
                this.path = [];
                this.noFiles = false;
                this.loadingfiles = true;
                return api.getData(pathToList, this.user.id).then(result => {
                    if (_.size(result.files) === 0) {
                        this.noFiles = true;
                    }
                    this.files = result.files;
                    this.path = result.path;
                    this.filters = result.filters;
                    this.parent = result.parent;
                    this.buttons = result.buttons;
                    this.loadingfiles = false;
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        this.loadingfiles = false;
                        this.filters = [];
                        getToast(this, 'danger', error.response.data.errors);
                    }
                });
            },
            refreshCurrent() {
                if(this.multiSelecting) {
                    this.refreshMultiSelected();
                }
                this.getData(this.currentPath);
            },
            goToFolder(path) {
                this.getData(path);
                this.currentPath = path;
                if (this.currentPath === '/') {
                    history.pushState(null, null, '/settings/filemanager');
                } else {
                    history.pushState(null, null, '/settings/filemanager?path=' + path);
                }
            },
            goToFolderNav(path) {
                this.getData(path);
                this.currentPath = path;
                if (this.currentPath === '/') {
                    history.pushState(null, null, '/settings/filemanager');
                } else {
                    history.pushState(null, null, '/settings/filemanager?path=' + path);
                }
            },
            showInfoItem(item) {
                this.info = item;
                this.modal.info = true;
            },
            closePreview() {
                this.info = {};
                this.modal.info = false;
            },
            uploadFiles(files, type, firstFolderName) {
                this.filesToUpload = files;
                this.uploadType = type;
                this.folderUploadedName = firstFolderName;
                this.$refs.uploader.startUploadingFiles(files, type);
            },
            removeFileFromUpload(uploadedFileId) {
                let index = this.filesToUpload.map(item => item.id).indexOf(uploadedFileId);
                this.$delete(this.filesToUpload, index);
                if (this.filesToUpload.length === 0) {
                    // if (this.uploadType === 'folders') {
                    //     this.callFolderEvent(this.folderUploadedName);
                    // }
                    this.folderUploadedName = null;
                    this.uploadType = null;
                    this.refreshCurrent();
                }
            },
            uploadFilesByButton(e) {
                this.$refs.manager.uploadFiles({files: Array.from(e.target.files)}, 'files');
            },
            refreshMultiSelected() {
                this.multiSelecting = false;
                this.selectedFiles = [];
            },
            // callFolderEvent(path) {
            //     api.eventFolderUploaded(this.currentPath + '/' + path);
            // },
            filterFiles() {
                let extensions = _.get(this.filters, this.filterBy);
                if (extensions == null) {
                    this.filteredExtensions = [];
                }
                if (extensions != null && extensions.length > 0) {
                    this.filteredExtensions = extensions;
                }
            },
            searchItems: _.debounce(function (e) {
                this.search = e.target.value;
            }, 300),
            select(file) {
                const findIndex = _.findIndex(this.selectedFiles, file);
                if (findIndex >= 0) {
                    this.selectedFiles.splice(findIndex, 1);
                    return;
                }
                this.selectedFiles.push(file);
            }
        },
        watch: {
            currentPath() {
                this.multiSelecting = false;
                this.selectedFiles = [];
            },
            filters() {
                if (this.filters) {
                    let size = _.size(this.filters);
                    if (size > 1) {
                        this.showFilters = true;
                        return true;
                    }
                }
                this.showFilters = false;
            }
        },
    };
</script>

<style lang="scss" scoped>
    ::v-deep {
        .manual_upload > input[type='file'] {
            display: none;
        }
        .modal {
            z-index: 999;
            &#modal-info {
                .animation-content {
                    max-width: 70vw !important;
                }
            }
            .modal-card-head {
                border-bottom: 1px solid #e9eaee;
                p {
                    font-size: 1.1rem !important;
                    font-weight: 700;
                    color: var(--mirage) !important;
                }
            }
            .modal-card-body {
                padding: 30px 20px;
                input {
                    font-size: 0.85rem;
                    height: 2.5rem;
                }
                .field.has-addons {
                    p.control {
                        span {
                            height: 2.5rem;
                        }
                    }
                }
                p.text {
                    margin-bottom: .5rem;
                }
                small.text-danger {
                    display: block;
                    line-height: 1.2;
                    color: var(--red);
                    font-weight: 600;
                }
            }
            .modal-card-foot, .modal-card-head {
                background-color: #e9eaee;
            }
        }
        .buttons {
            .button {
                height: auto;
                &:not(.load), &:not(.multiselect), &:not(.removing) {
                    padding: 0.55rem 2rem;
                }
                &.load {
                    padding: 0.55rem 1rem;
                    &.rotate span.icon {
                        animation: fa-spin 2s infinite linear;
                    }
                }
                &.removing {
                    padding: 0.55rem 1rem;
                }
                &.multiselect {
                    padding: 0.55rem 1rem;
                    & > span {
                        display: flex;
                        justify-content: space-between;

                        small {
                            margin-right: calc(-.375em - 1px);
                            margin-left: .1875em;
                            display: flex;
                            align-self: end;
                            line-height: 1;
                        }
                    }
                }
                span.icon {
                    display: flex;
                }
            }
        }
        #filemanager-manager {
            &.card .card-content .content {
                flex-direction: column;
            }
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
