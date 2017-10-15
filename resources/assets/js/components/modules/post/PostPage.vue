<template>
    <vp-page-container>
        <el-card
            class="no-border no-shadow mt4 pb4"
            v-if="post"
        >
            <h1 class="color-primary">{{ post.title | ucfirst }}</h1>
            <small>
                <em>Posted by <strong>{{ post.author.first_name }} {{ post.author.last_name }}</strong> on {{ post.formatted_date }}
                </em>
            </small>

            <div class="mt3" v-html="markdown"></div>

        </el-card>
    </vp-page-container>
</template>


<style lang="scss">

    a.router-link-exact-active {
        color: #20a0ff;
    }

</style>

<script>
    import { PostsService } from '@services';
    import markdown from 'marked';


    export default {

        data() {
            return {
                post: null
            }
        },
        computed: {
          markdown() {
                return markdown(this.post.content, {
                    breaks: true,
                    sanitize: true
                });
            }
        },
        mounted() {
            PostsService.get(this.$route.params.slug)
                .subscribe((post) => {
                    this.post = post;
                });
        }

    }


</script>