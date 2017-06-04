<template>
    <div>
        <h2>
            {{ post.title }} ({{ post.date }})
            <button class="btn btn-danger" v-on:click.prevent="deletePost(post)">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </h2>
        <p>{{ post.body }}</p>
    </div>
</template>

<script>
export default {
    props: ['post'],
    mounted() {
        console.log('Component Post mounted.')
    }
}
</script>
