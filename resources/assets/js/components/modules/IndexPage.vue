<template>
    <vp-page-container>
        <div
            class="no-border no-shadow mt4 pb4"

        >
            <el-card v-for="post in posts" :key="post.post_id" class="mb3">
                <div slot="header" class="clearfix">
                    <router-link :to="`p/${post.slug}`" class="text-decoration-none color-primary">
                        <h1 class="m0">{{ post.title | ucfirst }}</h1>
                    </router-link>
                </div>
                <div class="post-content">
                    <div v-html="parseMarkdown(post.content)"></div>
                    <div>
                        <router-link :to="`p/${post.slug}`" class="text-decoration-none color-primary right">
                            <strong class="color-primary-light" v-if="trimContent(post.content).split('\n').length > 4">{{ $t('post.readMore') }}</strong>
                        </router-link>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="mt1">
                    <small>
                        <em v-html="$t('post.postedBy', {name: `${post.author.first_name} ${post.author.last_name}`, date: post.formatted_date})"></em>
                    </small>
                </div>
            </el-card>
            <div>
                <el-button class="left" type="primary" v-if="showPrevBtn" @click="--page" :disabled="loading">< {{ $t('post.pagination.newer') }}</el-button>
                <el-button class="right" type="primary" v-if="showNextBtn" @click="++page" :disabled="loading">{{ $t('post.pagination.older') }} ></el-button>
            </div>
        </div>
    </vp-page-container>
</template>


<style lang="scss" scoped>

    .post-content {
        min-height: 125px;
    }

</style>

<script>
    import { PostsService } from '@services';
    import { mapState } from 'vuex'
    import markdown from 'marked';

    export default {
        data() {
            return {
                page: 1,
                posts : [],
                showPrevBtn: false,
                showNextBtn: false,
                loading: false
            }
        },
        watch: {
            page(page) {
                this.load();
                this.$router.push({
                    query: { page }
                })
            },
            "$route.query.page" : function () {
                if (this.$route.query.page == undefined) {
                    this.page = 1;
                }
            }
        },
        mounted() {

            if (this.$route.query.page !== undefined) {
                this.page = parseInt(this.$route.query.page);
            }

            this.load();
        },
        methods: {
            load() {
                this.loading = true;
                PostsService.fetch(this.page)
                    .subscribe((data) => {
                        this.posts = data.data;
                        this.showPrevBtn = data.current_page > 1;
                        this.showNextBtn = data.current_page < data.last_page;
                        this.page = data.current_page;

                        if (data.last_page !== 0 && data.current_page > data.last_page) {
                            this.page = 1;
                        } else {
                            this.loading = false;
                        }
                    });
            },
            parseMarkdown(content) {
                return markdown(this.trimContent(content).split("\n").splice(0,3).join("\n"), {
                    breaks: true,
                    sanitize: true
                });
            },
            trimContent(content) {
                return content.replace(/\n{3,}/g, "\n");
            }
        }

    }


</script>