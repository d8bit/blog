<template>
    <div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create post</div>

                <ul class="nav nav-tabs">
                    <li v-for="language in languages" v-bind:class="{ active: (language.name == 'es')}" >
                        <a data-toggle="tab" v-bind:href="'#language' + language.name">{{language.name}}</a>
                    </li>
                </ul>
                <form name="new-post" v-on:submit.prevent="createPost" method="post" enctype="multipart/form-data">
                    <div class="tab-content">
                        <div v-for="(postTranslation, index) in postTranslations" v-bind:id="'language' + postTranslation.language" v-bind:class="[(postTranslation.language == 'es') ? activeTabClass:'', tabClass]">
                            <div class="form-group">
                                <label v-bind:for="postTranslation.title">Title</label>
                                <input class="form-control" type="text" v-model="postTranslations[index].title" v-bind:name="'title_' + postTranslation.language">
                            </div>
                            <div class="form-group">
                                <label v-bind:for="postTranslation.body">Body</label>
                                <textarea class="form-control" type="text" v-model="postTranslations[index].body" v-bind:name="'body_' + postTranslation.language"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div v-if="!image">
                            <input class="form-control" type="file" name="image" v-on:change="onFileChange" accept="image/*">
                        </div>
                        <div  v-else>
                            <div class="row">
                                <div class="col-md-6">
                                    <img :src="image" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button v-on:click="removeImage">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input class="form-control" type="date" v-model="date" name="date">
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
                image: '',
                imageField: '',
                date: '',
                languages:[],
                postTranslations:[],
                activeTabClass: 'in active',
                tabClass: 'tab-pane fade'
            }
        },
        created() {
            this.fetchPosts();
            this.fetchLanguages();
            this.date = moment().format('YYYY-MM-DD');
        },
        methods: {
            fetchPosts() {
                axios.get('/posts').then( response => {
                    this.posts = response.data;
                    console.log("Fetched posts")
                });
            },
            fetchLanguages() {
                let that = this;
                axios.get('/languages').then( response => {
                    this.languages = response.data;
                    this.languages.forEach(function(item) {
                        let postTranslation = {
                            'title': '',
                            'body': '',
                            'image': '',
                            'date': '',
                            'language_id': item.id,
                            'language': item.name
                        };
                        that.postTranslations.push(postTranslation);
                    });
                    console.log("Fetched languages")
                });
            },
            createPost() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.imageField);
                formData.append('date', this.date);
                for(let i = 0; i < this.postTranslations.length; i++) {
                    formData.append('postTranslations[' + i + ']', JSON.stringify(this.postTranslations[i]));
                }
                console.warn(this.postTranslations);
                axios.post('/posts', formData).then(response => {
                    this.posts.push(response.data);
                    // this.resetFields();
                });
            },
            deletePost(post) {
                let that = this;
                let url = '/posts/' + post.id;
                axios.delete(url).then(response => {
                    const index = this.posts.indexOf(post);
                    that.posts.splice(index, 1);
                }).catch(function (error) {
                    console.error(error);
                });
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                this.imageField = files[0];
            },
            createImage(file) {
                let image = new Image();
                let reader = new FileReader();
                let that = this;
                reader.onload = (e) => {
                    that.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.image = '';
            },
            resetFields() {
                this.postTranslations.forEach(function(item) {
                    item.title = '';
                    item.body = '';
                    item.image = '';
                });
                this.image = '';
                this.imageField = '';
                this.date = moment().format('YYYY-MM-DD');
            }
        },
        mounted() {
            console.log('Component PostList mounted.')
        }
    }
</script>
<style>
img {
    width: 100%;
}
</style>
