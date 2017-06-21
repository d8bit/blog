<template>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Posts</div>
            <div class="panel-body">
                <Post  v-for="post in $store.getters.allPosts" v-bind:posts="posts" v-bind:post="post" v-bind:key="post.id"></Post>
            </div>
        </div>
    </div>
</template>

<script>
import Post from './Post.vue';
export default {
    props: ['posts', 'post'],
    components: { Post },
    methods: {
        showModal() {
            $('#post-' + this.post.id).modal();
        },
        deletePost() {
            let that = this;
            let url = '/posts/' + this.post.id;
            axios.delete(url).then(response => {
                const index = that.posts.indexOf(that.post);
                that.posts.splice(index, 1);
                console.log(response.data);
            }).catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted() {
        console.log('Component Post mounted.')
    }
}
</script>
