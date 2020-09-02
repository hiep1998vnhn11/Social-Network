<template>
<div>
    <v-navigation-drawer v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app>
      <v-list dense>
        <template v-for="item in items">  
          <v-list-item v-if="isLogin || item.auth" :key="item.text" :to="item.link" link>
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>   
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="blue darken-3" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span to="/home" class="hidden-sm-and-down">Social Network</span>
      </v-toolbar-title>
      <v-text-field flat solo-inverted hide-details prepend-inner-icon="mdi-magnify" label="Search" class="hidden-sm-and-down" />
      <v-spacer />
      <v-tooltip bottom v-if="isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" to="/logout"><v-icon>mdi-logout</v-icon></v-btn>
        </template>
        <span>{{$t('common.logout')}}</span>
      </v-tooltip>
      <v-tooltip bottom v-if="!isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" to="/login"><v-icon>mdi-login</v-icon></v-btn>
        </template>
        <span>{{$t('common.login')}}</span>
      </v-tooltip>
      <v-tooltip bottom v-if="!isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" to="/register"><v-icon>mdi-account-multiple-plus</v-icon></v-btn>
        </template>
        <span>{{$t('common.register')}}</span>
      </v-tooltip>
      <v-tooltip bottom v-if="!isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" to="/app"><v-icon>mdi-apps</v-icon></v-btn>
        </template>
        <span>{{$t('common.go_app')}}</span>
      </v-tooltip>
      <v-tooltip bottom v-if="isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" to="/notifications"><v-icon>mdi-bell</v-icon></v-btn>
        </template>
        <span>{{$t('common.notification')}}</span>
      </v-tooltip>
      <v-tooltip bottom v-if="isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" large to="/"><v-icon>mdi-hexagon-slice-2</v-icon></v-btn>
        </template>
        <span>{{$t('common.go_home')}}</span>
      </v-tooltip>
      <v-col cols="2">
      <v-select v-model="$i18n.locale" :items="langs" menu-props="auto" :label="$t('common.select_lang')"
        hide-details prepend-icon="mdi-earth">
      </v-select>
      </v-col>
    </v-app-bar>
</div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data(){
    return {
      langs: [
        {
          text: 'Tiếng Việt',
          value: 'vi'
        },
        {
          text: 'English',
          value: 'en'
        },
        {
          text: '日本語',
          value: 'ja'
        }
      ],
      items: [
          { icon: 'mdi-home', text: 'Home', link: '/', auth: true },
          { icon: 'mdi-history', text: 'History', link: '/history', auth: true },
          { icon: 'mdi-cog', text: 'Settings', link: '/setting', auth: true },
          { icon: 'mdi-message', text: 'Message', link: '/message', auth: false },
          { icon: 'mdi-help-circle', text: 'Help', link: '/help', auth: true },
          { icon: 'mdi-account-outline', text: 'My Profile', link: '/myprofile', profile: false },
          { icon: 'mdi-account-question', text: 'About This Application', link: '/about', auth: true },
      ],
      dialog: false,
      drawer: null,
    }
  },
  computed: {
    currentUser(){
      return this.$store.getters.currentUser
    },
    isLogin(){
      return(this.$store.getters.loggedIn)
    },
  },
  methods: {
    ...mapActions(['getCurrentUser'])
  },
  created(){
    if(!this.currentUser && this.isLogin) {
      this.getCurrentUser()
    }
  }
}
</script>