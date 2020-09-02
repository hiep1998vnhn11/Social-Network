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
              <v-menu bottom offset-y >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn icon v-bind="attrs" v-on="on" >
                    <v-icon>mdi-dots-vertical</v-icon>
                  </v-btn>
                </template>
                <v-list>
                  <v-list-item @click="deletePost">
                    <v-list-item-icon> <v-icon>mdi-trash-can-outline</v-icon></v-list-item-icon>
                    <v-list-item-title>Delete this post</v-list-item-title>
                  </v-list-item>
                  <v-list-item @click="deletePost">
                    <v-list-item-icon> <v-icon>mdi-trash-can-outline</v-icon></v-list-item-icon>
                    <v-list-item-title>Delete this post</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
              <v-menu>
                <template v-slot:activator="{ on: menu, attrs }">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on: tooltip }">
                      <v-btn  v-bind="attrs" v-on="{ ...tooltip, ...menu }" icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                      </v-btn>
                    </template>
                    <span>Option</span>
                  </v-tooltip>
                </template>
                <v-list>
                  <v-list-item
                    v-for="(item, index) in items"
                    :key="index"
                    @click="deletePost"
                  >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
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
          <v-col cols=4>
            <v-btn class="text-body-1" text block>
              <v-icon >mdi-heart-outline</v-icon> 
              <span class="text-capitalize">{{$t('action.like')}} </span>
            </v-btn>
          </v-col>
          <v-col cols=4>
            <v-btn class="text-capitalize" text block @click="writeComment = true">
              <v-icon>mdi-comment-outline</v-icon>
              {{$t('action.comment')}}
            </v-btn> 
          </v-col>
          <v-col cols=4>
            <v-btn text block class="text-capitalize">
              <v-icon>mdi-share-variant-outline</v-icon>
              {{$t('action.share')}}
            </v-btn> 
          </v-col>
        </v-card-actions>
      </v-card>
    </div>
    <v-dialog v-model="writeComment" hide-overlay max-width="1000px">
      <v-card>
        <v-toolbar>
            <v-btn icon @click="writeComment = false">
            <v-icon color="dark">mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title center>Comment to this post ...</v-toolbar-title>
        </v-toolbar>
        <v-container> 
          {{ post.comments }} 
          <v-row justify="space-around" v-for="comment in post.comments" :key="comment.id">
              <v-col cols='1'>
                <v-avatar size="40">
                  <img :src="comment.user_avatar" :alt="comment.user_name">
                </v-avatar>
              </v-col>
              <v-col cols='11'>
                <v-card style="border-radius: 5px">
                  <a style="color:black"><strong>{{ comment.user_name }}</strong></a>
                  <br />
                   {{ comment.content }} 
                  <br />
                    <v-row justify="space-around" v-for="sub_comment in comment.sub_comments" :key="sub_comment.id">
                      <v-col cols='1'>
                        <v-avatar size="40">
                          <img :src="sub_comment.user_avatar" :alt="sub_comment.user_name">
                        </v-avatar>
                      </v-col>
                      <v-col cols='11'>
                        <v-card style="border-radius: 5px">
                          <a style="color:black"><strong>{{ sub_comment.user_name }}</strong></a>
                          <br />
                          {{ sub_comment.content }} 
                        </v-card>
                      </v-col>
                  </v-row>
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
  </div>
</template>

<script>
import Fof from '@/views/404/Index'
import { mapGetters } from 'vuex'

export default {
    components: {
        Fof,
    },
    props: ['post'],
    data: () => {
      return {
        writeComment: false,
        comment: '',
        option: false,
      }
    },
    computed: mapGetters(['currentUser', 'loggedIn']),
    methods: {
      upload(){
        this.comment=''
      },
      onComment(){
        
      }
    }

}
</script>