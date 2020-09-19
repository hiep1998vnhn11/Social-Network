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
                    
                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item v-for="room in rooms" :key="room.id" link :to="{ name: 'MessageUser', params: { room_id: room.id }}">
                    <v-list-item-icon>
                        <v-avatar height=30px width=30px><img :src="room.avatar" :alt="room.name" /></v-avatar>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ room.name }}</v-list-item-title>
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
import { mapGetters, mapActions } from 'vuex'

export default {
    data () {
      return {
        items: [
          { title: 'Home', icon: 'mdi-dashboard' },
          { title: 'About', icon: 'mdi-question_answer' },
        ],
      }
    },
    computed: mapGetters(['rooms']),
    created: async function(){
        if(!this.rooms.length)
        try{
            await this.getRoom()
        } catch(err){
            console.log(err)
        }
    },
    methods: {
        ...mapActions(['getRoom']),
        search(){
            
        }
    }
}
</script>