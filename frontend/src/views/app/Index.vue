
<script>
  // Extensions
  import View from '@/views/View'

  // Mixins
  import LoadSections from '@/mixins/load-sections'

  export default {
    name: 'Home',

    metaInfo: { title: 'App' },

    extends: View,

    mixins: [
      LoadSections([
        'hero',
        'theme-features',
        'features',
        'contact-us',
        'affiliates',
        'social-media',
        'keep-in-touch',
        'newsletter',
        'info',
      ]),
    ],

    props: {
      id: {
        type: String,
        default: 'home',
      },
    },
  }
</script>
