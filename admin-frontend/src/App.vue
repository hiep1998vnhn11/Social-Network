<template>
  <v-fade-transition mode="out-in">
  <v-app id="inspire">
    <layout></layout>
    <v-main>
    <router-view/>
    </v-main>
  </v-app>
  </v-fade-transition>
</template>

<script>
import Layout from './components/Layout/Layout'
export default {
  name: 'App',
  components: {
    layout: Layout
  },
  metaInfo: {
      title: 'App',
      titleTemplate: '%s | Social NetWork',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      ],
    },
}
</script>
<style lang="sass">
  .extra-padding
    padding-bottom: 96px !important
    padding-top: 96px !important

    @media screen and (max-width: 959px)
      padding-top: 48px !important
      padding-bottom: 48px !important
</style>
