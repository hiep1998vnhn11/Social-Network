<script>
export default {
  data(){
    return {

    }
  },
  methods: {
    AuthProvider(provider){
      var self = this
      this.$auth.authenticate(provider)
        .then(response => {
          self.SocialLogin(provider, response)
        })
        .catch(err => {
          console.log({err: err})
        })
    },
    SocialLogin(provider, response){
      this.$http.post('/login/' + provider, response)
        .then(response => {
          console.log(response.data)
        })
        .catch(err => {
          console.log( {err: err})
        })
    }
  }
}
</script>