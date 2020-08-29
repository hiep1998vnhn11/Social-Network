<template>
<v-container class="grey lighten-5">
  <fof v-if="!(paramUser.length)"></fof>
  <div v-else>
    <v-row no-gutters>
      <v-card class="pa-2" outlined tile>
      <v-col md="8" offset-md="2">
        <v-img height="300px" :src="paramUser[0].background"/>
      </v-col>
      <v-row justify="space-around" class="bocAvatar">
      <v-avatar size="150" class="avatar">
        <img :src="paramUser[0].avatar" :alt="paramUser[0].name">
      </v-avatar>
      </v-row>
      <v-col align="center">
        <h1>{{paramUser[0].name}}</h1>

      </v-col>
      </v-card> 
    </v-row>
    <v-row>
      <v-col cols="4">
        <v-card class="pa-2" outlined tile>
          .col-4
        </v-card>
      </v-col>
      <v-col cols="8">
        <create-post></create-post>
      </v-col>
    </v-row>
  </div>
</v-container>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Fof from '@/views/404/Index'
import CreatePost from '../Post/CreatePost'

export default {
  data: () => ({
    isCurrent: false,
  }),
  metaInfo: { 
    title: 'UserProfile'
  },
  computed: mapGetters(['paramUser', 'currentUser']),
  components: {
    Fof,
    CreatePost
  },
  created(){
    this.setUser(this.$route.params.url)
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

<style>
.bocAvatar {
  position: relative;
}
.avatar {
  position: absolute;
  top: -150px;
  z-index: 10;

}
</style>