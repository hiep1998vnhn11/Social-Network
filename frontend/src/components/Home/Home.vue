<template>
  <v-container>
    <router-link to="/about" v-slot="{ href, navigate }">
      <NavLink :href="href" @click="navigate">about</NavLink>
    </router-link>
    <router-link to="/foo" v-slot="{ href, route, navigate, isActive, isExactActive }">
      <li :class="[isActive && 'router-link-active', isExactActive && 'router-link-exact-active']">
        <a :href="href" @click="navigate">{{ route.fullPath }}</a>
      </li>
    </router-link>
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
    <v-row cols="8" v-for="post in allPosts.data.data" :key="post.id">
      <v-col cols=8>
        <post-component :post="post"></post-component>
      </v-col>
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