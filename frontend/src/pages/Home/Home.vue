<template>
  <v-container>
    <v-row>
      <v-col cols="8">
        <create-post></create-post>
         <v-row cols="8" v-for="post in allPosts.data.data" :key="post.id">
      <v-col>
        <post-component :post="post"></post-component>
      </v-col>
    </v-row>
      </v-col>
      <v-col cols="4">
        hello
      </v-col>
    </v-row>
   
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CreatePost from '@/components/Post/CreatePost'
import PostComponent from '@/components/Post/PostComponent'

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