<template>
<div style="padding:30px">
  {{currentUser.name}}
  {{currentUser.avatarUrl}}
  {{currentUser.email}}
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
  metaInfo: { title: 'User Profile' },
  computed: mapGetters(['currentUser']),
  created(){
    if(this.currentUser === null) this.getCurrentUser()
  },
  methods: {
    ...mapActions(['getCurrentUser'])
  }
}
</script>
