<template>
	<div class="auth">
        <div class="auth--box">
            <div class="auth--into">
            	<img class="auth--tie logo" src="/img/logo.png" alt="PetPassport">
                <h4 class="auth--faith size--14">PETPASSPORT.ONLINE</h4>
            </div>
            <div class="auth--point">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        $(this.$el).find('select').niceSelect();
    }
}
</script>

<style lang="scss">
.auth {
    background-repeat: no-repeat;
    background-position: 50% 50%;
    background-size: cover;
    background-image: url('/img/background/login.jpg?2');
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2em;
}
.auth--box {
    background-color: rgba(255, 255, 255, 0.78);
    box-shadow: 0px 1px 1px rgba(30, 38, 56, 0.3);
    width: 24.90em;
}
.auth--into {
    border-bottom: 1px solid #dddddd;
    text-align: center;
    padding: 3.5em .7em 1.60em;
}
.auth--point {
    padding: 0.50em 1.70em 1.70em;
}
.auth--tie {
    margin-bottom: 1.28em;
}
</style>
