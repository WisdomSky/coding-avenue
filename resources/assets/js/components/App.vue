<template>
    <div class="app-container">
        <vue-progress-bar></vue-progress-bar>
        <main-navigation></main-navigation>
        <router-view></router-view>
        <!--TODO: commented temporarily-->
        <!--<keep-alive>
            <router-view name="live"></router-view>
        </keep-alive>-->
    </div>
</template>

<script>
    import config_file from '@root/config';

    export default {
        mounted() {

            this.$SmoothScrollWebSites({
                stepSize: 50,
                animationTime    : 500,
                touchpadSupport: true
            });

            axios.interceptors.request.use(this.requestSuccess, this.requestFail);
            axios.interceptors.response.use(this.responseSuccess, this.responseFail);
            this.$http.interceptors.request.use(this.requestSuccess, this.requestFail);
            this.$http.interceptors.response.use(this.responseSuccess, this.responseFail);



            this.$store.watch(function (state) {
                return state.route;
            }, this.callback);
            this.callback(this.$store.state.route);
        },
        methods: {
            requestSuccess(config) {
                this.$Progress.start();
                return config;
            },
            requestFail(error) {
                this.$Progress.fail();
                return Promise.reject(error);
            },
            responseSuccess(response) {
                this.$Progress.finish();
                return response;
            },
            responseFail(error) {
                if (error.response.data.exception && /^.*\\TokenMismatchException$/.test(error.response.data.exception)) {
                    this.$alert(this.$t('error.unknownError.message'), this.$t('error.unknownError.title'), {
                        confirmButtonText: this.$t('error.unknownError.confirmButtonText'),
                        customClass: 'alert-no-close',
                        callback: () => {
                            window.location.reload();
                        }
                    });
                }
                this.$Progress.fail();
                return Promise.reject(error);
            },
            callback(route) {
                if (route.meta.noAuth && this.$store.getters.isLoggedIn) {
                    // this.$router.replace(config_file.auth.landingRoute);
                } else if (route.meta.noAuth || this.$store.getters.isLoggedIn) {
                    // add side effects here
                } else if (route.path !== '/') {
                    let query =  {};

                    switch (route.path) {
                        case '/logout':
                            break;
                        default:
                            query.r = route.path;
                    }

                    this.$router.replace({
                        path: '/login',
                        query
                    });
                }
            }
        }
    }
</script>