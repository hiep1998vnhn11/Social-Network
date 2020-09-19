<template>
    <div></div>
</template>

<script>
export default {
    created(){
        this.$store.dispatch('destroyToken')
            .then(() => {
                this.$router.push({name: 'Login'})
            })
            .catch(() => {
                this.$swal({
                    icon: 'error',
                    'title': 'Ops...',
                    'text': 'Some thing went wrong with server... Please refresh!!!'
                })
            })

    }
}
</script>