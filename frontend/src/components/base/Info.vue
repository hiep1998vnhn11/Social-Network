<template>
  <v-theme-provider :dark="dark">
    <div>
      <base-img
        :src="require('@/assets/zero-logo-dark.svg')"
        contain
        max-width="128"
        min-height="78"
        width="100%"
      />

      <base-title
        size="body-1"
        space="4"
        title="MULTI-PURPOSE THEME"
        weight="regular"
      />

      <base-body>
        About more info of this Application, following: 
      </base-body>

      <base-btn
        href="https://github.com/hiep1998vnhn11/Social-Network"
        class="mb-12"
        color="white"
        target="_blank"
        outlined
      >
        GitHub
      </base-btn>
    </div>
  </v-theme-provider>
</template>

<script>
  export default {
    name: 'BaseInfo',

    props: {
      title: String,
      dark: Boolean,
    },

    data: () => ({
      business: [
        {
          icon: 'mdi-map-marker-outline',
          title: 'Address',
          text: 'Ha Noi <br> Viet Nam',
        },
        {
          icon: 'mdi-cellphone',
          title: 'Phone',
          text: '0343742152',
        },
        {
          icon: 'mdi-email',
          title: 'Email',
          text: 'hiep1998vnhn11@gmail.com<br>hiep.tran@sotatek.com',
        },
      ],
    }),
  }
</script>
