<template>
  <v-container class="grey lighten-5">
    <fof v-if="!paramPost"></fof>
    <post-component v-else :post="paramPost"></post-component>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Fof from '@/views/404/Index'
import PostComponent from '@/components/Post/PostComponent'

export default {
    created(){
        if(this.paramPost == null) this.setPost(this.$route.params.post_id)
    },
    computed: mapGetters(['paramPost']),
    methods: {
        ...mapActions(['getParamPost']),
        setPost(post_id){
            let meta = {
                params: {
                    post_id: post_id
                }
            }
            this.getParamPost(meta)
        }
    }, 
    components: {
        Fof,
        PostComponent
    },
}
</script>