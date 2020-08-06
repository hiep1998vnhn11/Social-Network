<template>
  <v-app id="inspire">
    <layout></layout>
    <v-main>
    <router-view/>
    </v-main>
  </v-app>
</template>

<script>
import Layout from './components/Layout/Layout'
export default {
  name: 'App',
  components: {
    layout: Layout
  }
}
</script>
