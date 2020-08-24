<template>
    <v-container>
        {{ message }}
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    computed: mapGetters(['message']),
    methods: {
        ...mapActions(['getMessage'])
    },
    created(){
        if(this.message.length == 0) this.getMessage()
    }
}
</script>