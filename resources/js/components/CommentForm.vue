<template>
    <form @submit.prevent="addComment" v-if="isAuthenticated" class="mb-3">
        <div class="d-flex align-items-center">
            <img :src="currentUser.avatar" :alt="currentUser.user_name" width="34px" class="rounded shadow-sm mr-2">
            <div class="input-group">
                    <textarea class="form-control border-0 shadow-sm" placeholder="Escribe un Comentario..."
                              name="comment"
                              v-model="newComment"
                              rows="1"
                              required
                    ></textarea>
                <div class="input-group-append">
                    <button class="btn btn-primary" dusk="comment-btn">Enviar</button>
                </div>
            </div>
        </div>
    </form>
    <div v-else class="mb-3 text-center">
        Debes <a href="/login">Autenticarte</a> para poder comentar
    </div>
</template>

<script>
export default {
    props: {
        statusId: Number,
        required: true
    },
    data(){
        return {
            newComment: ''
        }
    },
    methods: {
        addComment(){
        axios.post(`/statuses/${this.statusId}/comments`, { body: this.newComment })
            .then(res => {
                this.newComment = '';
                EventBus.$emit(`statuses.${this.statusId}.comments`, res.data.data)
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
