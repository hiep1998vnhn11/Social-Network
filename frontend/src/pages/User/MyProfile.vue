<script>
import { mapGetters } from 'vuex'
export default {
    computed: mapGetters(['currentUser']),
    created(){
        if(!this.currentUser) 
            this.$swal({
                icon: 'error',
                title: 'Ops...',
                text: 'Sorry, something went wrong... Please Login again!'
            }) .then(() => {
                this.$router.push({name: 'Login'})
            })
        else this.$router.push({ name: 'User_profile', params: { url: this.currentUser.url }})
    }
}
</script>