<template>
    <div class="d-flex align-items-center dropdown-item"
        :class="isRead ? '' : 'bg-light'" >
        <a
           :href="notification.data.link"
           :dusk="notification.id"
           class="dropdown-item">{{ notification.data.message }}</a>
        <button v-if="isRead"
                class="btn btn-link mr-2"
                @click.stop="markAsUnread"
                :dusk="`mark-as-unread-${notification.id}`"
                ><i class="far fa-circle"></i>
                <span class="position-absolute bg-dark text-white ml-2 py-1 px-2 rounded">Marcar como NO leida</span>
        </button>
        <button v-else
                @click.stop="markAsRead"
                class="btn btn-link mr-2"
                :dusk="`mark-as-read-${notification.id}`"
                ><i class="fas fa-circle"></i>
                <span class="position-absolute bg-dark text-white ml-2 py-1 px-2 rounded">Marcar como leida</span>
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            notification: Object
        },
        data() {
            return {
                isRead: !! this.notification.read_at
            }
        },
        methods: {
            markAsRead(){
                axios.post(`/read-notifications/${this.notification.id}`)
                .then(res => {
                    this.isRead = true;
                    EventBus.$emit('notification-read');
                })
                .catch(err => {
                    console.log(err);
                })
            },
            markAsUnread(){
                axios.delete(`/read-notifications/${this.notification.id}`)
                .then(res => {
                    this.isRead = false;
                    EventBus.$emit('notification-unread');

                })
                .catch(err => {
                    console.log(err);
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    button > span {
        display: none
    }
    button i {
        &:hover{
            & + span {
                display: inline;
            }
        }
    }
</style>
