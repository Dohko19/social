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
        }
    },
    data: () => ({
        friendshipStatus: ''
    }),
    created() {
        axios.get(`/friendships/${this.recipient.name}`)
        .then(res => {
            this.friendshipStatus = res.data.friendship_status;
        })
        .catch(err => {
            console.log(err.response.data)
        })
    },
    methods: {
        toggleFriendShipStatus(){
            this.redirectIfGuest();

            let method = this.getMethod();
            axios[method](`friendship/${this.recipient.name}`)
            .then(res => {
                this.friendshipStatus = res.data.friendship_status;
            })
            .catch(err => {
                console.log(err.response.data)
            })
        },
        getMethod(){
            if (this.friendshipStatus === 'pending' || this.friendshipStatus === 'accepted')
            {
                return 'delete';
            }
            return 'post';

        }
    },
    computed: {
        getText(){
            if( this.friendshipStatus === 'pending')
            {
                return 'Cancelar solicitud';

            }
            if( this.friendshipStatus === 'accepted')
            {
                return 'Eliminar de mis amigos';

            }
            if( this.friendshipStatus === 'denied')
            {
                return 'Solicitud denegada';

            }
            return 'Solicitar amistad';
        }
    }
}
</script>

<style scoped>

</style>
