<template>
<div style="padding:30px">
  <fof v-if="!(paramUser.length)"></fof>
  <div v-if="paramUser.length">
    Hello user has url {{ $route.params.url }}
  {{ paramUser }}
  </div>
  
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Fof from '@/views/404/Index'

export default {
  data: () => ({
  }),
  metaInfo: { title: 'User Profile' },
  computed: mapGetters(['paramUser']),
  components: {
    Fof,
  },
  created(){
    if(this.paramUser === null) this.setUser(this.$route.params.url)
  },
  methods: {
    ...mapActions(['getParamUser']),
    setUser(url){
      let meta = {
        params: {
          user_url: url
        }  
      }
      this.getParamUser( meta )
    },
  }
}
</script>
