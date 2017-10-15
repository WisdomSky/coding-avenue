<template>
    <vp-page-container>
        <el-card
            class="no-border no-shadow mt4 pb4"
        >
            <el-input v-model="form.title" placeholder="Title"></el-input>
            <el-input v-model="form.slug" placeholder="Slug (Optional)" size="small" class="mt1"></el-input>
            <el-row class="mt3 post-content-container">
                <el-col :span="12" style="height: 100%">
                    <el-input ref="contentinput" type="textarea" resize="none" v-model="form.content" class="post-content-input"></el-input>
                </el-col>
                <el-col :span="12" style="height: 100%">
                    <div v-html="markdown" class="markdown-content pl1 pr1"></div>
                </el-col>
            </el-row>
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

    export default {

        data() {
            return {
                post_id: this.$route.params.id,
                form: {
                    title: '',
                    slug: '',
                    content: ''
                }
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
        mounted() {

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


        }

    }


</script>