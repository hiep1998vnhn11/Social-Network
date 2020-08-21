<template>
<v-container class="grey lighten-5">
  <fof v-if="!(paramUser.length)"></fof>
  <div v-else>
    <v-row no-gutters>
      <v-card class="pa-2" outlined tile>
      <v-col md="8" offset-md="2">
        <v-img height="300px" :src="paramUser[0].background"/>
      </v-col>
      <v-row justify="space-around">
      <v-avatar size="150">
        <img :src="paramUser[0].avatar" :alt="paramUser[0].name">
      </v-avatar>
      </v-row>
      <v-col align="center">
        <h1>{{paramUser[0].name}}</h1>
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
        <v-card class="pa-2" outlined tile>
          <v-row justify="space-around">
            <v-col>
              <v-avatar size="40">
                <img :src="paramUser[0].avatar" :alt="paramUser[0].name">
              </v-avatar>
            </v-col>
            <v-col>
              <v-input />
            </v-col>
          </v-row>
          <v-divider class="mx-4"></v-divider>
          <v-btn
            :loading="loading5"
            :disabled="loading5"
            color="blue-grey"
            class="ma-2 white--text"
            fab
            @click="loader = 'loading5'"
          >
            <v-icon dark>mdi-cloud-upload</v-icon>
          </v-btn>
        </v-card>
      </v-col>
    </v-row>
  </div>
  
</v-container>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Fof from '@/views/404/Index'

export default {
  data: () => ({
  }),
  metaInfo: { title: 'User Profile' },
  computed: mapGetters(['paramUser']),
  components: {
    Fof,
  },
  created(){
    if(this.paramUser === null) this.setUser(this.$route.params.url)
  },
  methods: {
    ...mapActions(['getParamUser']),
    setUser(url){
      let meta = {
        params: {
          user_url: url
        }  
      }
      this.getParamUser( meta )
    },
  }
}
</script>
