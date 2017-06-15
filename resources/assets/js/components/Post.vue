<template>
    <div>
        <h2>
            {{ post.title }} ({{ post.date }})
            <button class="btn btn-danger" v-on:click.prevent="deletePost()">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </h2>
        <p>{{ post.body }}</p>
        <Modal v-bind:post="post" v-bind:key="post.id"></Modal>
    </div>
</template>

<script>
import Modal from './Modal.vue';
export default {
    props: ['posts', 'post'],
    components: { Modal },
    methods: {
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
