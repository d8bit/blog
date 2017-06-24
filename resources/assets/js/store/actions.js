
export const initLanguages = (context) => {
    axios.get('/languages').then(response => {
        context.commit('initLanguages', response.data);
        console.log('Fetched languages');
    });
};

export const initPosts = (context) => {
    axios.get('/posts').then(response => {
        context.commit('initPosts', response.data);
        console.log('Fetched posts');
    });
};

export const addPost = (context, post) => {
    axios.post('/posts', post).then(response => {
        context.commit('addPost', response.data);
        console.log('Post added. Response', response);
        console.log('Post added');
    });
};

export const deletePost = (context, post) => {
    let url = '/posts/' + post.id;
    axios.delete(url).then(response => {
        context.commit('deletePost', post);
        console.log('Post deleted. Response:', response);
    }).catch((error) => {
        console.error('Error deleting: ', error);
    });
};
