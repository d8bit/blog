
export const initLanguages = (state, languages) => {
    state.languages = languages;
};
export const initPosts = (state, posts) => {
    state.posts = posts;
};
export const addPost = (state, post) => {
    state.posts.push(post);
};
export const deletePost = (state, post) => {
    const index = state.posts.indexOf(post);
    state.posts.splice(index, 1);
};
