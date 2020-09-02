<template>
<v-container class="grey lighten-5">
  <fof v-if="!paramUser.length"></fof>
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
        <v-tooltip bottom v-if="isCurrent">
          <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on"><v-icon>mdi-cloud-upload-outline</v-icon></v-btn>
          </template>
          <span>Change Avatar</span>
        </v-tooltip>
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
      <v-col cols="8" v-if="isCurrent && loggedIn">
        <create-post></create-post>
      </v-col>
    </v-row>
  </div>
</v-container>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Fof from '@/views/404/Index'
import CreatePost from '@/components/Post/CreatePost'
import Cookies from 'js-cookie'

export default {
  data: () => ({
    isCurrent: false
  }),
  metaInfo: { 
    title: 'UserProfile'
  },
  computed: mapGetters(['paramUser', 'currentUser', 'loggedIn']),
  components: {
    Fof,
    CreatePost
  },
  created(){
    this.setUser(this.$route.params.url)
    this.isCurrent = Cookies.get('user_url') === this.$route.params.url
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