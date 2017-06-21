import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        posts: [],
        languages: []
    },
    getters: {
        allPosts(state) {
            return state.posts;
        },
        allLanguages(state) {
            return state.languages;
        }
    },
    mutations: {
        initLanguages(state, languages) {
            state.languages = languages;
        },
        initPosts(state, posts) {
            state.posts = posts;
        }
    },
    actions: {
        initLanguages(context) {
            axios.get('/languages').then( response => {
                context.commit('initLanguages', response.data);
                console.log("Fetched languages");
            });
        },
        initPosts(context) {
            axios.get('/posts').then(response => {
                context.commit('initPosts', response.data);
                console.log("Fetched posts")
            });
        }
    }
});
