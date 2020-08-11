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
                <button
                    class="btn btn-link"
                    v-if="status.is_liked"
                    dusk="unlike-btn"
                    @click="unlike(status)">
                    <strong><i class="fas fa-thumbs-up text-primary btn-sm mr-1"></i> TE GUSTA</strong>
                </button>
                <button
                    class="btn btn-link"
                    v-else dusk="like-btn"
                    @click="like(status)">
                    <i class="far fa-thumbs-up text-primary btn-sm mr-1"></i> ME GUSTA
                </button>
                <div class="mr-2">
                    <i class="far fa-thumbs-up text-secondary"></i>
                    <span dusk="likes-count">{{ status.likes_count }}</span>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            status: {
                type: Object,
                required: true
            }
        },
        methods: {
            like(status){
                axios.post(`/statuses/${status.id}/likes`)
                    .then((res) => {
                        status.is_liked = true;
                        status.likes_count++;
                    }).catch((err) => {
                    console.log(err)
                });
            },
            unlike(status){
                axios.delete(`/statuses/${status.id}/likes`)
                    .then((res) => {
                        status.is_liked = false;
                        status.likes_count--;

                    }).catch((err) => {
                    console.log(err)
                });
            }
        }
    }
</script>

<style scoped>

</style>
