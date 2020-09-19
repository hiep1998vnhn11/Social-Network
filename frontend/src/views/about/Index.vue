<script>
  // Extensions
  import View from '@/views/View'

  // Mixins
  import LoadSections from '@/mixins/load-sections'

  export default {
    name: 'About',

    metaInfo: { title: 'About Us' },

    extends: View,

    mixins: [
      LoadSections([
        'hero-alt',
        'about-our-product',
        'app-features',
        'social-media',
        'contact-us',
        'keep-in-touch',
        'info',
      ]),
    ],

    props: {
      id: {
        type: String,
        default: 'about',
      },
    },
  }
</script>
