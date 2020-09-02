<template>
<v-container class="grey lighten-5">
  <fof v-if="!paramUser"></fof>
  <div v-else>
    <v-row no-gutters>
      <v-card class="pa-2" outlined tile>
      <v-col md="8" offset-md="2">
        <v-img height="300px" :src="paramUser.background"/>
      </v-col>
      <v-row justify="space-around" class="bocAvatar">
      <v-avatar size="150" class="avatar">
        <img :src="paramUser.avatar" :alt="paramUser.name">
      </v-avatar>
        <v-tooltip bottom v-if="isCurrent">
          <template v-slot:activator="{ on, attrs }">
            <v-btn icon v-bind="attrs" v-on="on"><v-icon>mdi-cloud-upload-outline</v-icon></v-btn>
          </template>
          <span>Change Avatar</span>
        </v-tooltip>
      </v-row>
      <v-col align="center">
        <h1>{{paramUser.name}}</h1>
        <h1> {{ paramUser.id }}</h1>
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
        {{ paramUserPost }}
        <div v-for="post in paramUserPost" :key="post.id">
          <post-component :post="post"></post-component>
        </div>
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
import PostComponent from '@/components/Post/PostComponent'

export default {
  data: () => ({
    isCurrent: false
  }),
  metaInfo: { 
    title: 'UserProfile'
  },
  computed: mapGetters(['paramUser', 'currentUser', 'loggedIn', 'paramUserPost']),
  components: {
    Fof,
    CreatePost,
    PostComponent
  },
  created(){
    this.setUser( this.$route.params.url )
    this.setPosts( this.paramUser.id )
    this.isCurrent = Cookies.get('user_url') === this.$route.params.url
  },
  methods: {
    ...mapActions(['getParamUser', 'getParamUserPost']),
    setUser(url){
      let meta = {
        params: {
          user_url: url
        }  
      }
      this.getParamUser( meta )
    },

    setPosts(user_id){
      let meta = {
        params: {
          user_id: user_id
        }
      }
      this.getParamUserPost( meta )
    }
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