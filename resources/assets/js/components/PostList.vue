<template>
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Example Component</div>


            <form v-on:submit.prevent="create" method="post">
                <input class="form-control" type="text" v-model="post.title" name="title">
                <input class="form-control" type="text" v-model="post.body" name="body">
                <input type="submit">
            </form>

            <div class="panel-body">
                <div v-for="post in posts">
                    <p>{{ post.title }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                post:{}
            }
        },
        created() {
            this.fetchPosts();
            console.log(this.fetchPosts())
        },
        methods: {
            fetchPosts() {
                axios.get('/posts').then( response => {
                    this.posts = response.data;
                    console.log("Fetched posts")
                });
            },
            create() {
                this.$http.post('/posts', this.post).then(response => {
                    this.posts.push(response.data);
                    console.log(response.data);
                });
            }
        },
        mounted() {
            console.log('Component PostList mounted.')
        }
    }
</script>
