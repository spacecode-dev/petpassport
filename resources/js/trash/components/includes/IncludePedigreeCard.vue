<template>
    <div class="card" v-if="profile" :class="{ 'card--male': profile.gender == 1, 'card--female': profile.gender == 2 }" @click="showInfo">
        <span class="card__photo" :style="{ 'background-image': 'url(\'' + profile.avatar + '\')' }"></span>
        <div class="card__query">
            <span class="card__note">
                <router-link :to="profile.link + '/pedigree'">
                    {{ profile.name }}
                </router-link>
            </span>
            <p class="card__lead">
                <!-- Black&White 2010 Finland -->
                <template v-if="profile.passport && profile.passport.colour">
                    {{ profile.passport.colour }}
                </template>
                <template v-if="birth_year">
                    {{ birth_year }}
                </template>
                <template v-if="profile.birth_country_id">
                    {{ profile_birth_country_name }}
                </template>

                &#8288;
            </p>
            <div class="card__gender"></div>
        </div>
    </div>
    <div class="card card-empty" v-else>
        <span class="card__photo">
            <i class="fa fa-question" aria-hidden="true"></i>
        </span>
        <div class="card__query">
            <span class="card__note">
                <span class="c-gray">
                    Нет данных
                </span>
            </span>
            <p class="card__lead">
                &#8288;
            </p>
        </div>
    </div>
</template>

<script>
import * as moment from 'moment';
import { mapCacheActions } from 'vuex-cache';

import ModalPedigreeCard from './modals/ModalPedigreeCard';

export default {
    props: {
        profile: Object,
        stacked: {
            type: Boolean,
            default: false
        }
    },
    asyncComputed: {
        async profile_birth_country_name() {
            if (!this.profile || !this.profile.birth_country_id) return;
            const countries = await this.getCountries();
            return countries.find(c => c.id == this.profile.birth_country_id).name;
        }
    },
    computed: {
        birth_year() {
            if (!this.profile || !this.profile.birthday) return;

            return moment(this.profile.birthday).format('YYYY');
        }
    },
    methods: {
        ...mapCacheActions([
            'getCountries'
        ]),
        showInfo(e) {
            if (e.target.tagName == 'A') return;
            if (this.stacked && !$(this.$el).hasClass('front')) return;

            this.$modal.show(ModalPedigreeCard, {
                profile: this.profile
            }, {
                classes: '',
                height: 'auto',
                maxWidth: 800,
                adaptive: true,
                scrollable: true
            });
        }
    }
}
</script>

<style lang="scss">
.view--vertical {
    .line:nth-child(1) {
        .card {
            display: flex;
            align-items: center;
        }
        .card__query {
            flex-grow: 1;
        }
        .line__item:nth-child(1) .card {
            padding-right: 5.5em;
        }
        .line__item:nth-child(2) {
            .card {
                display: flex;
                flex-direction: column;
                padding-top: .5em;
                padding-bottom: .5em;
            }
            .card__photo {
                margin-bottom: .4em;
            }
            .card__lead {
                margin-top: .15em;
            }
            .card__gender {
                right: auto;
                bottom: auto;
                left: -1.6em;
                top: -.02em;
            }
            .card__query {
                position: relative;
            }
        }
        .line__item:nth-child(3) {
            .card {
                display: flex;
                flex-direction: row-reverse;
                padding-left: 5.2em;
            }
            .card__gender {
                right: auto;
                bottom: .8em;
                left: .8em;
            }
        }   
    }
    .line:nth-child(2) {
        .card {
            display: flex;
            align-items: center;
            padding-top: 2em;
            padding-bottom: 2em;
        }
        .card__query {
            flex-grow: 1;
        }
        .line__item:nth-child(n+3) .card {
            display: flex;
            flex-direction: row-reverse;
        }
    }
    .line:nth-child(3),
    .line:nth-child(4),
    .line:nth-child(5),
    .line:nth-child(6) {
        .card {
            padding-bottom: 3.6em;
        }
        .card__photo {
            margin-bottom: 1.2em
        }
        .card__lead {
            margin-top: 1.65em;
        }
        .line__item:nth-child(n+5) .card {
            text-align: right;
        }
    }
    .line:nth-child(n+4):last-child {
        .card {
            padding-bottom: 3.1em;
            text-align: center !important;
            padding-left: .4em;
            padding-right: .4em;

            &.front {
                z-index: 1
            }
        }
        .card:nth-child(2n) {
            position: absolute;
            min-height: 100%;
            left: 5px;
            right: 3em;
            top: 1.3em;
        }
        .card__photo {
            margin-bottom: 1.2em;
        }
        .line__item:nth-child(n+5) .card:nth-child(2n) {
            left: 3em;
            right: 5px;
        }
    }
}

.view--vertical .line:nth-child(2) .line__item:nth-child(n+3) .card__gender,
.view--vertical .line:nth-child(3) .line__item:nth-child(n+5) .card__gender,
.view--vertical .line:nth-child(4) .line__item:nth-child(n+5) .card__gender {
    right: auto;
    left: .8em;
}

.view--horisontal {
    .card {
        display: flex;
        align-items: center;
        width: 100%;
    }
    .line:nth-child(1) {
        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            /*max-width: 14.3em;*/
            min-width: 9em;
            /*width: 100%;*/
        }
        .card__photo {
            margin-bottom: 1.3em;
        }
        .line__item:nth-child(2) .card {
            max-width: 17em;
        }
        .line__item:nth-child(3) {
            .card {
                display: flex;
                flex-direction: column-reverse;
            }
            .card__photo {
                margin-bottom: 0;
                margin-top: 1.3em;
            }
        }
    }
    .line:nth-child(2) {
        .card {
            display: flex;
            padding-top: 2.58em;
            padding-bottom: 2.58em;
        }
        .card__query {
            padding-left: 1.3em;
        }
    }
    .line:nth-child(3),
    .line:nth-child(4),
    .line:nth-child(5),
    .line:nth-child(6) {
        .card {
            padding-top: .54em;
            padding-bottom: .54em;
        }
        .card__query {
            padding-left: 1.5em;
            padding-right: 1.5em;
        }
    }
    .line:nth-child(n+4):last-child {
        .card {
            padding-top: .38em;
            padding-bottom: .38em;

            &.front {
                z-index: 1;
                position: relative;
            }

            &:nth-child(2) {
                margin-top: -2em;/*-3.5em;*/
                margin-left: 3em;/* 3.3em;
                /*margin-right: -2.7em;*/
            }
        }
        .card__query {
            padding-left: 2.3em;
            padding-right: 2.3em;
            flex-grow: 1
        }
        .card__photo {
            font-size: .8em;
        }
    }
}

.view--horisontal.view--no-photo .line:nth-child(4) .line__item .card:nth-child(2) {
    margin-top: -1.9em;
}

.view--no-photo .card__photo {
    display: none !important;
}

/*
.view--horisontal .card {
    width: 20vw;
}
*/
.view--horisontal .line:nth-child(3) .card,
.view--horisontal .line:nth-child(4) .card,
.view--horisontal .line:nth-child(5) .card,
.view--horisontal .line:nth-child(6) .card,
.view--horisontal .line:nth-child(7) .card {
    width: 100%;
}

@media all and (max-width: 991px) {
    .view--vertical {
        .line:nth-child(3) .card,
        .line:nth-child(4) .card,
        .line:nth-child(5) .card,
        .line:nth-child(6) .card {
            padding-left: .3em;
            padding-right: .3em;
        }
        .line:nth-child(n+4):last-child {
            .card {
                padding-right: 2px;

                &:nth-child(2n) {
                    right: 1.8em;
                }
            }
            .card__photo {
                font-size: .82em;
            }
            .line__item:nth-child(n+5) .card:nth-child(2n) {
                left: 1.8em;
            }
        }
    }
}
@media all and (max-width: 767px) {
    .view--vertical {
        .line:nth-child(1) {
            .line__item:nth-child(1) .card {
                padding-right: 1.53em;
            }
            .line__item:nth-child(3) .card {
                padding-left: 1.53em;
            }
        }
        .line:nth-child(2) {
            .card {
                flex-direction: column;
                padding-bottom: 3.46em;
            }
            .card__photo {
                margin-bottom: 1.1em;
            }
        }
        .line:nth-child(3) .line__item:nth-child(n+3) .card,
        .line:nth-child(4) .line__item:nth-child(n+3) .card,
        .line:nth-child(5) .line__item:nth-child(n+3) .card,
        .line:nth-child(6) .line__item:nth-child(n+3) .card {
            flex-direction: column;
        }
    }
    .view--horisontal .line:nth-child(1) {
        .card {
            max-width: 11.2em;
        }
        .line__item:nth-child(2) .card {
            max-width: 11.3em;
        }
    }
}
@media all and (max-width: 575px) {
    .view--horisontal {
        .line:nth-child(1) .line__item:nth-child(2) .card {
            max-width: 8.3em;
        }
        .line:nth-child(2) {
            .card {
                flex-direction: column;
                align-items: center;
            }
            .card__photo {
                margin-bottom: 1.1em;
            }
        }
        .line:nth-child(3) .line__item .card .card__query,
        .line:nth-child(4) .line__item .card .card__query,
        .line:nth-child(5) .line__item .card .card__query,
        .line:nth-child(6) .line__item .card .card__query {
            padding-left: 0;
        }
    }
}
@media all and (max-width: 460px) {
    .view--vertical .line:nth-child(3),
    .view--vertical .line:nth-child(4),
    .view--vertical .line:nth-child(5),
    .view--vertical .line:nth-child(6) {
        .card {
            font-size: .66em;
        }
        .card__photo {
            font-size: .7em;
        }
    }
}
</style>

<style lang="scss" scoped>
.card {
    background: var(--c-white);
    border: 2px solid #CBCBCB;
    box-sizing: border-box;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, .25);
    border-radius: 10px;
    padding: 1.5em;
    position: relative;
    /*width: 100%;*/
    cursor: pointer;

    &.card-empty {
        background: #EEE;
        cursor: default;
    }
}

.card__photo {
    width: 4.2em;
    height: 4.2em;
    border-radius: 100%;
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-size: cover;
    background-color: #D5D5D5;
    flex-shrink: 0;
    display: inline-flex;
    justify-content: center;
    align-items: center;

    i {
        font-size: 2em;
        color: #EEE;
    }
}
.card__gender {
    display: inline-block;
    width: 1.1em;
    height: 1.1em;
    background-position: 50% 50%;
    background-repeat: no-repeat;
    background-size: contain;
    position: absolute;
    bottom: .8em;
    right: .8em;
}
.card__note {
    color: #3e3e3e;
    font-size: .81em;
    display: block;
}
.card__lead {
    font-size: .75em;
    margin-top: .8em;
}
.card__query {
    text-align: center;
}
.card--male .card__note {
    color: var(--c-dark-violet);
}
.card--male .card__gender {
    background-image: url('/img/icons/sex-male.svg');
    background-size: .9em;
}
.card--female .card__note {
    color: var(--c-red);
}
.card--female .card__gender {
    background-image: url('/img/icons/sex-fem.svg');
}

@media all and (max-width: 1200px) {
    .card {
        border: 0;
    }
}

@media all and (max-width: 575px) {
    
    /* Card */

    .card {
        padding: .96em .36em;
        border-radius: 5px;
    }
    .card__photo {
        font-size: .8em;
    }
}
</style>
