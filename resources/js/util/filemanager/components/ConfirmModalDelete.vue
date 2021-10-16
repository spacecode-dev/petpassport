<template>
    <b-modal id="modal-delete-folder" :active.sync="active" has-modal-card trap-focus :on-cancel.prevent="handleClose">
        <div class="modal-card" style="max-width: 500px;">
            <header class="modal-card-head">
                <p class="modal-card-title">Удаление {{ type === 'folder' ? 'папки: ' : 'файла: ' + name}}</p>
            </header>
            <section class="modal-card-body">
                <template v-if="type === 'folder'">
                    <p class="text">Вы уверены, что хотите удалить эту папку?</p>
                    <small class="text-danger">Важно: папка и всё её содержимое будет удалено из вашего хранилища</small>
                </template>
                <template v-else>
                    <p class="text">Вы уверены, что хотите удалить этот файл?</p>
                    <small class="text-danger">Важно: файл будет удален из вашего хранилища</small>
                </template>
            </section>
            <footer class="modal-card-foot">
                <b-button
                    type="is-secondary"
                    @click="handleClose"
                    size="is-normal"
                    :disabled="processing"
                >
                    Закрыть
                </b-button>
                <b-button
                    type="is-danger"
                    @click.prevent="deleteData"
                    size="is-normal"
                    :disabled="processing"
                    :loading="processing"
                >
                    Удалить
                </b-button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
    import api from '../api';
    import EventBus from "../../event-bus";
    import {getToast} from "../../helper";

    export default {
        props: {
            active: {
                type: Boolean,
                default: false
            },
            userId: {
                type: Number,
                default: 0,
                required: true,
            },
        },
        data() {
            return {
                name: null,
                type: null,
                path: null,
                processing: false,
            }
        },
        mounted() {
            EventBus.$on('delete', (type, path) => {
                this.type = type;
                this.path = path;
                this.name = path.replace(/^.*[\\/]/, '');
            });
        },
        methods: {
            deleteData() {
                this.type === 'folder' ? this.deleteFolder() : this.deleteFile();
            },
            deleteFolder() {
                this.processing = true;
                api.removeDirectory(this.path, this.userId).then(response => {
                    EventBus.$emit('closeModal', 'delete');
                    EventBus.$emit('refreshFilemanager');
                    getToast(this, 'success', response.message);
                    this.processing = false;
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                    this.processing = false;
                });
            },
            deleteFile() {
                this.processing = true;
                api.removeFile(this.path, this.userId).then(response => {
                    EventBus.$emit('closeModal', 'delete');
                    EventBus.$emit('refreshFilemanager');
                    getToast(this, 'success', response.message);
                    this.processing = false;
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                    this.processing = false;
                });
            },
            handleClose() {
                EventBus.$emit('closeModal', 'delete');
            },
        },
    };
</script>
