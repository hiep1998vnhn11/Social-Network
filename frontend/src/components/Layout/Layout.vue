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
      <v-btn icon to="/setting">
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon to="/notification">
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn
        to="/"
        icon
        large
      >
       <v-icon>mdi-hexagon-slice-2</v-icon>
      </v-btn>
    </v-app-bar>
</div>
</template>

<script>
export default {
    data(){
        return {
            items: [
                { icon: 'mdi-home', text: 'Home', link: '/home', auth: 'true' },
                { icon: 'mdi-history', text: 'History', link: '/hostory', auth: 'true' },
                { icon: 'mdi-cog', text: 'Settings', link: '/setting', auth: 'false' },
                { icon: 'mdi-message', text: 'Message', link: '/message', auth: 'true' },
                { icon: 'mdi-help-circle', text: 'Help', link: '/help', auth: 'false' },
                { icon: 'mdi-account-outline', text: 'My Profile', link: '/user', auth: 'true' },
                { icon: 'mdi-account-question', text: 'About This Application', link: '/about', auth: 'false' },
                { icon: 'mdi-logout', text: 'Logout', link: '/loggout', auth: 'true' },
                { icon: 'mdi-login', text: 'Login', link: '/login', auth: 'false'},
                { icon: 'mdi-account-multiple-plus', text: 'Register', link: '/register', auth: 'false'},
            ],
            dialog: false,
            drawer: null,
        }
    },
    methods: {

    }
}
</script>