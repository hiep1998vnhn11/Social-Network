<template>
    <div>hello</div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    methods: {
        ...mapActions([
            'fetchUser',
        ]),
        created(){
            this.fetchUser()
        }
    }
}
</script>