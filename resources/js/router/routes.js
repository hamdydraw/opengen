const  routes = [
    { path: '/home', component: require('../components/Dashboard.vue').default , meta: { requiresAuth: true },beforeEnter: (to, from, next) => {
      
      next();
    } },
    { path: '/developer', component: require('../components/Developer.vue').default , meta: { requiresAuth: true } },
    { path: '/profile', component: require('../components/Profile.vue').default , meta: { requiresAuth: true } },
    { path: '/users', component: require('../components/Users.vue').default , meta: { requiresAuth: true } },
    { path: '/category', component: require('../components/Category/index.vue').default , meta: { requiresAuth: true } },
    { path: '/category/addEdit/:id?',name:'categoryaddEdit', component: require('../components/Category/addEdit.vue').default , meta: { requiresAuth: true } },
    { path: '/currency', component: require('../components/Currency/index.vue').default , meta: { requiresAuth: true } },
    { path: '/currency/addEdit/:id?',name:'currencyaddEdit', component: require('../components/Currency/addEdit.vue').default , meta: { requiresAuth: true } },
    { path: '/language', component: require('../components/Language/index.vue').default , meta: { requiresAuth: true } },
    { path: '/language/addEdit/:id?',name:'languageaddEdit', component: require('../components/Language/addEdit.vue').default , meta: { requiresAuth: true } },
    
    { path: '/attribute', component: require('../components/Attribute/index.vue').default , meta: { requiresAuth: true } },
    { path: '/attribute/addEdit/:id?',name:'attributeaddEdit', component: require('../components/Attribute/addEdit.vue').default , meta: { requiresAuth: true } },
    
    { path: '/attributegroups', component: require('../components/Attributegroup/index.vue').default , meta: { requiresAuth: true } },
    { path: '/attributegroups/addEdit/:id?',name:'attributegroupaddEdit', component: require('../components/Attributegroup/addEdit.vue').default , meta: { requiresAuth: true } },
    

    { path: '/weightclass', component: require('../components/Weightclass/index.vue').default , meta: { requiresAuth: true } },
    { path: '/weightclass/addEdit/:id?',name:'WeightclassaddEdit', component: require('../components/Weightclass/addEdit.vue').default , meta: { requiresAuth: true } },
   
    { path: '/lengthclass', component: require('../components/Lengthclass/index.vue').default , meta: { requiresAuth: true } },
    { path: '/lengthclass/addEdit/:id?',name:'LengthclassaddEdit', component: require('../components/Lengthclass/addEdit.vue').default , meta: { requiresAuth: true } },
   
    { path: '/taxrate', component: require('../components/Taxrate/index.vue').default , meta: { requiresAuth: true } },
    { path: '/taxrate/addEdit/:id?',name:'taxrateaddEdit', component: require('../components/Taxrate/addEdit.vue').default , meta: { requiresAuth: true } },
    
    { path: '/merchant', component: require('../components/Merchant/index.vue').default , meta: { requiresAuth: true } },
    { path: '/merchant/addEdit/:id?',name:'merchantaddEdit', component: require('../components/Merchant/addEdit.vue').default , meta: { requiresAuth: true } },
   
    { path: '/merchanttype', component: require('../components/MerchantType/index.vue').default , meta: { requiresAuth: true } },
    { path: '/merchanttype/addEdit/:id?',name:'merchanttypeaddEdit', component: require('../components/MerchantType/addEdit.vue').default , meta: { requiresAuth: true } },
   

    { path: '/pilot', component: require('../components/Pilot/index.vue').default , meta: { requiresAuth: true } },
    { path: '/pilot/addEdit/:id?',name:'pilotaddEdit', component: require('../components/Pilot/addEdit.vue').default , meta: { requiresAuth: true } },
   
    { path: '/product', component: require('../components/Product/index.vue').default , meta: { requiresAuth: true } },
    { path: '/product/addEdit/:id?',name:'productaddEdit', component: require('../components/Product/addEdit.vue').default , meta: { requiresAuth: true } },
   
    { path: '/inout', component: require('../components/Inout/index.vue').default , meta: { requiresAuth: true } },

    { path: '/notfound',name:'notfound', component: require('../components/NotFound.vue').default , meta: { requiresAuth: true } },
    { path: '*', component: require('../components/NotFound.vue').default , meta: { requiresAuth: true } }
  ];
export default routes;