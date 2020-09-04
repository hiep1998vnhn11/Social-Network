<template>
  <div class="grey lighten-5">
    <fof v-if="!post"></fof>
    <div v-else>
      <v-card class="mx-auto">
        <v-list-item>
          <router-link :to="{ name: 'User_profile', params: { url: post.user_url }}" v-slot="{ href, navigate }">
            <v-list-item-avatar color="grey">
              <img :src="post.user_avatar" :alt="post.user_name" @click="navigate" :href="href">
            </v-list-item-avatar>
          </router-link>
          <v-list-item-content>
            <v-list-item>
              <router-link :to="{ name: 'User_profile', params: { url: post.user_url }}" v-slot="{ href, navigate }">
                <div class="font-weight-black" :href="href" @click="navigate">{{ post.user_name }}</div>
              </router-link>
              <v-spacer></v-spacer>
              <v-tooltip top class="text-body1">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="text-body1" v-bind="attrs" v-on="on" icon @click="deleteDialog = true">
                    <v-icon color="primary">mdi-trash-can-outline</v-icon>
                  </v-btn>
                </template>
                <span class="text-body1">Delete this post</span>
              </v-tooltip>
            </v-list-item>
            <v-list-item-subtitle>
              {{ post.created_at }}
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-container>
          {{ post.content }}
          <v-img :src="post.imageUrl"></v-img>
        </v-container>
        <v-row>
          <v-tooltip top class="text-body1">
            <template v-slot:activator="{ on, attrs }">
              <v-btn class="text-body1" v-bind="attrs" v-on="on" icon>
                <v-icon color="primary">mdi-heart</v-icon>
              </v-btn>
            </template>
            <span class="text-body1">{{ post.likes }}</span>
          </v-tooltip>
          {{ post.like_count }}
          {{$t('count.likes')}}
          <v-spacer></v-spacer>
          <v-icon color="primary">mdi-comment</v-icon>
          {{post.comment_count}}
          {{$t('count.comments')}}
        </v-row>
        <v-divider class="mx-4"></v-divider>
        <v-card-actions>
          <v-col cols=6>
            <v-btn class="text-body-1" text block @click="onLike">
              <v-icon v-if="!post.is_like">mdi-heart-outline</v-icon> 
              <v-icon v-else color="primary">mdi-heart</v-icon>
              <span class="text-capitalize">{{$t('action.like')}} </span>
            </v-btn>
          </v-col>
          <v-col cols=6>
            <v-btn class="text-capitalize" text block @click="openCommentDialog">
              <v-icon>mdi-comment-outline</v-icon>
              {{$t('action.comment')}}
            </v-btn> 
          </v-col>
        </v-card-actions>
      </v-card>
    </div>
    <v-dialog v-model="writeComment" persistent hide-overlay max-width="1000px">
      <v-card>
        <v-toolbar>
            <v-btn icon @click="closeCommentDialog">
              <v-icon color="dark">mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title center>Comment to this post ...</v-toolbar-title>
        </v-toolbar>
        <v-container> 
          <v-row justify="space-around" v-for="comment in post.comments" :key="comment.id">
              <v-col cols='1'>
                <router-link :to="{ name: 'User_profile', params: { url: comment.user_url }}" v-slot="{ href, navigate }">
                  <v-avatar size=40>
                    <img :src="comment.user_avatar" :alt="comment.user_name" @click="navigate" :href="href">
                  </v-avatar>
                </router-link>
              </v-col>
              <v-col cols='11'>
                <v-card style="border-radius: 5px">
                  <router-link :to="{ name: 'User_profile', params: { url: comment.user_url }}" v-slot="{ href, navigate }">
                    <div class="font-weight-black" :href="href" @click="navigate">{{ comment.user_name }}</div>
                  </router-link>
                   {{ comment.content }} 
                  <br />
                  <div v-if="comment.sub_comment_count">
                    <v-row justify="space-around" v-for="sub_comment in comment.sub_comments" :key="sub_comment.id">
                      <v-col cols='1'>
                         <router-link :to="{ name: 'User_profile', params: { url: sub_comment.user_url }}" v-slot="{ href, navigate }">
                          <v-avatar size=40>
                            <img :src="comment.user_avatar" :alt="sub_comment.user_name" @click="navigate" :href="href">
                          </v-avatar>
                        </router-link>
                      </v-col>
                      <v-col cols='11'>
                        <v-card style="border-radius: 5px">
                          <router-link :to="{ name: 'User_profile', params: { url: sub_comment.user_url }}" v-slot="{ href, navigate }">
                            <div class="font-weight-black" :href="href" @click="navigate">{{ sub_comment.user_name }}</div>
                          </router-link>
                          {{ sub_comment.content }} 
                        </v-card>
                      </v-col>
                    </v-row>
                  </div>
                </v-card>
              </v-col>
          </v-row>
          <v-divider></v-divider>
          <v-row v-if="loggedIn" justify="space-around">
              <v-col cols='1'>
                <v-avatar size="40">
                  <img :src="currentUser.avatar" :alt="currentUser.name">
                </v-avatar>
              </v-col>
              <v-col cols='11'>
                <v-text-field clearable 
                  :label="$t('create_post.content')" 
                  v-model="comment"
                  append-icon="mdi-file-image-outline"
                  @click:append="upload">
                </v-text-field>  
              </v-col>
          </v-row>
          <v-row v-if="!loggedIn" justify="space-around">
            You are not login! Please login for Comment!
          </v-row>
        <v-btn v-if="loggedIn" color="primary" block @click="onComment">
          Comment
        </v-btn>
        </v-container>  
        </v-card>
    </v-dialog>

    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">Delete Post?</v-card-title>
        <v-card-text>
          Do you want to delete this post?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="deleteDialog = false">
            Disagree
          </v-btn>
          <v-btn color="green darken-1" text @click="deletePost">
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import Fof from '@/views/404/Index'
import { mapGetters } from 'vuex'
import axios from 'axios'
import io from 'socket.io-client'
const ENDPOINT = 'localhost:6001'

export default {
  components: {
    Fof,
  },
  props: ['post'],
  data: () => {
    return {
      writeComment: false,
      comment: '',
      deleteDialog: false,
      socket: null,
      isLike: false
    }
  },
  computed: mapGetters(['currentUser', 'loggedIn']),
  methods: {
    upload(){
      this.comment=''
    },
    openCommentDialog(){
      this.writeComment = true
      if(this.loggedIn){
        this.socket = io(ENDPOINT)
        this.socket.on('receivedComment', (data) => {
          const commentReceived = data.response.data.data
          Object.assign(commentReceived, {
            user_url: data.user.url,
            user_avatar: data.user.avatar,
            user_name: data.user.name,
            sub_comment_count: 0
          })
          this.post.comments.unshift(commentReceived)
        })
      }
    },
    closeCommentDialog(){
      this.writeComment = false
      if(this.loggedIn){
        this.socket.close()
      }
    },
    async onComment(){
      if(!this.comment){
        this.$swal({
          icon: 'info',
          text: 'Content is required!'
        })
      } else {
        let url = `/auth/user/post/${this.post.id}/create_comment`
        let response = await axios.post(url, {
          content: this.comment
        })
        const currentComment = response.data.data
        Object.assign(currentComment, {
            user_url: this.currentUser.url,
            user_avatar: this.currentUser.avatar,
            user_name: this.currentUser.name,
            sub_comment_count: 0
        })
        this.post.comments.unshift(currentComment)
        await this.socket.emit('comment', {
          user: this.currentUser,
          response: response,
          comment: this.comment
        })
        this.comment = ''
        response = null
      }
    },
    async deletePost(){
      let url = `/auth/user/post/${this.post.id}/delete`
      try{
        const response = await axios.post(url)
        this.$swal({
          icon: 'success',
          text: response.data.message
        })
      } catch {
        this.$swal({
          icon: 'error',
          text: 'Permission denied'
        })
      } 
      this.deleteDialog = false
    },
    async onLike(){
      this.post.is_like = !this.post.is_like
      if(!this.post.is_like){ // handle unlike
        this.post.like_count -= 1
      } else this.post.like_count += 1
      let url = `/auth/user/post/${this.post.id}/handle_like`
      await axios.post(url) 
    }
  }
}
</script>