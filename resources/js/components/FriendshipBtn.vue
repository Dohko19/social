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
            this.redirectIfGuest();

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
            if (this.localFriendshipStatus === 'pending' || this.localFriendshipStatus === 'accepted')
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
            if( this.localFriendshipStatus === 'accepted')
            {
                return 'Eliminar de mis amigos';

            }
            if( this.localFriendshipStatus === 'denied')
            {
                return 'Solicitud denegada';

            }
            return 'Solicitar Amistad';
        }
    }
}
</script>

<style scoped>

</style>
