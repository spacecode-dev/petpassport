<template>
    <div class="view" :class="[ 'view--' + orientation, noPhoto ? 'view--no-photo' : '' ]">
        <div class="level-wrap">
            <IncludeDropdown class="level dropdown-left">
                <template v-slot:toggle>
                    <button class="current">{{ level }}</button>
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                </template>
                <ul class="dropdown-menu-custom">
                    <li v-for="i in 7" @click.prevent="level = i">
                        {{ i }}
                    </li>
                </ul>
            </IncludeDropdown>
        </div>
        <!-- Element-filter start -->
        <div class="filter" v-if="profile.user_id">
            <div class="filter__item">
                <IncludeDropdown class="dropdown-left">
                    <template v-slot:toggle>
                        <button class="filter__btn">Формат</button>
                    </template>
                    <ul class="dropdown-menu-custom">
                        <li>
                            <a href="#" :class="{ active: orientation == 'horisontal' }" @click.prevent="orientation = 'horisontal'">
                                Горизонтально
                            </a>
                        </li>
                        <li>
                            <a href="#" :class="{ active: orientation == 'vertical' }" @click.prevent="orientation = 'vertical'">
                                Вертикально
                            </a>
                        </li>
                        <li class="separator"></li>
                        <li>
                            <a href="#" :class="{ active: noPhoto }" @click.prevent="noPhoto = true">
                                Текст
                            </a>
                        </li>
                        <li>
                            <a href="#" :class="{ active: !noPhoto }" @click.prevent="noPhoto = false">
                                Текст + фото
                            </a>
                        </li>
                    </ul>
                </IncludeDropdown>
                <router-link class="filter__btn" :to="profile.link">
                    Профиль
                </router-link>
            </div>
            <div class="filter__item">
                <router-link class="filter__btn" :to="profile.link + '/card'">
                    Анкета
                </router-link>
                <button class="filter__btn" @click.prevent="print">
                    Печать
                </button>
            </div>
        </div>
        <!-- Element-filter end -->
        <div class="line__wrap">
            <div class="line">
                <div class="line__item" v-for="(profile, i) in lines[0]">
                    <IncludePedigreeCard :profile="profile" @show-info="showInfo(profile)" :main="i == 1" />
                </div>
            </div>
            <template v-for="i in (level - 1)">
                <div class="line" v-if="i < (level - 1)">
                    <div class="line__item" v-for="profile in lines[i]">
                        <IncludePedigreeCard :profile="profile" @show-info="showInfo(profile)" />
                    </div>
                </div>
            </template>
            <div class="line" v-if="level >= 4">
                <div class="line__item stack" v-for="(stack, i) in lines[level - 1]">
                    <IncludePedigreeCard v-for="(profile, i) in stack" :key="i" :profile="profile" :stacked="true" @show-info="showInfo(profile)" :class="{ front: i == 1 }" />
                </div>
            </div>
            <div class="line" v-else-if="level > 1 && lines[level - 1]">
                <div class="line__item" v-for="profile in lines[level - 1]">
                    <IncludePedigreeCard :profile="profile" @show-info="showInfo(profile)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import NProgress from 'nprogress';

export default {
    data() {
        return {
            profile: {},
            lines: [],
            orientation: 'horisontal',
            noPhoto: false,
            level: 4
        }
    },
    created() {
        this.load();
    },
    mounted() {
        $(this.$el).on('click', '.stack .card', function() {
            $(this).siblings().removeClass('front');
            $(this).addClass('front');
        });
    },
    methods: {
        print() {
            window.print();
        },
        resetLines() {
            this.lines = [];
            this.lines.push(new Array(3).fill(null, 0, 3));

            let mul = 2;

            for (let i = 0; i < (this.level - 2); i++) {
                mul *= 2;
                this.lines.push(new Array(mul).fill(null, 0, mul));
            }

            if (this.level >= 4) {
                this.lines.push(new Array(mul).fill([ null, null ], 0, mul));
            } else {
                this.lines.push(new Array(mul).fill(null, 0, mul));
            }

            // Line 1
            this.lines[0][0] = this.profile.parents.find(p => p.gender == 1);
            this.lines[0][1] = this.profile;
            this.lines[0][2] = this.profile.parents.find(p => p.gender == 2);

            // Line 2
            for (let i = 0; i < this.lines[0].length; i++) {
                if (i == 1) continue;

                const profile = this.lines[0][i];

                if (profile) {
                    const add = (i == 0 ? 0 : 2);
                    this.lines[1][add] = profile.parents.find(p => p.gender == 1);
                    this.lines[1][add + 1] = profile.parents.find(p => p.gender == 2);
                }
            }

            for (let i = 3; i <= this.level; i++) {
                this.makeLine(i, this.level >= 4 && i == this.level);
            }
        },
        async load() {
            NProgress.start();
            this.profile = (await axios.get('/api/profiles/' + this.$route.params.slug + '/pedigree')).data;
            NProgress.done();

            this.resetLines();
        },
        makeLine(num, stacked) {
            for (let i = 0; i < this.lines[num - 2].length; i++) {
                const profile = this.lines[num - 2][i];

                if (profile) {
                    if (stacked) {
                        this.lines[num - 1][i] = [
                            profile.parents.find(p => p.gender == 1),
                            profile.parents.find(p => p.gender == 2)
                        ];
                    } else {
                        const add = i * 2;
                        this.lines[num - 1][add] = profile.parents.find(p => p.gender == 1);
                        this.lines[num - 1][add + 1] = profile.parents.find(p => p.gender == 2);
                    }
                }
            }
        },
        fixSize() {
            const $wrap = $(this.$el).find('.line__wrap');
            if (this.orientation == 'vertical') {
                $wrap.css({
                    width: 'auto'
                });
                /*
                const $cards = $wrap.find('.line__item');

                let width = 0;
                $cards.each(function() {
                    const w = $(this).offset().left + $(this).outerWidth();
                    width = Math.max(width, w);
                    console.log(w);
                });
                */
                const $last = $wrap.find('.line__item').last();
                $wrap.css({
                    width: $last.offset().left + $last.outerWidth()
                });
            }
        }
    },
    watch: {
        orientation() {
            this.$nextTick(() => this.fixSize());
        },
        level() {
            this.resetLines();
            this.$nextTick(() => this.fixSize());
        },
        '$route': function() {
            this.load();
        }
    }
}
</script>

<style lang="scss" scoped>
.view {
    color: var(--c-black);
    background: #f5f5f5;
    padding: 10px;
}
.view--horisontal {
    /*padding-left: 7em;*/
}
.view--vertical {
    padding-top: 3.5em;
}

.level-wrap {
    z-index: 15;
    position: fixed;
    top: 1em;
    left: 1em;
    width: 5em;
    text-align: center;

    .level {
        display: inline-flex;
    }

    .current {
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5em;
        text-align: center;
        color: #FFF;
        background: var(--c-red);
        border-radius: 100%;
        box-shadow:  0 4px 12px 0 rgba(0, 0, 0, .39);
        font-size: 1.2em;
        cursor: pointer;
    }

    ::v-deep .dropdown-menu-custom {
        padding: 0;
        border-radius: 5px;
        overflow: hidden;

        li {
            background: var(--c-red);
            width: 1.5em;
            height: 1.5em;
            line-height: 1.5em;
            font-size: 1.2em;
            color: #FFF;
            cursor: pointer;
        }
    }
}

@media all and (min-width: 768px) {
    .view--horisontal .level-wrap {
        top: 2em;
    }
}


.filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    z-index: 10;
    top: 1em;
    left: 0;
    right: 0;

    @media all and (max-width: 767px) {
        justify-content: flex-end;
        right: 1em;
    }

    .filter__item {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 33.3%;

        &:last-child {
            margin-left: auto;
        }

        & > * + * {
            margin-left: 1.6em;
        }

        .filter__btn {
            background: var(--c-white);
            border: 1px solid #C8C4C4;
            box-sizing: border-box;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, .25);
            border-radius: 5px;
            font-family: Open Sans, sans-serif;
            padding: .54em 2.08em;
            font-size: .78em;
            line-height: 1.2;
            display: inline-block;
            color: var(--c-black);
            cursor: pointer;
            text-align: center;
        }

        @media all and (max-width: 767px) {
            width: auto;
            margin: 0 !important;

            & > * {
                margin-left: 1em !important;
            }
        }

        @media all and (max-width: 575px) {
            .filter__btn {
                padding-left: 1em;
                padding-right: 1em;
            }
        }
    }
}

@media all and (min-width: 768px) {
    .view--horisontal .filter {
        flex-direction: column;
        top: 6em;
        left: 1em;
        bottom: 2em;
        right: auto;

        .filter__item {
            /*height: 33.3%;*/
            flex-direction: column;
            /*width: 100%;*/
            width: 5em;

            &:last-child {
                margin-top: auto;
            }

            & > * {
                width: 100%;

                & + * {
                    margin-top: 1.9em;
                    margin-left: 0;
                }
            }

            .filter__btn {
                padding: 1em .7em;
                width: 100%;
            }
        }
    }
}


/* Line */
.line {
    display: flex;
    font-size: .92em;
}
.view--horisontal .line:first-child {
    margin: -1em 0;
}
.line__item {
    padding: 5px;
    display: flex;
    flex-grow: 1;
    flex-basis: 0;
}
.view--horisontal .line__item {
    padding: 1em 5px;
}
.line__item.stack {
    flex-direction: column;
    position: relative;
}
/*
.line:nth-child(n+4):last-child {
    margin-bottom: 5px;
    padding-bottom: 1.5em;
}
*/
.view--horisontal .line__wrap {
    display: flex;
    flex-grow: 1;
    padding-right: 2.3em;
}
.view--vertical .line__item > * {
    flex-grow: 1;
}
.view--vertical .line:nth-child(1) .line__item:nth-child(2) {
    margin: -3em -5em 3em;
    position: relative;
    z-index: 1;
}
/*
.view--vertical .line:nth-child(1) .line__item {
    width: 50%;
}
.view--vertical .line:nth-child(2) .line__item {
    width: 25%;
}
/*
.view--vertical .line:nth-child(3) .line__item,
.view--vertical .line:nth-child(4) .line__item,
.view--vertical .line:nth-child(5) .line__item,
.view--vertical .line:nth-child(6) .line__item {
    width: 12.5%;
}
*/
.view--vertical .line:nth-child(n+4):last-child .line__item {
    /*width: 12.5%;*/
    position: relative;
    padding-left: 3em;
}
.view--vertical .line:nth-child(n+4):last-child .line__item:nth-child(n+5) {
    padding-left: 5px;
    padding-right: 3em;
}

/* View */

.view--horisontal {
    display: flex;
}

/* Format */

.format {
    position: absolute;
    left: 0;
    top: 0;
    border: 1px solid #dddddd;
    border-radius: 3px;
    background-color: #f5f5f5;
    z-index: 4;
    display: none;
}
.format__item {
    display: block;
    color: #605B5B;
    font-size: .9em;
    line-height: 1.4;
}
.format__point {
    padding: .4em .8em;
}
.format__item.active {
    color: #230769;
    font-weight: 600;
}
.format__point + .format__point {
    border-top: 1px solid rgba(62, 62, 62, .28);
}

/*
 * CASCADE
 */

.view--horisontal .line {
    display: flex;
    flex-direction: column;
    margin-left: -1.7em;
}
.view--horisontal .line:nth-child(1) {
    z-index: 4;
    margin-left: 3em;
}
.view--horisontal .line:nth-child(1) .line__item:nth-child(2) {
    /*
    margin-top: -5em;
    margin-bottom: -5em;
    margin-left: -6.5em;
    */
    margin: -5em 0;
    z-index: 1;
    position: relative;
    left: -3em;
}
.view--horisontal .line:nth-child(1) .line__item {
    flex-grow: 1;
    width: 20vw;
}

.view--horisontal .line:nth-child(2) .line__item {
    /*
    margin-top: .6em;
    margin-bottom: .6em;
    */
    flex-grow: 1;
    max-width: 18.5em;
    width: 20vw;
}

.view--horisontal .line:nth-child(2) {
    justify-content: space-around;
    z-index: 3
}

.view--horisontal .line:nth-child(3),
.view--horisontal .line:nth-child(4),
.view--horisontal .line:nth-child(5),
.view--horisontal .line:nth-child(6) {
    z-index: 2;
    justify-content: space-around;
    flex-grow: 1;
}

.view--horisontal .line:nth-child(7) .line__item {
    display: flex;
    flex-direction: column;
}
.view--horisontal .line:nth-child(7) {
    justify-content: space-around;
    flex-grow: 1;
    padding-bottom: 0;
    margin-bottom: 0;
    padding-top: 0;
}

/*
 * MEDIA
 */

@media all and (max-width: 1200px) {

    /* Line */

    .line {
        font-size: .78em;
    }
    .line__itemn {
        padding: 2px;
    }
}
@media all and (max-width: 991px) {

    /* Line */
    .view--vertical .line:nth-child(7) .line__item {
        padding-left: 1.3em;
    }
    .view--vertical .line:nth-child(7) .line__item:nth-child(n+5) {
        padding-right: 1.3em;
        padding-left: 2px;
    }

    .view--horisontal .line:nth-child(1) .line__item:nth-child(2) {
        margin-right: 2.8em;
        margin-left: -6em;
    }
}
@media all and (max-width: 767px) {

    /* Line */

    .line:nth-child(1) {
        flex-wrap: wrap;
    }
    .line:nth-child(4) {
        display: none;
    }
    .view--horisontal .line__wrap {
        padding-left: 3.5em;
        padding-right: 0;
    }
    .view--vertical .line:nth-child(1) .line__item:nth-child(2) {
        width: 100%;
        margin: 0em;
        order: -1;
    }
    .view--vertical .line:nth-child(1) .line__item:nth-child(3) {
        width: 50%;
    }
    .view--vertical .line:nth-child(1) .line__item:nth-child(1) {
        width: 50%;
    }

    /* View */

    .view--horisontal {
        flex-wrap: wrap
    }
    .view--horisontal .line:nth-child(1) .line__item:nth-child(2) {
        margin-left: -2.9em
    }

    .view--horisontal .line:nth-child(3),
    .view--horisontal .line:nth-child(4),
    .view--horisontal .line:nth-child(5),
    .view--horisontal .line:nth-child(6) {
        flex: 1;
    }
    .view--horisontal .line:nth-child(7) {
        display: none;
    }
}
@media all and (max-width: 575px) {

    /* Line */

    .line {
        font-size: .64em;
    }
    .view--horisontal .line__wrap {
        padding-left: 2.7em;
    }
    .view--horisontal .line:nth-child(2) .line__item {
        margin-top: 1em;
        margin-bottom: 1em;
    }
}

@for $i from 1 through 7 {
    .line:nth-last-child(#{$i}) {
        z-index: $i !important;
    }
}
</style>

