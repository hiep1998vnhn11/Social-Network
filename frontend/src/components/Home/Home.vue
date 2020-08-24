<template>
<v-container>
  <v-row>
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
  <v-col cols="4">
    <v-card class="pa-2" outlined tile>
      Trending, Friend, or SomeThing
    </v-card>
  </v-col>
</v-row>
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
              <v-btn icon v-bind="attrs" v-on="on" @click="addImage = true"><v-icon>mdi-file-image-outline</v-icon></v-btn>
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
  <v-dialog v-model="addImage" hide-overlay max-width="600px">
    <h1>he</h1>
  </v-dialog>

</v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  metaInfo: { title: 'Home' },
  computed: mapGetters(['allPosts', 'currentUser']),
  created(){
    if(this.allPosts.length === 0) this.getPost()
  },
  methods: {
    ...mapActions(['getPost']),
    onPost(){
      this.visible = null
      this.content = null
      this.writePost = false
    }
  },
  data: () => ({
      writePost: false,
      chooseVisible: false,
      visible: null,
      content: null,
  })
}
</script>