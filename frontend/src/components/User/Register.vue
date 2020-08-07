<template>
<div>
    <v-container class="grey lighten-5">
    <v-row
      class="mb-6"
      justify="center"
      no-gutters
    >
      <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >
    <v-text-field
      v-model="name"
      :counter="10"
      :rules="nameRules"
      label="Name"
      required
    ></v-text-field>

    <v-text-field
      v-model="email"
      :rules="emailRules"
      label="E-mail"
      required
    ></v-text-field>

    <v-text-field
      v-model="password"
      :rules="emailRules"
      label="Password"
      required
    ></v-text-field>

    <v-text-field
      v-model="password_comfirm"
      :rules="emailRules"
      label="Confirm Password"
      required
    ></v-text-field>

    <v-checkbox
      v-model="checkbox"
      :rules="[v => !!v || 'You must agree to continue!']"
      label="Remember me"
      required
    ></v-checkbox>

    <v-btn
      color="error"
      class="mr-4"
      @click="register"
    >
      Register
    </v-btn>

    <v-btn
      :disabled="!valid"
      color="success"
      class="mr-4"
      @click="validate"
    >
      Validate
    </v-btn>

    <v-btn
      color="warning"
      @click="resetValidation"
    >
      Reset Validation
    </v-btn>
    
  </v-form>
    </v-row>
    <v-row class="mb-6"
      justify="center"
      no-gutters>
    Have a acount? go to <router-link to="/login"> Login </router-link>
    </v-row>
    </v-container>
  
</div>
</template>

<script>
  export default {
    data: () => ({
      valid: true,
      name: '',
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      email: '',
      emailRules: [
        v => !!v || 'E-mail is required!',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules: [
          v=>!!v || 'Password os required!'
      ],
      select: null,
      items: [
        'Item 1',
        'Item 2',
        'Item 3',
        'Item 4',
      ],
      checkbox: false,
    }),

    methods: {
      validate () {
        this.$refs.form.validate()
      },
      reset () {
        this.$refs.form.reset()
      },
      resetValidation () {
        this.$refs.form.resetValidation()
      },
    },
  }
</script>