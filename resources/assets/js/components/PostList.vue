<template>
    <div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create post</div>

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#default">Default</a></li>
                    <li v-for="language in languages">
                        <a data-toggle="tab" v-bind:href="'#language' + language.id">{{language.name}}</a>
                    </li>
                </ul>
                <form v-on:submit.prevent="createPost" method="post">
                    <div class="tab-content">
                        <div id="default" class="tab-pane fade in active">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" v-model="post.title" v-bind:name="'title_default'">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea class="form-control" type="text" v-model="post.body" name="body"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input class="form-control" type="date" v-model="post.date" name="date">
                            </div>
                            <input type="hidden" name="language_id" value="">
                            <input class="btn btn-primary" type="submit">
                        </div>
                        <div v-for="language in languages" v-bind:id="'language' + language.id" class="tab-pane fade">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" v-model="post.title" v-bind:name="'title_' + language.name">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea class="form-control" type="text" v-model="post.body" v-bind:name="'body_' + language.name"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input class="form-control" type="date" v-model="post.date" v-bind:name="'date_' + language.name">
                            </div>
                            <input class="btn btn-primary" type="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Posts</div>
                <div class="panel-body">
                    <Post  v-for="post in posts" v-bind:posts="posts" v-bind:post="post" v-bind:key="post.id"></Post>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Post from './Post.vue';

    export default {
        components: { Post },
        data() {
            return {
                posts: [],
                post:{},
                languages:[]
            }
        },
        created() {
            this.fetchPosts();
            this.fetchLanguages();
            this.post.date = moment().format('YYYY-MM-DD');
        },
        methods: {
            fetchPosts() {
                axios.get('/posts').then( response => {
                    this.posts = response.data;
                    console.log("Fetched posts")
                });
            },
            fetchLanguages() {
                axios.get('/languages').then( response => {
                    this.languages = response.data;
                    console.log("Fetched languages")
                });
            },
            createPost() {
                axios.post('/posts', this.post).then(response => {
                    this.posts.push(response.data);
                    this.post = {'date': moment().format('YYYY-MM-DD')};
                    console.log(response.data);
                });
            },
            deletePost(post) {
                let that = this;
                let url = '/posts/' + post.id;
                axios.delete(url).then(response => {
                    const index = this.posts.indexOf(post);
                    that.posts.splice(index, 1);
                    console.log(response.data);
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            console.log('Component PostList mounted.')
        }
    }
</script>
