<template>
    <div class="stack-uploads" v-if="files.length > 0">
<!--        <div class="files" v-if="type === 'folders'">-->
<!--            <transition name="fade" mode="out-in">-->
<!--                <div>-->
<!--                    <div class="preview">-->
<!--                        <b-icon icon="folder"/>-->
<!--                    </div>-->
<!--                    <small>-->
<!--                        <template v-if="error">-->
<!--                            <small class="text-danger">Error on upload</small>-->
<!--                        </template>-->
<!--                        <template v-else>-->
<!--                            <small v-if="totalPercent === 100" class="ml-1 text-success">Success</small>-->
<!--                            <progress-module :percent="totalPercent" type="folder"/>-->
<!--                        </template>-->
<!--                    </small>-->
<!--                </div>-->
<!--            </transition>-->
<!--        </div>-->
        <div class="files" v-for="(file, indexFiles) in files" :key="indexFiles">
            <transition name="fade" mode="out-in">
                <div :key="indexFiles" v-if="file.upload">
                    <div class="preview">
                        <img v-if="isImage(file)" :src="file.preview" alt="upload">
                        <div v-else class="rounded-full bg-50 w-12 h-12 flex justify-center items-center">
                            <div class="uppercase">
                                {{ file.preview }}
                            </div>
                        </div>
                    </div>
                    <small>
                        <template v-if="file.error">
                            <small class="text-danger">Error on upload</small>
                        </template>
                        <template v-else>
                            {{ file.name | truncate(15) }}
                            <small v-if="file.progress === 100" class="text-success">Success</small>
                            <progress-module/>
                        </template>
                    </small>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import axios from 'axios';
    import Progress from '../modules/Progress';
    import {getToast} from "../../helper";
    let token = document.head.querySelector('meta[name="csrf-token"]');
    export default {
        props: {
            current: {
                type: String,
                default: '/',
                required: true,
            },
            userId: {
                type: String,
                default: 0,
                required: true,
            },
            visibility: {
                type: String,
                default: 'public',
            },

            rules: {
                type: Array,
                default: [],
                required: false,
            },
        },

        components: {
            'progress-module': Progress,
        },
        data() {
            return {
                token: token.content,
                files: [],
                filesUploaded: [],
                type: 'files',
                // totalPercent: 0,
                error: false,
            }
        },
        methods: {
            isImage(file) {
                return file.type.includes('image');
            },

            getRandomArbitrary(min, max) {
                return Math.random() * (max - min) + min;
            },

            startUploadingFiles(files, type) {
                this.files = files;
                this.type = type;
                this.filesUploaded = [];
                this.processFiles();
            },

            async processFiles() {
                Array.from(this.files).forEach(file => {
                    this.startUpload(file);
                });
            },

            startUpload(file) {
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                    onUploadProgress: progressEvent => {
                        file.progress = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
                    },
                };
                let filePath = '/';
                if (file.file.webkitRelativePath) {
                    filePath = file.file.webkitRelativePath.replace('/' + file.file.name, '');
                } else if (file.file.filepath) {
                    filePath = file.file.filepath;
                }
                let data = new FormData();
                data.append('file', file.file);
                data.append('userId', this.userId);
                data.append('current', this.current + '/' + filePath);
                data.append('visibility', this.visibility);

                if (this.type === 'files') {
                    data.append('rules', JSON.stringify(this.rules));
                    this.uploadFileToServer(file, data, config);
                } else {
                    this.uploadFolderToServer(file, data, config);
                }
            },

            uploadFileToServer(file, data, config) {
                axios.post('/api/filemanager/uploads/add', data, config).then(response => {
                    _.forEach(this.files, fileUpload => {
                        if (fileUpload.name === response.data.name) {
                            fileUpload.upload = true;
                        }
                    });
                    this.filesUploaded.push(file.id);
                    setTimeout(() => {
                        this.$emit('removeFile', file.id);
                    }, 2000);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        // if (error.response.data.errors) {
                        //     let errors = error.response.data.errors;
                        //     let errorsArray = Object.values(errors).flat();
                        //     let errorMessage = errorsArray.join('<br>');
                        //     getToast(this, 'danger', errorMessage);
                        // } else {
                            getToast(this, 'danger', error.response.data.errors);
                        // }
                    }
                    file.error = true;
                    setTimeout(() => {
                        this.$emit('removeFile', file.id);
                    }, 1000);
                });
            },

            uploadFolderToServer(file, data, config) {
                data.append('folder', true);
                axios.post('/api/filemanager/uploads/add', data, config).then(response => {
                    _.forEach(this.files, fileUpload => {
                        if (fileUpload.name === response.data.name) {
                            fileUpload.upload = true;
                        }
                    });
                    this.filesUploaded.push(file.id);
                    // this.totalPercent = (100 * this.filesUploaded.length) / this.files.length;
                    setTimeout(() => {
                        this.$emit('removeFile', file.id);
                    }, 2000);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        // if (typeof error.response.data.errors !== 'string') {
                        //     let errors = error.response.data.errors;
                        //     let errorsArray = Object.values(errors).flat();
                        //     let errorMessage = errorsArray.join('<br>');
                        //     getToast(this, 'danger', errorMessage);
                        // } else {
                            getToast(this, 'danger', error.response.data.errors);
                        // }
                    }
                    this.error = true;
                    setTimeout(() => {
                        this.$emit('removeFile', file.id);
                    }, 1000);
                });
            },
        },

        filters: {
            truncate: function (text, stop, clamp) {
                return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '');
            },
        },
    };
</script>

<style lang="scss" scoped>
    ::v-deep {
        &.stack-uploads {
            right: 15px;
            bottom: 15px;
            width: 400px;
            z-index: 99;
            position: fixed;
            .files {
                background: white;
                margin-top: 1rem;
                box-shadow: 0 1px 1px rgba(30, 38, 56, 0.25), 0 2px 5px rgba(30, 38, 56, 0.15);
                border-radius: 4px;
                padding: 1.5rem;
                & > div {
                    display: flex;
                    flex-wrap: wrap;
                    text-align: center;
                    width: 100%;
                    flex-direction: column;
                }
                .preview {
                    img {
                        width: 4rem;
                        height: 4rem;
                        object-fit: cover;
                        border-radius: 4rem;
                        margin-bottom: .3rem;
                    }
                    svg {
                        font-size: 2rem;
                        margin-bottom: .3rem;
                    }
                }
            }
        }
    }
</style>
