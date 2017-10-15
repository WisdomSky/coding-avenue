<template>
    <vp-page-container>
        <el-card
            class="no-border no-shadow mt4 pb4"
            v-loading.body="loading"
        >
            <div>
                <div>
                    <small>Title</small>
                    <el-input v-model="form.title" placeholder="Title" @keyup.native.enter="submit"></el-input>
                </div>
                <div class="mt1">
                    <small>Slug</small>
                    <el-input v-model="form.slug" placeholder="Slug (Optional)" size="small" @keyup.native.enter="submit"></el-input>
                </div>
                <div class="mt3">
                    <small>Content</small>
                    <el-row class="post-content-container">
                        <el-col :span="12" style="height: 100%">
                            <el-input ref="contentinput" type="textarea" resize="none" v-model="form.content" class="post-content-input"></el-input>
                        </el-col>
                        <el-col :span="12" style="height: 100%">
                            <div v-html="markdown" class="markdown-content pl1 pr1"></div>
                        </el-col>
                    </el-row>
                </div>
            </div>
            <div class="mt2">
                <el-button type="primary" @click.prevent="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</el-button>
                <div class="right" v-if="post || $route.params.id == 'new'">
                    <el-switch
                            v-model="publishSwitch"
                            on-text="Publish"
                            off-text="Unpublish"
                            :width="110"
                    >
                    </el-switch>
                </div>
            </div>
        </el-card>
    </vp-page-container>
</template>


<style lang="scss">

    .post-content-container {
        border: 1px solid #ccc;
        height: 500px;

        .post-content-input {

            &, textarea {
                height: 100%;
            }

            textarea {
                border: 0;
                border-right: 1px solid #ccc;
                border-radius: 0;
            }

        }

        .markdown-content {
            height: 100%;
            overflow: auto;
        }

    }

</style>

<script>
    import { PostsService } from '@services';
    import markdown from 'marked';
    import slugify from 'slugify'

    export default {

        data() {
            return {
                form: {
                    title: '',
                    slug: '',
                    content: '',
                    type: 'published'
                },
                publishSwitch: true,
                post: null,
                loading: false
            }
        },
        computed: {
            markdown() {
                return markdown(this.form.content, {
                    breaks: true,
                    sanitize: true
                });
            }
        },
        watch: {
            publishSwitch(published) {
                this.form.type = published ? 'published' : 'draft';
            },
            '$route.params.id': function () {
                this.loadPost();
            },
            'form.title': function (title) {
                if (!this.post) {
                    this.form.slug = slugify(title);
                }
            }
        },
        mounted() {

            this.loadPost();

            (function (_this) {

                $(_this.$refs.contentinput.$el).find('textarea').on('keydown', function(e) {

                    let $this = $(this).get(0);

                    var keyCode = e.keyCode || e.which;

                    if (keyCode == 9) {
                        e.preventDefault();
                        var start = $this.selectionStart;
                        var end = $this.selectionEnd;

                        _this.form.content = _this.form.content.substring(0, start) + "\t" + _this.form.content.substring(end);

                        // put caret at right position again
                        $this.selectionStart = $this.selectionEnd = start + 1;
                    }
                });
            })(this)


        },
        methods: {
            loadPost() {
                if (this.$route.params.id !== 'new') {
                    this.loading = true;
                    PostsService.get(this.$route.params.id)
                        .subscribe((post) => {
                            this.post = post;
                            this.publishSwitch = post.type === 'published';

                            _.extend(this.form, {
                                title: post.title,
                                slug: post.slug,
                                content: post.content,
                                type: post.type
                            })
                            this.loading = false;
                        },() => {
                            this.$router.replace('/edit/new');
                        })
                }
            },
            submit() {
                let obs;

                if (this.post) {
                    obs = PostsService.update(this.post.post_id, this.form);
                } else {
                    obs = PostsService.create(this.form);
                }

                this.loading = true;
                obs.subscribe((post) => {
                    this.$notify.success({
                        title: 'Post Saved',
                        message: 'The post was saved successfully.'
                    });
                    this.loading = false;

                    if (!this.post && post) {
                        this.$router.replace(`/edit/${post.key}`);
                    }

                },(error) => {
                    this.$notify.error({
                        title: 'Saving failed',
                        message: error.response.data[Object.keys(error.response.data)[0]][0]
                    });
                    this.loading = false;
                })

            }
        }

    }


</script>