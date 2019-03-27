
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import { Form, HasError, AlertError } from 'vform'
window.Form=Form;
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import Gate from './Gate';
import titleMixin from './titleMixin'

Vue.prototype.$gate=new Gate(window.user);
Vue.prototype.$appName = 'Open-gen';
Vue.prototype.$baseUrl ="http:\/\/127.0.0.1:8000\/";


Vue.mixin(titleMixin);


window.Swal=Swal;

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.Toast=Toast;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter)
let routes = [
    { path: '/home', component: require('./components/Dashboard.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/category', component: require('./components/Category/index.vue').default },
    { path: '/category/addEdit/:id?',name:'categoryaddEdit', component: require('./components/Category/addEdit.vue').default },
    { path: '/notfound', component: require('./components/NotFound.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
  ]
const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
  })

  Vue.filter('upText', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  })

  Vue.filter('todata', function (value) {
    return moment(value).format('MMMM Do YYYY');
  })

  let Fire=new Vue();
  window.Fire=Fire;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.use(VueProgressBar, options)




const app = new Vue({
    el: '#app',
    router,
    data:{
      search:''
    },
    methods: {
      searchhit:_.debounce(()=>{
        Fire.$emit('searching');
      },1000)
    },
});
