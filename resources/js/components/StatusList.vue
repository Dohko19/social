<template>
    <div @click="redirectIfGuest">
        <transition-group name="status-list-transition">
            <status-list-item
                v-for="status in statuses"
                :key="status.id"
                :status="status"
            ></status-list-item>
        </transition-group>
    </div>
</template>
<script>
import StatusListItem from './StatusListItem'

export default {
    components: { StatusListItem },
    props: {
      url: String
    },
    data() {
        return {
            statuses: []
        }
    },
    mounted() {
        axios.get(this.getUrl)
        .then((res) => {
            this.statuses = res.data.data;
        })
        .catch((err) => {
            console.log(err.response.data)
        });
        EventBus.$on('status-created', status => {
            this.statuses.unshift(status);
        });
        let pusher = 'StatusCreated';
        let io = '.StatusCreated';
        Echo.channel('statuses').listen(pusher, ({status}) => {
            this.statuses.unshift(status); //socket io and pusher // With socket.IO version 2.3.0 using a DAT after name of listen event
        });

    },
    computed:{
        getUrl(){
            return this.url ? this.url : '/statuses';
        }
    }

}
</script>
<style>
    .status-list-transition-move{
        transition: all .8s;
    }
</style>
