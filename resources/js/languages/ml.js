import Vue from 'vue'
import { MLInstaller, MLCreate, MLanguage } from 'vue-multilanguage'
import arabic from './ar';
import english from './en';
Vue.use(MLInstaller)

export default new MLCreate({
  initial: 'عربي',
  save:true, //process.env.NODE_ENV === 'production',
  languages: [
    new MLanguage('English').create(english),

    new MLanguage('عربي').create(arabic)
  ]
})