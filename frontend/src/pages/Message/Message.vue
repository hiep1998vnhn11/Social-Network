<template>
    <v-row>
        <v-col cols=3>
            <v-navigation-drawer absolute permanent left width=25%>
                <div class="text-right">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on" to="/message/setting"><v-icon>mdi-message-settings-outline</v-icon></v-btn>
                        </template>
                        <span>Setting</span>
                    </v-tooltip>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on" to="/message/new"><v-icon>mdi-message-plus-outline</v-icon></v-btn>
                        </template>
                        <span>New Chat</span>
                    </v-tooltip>
                </div>

                <v-autocomplete
                    v-model="select"
                    :loading="loading"
                    :items="items.title"
                    :search-input.sync="search"
                    cache-items
                    flat
                    hide-no-data
                    hide-details
                    label="Search for Message"
                    solo-inverted
                    ></v-autocomplete>
                    
                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    >
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>
        </v-col>
        <v-col cols=9>
              <router-view></router-view>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data () {
      return {
        items: [
          { title: 'Home', icon: 'mdi-dashboard' },
          { title: 'About', icon: 'mdi-question_answer' },
        ],
      }
    },
}
</script>