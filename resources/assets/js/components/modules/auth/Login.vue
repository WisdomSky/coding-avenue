\<template>
    <transition
                name="custom-classes-transition"
                enter-active-class="animated zoomIn"
                :leave-active-class="animOutTransition"
    >
        <login-container :title="$t('auth.login.signIn') | uppercase">
            <div>
                <el-button class="btn-block" type="primary" size="large" @click="login" v-loading.body="loading">
                    Sign In with Google
                </el-button>
            </div>
            <div class="center mt4">
                <router-link to="/">Go to home</router-link>
            </div>
        </login-container>
    </transition>
</template>

<script>
    import config_file from '@root/config';
    import { AuthService } from '@services';

    export default {
        data() {
          return {
              error: {},
              isProcessing: false,
              loading: false,
              animOutTransition: 'animated zoomOut'
          }
        },
        methods: {
            login() {
                this.loading = true;
                this.isProcessing = true;
                this.error = {};
                this.animOutTransition = 'animated zoomOutDown';

                AuthService.login()
                    .subscribe(() => {

                        this.$router.replace({path: this.$route.query && this.$route.query.r ? this.$route.query.r : config_file.auth.landingRoute});
                        this.isProcessing = false
                        this.loading = false;
                    }, (err) => {

                        let message;


                        if (err.response && err.response.data && err.response.data.code == 'failed') {
                            message = 'Your account is not authorized for login.';
                        }

                        if (message) {
                            this.$notify.error({
                                title: 'Unable to login',
                                message
                            });
                        }

                        this.loading = false;
                        this.isProcessing = false;
                        this.animOutTransition = 'animated rollOut';

                    });
            }
        }
    }
</script>

