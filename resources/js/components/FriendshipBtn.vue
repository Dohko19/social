<template>
    <button
        @click="toggleFriendShipStatus"
    >
        {{ getText }}
    </button>

</template>

<script>
export default {
    props: {
        recipient: {
            type: Object,
            required: true
        },
        friendshipStatus: {
            type: String,
            required: true
        }
    },
    data(){
        return {
            localFriendshipStatus: this.friendshipStatus
        }
    },
    methods: {
        toggleFriendShipStatus(){
            let method = this.getMethod();
            axios[method](`friendship/${this.recipient.name}`)
            .then(res => {
                this.localFriendshipStatus = res.data.friendship_status;
            })
            .catch(err => {
                console.log(err.response.data)
            })
        },
        getMethod(){
            if (this.localFriendshipStatus === 'pending')
            {
                return 'delete';
            }
            return 'post';

        }
    },
    computed: {
        getText(){
            if( this.localFriendshipStatus === 'pending')
            {
                return 'Cancelar Solicitud';

            }
            return 'Solicitar Amistad';
        }
    }
}
</script>

<style scoped>

</style>
