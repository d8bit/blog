<template>
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Example Component</div>

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
                posts: []
            }
        },
        created() {
            this.fetchPosts();
            console.log(this.fetchPosts())
        },
        methods: {
            fetchPosts() {
                this.$http.get('/posts').then( response => {
                    this.posts = response.data;
                    console.log("Fetched posts")
                });
            }
        },
        mounted() {
            console.log('Component PostList mounted.')
        }
    }
</script>
