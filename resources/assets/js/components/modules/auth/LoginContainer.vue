<template>
        <div class="login-container auth" v-if="!$store.getters.isLoggedIn">
            <h1 class="heading">{{ $t("site.title") | uppercase }}</h1>
            <div class="form">
                <h4 class="title">{{ title }}</h4>
                <slot></slot>
                <div class="field-margin mt3">
                    <div class="copyright">
                        &copy; 2017 Ingenuiti. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: ''
            }
        }
    }
</script>


<style lang="scss">
    @import "~@variables.scss";

    .login-container {

        width: 525px;
        position: fixed;
        left:50%;
        margin-left: -262px;
        margin-top: 100px;
        top: 0;

        height: 100%;
        a {
            color: $vp-primary-color;
        }

        .heading {
            text-align: center;
            color: $vp-primary-color;
            margin-bottom: 50px;
            font-size: 40px;
        }
        .form {
            overflow: hidden;

            *:not([class^=el-]) {
                @include fontFamilyPoppins;
            }

            .el-input__inner {
                border-radius: 0;
                border-width: 0px 0px 1px 0px;
                border-color: $vp-color-light-gray;
                color: $vp-secondary-color;
                font-size: 16px;
                padding: 15px 15px;
                height: auto;
            }


        }

        .copyright {
            @include fontFamilyElement;
            font-size: 13px;
            text-align: center;
        }

    }
</style>
