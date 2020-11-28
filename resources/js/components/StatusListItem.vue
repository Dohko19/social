<template>
    <div>
        <div class="card mb-3 border-0 shadow-sm"  >
            <div class="card-body d-flex flex-column">
                <div class=" d-flex mb-3">
                    <img class="shadow-sm mr-3 rounded" :src="status.user.avatar" width="40px" :alt="status.user.name">
                    <div>
                        <h5 class="mb-1"><a :href="status.user.link" v-text="status.user.name"></a></h5>
                        <div class="text-muted small" v-text="status.ago"></div>
                    </div>
                </div>
                <p class="card-text text-secondary" v-text="status.body"></p>
            </div>
            <div class="card-footer p-2 d-flex justify-content-between align-items-center">
                <like-btn
                    dusk="like-btn"
                    :url="`/statuses/${status.id}/likes`"
                    :model="status"
                ></like-btn>
                <div class="mr-2">
                    <i class="far fa-thumbs-up text-secondary"></i>
                    <span dusk="likes-count">{{ status.likes_count }}</span>
                </div>
            </div>
            <div class="card-footer pb-0" v-if="isAuthenticated || status.comments.length">
                <comment-list
                :comments="status.comments"
                :status-id="status.id"
                ></comment-list>

                <comment-form
                    :status-id="status.id"
                ></comment-form>
            </div>
        </div>
    </div>
</template>

<script>
    import LikeBtn from './LiKeBtn'
    import CommentList from './CommentList';
    import CommentForm from './CommentForm';

    export default {
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        components: { LikeBtn, CommentList, CommentForm },
        mounted() {
            Echo.channel(`statuses.${this.status.id}.likes`)
                .listen('ModelLiked', e => {
                    this.status.likes_count++;
                });

            Echo.channel(`statuses.${this.status.id}.likes`)
                .listen('ModelUnLiked', e => {
                    this.status.likes_count--;
                })
        }
    }
</script>

<style scoped>

</style>
