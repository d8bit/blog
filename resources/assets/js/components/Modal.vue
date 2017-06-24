<template>
    <div>
        <div class="modal fade" tabindex="-1" role="dialog" v-bind:id="'post-' + post.id">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <form name="edit-post" v-on:submit.prevent="editPost" method="post">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" v-model="post.title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea class="form-control" type="text" v-model="post.body" v-bind:name="'body'"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>
export default {
    props: ['posts', 'post'],
    methods: {
        editPost() {
            console.log('edit post');
        }
    },
    mounted() {
        console.log('Component Modal mounted.')
    }
}
</script>
