<template>
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
