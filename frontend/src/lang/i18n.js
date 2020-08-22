import Vue from 'vue'
import VueI18n from 'vue-i18n'
import viMessage from './vi.json'
import enMessage from './en.json'
import jaMessage from './ja.json'
import Cookies from 'js-cookie'

Vue.use(VueI18n)

const messages = {
  vi: viMessage,
  en: enMessage,
  ja: jaMessage
}

let lang = 'en'
if(Cookies.get('lang')) lang = Cookies.get('lang')

const i18n = new VueI18n({
  locale: lang, // set locale
  messages,
  fallbackLocale: 'en',
})

export default i18n