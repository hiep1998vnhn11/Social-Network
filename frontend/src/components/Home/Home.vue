<template>
    <div>
      {{ allPosts.data.data }}
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  metaInfo: { title: 'Home' },
  computed: mapGetters(['allPosts']),
  created(){
    if(this.allPosts.length === 0) this.getPost()
  },
  methods: {
    ...mapActions(['getPost'])
  }
}
</script>