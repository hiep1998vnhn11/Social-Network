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
        <v-card class="pa-2" outlined tile>
          <v-row justify="space-around">
            <v-col cols="1">
              <v-avatar size="40">
                <img :src="currentUser.avatar" :alt="currentUser.name">
              </v-avatar>
            </v-col>
            <v-col cols="11">
              <v-btn width="650px" text @click="writePost = true">
                {{ $t('create_post.writeSt') }}
              </v-btn>
            </v-col>
          </v-row>
          <v-divider class="mx-4"></v-divider>
          <v-row>
            <v-col cols="4">Upload Image</v-col>
            <v-col cols="4">Hello</v-col>
            <v-col cols="4">Hi</v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </div>
  <v-dialog v-model="writePost" hide-overlay max-width="600px">
    <v-card>
      <v-toolbar>
        <v-btn icon @click="writePost = false">
          <v-icon color="dark">mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title center>Write something ...</v-toolbar-title>
      </v-toolbar>
      <v-container>  
      <v-row justify="space-around">
        <v-col cols='1'>
          <v-avatar size="40">
            <img :src="currentUser.avatar" :alt="currentUser.name">
          </v-avatar>
        </v-col>
        <v-col cols='8'>
          <b><i>{{currentUser.name}}</i></b>
        </v-col>
        <v-col cols="3">
          <v-select v-model="visible" :items="[
            {
              text: $t('create_post.private'),
              value: 'private'
            },
            {
              text: $t('create_post.friend'),
              value: 'friend'
            },
            {
              text: $t('create_post.public'),
              value: 'public'
            }
          ]" :label="$t('create_post.privacy')">
        </v-select>
        </v-col>
      </v-row>
      <v-row>
        <v-container>
          <v-textarea clearable :label="$t('create_post.content')" v-model="content"></v-textarea>
        </v-container>
      </v-row>
      <v-container>
        <v-toolbar dense>
          <v-toolbar-title>{{$t('create_post.add')}}</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on"><v-icon>mdi-file-image-outline</v-icon></v-btn>
            </template>
            <span>{{$t('create_post.image')}}</span>
          </v-tooltip>
        </v-toolbar>  
      </v-container>
      <v-divider></v-divider>
      <v-btn color="primary" width="577px" @click="onPost">
        Post this article
      </v-btn>
      </v-container>  
    </v-card>
  </v-dialog>
</v-container>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Fof from '@/views/404/Index'

export default {
  data: () => ({
    isCurrent: false,
    writePost: false,
    chooseVisible: false,
    visible: null,
    content: null,
  }),
  metaInfo: { 
    title: 'UserProfile'
  },
  computed: mapGetters(['paramUser', 'currentUser']),
  components: {
    Fof,
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
    onPost(){
      this.visible = null
      this.content = null
      this.writePost = false
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