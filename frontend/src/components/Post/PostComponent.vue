<template>
  <v-container class="grey lighten-5">
              {{paramPost.data[0].likes}}<br />
              {{paramPost.data[0].comments}} <br />
                            {{paramPost.data[0].comments.sub_comments}}
  <fof v-if="!paramPost.data.length"></fof>
  <div v-else>
  <v-card class="mx-auto">
    <v-list-item>
      <v-list-item-avatar color="grey">
        <img :src="paramPost.data[0].user_avatar" :alt="paramPost.data[0].user_name">
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title>
          <router-link color="black" :to="{ name: 'User_profile', params: { url: paramPost.data[0].user_url }}">
            {{ paramPost.data[0].user_name }}
          </router-link>
        </v-list-item-title>
        <v-list-item-subtitle>
            {{ paramPost.data[0].created_at }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
    <v-container>
        {{ paramPost.data[0].content }}
        <v-img :src="paramPost.data[0].imageUrl"></v-img>
 
    </v-container>
      <v-row>
        <v-tooltip top>
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" icon>
          <v-icon color="primary">mdi-heart</v-icon>
          
        </v-btn>
      </template>
      <span>{{ paramPost.data[0].likes }}</span>
    </v-tooltip>
      {{paramPost.data[0].like_count}}
      {{$t('count.likes')}}
      <v-spacer></v-spacer>
      <v-icon color="primary">mdi-comment</v-icon>
      {{paramPost.data[0].comment_count}}
      {{$t('count.comments')}}
      </v-row>
    <v-divider class="mx-4"></v-divider>
    <v-card-actions>
      <v-col cols=4>
        <v-btn text block>
          <v-icon >mdi-heart-outline</v-icon> 
          {{$t('action.like')}} 
        </v-btn>
      </v-col>
      <v-col cols=4>
        <v-btn text block>
          <v-icon>mdi-comment-outline</v-icon>
          {{$t('action.comment')}}
        </v-btn> 
      </v-col>
      <v-col cols=4>
        <v-btn text block>
          <v-icon>mdi-share-variant-outline</v-icon>
          {{$t('action.share')}}
        </v-btn> 
      </v-col>
    </v-card-actions>
  </v-card>
  </div>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Fof from '@/views/404/Index'

export default {
    created(){
        if(this.paramPost == null) this.setPost(this.post_id)
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
    },
    props: ['post_id']
}
</script>