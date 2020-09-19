<template>
  <base-section id="about-our-product">
    <base-section-heading
      color="grey lighten-2"
      icon="mdi-hexagon-slice-2"
      title="About our Product"
    />

    <v-container>
      <v-row>
        <v-col
          v-for="card in cards"
          :key="card.title"
          cols="12"
          md="4"
        >
          <base-info-card v-bind="card" />
        </v-col>
      </v-row>
    </v-container>
  </base-section>
</template>

<script>
  export default {
    name: 'SectionAboutOurProduct',

    data: () => ({
      cards: [
        {
          title: 'Laravel and VueJs',
          subtitle: 'My first product',
          text: 'This website was build by Laravel server and VueJs frontend. If you want to study this Technology, should visit my github down this page!',
          callout: '01',
        },
        {
          title: 'Social Network',
          subtitle: 'Special',
          text: 'I don\'t know I will do anything with this application, but first this is a Social Network for see feed, sent message and add friend!',
          callout: '02',
        },
        {
          title: 'Thank you',
          subtitle: 'Last',
          text: 'Thank for your download or connect to my wevsite. All your actions and comments are my success in future! Thankyou! ',
          callout: '03',
        },
      ],
    }),
  }
</script>
