<template>
    <b-modal id="modal-create-folder" :active.sync="active" has-modal-card trap-focus :on-cancel.prevent="handleClose">
        <div class="modal-card" style="max-width: 500px;">
            <header class="modal-card-head">
                <p class="modal-card-title">Создание папки</p>
            </header>
            <section class="modal-card-body">
                <b-field
                    :type="validation.type"
                    :message="validation.message"
                >
                    <b-input
                        @keyup.enter="createFolder"
                        type="text"
                        placeholder="Укажите название папки"
                        v-model="folderName"
                        @input="typing"
                        expanded
                        autofocus
                    />
                </b-field>
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
                    type="is-success"
                    @click.prevent="createFolder"
                    size="is-normal"
                    :disabled="processing"
                    :loading="processing"
                >
                    Создать
                </b-button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
    import api from '../api';
    import {getToast} from '../../helper';
    import EventBus from "../../event-bus";
    export default {
        props: {
            active: {
                type: Boolean,
                default: false
            },
            current: {
                type: String,
                default: '/',
                required: true,
            },
            userId: {
                type: Number,
                default: 0,
                required: true,
            },
        },
        data() {
            return {
                folderName: null,
                processing: false,
                validation: {
                    type: null,
                    message: null
                }
            }
        },
        methods: {
            typing() {
                this.validation.type = null;
                this.validation.message = null;
            },
            createFolder() {
                this.processing = true;
                api.createFolder(this.folderName, this.current, this.userId).then(response => {
                    this.handleClose();
                    EventBus.$emit('refreshFilemanager');
                    this.folderName = null;
                    this.processing = false;
                    getToast(this, 'success', response.message);
                }).catch(error => {
                    if (typeof error.response !== 'undefined' && error.response.status === 422) {
                        this.validation.message = error.response.data.errors;
                        this.validation.type = 'is-danger';
                    }
                    this.processing = false;
                });
            },
            cancelCreate() {
                this.folderName = null;
                EventBus.$emit('closeModal', 'create_folder');
            },
            handleClose() {
                this.cancelCreate();
            },
        },
    };
</script>
