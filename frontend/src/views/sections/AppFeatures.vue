<template>
  <base-section id="app-features">
    <base-section-heading title="App Features">
    I have not thought of my application name yet. But i think Social Network is nice, so this was Social Network (haha). I hope this will help me much in my graduation thesis next year (think so)!
    </base-section-heading>

    <v-container>
      <v-row>
        <v-col
          v-for="(feature, i) in features"
          :key="i"
          cols="12"
          md="6"
        >
          <base-avatar-card
            v-bind="feature"
            align="left"
            horizontal
          >
            About my Project Features
          </base-avatar-card>
        </v-col>
      </v-row>
    </v-container>
  </base-section>
</template>

<script>
  export default {
    name: 'SectionThemeFeatures',

    data: () => ({
      features: [
        {
          title: 'Perfect to share',
          icon: 'mdi-fountain-pen-tip',
        },
        {
          title: 'Including smartphone',
          icon: 'mdi-cellphone',
        },
        {
          color: 'primary',
          dark: true,
          title: 'Easily Upload and Write',
          icon: 'mdi-pencil-box-outline',
        },
        {
          title: 'Image Parallax',
          icon: 'mdi-image-size-select-actual',
        },
        {
          title: 'Amazing',
          icon: 'mdi-ice-pop',
        },
        {
          title: '24/7 Support',
          icon: 'mdi-help-circle-outline',
        },
      ],
    }),
  }
</script>
