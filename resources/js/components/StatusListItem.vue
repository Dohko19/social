<template>
    <div>
        <div class="card mb-3 border-0 shadow-sm"  >
            <div class="card-body d-flex flex-column">
                <div class=" d-flex mb-3">
                    <img class="shadow-sm mr-3 rounded" src="https://avatarfiles.alphacoders.com/141/141175.gif" width="40px" alt="">
                    <div>
                        <h5 class="mb-1" v-text="status.user_name"></h5>
                        <div class="text-muted small" v-text="status.ago"></div>
                    </div>
                </div>
                <p class="card-text text-secondary" v-text="status.body"></p>
            </div>
            <div class="card-footer p-2 d-flex justify-content-between align-items-center">
                <like-btn
                    :status="status"
                ></like-btn>
                <div class="mr-2">
                    <i class="far fa-thumbs-up text-secondary"></i>
                    <span dusk="likes-count">{{ status.likes_count }}</span>
                </div>
            </div>
            <div class="card-footer">
                <div v-for="comment in comments" class="mb-3">
                    <img :src="comment.user_avatar" :alt="comment.user_name" width="34px" class="rounded shadow-sm float-left mr-2">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-2 text-secondary" >
                            <a href="#"> <strong>{{ comment.user_name }}</strong> </a>
                            {{ comment.body }}
                        </div>
                    </div>
                </div>
                <form @submit.prevent="addComment" v-if="isAuthenticated">
                    <div class="d-flex align-items-center">
                        <img src="https://avatarfiles.alphacoders.com/141/141175.gif" :alt="currentUser.user_name" width="34px" class="rounded shadow-sm mr-2">
                        <div class="input-group">
                            <textarea class="form-control border-0 shadow-sm" placeholder="Escribe un Comentario..."
                                      name="comment"
                                      v-model="newComment"
                                      rows="1"
                                      required></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-primary" dusk="comment-btn">Enviar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import LikeBtn from './LiKeBtn'
    export default {
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        components: { LikeBtn },
        data(){
            return {
                newComment: '',
                comments: this.status.comments
            }
        },
        methods: {
            addComment(){
                axios.post(`/statuses/${this.status.id}/comments`, { body: this.newComment })
                .then(res => {
                    this.newComment = '';
                    this.comments.push(res.data.data);
                })
                .catch(err => {
                    console.log(err.response.data);
                })
            }
        }
    }
</script>

<style scoped>

</style>
