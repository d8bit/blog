<template>
    <div>
        <div>
            <ul class="nav nav-tabs">
                <li v-for="language in $store.getters.allLanguages" v-bind:class="{ active: (language.name == 'es')}" >
                    <a data-toggle="tab" v-bind:href="'#language_' + language.name">{{language.name}}</a>
                </li>
            </ul>
            <form name="new-post" v-on:submit.prevent="createPost" method="post" enctype="multipart/form-data">
                <div class="tab-content">
                    <div v-for="(postTranslation, index) in post.translations" v-bind:id="'language_' + postTranslation.language.name" v-bind:class="[(postTranslation.language.name == 'es') ? activeTabClass:'', tabClass]">
                        <div class="form-group">
                            <label v-bind:for="postTranslation.title">Title</label>
                            <input class="form-control" type="text" v-model="post.translations[index].title" v-bind:name="'title_' + postTranslation.language.name">
                        </div>
                        <div class="form-group">
                            <label v-bind:for="postTranslation.body">Body</label>
                            <textarea class="form-control" type="text" v-model="post.translations[index].body" v-bind:name="'body_' + postTranslation.language.name"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <div v-if="!post.image">
                        <input class="form-control" type="file" name="image" v-on:change="onFileChange" accept="image/*">
                    </div>
                    <div  v-else>
                        <div class="row">
                            <div class="col-md-6">
                                <img :src="'storage/' + post.image" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn-remove" v-on:click="removeImage">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input class="form-control" type="date" v-model="post.date" name="date">
                </div>
                <input class="btn btn-primary" type="submit" value="Save">
            </form>
        </div>
    </div>
</template>

<script>
import Modal from './Modal.vue';
    export default {
        props: ['posts', 'post'],
        components: { Modal },
        data() {
            return {
                activeTabClass: 'in active',
                tabClass: 'tab-pane fade'
            }
        },
        methods: {
            removeImage: function (e) {
                this.post.image = '';
            },
            showModal() {
                $('#post-' + this.post.id).modal();
            },
            deletePost() {
                this.$store.dispatch('deletePost', this.post);
            }
        },
        mounted() {
            console.log(this.post);
            console.log('Component Post mounted.')
        }
    }
</script>
