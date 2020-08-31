<template>
  <v-container>
    <v-row>
      <v-col cols="8">
        <create-post></create-post>
      </v-col>
      <v-col cols="4">
        <v-card class="pa-2" outlined tile>
          Trending, Friend, or SomeThing
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <post-component post_id='1'></post-component>
      <post-component post_id='2'></post-component>

    </v-row>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CreatePost from '../Post/CreatePost'
import PostComponent from '../Post/PostComponent'

export default {
  metaInfo: { title: 'Home' },
  components: {
    CreatePost,
    PostComponent
  },
  computed: mapGetters(['allPosts', 'currentUser']),
  created(){
    if(this.allPosts.length === 0) this.getPost()
  },
  methods: {
    ...mapActions(['getPost']),
  },
  data: () => ({
  })
}
</script>