<template>
    <div> 
        <v-card color="grey lighten-4" flat height=630px tile>
            <v-toolbar dense>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Title</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
            </v-toolbar>
        </v-card>    
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    computed: mapGetters(['messages']),
    created: async function(){
        const payload = {
            room_id: this.$route.params.room_id,
            params: {

            }
        }
        await this.getMessage(payload)
    },
    methods: {
        ...mapActions(['getMessage'])
    }
}
</script>