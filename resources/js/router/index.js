import VueRouter from 'vue-router';
import routes from './routes';

const router= new VueRouter({
    mode: 'history',
    base: '/',
    routes,
});
/*router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
      const authUser = window.user
    
      if (authUser && authUser.type=="merchant1") {
        next()
      } else {
        next({name: 'notfound'})
      }
    }
    next()
  })
  */
  export default router