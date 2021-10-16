<template>
    <b-modal id="modal-info" :active.sync="active" has-modal-card trap-focus :on-cancel.prevent="handleClose">
        <div class="modal-card" style="width: 70vw;">
            <header class="modal-card-head">
                <p class="modal-card-title">Превью: {{ info.name }}</p>
            </header>
            <section class="modal-card-body modal-info">
                <div>
                    <div class="box-preview">
                        <template v-if="info.type === 'image'">
                            <ImageInfo :file="info" :preview="true" class="card image"/>
                        </template>
                        <template v-else-if="info.type === 'video'">
                            <video ref="video" controls crossorigin playsinline>
                                <source :src="info.url" :type="info.mime"/>
                            </video>
                        </template>
                        <template v-else>
                            <object class="no-preview" v-html="info.image"/>
                        </template>
                    </div>
                    <div class="box-info">
                        <div class="info-data">
                            <div class="info">
                                <span class="title">Название:</span>
                                <span class="value">{{ info.name }}</span>
                            </div>
                            <div class="info" v-if="info.mime">
                                <span class="title">Тип:</span>
                                <span class="value">{{ info.mime }}</span>
                            </div>
                            <div class="info" v-if="info.date">
                                <span class="title">Последняя модификация:</span>
                                <span class="value">{{ info.date }}</span>
                            </div>
                            <div class="info" v-if="info.size">
                                <span class="title">Вес:</span>
                                <span class="value">{{ info.size }}</span>
                            </div>
                            <div class="info" v-if="info.dimensions">
                                <span class="title">Размеры:</span>
                                <span class="value">{{ info.dimensions }}</span>
                            </div>
                            <div class="info url" v-if="info.url">
                                <span class="title">Ссылка</span>
                                <div class="value">
                                    <b-input
                                        :value="info.url"
                                        id="linkUrl"
                                    />
                                    <p class="control">
                                        <b-button type="is-success" @click.prevent="onCopy">Скопировать</b-button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <b-button
                    type="is-secondary"
                    @click="handleClose"
                    size="is-normal"
                >
                    Закрыть
                </b-button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
    import ImageInfo from '../modules/Image';
    import Plyr from 'plyr';
    import 'plyr/dist/plyr.css';
    import {getToast} from "../../helper";

    export default {
        props: {
            active: {
                type: Boolean,
                default: false
            },
            info: {
                type: Object,
                default: function () {
                    return {name: ''};
                },
                required: true,
            },
        },
        components: {
            ImageInfo: ImageInfo
        },

        data() {
            return {
                loaded: false,
                currentInfo: {},
                nameNoExtension: null,
                nameWidth: null,
                inputElement: null,
                correctName: null
            }
        },

        methods: {
            closePreview() {
                this.correctName = null;
                this.$emit('closePreview', true);
            },

            onCopy() {
                let linkToCopy = document.querySelector('#linkUrl');
                linkToCopy.select();
                try {
                    let successful = document.execCommand('copy');
                    let variant = 'success';
                    let message = 'Ссылка была успешно скопирована';
                    if(!successful) {
                        variant = 'danger';
                        message = 'Ошибка копирования';
                    }
                    window.getSelection().removeAllRanges();
                    getToast(this, variant, message);
                } catch (err) {
                    window.getSelection().removeAllRanges();
                    getToast(this, 'danger', 'Упс, невозможно скопировать');
                }
            },

            selectFile() {
                this.closePreview();
                this.$emit('selectFile', this.info);
            },

            handleClose() {
                this.closePreview();
            },
        },

        computed: {
            playerOptions() {
                if (this.info) {
                    return {
                        video: {
                            url: this.info.name,
                        },
                        autoplay: false,
                        contextmenu: [
                            {
                                text: 'GitHub',
                                link: 'https://github.com/MoePlayer/vue-dplayer',
                            },
                        ],
                    };
                }
                return {};
            },
        },

        watch: {
            'info.type': function (type) {
                if (type === 'video') {
                    this.$nextTick(function () {
                        setTimeout(() => {
                            new Plyr(this.$refs.video);
                        });
                    });
                }
            },

            'info.name': function (name) {
                if (name) {
                    this.nameNoExtension = name
                        .split('.')
                        .slice(0, -1)
                        .join('.');
                }
            },

            nameNoExtension: function (name) {
                if (name) {
                    this.nameWidth = (name.length + 1) * 7;
                }
            },
        },
    };
</script>

<style lang="scss" scoped>
    ::v-deep {
        .modal-info {
            & > div {
                display: flex;
                .box-preview {
                    width: 100%;
                    margin-right: 15px;
                    display: flex;
                    justify-content: center;
                }
                .box-info {
                    min-width: 400px;
                    display: flex;
                    .info-data {
                        width: 100%;
                        .info {
                            display: flex;
                            align-items: center;
                            font-size: .85rem;
                            margin-bottom: .5rem;
                            &.url {
                                .title {
                                    min-width: 65px;
                                }
                                .value {
                                    display: flex;
                                    width: 100%;
                                    justify-content: space-between;
                                    .control.is-clearfix {
                                        width: 100%;
                                    }
                                }
                            }
                            .title {
                                user-select: none;
                                font-weight: 700;
                                margin-right: 0.5rem;
                                margin-bottom: 0;
                                font-size: .85rem;
                                background: rgba(220, 220, 220, .3);
                                padding: .3rem;
                                border-radius: 4px;
                            }
                            span.value {
                                font-weight: 600;
                            }
                            div.value {
                                .control {
                                    button {
                                        padding-top: 0;
                                        padding-bottom: 0;
                                        font-size: .715rem;
                                        height: 26px;
                                    }
                                    &.is-clearfix {
                                        margin-right: .3rem;
                                        input {
                                            height: 26px;
                                            font-size: .75rem;
                                            box-sizing: border-box !important;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    .no-preview > .svg-mime {
        width: 90px;
        height: 90px;
        fill: gainsboro;
    }
</style>
