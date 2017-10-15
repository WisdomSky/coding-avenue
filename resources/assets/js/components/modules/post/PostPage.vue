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

            <vue-markdown class="mt3">{{ post.content }}</vue-markdown>

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

    export default {

        data() {
            return {
                post: null
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