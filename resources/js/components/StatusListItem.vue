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
                <form @submit.prevent="addComment">
                    <textarea name="comment" v-model="newComment"></textarea>
                    <button dusk="comment-btn">Enviar</button>
                </form>
                <div v-for="comment in comments">{{ comment.body }}</div>
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
                    this.newComment = ''
                    this.comments.push(res.data.data);
                })
            }
        }
    }
</script>

<style scoped>

</style>
