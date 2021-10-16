<template>
    <section class="hero" :style="'background-image: url(' + getLoginBg + ')'">
        <div class="card auth--box">
            <div class="card-content">
                <div class="auth--intro">
                    <img :src="getMainLogo" alt="PetPassport">
                    <h4>PetPassport.online</h4>
                </div>
                <div class="auth--form">
                    <slot></slot>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        computed: {
            ...mapState({
                storage: state => state.settings.storage.path,
            }),
            getMainLogo() {
                return this.storage + '/custom/logo.png';
            },
            getLoginBg() {
                return this.storage + '/custom/login.jpg';
            }
        }
    }
</script>

<style lang="scss" scoped>
    ::v-deep.hero {
        background-repeat: no-repeat;
        background-position: 50% 50%;
        background-size: cover;
        min-height: 100vh;
        justify-content: center;
        align-items: center;
        .auth--box {
            width: 24.9em;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.78);
            .card-content {
                padding-bottom: .5rem;
            }
            .auth--intro {
                position: relative;
                text-align: center;
                padding: 2em 0 1.6em 0;
                &:before {
                    content: '';
                    position: absolute;
                    bottom: 0;
                    left: -1.5rem;
                    width: calc(100% + 3rem);
                    height: 1px;
                    background: gainsboro;
                }
                img {
                    width: 21px;
                    height: 25px;
                    object-fit: cover;
                    margin-bottom: 1.28em;
                }
                h4 {
                    font-size: .88rem;
                    text-transform: uppercase;
                }
            }
        }
    }
</style>
