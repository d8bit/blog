<template>
    <div>
        <div>
            <h2>
                <span v-on:click.prevent="showModal()">{{ post.translations[0].title }} ({{ formattedDate }})</span>
                <div v-if="post.image">
                    <img :src="'storage/' + post.image" alt="">
                </div>
                <button class="btn btn-danger" v-on:click.prevent="deletePost()">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>
            </h2>
            <p v-on:click.prevent="showModal()">{{ post.translations[0].body }}</p>
        </div>
        <Modal v-bind:post="post" v-bind:key="post.id"></Modal>
    </div>
</template>

<script>
import Modal from './Modal.vue';
export default {
    props: ['posts', 'post'],
    components: { Modal },
    computed: {
        formattedDate() {
            return moment(this.post.date).format('DD/MM/YYYY')
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
        console.log('Component Post mounted.')
    }
}
</script>
