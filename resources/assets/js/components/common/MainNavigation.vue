<template>
    <transition
            appear
            name="custom-classes-transition"
            enter-active-class="animated fadeInDown"
    >
        <div class="menu-container">
            <el-row type="flex" class="main-menu" v-if="$route.path !== '/login'">
                <el-col :span="1" class="text-right" style="line-height: 60px;">
                    <a href="#" class="text-light" @click.stop.prevent="$router.back()" v-if="!endOfHistory">
                        <i class="fa fa-arrow-circle-left fa-2x" aria-hidden="true"></i>
                    </a>
                </el-col>
                <el-col :span="4">
                    <router-link :to="{ path: '/'}" class="logo text-decoration-none">
                        {{ $t('site.title') }}
                    </router-link>
                </el-col>
                <el-col :span="10">
                    <el-menu mode="horizontal" @select="handleSelect" class="vue-router" v-if="$store.getters.isLoggedIn">
                        <el-menu-item index="1">
                            <router-link :to="{ path: '/dashboard'}" class="el-menu-item text-decoration-none fit">
                                <i class="fa fa-sticky-note"></i> {{ $t('navigation.dashboard') }}
                            </router-link>
                        </el-menu-item>
                    </el-menu>
                </el-col>
                <el-col :span="8">
                    <el-menu class="pull-right vue-router" mode="horizontal" @select="handleSelect" v-if="$store.getters.isLoggedIn">
                        <el-submenu index="2" class="user-links">
                            <template slot="title">
                            <user-avatar :user="getAuthUser" class="circle avatar mr1"></user-avatar>
                                {{ getAuthUser.first_name }} {{ getAuthUser.last_name }}
                        </template>
                            <el-menu-item index="1" class="logout">
                                <a href="/logout" @click.prevent="logout()" class="text-decoration-none el-menu-item"><i class="fa fa-sign-out fa-fw"></i> {{ 'Logout' | capitalize }}</a>
                            </el-menu-item>
                        </el-submenu>

                    </el-menu>
                </el-col>
            </el-row>
        </div>
    </transition>
</template>

<script>
    import { mapGetters } from 'vuex';
    import { AuthService } from '@services';

    export default {
        data() {
          return {
              endOfHistory: true
          }
        },
        computed: {
            ...mapGetters([
                'getAuthUser'
            ])
        },
        watch: {
            '$route.path': function() {
                this.endOfHistory = window.history.state === null;
            }
        },
        methods: {
            handleSelect(key, keyPath) {
            },
            logout() {
                this.$router.push({
                    name: 'logout',
                    params: {
                        explicit: true
                    }
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "~@variables.scss";

    .menu-container {
        padding-top: 60px;
        position: relative;
        z-index: 1000;
    }

    .logo {
        white-space: nowrap;
    }

    .avatar {
        height: 36px;
        width: 36px;
        vertical-align: middle;
    }

    .main-menu {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: $vp-primary-color;
        z-index: 100000000000000000000 !important;
        .el-menu {
            background-color: transparent;
        }
        .logo {
            height: 60px;
            line-height: 60px;
            padding: 0 20px;
            text-decoration: none;
            color: $vp-color-light;
            font-weight: bold;
            font-size: 20px;
        }
        .el-menu-item,
        .el-submenu {
            color: $vp-color-light;
            .fa-2x {
                font-size: 1.5em;
                color: $vp-color-light;
            }
        }


        .user-links {

            li {
                padding: 0px 10px;
            }

            a {
                color: $vp-color-gray !important;

                &.router-link-exact-active {
                    color: $vp-primary-color !important;
                    text-shadow: none;

                }

            }


        }

    }
</style>

<style lang="scss">
    @import "~@variables.scss";

    .main-menu {
        .el-menu-item,
        .el-submenu {
            .el-badge__content {
                top: 20px;
                right: 27px;
                background-color: $vp-color-danger;
                border: 0;
                box-sizing: border-box;
                width: 22px;
                height: 22px;
                line-height: 24px;
            }

            .el-submenu__title {
                color: $vp-color-light;
            }

            .el-submenu__icon-arrow {
                color: $vp-color-light !important;
            }

            &.bell {
                .el-submenu__icon-arrow {
                    display: none;
                }
            }
        }

        .brand-version {
            top: -1em;
            background: $vp-color-blue;
            border-radius: 0.5em;
            padding: 0 0.5em;
            font-weight: 100;
        }
    }
</style>