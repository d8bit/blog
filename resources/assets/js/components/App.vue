<template>
    <div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create post</div>
                <FormPost></FormPost>
            </div>
        </div>
        <Posts v-bind:posts="posts"></Posts>
    </div>
</template>

<script>
import FormPost from './FormPost.vue';
import Posts from './Posts.vue';
export default {
    components: { FormPost, Posts },
    props: ['posts'],
    created() {
        this.$store.dispatch('initLanguages');
        this.$store.dispatch('initPosts');
    },
    mounted() {
        console.log('Component App mounted.')
    }
}
</script>
