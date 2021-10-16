<template>
    <b-modal id="modal-multidelete" :active.sync="active" has-modal-card trap-focus :on-cancel.prevent="handleClose">
        <div class="modal-card" style="max-width: 500px;">
            <header class="modal-card-head">
                <p class="modal-card-title">Множественное удаление</p>
            </header>
            <section class="modal-card-body">
                <template>
                    <p class="text">Вы уверены, что хотите удалить выбранные файлы и/или папки?</p>
                    <small class="text-danger">Важно: выбранные файлы, папки и их содержимое будут удалены из вашего хранилища</small>
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
            selectedFiles: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                processing: false
            }
        },
        methods: {
            async deleteData() {
                this.processing = true;
                for (const file of this.selectedFiles) {
                    if (file.type === 'dir') {
                        await this.deleteFolder(file);
                    } else {
                        await this.deleteFile(file);
                    }
                }
                if(this.processing)
                    this.processing = false;
                EventBus.$emit('refreshFilemanager');
                EventBus.$emit('closeModal', 'multidelete');
            },

            deleteFolder(file) {
                api.removeDirectory(file.path, this.userId).then(response => {
                    getToast(this, 'success', response.message);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                });
            },

            deleteFile(file) {
                api.removeFile(file.path, this.userId).then(response => {
                    getToast(this, 'success', response.message);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        getToast(this, 'danger', error.response.data.errors);
                    }
                });
            },
            handleClose() {
                EventBus.$emit('closeModal', 'multidelete');
            },
        },
    };
</script>
