<template>
    <div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create post</div>

                <form v-on:submit.prevent="createPost" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control" type="text" v-model="post.title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <input class="form-control" type="text" v-model="post.body" name="body">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input class="form-control" type="date" v-model="post.date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="language">Language</label>
                        <select name="language" class="form-control">
                            <option value="">&nbsp;</option>
                            <option v-for="language in languages" v-bind:value="language.id" v-bind:key="language.id">
                                {{language.name}}
                            </option>
                        </select>
                    </div>
                    <input class="btn btn-primary" type="submit">
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
