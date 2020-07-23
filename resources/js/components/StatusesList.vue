<template>
    <div>
        <div class="card mb-3 border-0 shadow-sm" v-for="status in statuses" :key="status.id" >
            <div class="card-body d-flex flex-column">
                <div class=" d-flex mb-3">
                    <img class="shadow-sm mr-3 rounded" src="https://avatarfiles.alphacoders.com/141/141175.gif" width="40px" alt="">
                    <div>
                        <h5 class="mb-1" v-text="status.user_name"></h5>
                        <div class="text-muted small" v-text="status.ago"></div>
                    </div>
                </div>
                <p class="card-text text-secondary" v-text="status.body"></p>
                <button dusk="like-btn" @click="like(status)"></button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            statuses: []
        }
    },
    mounted() {
        axios.get('/statuses')
        .then((res) => {
            this.statuses = res.data.data;
        })
        .catch((err) => {
            console.log(err)
        });
        EventBus.$on('status-created', status => {
            this.statuses.unshift(status);
        })
    },
    methods: {
        like(status){
            axios.post(`/statuses/${status}/likes`)
            .then((res) => {
                status.is_liked = true;
            }).catch((err) => {

            });
        }
    }
}
</script>
