<template>
    <div v-if="localFriendShipStatus === 'pending' ">
        <span v-text="sender.name"></span> te ha enviado una solicitud de amistad
        <button @click="acceptFriendshipRequest">Aceptar solicitud</button>
    </div>
    <div v-else>
        Tu y <span v-text="sender.name"></span> son amigos
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
                this.localFriendShipStatus = 'accepted'
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
