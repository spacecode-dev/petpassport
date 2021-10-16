<template>
    <div ref="fileManagerContainer" id="filemanager-manager-container" v-cloak>
        <nav class="breadcrumb has-arrow-separator" aria-label="breadcrumbs">
            <ul>
                <li>
                    <a href="#" target="_self" @click.prevent="goToFolderNav(home)">
                        <b-icon icon="folder-home"/>
                    </a>
                </li>
                <template v-for="(folder ,index) in path">
                    <li v-if="checkIsLastItem(index)" :key="index" class="is-active">
                        <a href="#" aria-current="page">{{ folder.name }}</a>
                    </li>
                    <li v-else :key="index">
                        <a href="#" target="_self" @click.prevent="goToFolder(folder.path)">{{ folder.name }}</a>
                    </li>
                </template>
            </ul>
        </nav>
        <vue-custom-scrollbar class="scroll-area" tagname="div" :settings="settings">
            <div class="files">
                <div>
                    <template v-if="files.error">
                        <div class="w-100 text-center my-4">
                            <h6>У вас нет прав для просмотра этой папки</h6>
                        </div>
                    </template>
                    <template v-if="noFiles">
                        <div class="w-100 text-center my-4">
                            <h6>Нет файлов или папок в текущем каталоге</h6>
                            <b-button v-if="!showModal && current !== '/' && buttons.delete_folder" @click="removeDirectory" type="is-danger" size="is-normal">Удалить папку</b-button>
                        </div>
                    </template>
                    <template v-if="!files.error">
                        <template>
                            <template v-if="!files.error">
                                <template v-if="parent.id">
                                    <div class="grid" :key="parent.id">
                                        <Folder :ref="'folder_' + parent.id" :file="parent" :data-key="parent.id" class="folder-item" :class="{'loading': loadingInfo}" @goToFolderEvent="goToFolder"/>
                                    </div>
                                </template>
                                <template v-for="file in filteredFiles">
                                    <div class="grid" :key="file.id">
                                        <template v-if="file.type === 'file'">
                                            <ImageLoader
                                                :ref="'file_' + file.id"
                                                :file="file"
                                                :data-key="file.id"
                                                :multi-selecting="multiSelecting"
                                                :selected-files="selectedFiles"
                                                :delete-permission="buttons.delete_file"
                                                :rename-permission="buttons.rename_file"
                                                class="file-item"
                                                @missing="(value) => missing = value"
                                                @showInfo="showInfo"
                                                @rename="rename"
                                                @delete="deleteData"
                                                @select="select"
                                            />
                                        </template>
                                        <template v-if="file.type === 'dir'">
                                            <Folder
                                                :ref="'folder_' + file.id"
                                                :file="file"
                                                :data-key="file.id"
                                                :multi-selecting="multiSelecting"
                                                :selected-files="selectedFiles"
                                                :delete-permission="buttons.delete_folder"
                                                :rename-permission="buttons.rename_folder"
                                                class="folder-item"
                                                :class="{'loading': loadingInfo}"
                                                @goToFolderEvent="goToFolder"
                                                @rename="rename"
                                                @delete="deleteData"
                                                @select="select"
                                            />
                                        </template>
                                    </div>
                                </template>
                            </template>
                        </template>
                    </template>
                </div>
            </div>
        </vue-custom-scrollbar>
    </div>
</template>

<script>
    import _ from 'lodash';
    import filesize from 'filesize';
    import MD5 from 'md5';
    import api from '../api';
    import vueCustomScrollbar from 'vue-custom-scrollbar';
    import ImageLoader from '../modules/ImageLoader';
    import Folder from '../modules/Folder';
    import EventBus from "../../event-bus";
    import {mapState} from "vuex";
    import {getToast} from "../../helper";

    export default {
        name: 'Manager',
        components: {
            vueCustomScrollbar,
            ImageLoader: ImageLoader,
            Folder: Folder
        },
        props: {
            files: {
                default: () => [],
                required: true,
            },
            path: {
                default: () => [],
                required: true,
            },
            userId: {
                type: Number,
                default: 0,
                required: true,
            },
            current: {
                type: String,
                default: '/',
                required: true,
            },
            parent: {
                type: Object,
                required: true,
            },
            noFiles: {
                type: Boolean,
                default: false,
                required: true,
            },
            home: {
                type: String,
                required: false,
                default: '/',
            },
            search: {
                type: String,
                required: false,
                default: '',
            },
            filters: {
                type: Array,
                required: false,
                default: () => [],
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
            buttons: {
                default: () => [],
                required: true,
            },
        },
        data() {
            return {
                info: {},
                loadingInfo: false,
                firstUploadFolder: null
            }
        },
        methods: {
            goToFolder(path) {
                this.$emit('goToFolderManager', path);
            },
            goToFolderNav(path) {
                this.$emit('goToFolderManagerNav', path);
            },
            checkIsLastItem(index) {
                return _.size(this.path) === parseInt(index) + 1;
            },
            removeDirectory() {
                api.removeDirectory(this.current, this.userId).then(response => {
                    this.$emit('goToFolderManager', this.getParentFolder());
                    EventBus.$emit('refreshFilemanager');
                    getToast(this, 'success', response.message);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                });
            },
            showInfo(file) {
                api.getInfo(file.path, this.userId).then(response => {
                    this.$emit('showInfoItem', response);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 404) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                });
            },
            selectFile(file) {
                this.$emit('selectFile', file);
            },
            async getFilesAsync(dataTransfer) {
                const files = [];
                const folders = [];
                this.firstUploadFolder = null;
                for (let i = 0; i < dataTransfer.items.length; i++) {
                    let item = dataTransfer.items[i];
                    let entry = item.webkitGetAsEntry();
                    if (entry.isDirectory) {
                        if (this.firstUploadFolder == null) {
                            this.firstUploadFolder = entry.name;
                        }
                        if (item.kind === 'file') {
                            if (typeof item.webkitGetAsEntry === 'function') {
                                let entryContent = await this.readEntryContentAsync(entry);
                                folders.push(...entryContent);
                            }
                            let file = item.getAsFile();
                            if (file) {
                                files.push(file);
                            }
                        }
                    } else {
                        let file = item.getAsFile();
                        if (file) {
                            files.push(file);
                        }
                    }
                }
                return {files: files, folders: folders};
            },
            readEntryContentAsync(entry) {
                return new Promise(resolve => {
                    let reading = 0;
                    const contents = [];
                    readEntry(entry);

                    function readEntry(entry) {
                        if (isFile(entry)) {
                            reading++;
                            entry.file(file => {
                                reading--;
                                file.filepath = entry.fullPath.replace('/' + entry.name, '');
                                contents.push(file);
                                if (reading === 0) {
                                    resolve(contents);
                                }
                            });
                        } else if (isDirectory(entry)) {
                            readReaderContent(entry.createReader());
                        }
                    }

                    function readReaderContent(reader) {
                        reading++;
                        reader.readEntries(function (entries) {
                            reading--;
                            for (const entry of entries) {
                                readEntry(entry);
                            }
                            if (reading === 0) {
                                resolve(contents);
                            }
                        });
                    }

                    function isDirectory(entry) {
                        return entry.isDirectory;
                    }

                    function isFile(entry) {
                        return entry.isFile;
                    }
                });
            },
            uploadFiles(data) {
                let files = this.formatFiles(data.files || []);
                let folders = this.formatFiles(data.folders || []);
                if (files.length > 0) {
                    this.$emit('uploadFiles', files, 'files');
                }
                if (folders.length > 0) {
                    this.$emit('uploadFiles', folders, 'folders', this.firstUploadFolder);
                }
            },
            formatFiles(files) {
                let arrayFiles = [];
                files.forEach(file => {
                    if (file.name !== '.DS_Store') {
                        arrayFiles.push({
                            id: MD5(file.name),
                            preview: this.getPreview(file),
                            type: file.type,
                            name: file.name,
                            size: filesize(file.size),
                            upload: true,
                            progress: 0,
                            error: false,
                            file: file,
                        });
                    }
                });
                return arrayFiles;
            },
            getPreview(file) {
                if (this.isImage(file)) {
                    return URL.createObjectURL(file);
                }
                return file.name.split('.').pop();
            },
            isImage(file) {
                return file.type.includes('image');
            },
            getFileById(type, id) {
                if (id === 'folder_back') {
                    return this.$refs[type + '_' + id];
                }
                let found = this.files.find(file => file.id === id);
                if (found) {
                    return this.$refs[type + '_' + id][0];
                }
            },
            getParentFolder() {
                let pathData = this.current.split('/');
                pathData.pop();
                if (pathData.length) {
                    return pathData.join('/');
                }
                return '/';
            },
            rename(type, path) {
                this.$emit('rename', type, path);
            },
            deleteData(type, path) {
                this.$emit('delete', type, path);
            },
            select(file) {
                this.$emit('select', file);
            }
        },
        computed: {
            ...mapState({
                settings: state => state.settings.filemanager.scroll.settings,
                showModal: state => state.settings.filemanager.showModal
            }),
            pathsLength() {
                return _.size(this.path);
            },
            filesCount() {
                return _.size(this.files);
            },
            filteredFiles() {
                let filtered = this.files;
                if (this.search) {
                    filtered = this.files.filter(m => m.name.toLowerCase().indexOf(this.search) > -1);
                }
                if (this.filters.length > 0) {
                    filtered = _.filter(filtered, file => {
                        if (file.type === 'dir') {
                            return true;
                        }
                        return _.includes(this.filters, file.ext.toLowerCase());
                    });
                }
                return filtered;
            },
        },
    };
</script>

<style lang="scss" scoped>
    ::v-deep {
        .breadcrumb {
            ul {
                margin: 0;
                li {
                    &:not(.is-active) {
                        a {
                            font-weight: 600;
                        }
                    }
                    margin: 0;
                }
            }
        }
        .files {
            & > div {
                display: flex;
                flex-wrap: wrap;
            }
            .w-100 {
                width: 100%;
            }
            .text-center {
                text-align: center;
            }
            .my-4 {
                margin: 2rem 0;
            }
            .grid {
                width: 200px;
                height: 200px;
                margin-right: 1rem;
                margin-bottom: 1rem;
                overflow: hidden;
                position: relative;

                &:hover {
                    .folder-item .main-svg, .file-item .image-block, .file-item .mime-icon {
                        opacity: .5;
                    }

                    .folder-item .actions-grid, .file-item .actions-grid {
                        display: flex;
                    }
                }

                .folder-item, .file-item {
                    position: absolute;
                    left: 0;
                    right: 0;
                    top: 0;
                    bottom: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    margin: 0;

                    .name {
                        position: absolute;
                        bottom: 0;
                        width: 100%;
                        background: #f8f9fa;
                        font-size: .85rem;
                        text-align: center;
                        padding: .3rem 0;
                        cursor: pointer;
                        font-weight: 600;
                    }

                    .actions-grid {
                        position: absolute;
                        display: none;
                        right: 7px;
                        top: 7px;
                        color: var(--manatee);

                        & > div {
                            display: flex;
                        }

                        &.is-select {
                            display: flex !important;
                        }

                        span.icon {
                            cursor: pointer;

                            i:before {
                                font-size: 1.4rem;
                            }

                            &.trash {
                                margin-right: .3rem;
                            }
                        }
                    }
                }

                .file-item {
                    .image-block {
                        position: absolute;
                        transition: opacity .3s;
                        top: 39px;

                        .block-grid {
                            width: 150px;
                            height: 130px;
                            background-size: cover;
                            background-position: top center;
                            background-repeat: no-repeat;
                            border-radius: .25rem .25rem 0 0;
                        }
                    }

                    .mime-icon {
                        transition: opacity .3s;
                        margin-top: -25px;

                        svg {
                            width: 90px;
                            height: 90px;
                            fill: gainsboro;
                        }

                    }
                }

                .folder-item .main-svg {
                    color: gainsboro;
                    transition: opacity .3s;
                    margin-top: -25px;
                    i:not(.mdi-undo-variant) {
                        &:before {
                            font-size: 7rem;
                        }
                    }
                    i.mdi-undo-variant:before {
                        font-size: 3rem;
                    }
                }
            }
        }
    }

    ::v-deep .custom-control-label::after, ::v-deep .custom-control-label::before {
        top: 0;
        left: -1.25rem;
        width: 1.15rem;
        height: 1.15rem;
    }
</style>
