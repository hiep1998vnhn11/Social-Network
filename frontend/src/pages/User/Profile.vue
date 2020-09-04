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
          <div class="change-avatar">
            <v-tooltip bottom v-if="isCurrent">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on" @click="avatarDialog = true"><v-icon>mdi-cloud-upload-outline</v-icon></v-btn>
            </template>
            <span>Change Avatar</span>
          </v-tooltip>
          </div>
          <div class="change-background">
            <v-tooltip bottom v-if="isCurrent">
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on" @click="backgroundDialog = true"><v-icon>mdi-cloud-upload-outline</v-icon></v-btn>
            </template>
            <span>Change Background</span>
          </v-tooltip>
          </div>     
        </v-row>
        <v-col align="center">
          <h1>{{paramUser.name}}</h1>
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
        <create-post  v-if="isCurrent && loggedIn"></create-post>
        <br v-if="isCurrent && loggedIn" />
        <div v-for="post in paramUserPost" :key="post.id">
          <post-component :post="post"></post-component>
          <br />
        </div>
      </v-col>
    </v-row>

    <v-dialog v-model="avatarDialog" hide-overlay max-width="60%">
      <v-card>
        <v-toolbar>
            <v-btn icon @click="avatarDialog = false">
              <v-icon color="dark">mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title center>Change avatar now!</v-toolbar-title>
        </v-toolbar>
        <v-container>
          <v-text-field label="Avatar url here" :rules="rules" hide-details="auto" v-model="avatar"></v-text-field>
          <v-row>
            <v-col cols=6>
              <v-btn color="primary" block @click="onChangeAvatar">
                Change Avatar
              </v-btn>
            </v-col>
            <v-col cols=6>
              <v-btn block @click="onPreview">
                Preview
              </v-btn>
            </v-col>
          </v-row> 
        </v-container>
      </v-card>
    </v-dialog>

    <v-dialog v-model="backgroundDialog" hide-overlay max-width="1000px">
      <v-card>
        <v-toolbar>
            <v-btn icon @click="backgroundDialog = false">
              <v-icon color="dark">mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title center>Change background now!</v-toolbar-title>
        </v-toolbar>
        <v-container>
          <v-text-field label="Background url here" :rules="rules" hide-details="auto" v-model="background"></v-text-field>
          <br />
          <v-row>
            <v-col cols=6>
              <v-btn color="primary" block @click="onChangeBackground">
                Change Background
              </v-btn>
            </v-col>
            <v-col cols=6>
              <v-btn block @click="onPreview">
                Preview
              </v-btn>
            </v-col>
          </v-row> 
        </v-container>
      </v-card>
    </v-dialog>

    <v-dialog v-model="infoDialog" persistent hide-overlay max-width="1000px">
      <v-card>
        <v-card-title class="headline">Delete Post?</v-card-title>
        <v-card-text>
          Do you want to delete this post?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="infoDialog = false">
            Disagree
          </v-btn>
          <v-btn color="green darken-1" text @click="onChangeInfo">
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="previewDialog" hide-overlay max-width="80%">
      <v-card>
        <v-toolbar>
          <v-toolbar-title center>Preview your profile after change ...</v-toolbar-title>
        </v-toolbar>
        <v-container>
          <img :src="currentBackground" width="100%" />
          <v-row justify="space-around" class="bocAvatar">
            <v-avatar size="150" class="avatar">
              <img :src="currentAvatar" :alt="paramUser.name">
            </v-avatar>
          </v-row>
          <v-row>
            <v-col cols=6>
              <v-btn color="primary" block @click="previewDialog = false">
                Save Change
              </v-btn>
            </v-col>
            <v-col cols=6>
              <v-btn block color="error" @click="previewDialog = false">
                Cancel
              </v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-dialog>
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
    isCurrent: false,
    isGet: false,
    avatarDialog: false,
    infoDialog: false,
    backgroundDialog: false,
    previewDialog: false,
    rules: [
        value => !!value || 'Required.',
    ],
    currentAvatar: null,
    currentBackground: null,

    avatar: null,
    background: null
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
  created: function(){
    this.setUser( this.$route.params.url )
    this.setPosts( this.$route.params.url )
    this.isCurrent = Cookies.get('user_url') === this.$route.params.url
  },
  methods: {
    ...mapActions(['getParamUser', 'getParamUserPost']),
    async setUser(url){
      let meta = {
        params: {
          user_url: url
        }  
      }
      await this.getParamUser( meta )
    },

    setPosts(url){
      let meta = {
        params: {
          user_url: url
        }
      }
      this.getParamUserPost( meta )
    },

    onPreview(){
      if(this.avatar){
        this.currentAvatar = this.avatar
        this.currentBackground = this.currentUser.background
      }
      else if(this.background){
        this.currentBackground = this.background
        this.currentAvatar = this.currentUser.avatar
      } else {
        this.$swal({
          icon: 'info',
          text: 'Please input require field!'
        })
        return false
      }
      this.previewDialog = true
    },
    onChangeAvatar(){
      
      this.avatar = null
      this.avatarDialog = false
    },
    onChangeBackground(){

      this.background = null
      this.backgroundDialog = false
    },
    onChangeInfo(){

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
  z-index: 2;
}

.change-avatar {
  position: absolute;
  top: -50px;
  z-index: 3;
}

.change-background{
  position: absolute;
  top: -50px;
  right: 20%;
}
</style>