<template>
<div>
  <v-container class="grey lighten-5">
    <v-row class="mb-6" justify="center" no-gutters>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
          v-model="name"
          :counter="20"
          :rules="nameRules"
          label="Name"
          required></v-text-field>

        <v-text-field
          v-model="email"
          :rules="emailRules"
          label="E-mail"
          required ></v-text-field>

        <v-text-field
          v-model="password"
          type="password"
          :rules="passwordRules"
          label="Password"
          required ></v-text-field>

        <v-text-field
          v-model="password_confirm"
          :rules="confirmPasswordRules"
          label="Confirm Password"
          type="password"
          required ></v-text-field>

        <v-btn color="error" class="mr-4" @click="register">
          Register
        </v-btn>

        <v-btn :disabled="!valid" color="success" class="mr-4" @click="validate">
          Validate
        </v-btn>

        <v-btn color="warning" @click="resetValidation">
          Reset Validation
        </v-btn>  
      </v-form>
    </v-row>
    <v-row class="mb-6" justify="center" no-gutters>
      Have a acount? go to <router-link to="/login"> Login </router-link>
    </v-row>
  </v-container>
</div>
</template>

<script>
export default {
  metaInfo: { title: 'Register' },
  data: () => ({
    valid: true,
    name: '',
    password: '',
    password_confirm: '',
    nameRules: [
      v => !!v || 'Name is required',
      v => (v && v.length <= 20) || 'Name must be less than 10 characters',
    ],
    email: '',
    emailRules: [
      v => !!v || 'E-mail is required!',
      v => /.+@.+/.test(v) || 'E-mail must be valid',
    ],
    passwordRules: [
      v => !!v || 'Password is required!'
    ],
    confirmPasswordRules: [
      v => !!v || 'Confirm password is required!',
    ],
    select: null,
    items: [
      'Item 1',
      'Item 2',
      'Item 3',
      'Item 4',
    ],
  }),

  methods: {
    validate () {
      this.$refs.form.validate()
    },
    register () {
      if( !this.email || !this.password || !this.name || !this.password_confirm){
        this.$swal({
          icon: 'info',
          title: 'Oops...',
          text: 'Please enter all required field!',
        }).then(
          this.validate()
        )
      } else if(this.password !== this.password_confirm){
        this.$swal({
          icon: 'error',
          title: 'Confirmation Password...',
          text: 'Password comfirm is different from password! Please enter the same password and password comfirm!',
        })
      } else {
      this.$store.dispatch('register', {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirm
      })
        .then (() => {
          this.$swal({
            icon: 'success',
            title: 'Register successfully!',
            text: 'Register Successfully with email: ' + this.email + '. To ensure a secure connection, please login!',
          })
          this.$router.push({name: 'Login'})
        })
        .catch( () => {
            this.$swal({
            icon: 'error',
            title: 'Register fail!',
            text: 'Register fail! Please check again!',
          })        
        })
      }
    },
    resetValidation () {
      this.$refs.form.resetValidation()
    },
  },
}
</script>