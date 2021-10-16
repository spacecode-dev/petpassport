<template>
    <b-modal id="modal-rename-folder" :active.sync="active" has-modal-card trap-focus :on-cancel.prevent="handleClose">
        <div class="modal-card" style="max-width: 500px;">
            <header class="modal-card-head">
                <p class="modal-card-title">Переименование {{ type === 'folder' ? 'папки' : 'файла' }}</p>
            </header>
            <section class="modal-card-body">
                <b-field
                    :type="validation.type"
                    :message="validation.message"
                >
                    <b-input
                        v-if="type === 'folder'"
                        @keyup.enter="renamePath"
                        type="text"
                        v-model="name"
                        :placeholder="name"
                        @input="typing"
                        expanded
                        autofocus
                    />
                    <b-input
                        v-if="type !== 'folder'"
                        @keyup.enter="renamePath"
                        type="text"
                        v-model="nameWithoutExtension"
                        :placeholder="nameWithoutExtension"
                        @input="typing"
                        expanded
                        autofocus
                    />
                    <p v-if="type !== 'folder'" class="control">
                        <span class="button is-static">{{ extension }}</span>
                    </p>
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
                    @click.prevent="renamePath"
                    size="is-normal"
                    :disabled="processing"
                    :loading="processing"
                >
                    Переименовать
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
                nameWithoutExtension: null,
                processing: false,
                validation: {
                    type: null,
                    message: null
                }
            }
        },
        watch: {
            extension(value) {
                if (value) {
                    let tempName = this.name;
                    this.nameWithoutExtension = tempName.replace(value, '');
                }
            },
        },
        computed: {
            extension() {
                if (this.type !== 'folder') {
                    let re = /(?:\.([^.]+))?$/;
                    let ext = re.exec(this.name);
                    if (ext) {
                        return ext[0];
                    }
                }
                return '';
            },
        },
        mounted() {
            EventBus.$on('rename', (type, path) => {
                this.type = type;
                this.path = path;
                this.name = path.replace(/^.*[\\/]/, '');
            });
        },
        methods: {
            typing() {
                this.validation.type = null;
                this.validation.message = null;
            },
            renamePath() {
                let nameToSave = this.type === 'folder' ? this.name : this.nameWithoutExtension + this.extension;
                this.processing = true;
                api.rename(this.path, nameToSave, this.userId).then(response => {
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
            cancelRename() {
                this.name = null;
                this.type = null;
                this.path = null;
                EventBus.$emit('closeModal', 'rename');
            },
            handleClose() {
                this.cancelRename();
            }
        },
    };
</script>
