const  routes = [
    { path: '/home', component: require('../components/Dashboard.vue').default,beforeEnter: (to, from, next) => {
      
      next();
    } },
    { path: '/developer', component: require('../components/Developer.vue').default },
    { path: '/profile', component: require('../components/Profile.vue').default },
    { path: '/users', component: require('../components/Users.vue').default },
    { path: '/category', component: require('../components/Category/index.vue').default },
    { path: '/category/addEdit/:id?',name:'categoryaddEdit', component: require('../components/Category/addEdit.vue').default },
    { path: '/currency', component: require('../components/Currency/index.vue').default },
    { path: '/currency/addEdit/:id?',name:'currencyaddEdit', component: require('../components/Currency/addEdit.vue').default },
    { path: '/language', component: require('../components/Language/index.vue').default },
    { path: '/language/addEdit/:id?',name:'languageaddEdit', component: require('../components/Language/addEdit.vue').default },
    
    { path: '/weightclass', component: require('../components/Weightclass/index.vue').default },
    { path: '/weightclass/addEdit/:id?',name:'WeightclassaddEdit', component: require('../components/Weightclass/addEdit.vue').default },
   
    { path: '/lengthclass', component: require('../components/Lengthclass/index.vue').default },
    { path: '/lengthclass/addEdit/:id?',name:'LengthclassaddEdit', component: require('../components/Lengthclass/addEdit.vue').default },
   
    { path: '/taxrate', component: require('../components/Taxrate/index.vue').default },
    { path: '/taxrate/addEdit/:id?',name:'taxrateaddEdit', component: require('../components/Taxrate/addEdit.vue').default },
    
    { path: '/merchant', component: require('../components/Merchant/index.vue').default },
    { path: '/merchant/addEdit/:id?',name:'merchantaddEdit', component: require('../components/Merchant/addEdit.vue').default },
   
    { path: '/merchanttype', component: require('../components/MerchantType/index.vue').default },
    { path: '/merchanttype/addEdit/:id?',name:'merchanttypeaddEdit', component: require('../components/MerchantType/addEdit.vue').default },
   

    { path: '/pilot', component: require('../components/Pilot/index.vue').default },
    { path: '/pilot/addEdit/:id?',name:'pilotaddEdit', component: require('../components/Pilot/addEdit.vue').default },
   
    { path: '/product', component: require('../components/Product/index.vue').default },
    { path: '/product/addEdit/:id?',name:'productaddEdit', component: require('../components/Product/addEdit.vue').default },
   
    { path: '/notfound', component: require('../components/NotFound.vue').default },
    { path: '*', component: require('../components/NotFound.vue').default }
  ];
export default routes;