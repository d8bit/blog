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
                <form name="new-post" v-on:submit.prevent="createPost" method="post">
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
                        <label for="date">Date</label>
                        <input class="form-control" type="date" v-model="post.date" name="date">
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
                languages:[],
                postTranslations:[],
                activeTabClass: 'in active',
                tabClass: 'tab-pane fade'
            }
        },
        created() {
            this.fetchPosts();
            this.fetchLanguages();
            this.post.date = moment().format('YYYY-MM-DD');
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
                            'date': that.post.date,
                            'language_id': item.id,
                            'language': item.name
                        };
                        that.postTranslations.push(postTranslation);
                    });
                    console.log("Fetched languages")
                });
            },
            createPost() {
                this.postTranslations['date'] = this.post.date;
                axios.post('/posts', this.postTranslations).then(response => {
                    this.posts.push(response.data);
                    this.post = {'date': moment().format('YYYY-MM-DD')};
                    console.log(response.data);
                });
            },
            deletePost(post) {
                let that = this;
                let url = '/posts/' + post.id;
                axios.delete(url).then(response => {
                    const index = this.posts.indexOf(post);
                    that.posts.splice(index, 1);
                    console.log(response.data);
                }).catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            console.log('Component PostList mounted.')
        }
    }
</script>
