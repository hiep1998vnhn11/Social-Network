<template>
<div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list dense>
        <template v-for="item in items">  
          <v-list-item
            v-if="isLogin || item.auth"
            :key="item.text"
            :to="item.link"
            link
          >
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
    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span to="/home" class="hidden-sm-and-down">Social Network</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-tooltip bottom v-if="isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            to="/logout"
          ><v-icon>mdi-logout</v-icon></v-btn>
        </template>
        <span>Logout</span>
      </v-tooltip>
      <v-tooltip bottom v-if="!isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            to="/login"
          ><v-icon>mdi-login</v-icon></v-btn>
        </template>
        <span>Login</span>
      </v-tooltip>
      <v-tooltip bottom v-if="!isLogin">
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            to="/register"
          ><v-icon>mdi-account-multiple-plus</v-icon></v-btn>
        </template>
        <span>Register</span>
      </v-tooltip>
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            to="/"
          ><v-icon>mdi-apps</v-icon></v-btn>
        </template>
        <span>Go to App</span>
      </v-tooltip>
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            to="/notifications"
          ><v-icon>mdi-bell</v-icon></v-btn>
        </template>
        <span>Notification</span>
      </v-tooltip>
      <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
            large
            to="/home"
          ><v-icon>mdi-hexagon-slice-2</v-icon></v-btn>
        </template>
        <span>Go to Home</span>
      </v-tooltip>
    </v-app-bar>
</div>
</template>

<script>
export default {
    data(){
        return {
            items: [
                { icon: 'mdi-home', text: 'Home', link: '/home', auth: 'true' },
                { icon: 'mdi-history', text: 'History', link: '/history', auth: 'true' },
                { icon: 'mdi-cog', text: 'Settings', link: '/setting', auth: 'false' },
                { icon: 'mdi-message', text: 'Message', link: '/message', auth: 'true' },
                { icon: 'mdi-help-circle', text: 'Help', link: '/help', auth: 'false' },
                { icon: 'mdi-account-outline', text: 'My Profile', link: '/profile', auth: 'true' },
                { icon: 'mdi-account-question', text: 'About This Application', link: '/about', auth: 'false' },
            ],
            dialog: false,
            drawer: null,
        }
    },
    computed: {
      isLogin(){
        return(this.$store.getters.currentUser) 
      }
    }
}
</script>