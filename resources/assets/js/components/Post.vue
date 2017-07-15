<template>
    <div>
        <div>
            <h2>
                <span>{{ post.translations[0].title }} ({{ formattedDate }})</span>
            </h2>
            <div v-if="post.image">
                <img :src="post.image" alt="">
            </div>
            <p>{{ post.translations[0].body }}</p>
            <button class="btn btn-default" v-on:click.prevent="showModal()">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true">Edit</span>
            </button>
            <button class="btn btn-danger" v-on:click.prevent="deletePost()">
                <span class="glyphicon glyphicon-trash" aria-hidden="true">Delete</span>
            </button>
        </div>
        <Modal v-bind:post="post" v-bind:key="post.id"></Modal>
    </div>
</template>

<script>
/* global moment  */
import Modal from './Modal.vue';
export default {
    props: ['posts', 'post'],
    components: { Modal },
    computed: {
        formattedDate() {
            return moment(this.post.date).format('DD/MM/YYYY');
        }
    },
    methods: {
        showModal() {
            $('#post-' + this.post.id).modal();
        },
        deletePost() {
            this.$store.dispatch('deletePost', this.post);
        }
    },
    mounted() {
        console.log('Component Post mounted.');
    }
};
</script>
