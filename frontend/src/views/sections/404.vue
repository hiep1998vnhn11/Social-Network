<template>
  <base-section id="404">
    <base-subheading
      class="primary--text"
      title="Oh!"
    />

    <base-subheading
      space="8"
      title="Looks like this page doesn't exist"
    />
    <base-subheading
      space="8"
      title="Or this page is in development phase"
    />

    <base-img
      :src="require('@/assets/404-Pages.jpg')"
      class="mx-auto mb-12"
      contain
      height="250"
      width="400"
    />

    <div class="text-center">
      <base-btn :to="{ name: 'Home' }">
        Go back to Home page
      </base-btn>
    </div>
  </base-section>
</template>

<script>
  export default {
    name: 'FourOhFour',

    provide: {
      heading: { align: 'center' },
    },
  }
</script>
