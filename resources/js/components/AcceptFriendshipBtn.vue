<template>
    <div>
        <div v-if="localFriendShipStatus === 'pending' ">
            <span v-text="sender.name"></span> te ha enviado una solicitud de amistad
            <button @click="acceptFriendshipRequest">Aceptar solicitud</button>
            <button dusk="deny-friendship" @click="denyFriendshipRequest">Denegar solicitud</button>
        </div>
        <div v-else-if="localFriendShipStatus === 'accepted'">
            Tu y <span v-text="sender.name"></span> son amigos
        </div>
        <div v-else-if="localFriendShipStatus === 'denied'">
            Solicitud denegada de <span v-text="sender.name"></span>
        </div>
        <div v-if="localFriendShipStatus === 'deleted'">Solicitud eliminada</div>
        <button v-else dusk="delete-friendship" @click="deleteFriendship">Eliminar</button>
    </div>
</template>

<script>
export default {
    props:{
      sender:{
          type:Object,
          required:true
      },
      friendshipStatus:{
          type: String,
          required: true
      }
    },
    data(){
        return{
            localFriendShipStatus: this.friendshipStatus
        }
    },
    methods:{
        acceptFriendshipRequest(){
            axios.post(`/accept-friendships/${this.sender.name}`)
            .then(res => {
                this.localFriendShipStatus = res.data.friendship_status
            })
            .catch(err => {
                console.log(err.response.data)
            })
        },
        denyFriendshipRequest(){
            axios.delete(`/accept-friendships/${this.sender.name}`)
            .then(res => {
                this.localFriendShipStatus = res.data.friendship_status
            })
            .catch(err => {
                console.log(err.response.data)
            })
        },
        deleteFriendship(){
            axios.delete(`/friendship/${this.sender.name}`)
            .then(res => {
                this.localFriendShipStatus = res.data.friendship_status
            })
            .catch(err => {
                console.log(err.response.data)
            })
        }
    }
}
</script>

<style scoped>

</style>
