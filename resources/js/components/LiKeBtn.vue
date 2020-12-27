<template>
    <button
        :class="getBtnClases"
        @click="toggle()">
        <strong><i :class="getIconClases"></i>
            {{ getText }}
        </strong>
    </button>

</template>

<script>
    export default {
        props: {
            model: {
                type: Object,
                required: true
            },
            url: {
                type: String,
                required: true
            }
        },
        methods: {
            toggle(){
                let method = this.model.is_liked ? 'delete' : 'post';
                axios[method](this.url)
                .then(res => {
                    this.model.is_liked = ! this.model.is_liked;
                    this.model.likes_count = res.data.likes_count;
                })
            }
        },
        computed: {
            getText(){
                return this.model.is_liked ? 'TE GUSTA' : 'ME GUSTA';
            },
            getBtnClases(){
                return [
                    this.model.is_liked ? 'font-weight-bold' : '',
                    'btn', 'btn-link', 'btn-sm',
                ]
            },
            getIconClases(){
                return [
                    this.model.is_liked ? 'fa' : 'far',
                    'fa-thumbs-up','text-primary','btn-sm','mr-1',
                ]
            },
        }
    }
</script>

<style lang="scss" scoped>
 .comment-like-btn{
     font-size: 0.6em;
     padding-left: 0;
     i { display:none }
 }
</style>
