<template>
    <vp-page-container>
        <el-card class="no-border no-shadow mt4 pb4">
            <div>
                <router-link to="edit/new" tag="el-button" class="el-button--primary"><i class="fa fa-plus" aria-hidden="true"></i> {{ $t('post.buttons.newPost') }}</router-link>
                <el-select
                        v-model="per_page"
                        placeholder="Select"
                        class="right per-page-dropdown">
                    <el-option label="5" value="5"></el-option>
                    <el-option label="10" value="10"></el-option>
                    <el-option label="15" value="15"></el-option>
                    <el-option label="20" value="20"></el-option>
                    <el-option label="25" value="25"></el-option>
                    <el-option label="50" value="50"></el-option>
                    <el-option label="100" value="100"></el-option>
                </el-select>
                <div
                        class="bulk-actions mt2 mb1 p1"
                        v-if="selection.length">
                    <div class="mb1">
                        <small>{{ $t('post.buttons.bulkActions.label') }}</small>
                    </div>
                    <el-button type="primary" @click.stop.prevent="publishPost(selection)"><i class="fa fa-check" aria-hidden="true"></i> {{ $t('post.buttons.bulkActions.publish') }}</el-button>
                    <el-button type="primary" @click.stop.prevent="unpublishPost(selection)"><i class="fa fa-ban" aria-hidden="true"></i> {{ $t('post.buttons.bulkActions.unpublish') }}</el-button>
                    <el-button type="primary" @click.stop.prevent="deletePost(selection)"><i class="fa fa-trash" aria-hidden="true"></i> {{ $t('post.buttons.bulkActions.delete') }}</el-button>
                </div>
            </div>
            <div class="mt3 mb2">
                <el-table
                        ref="multipleTable"
                        :data="posts"
                        v-loading.body="loading"
                        border
                        row-class-name="post-row"
                        @cell-click="editPost"
                        @selection-change="multiSelection"
                        style="width: 100%">
                    <el-table-column
                            type="selection"
                            width="55">
                    </el-table-column>
                    <el-table-column
                            property="title"
                            :label="$t('post.table.labels.title')"
                            show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                            property="slug"
                            :label="$t('post.table.labels.slug')"
                            width="200"
                            show-overflow-tooltip>

                    </el-table-column>
                    <el-table-column
                            width="120"
                            :label="$t('post.table.labels.status')">
                        <template scope="scope">
                            <el-tag type="success" v-if="scope.row.type == 'published'" :close-transition="true">{{ $t('post.table.tags.published') }}</el-tag>
                            <el-tag type="primary" v-if="scope.row.type == 'draft'" :close-transition="true">{{ $t('post.table.tags.draft') }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column
                            width="100"
                            :label="$t('post.table.labels.actions')">
                        <template scope="scope">
                            <div class="center">
                                <el-tooltip
                                        placement="top"
                                        :content="$t('post.table.tooltips.publishPost')"
                                        v-if="scope.row.type == 'draft'">
                                    <a href="#" @click.stop.prevent="publishPost(scope.$index)" class="mr1">
                                        <i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>
                                    </a>
                                </el-tooltip>

                                <el-tooltip
                                        placement="top"
                                        :content="$t('post.table.tooltips.unpublishPost')"
                                        v-if="scope.row.type == 'published'">
                                    <a href="#" @click.stop.prevent="unpublishPost(scope.$index)" class="mr1">
                                        <i class="fa fa-ban text-warn" aria-hidden="true"></i>
                                    </a>
                                </el-tooltip>
                                <el-tooltip
                                        placement="top"
                                        :content="$t('post.table.tooltips.deletePost')">
                                    <a href="#" @click.stop.prevent="deletePost(scope.$index)"><i class="fa fa-trash color-primary" aria-hidden="true"></i></a>
                                </el-tooltip>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div
                class="bulk-actions mt2 mb1 p1"
                v-if="selection.length">
                <div class="mb1">
                    <small>{{ $t('post.buttons.bulkActions.label') }}</small>
                </div>
                <el-button type="primary" @click.stop.prevent="publishPost(selection)"><i class="fa fa-check" aria-hidden="true"></i> {{ $t('post.buttons.bulkActions.publish') }}</el-button>
                <el-button type="primary" @click.stop.prevent="unpublishPost(selection)"><i class="fa fa-ban" aria-hidden="true"></i> {{ $t('post.buttons.bulkActions.unpublish') }}</el-button>
                <el-button type="primary" @click.stop.prevent="deletePost(selection)"><i class="fa fa-trash" aria-hidden="true"></i> {{ $t('post.buttons.bulkActions.delete') }}</el-button>
            </div>
            <div v-if="!loading">
                <div class="left">
                    {{ $t('post.table.noOfPosts',{total})}}
                </div>
                <div class="right">
                    <el-button class="ml1" type="primary" v-if="showPrevBtn" @click="--page" :disabled="loading">< Prev</el-button>
                    <el-button type="primary" v-if="showNextBtn" @click="++page" :disabled="loading">Next ></el-button>
                </div>
            </div>
        </el-card>
    </vp-page-container>
</template>


<style lang="scss">

    .post-row {
        cursor: pointer;
    }

    .per-page-dropdown {
        width: 75px;
    }

    .bulk-actions {
        border: 1px solid #ccc;
    }

</style>

<script>
    import { PostsService } from '@services';

    export default {
        data() {
            return {
                page: 1,
                posts : [],
                showPrevBtn: false,
                showNextBtn: false,
                loading: false,
                total: 0,
                per_page: 5,
                selection: []
            }
        },
        watch: {
            page() {
                this.load();
            },
            per_page() {
                this.load();
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            load() {
                this.loading = true;
                PostsService.fetch(this.page, true, this.per_page)
                    .subscribe((data) => {
                        this.posts = data.data;
                        this.showPrevBtn = data.current_page > 1;
                        this.showNextBtn = data.current_page < data.last_page;
                        this.page = data.current_page;
                        this.total = data.total;
                        if (data.last_page !== 0 && data.current_page > data.last_page) {
                            this.page = 1;
                        } else {
                            this.loading = false;
                        }
                    });
            },
            multiSelection(selection) {
                this.selection = selection;
            },
            editPost(row, column) {
                if (column.type !== 'selection') {
                    this.$router.push(`/edit/${row.key}`);
                }
            },
            deletePost(index) {

                if (Array.isArray(index)) {
                    index = index.map((p) => p.key);
                } else {
                    index = this.posts[index].key;
                }

                this.$confirm('Do you want to proceed?', 'Delete Post', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    type: 'error'
                }).then(() => {
                    this.loading = true;
                    PostsService.del(index).subscribe(() => {
                        this.load();
                    });
                });


            },
            publishPost(index) {

                if (Array.isArray(index)) {
                    index = index.map((p) => p.key);
                } else {
                    index = this.posts[index].key;
                }

                this.loading = true;

                PostsService.update(index, {
                    type: 'published'
                }).subscribe(() => {
                    this.load();
                });
            },
            unpublishPost(index) {


                if (Array.isArray(index)) {
                    index = index.map((p) => p.key);
                } else {
                    index = this.posts[index].key;
                }

                this.loading = true;

                PostsService.update(index, {
                    type: 'draft'
                }).subscribe(() => {
                    this.load();
                });
            }
        }
    }

</script>