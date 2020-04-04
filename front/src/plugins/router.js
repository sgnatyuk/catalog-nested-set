import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import(/* webpackChunkName: "home" */ '../components/Home'),
      meta: {
        title: 'Home',
      },
    },
    {
      path: '/categories',
      name: 'categories',
      component: () => import(/* webpackChunkName: "category" */ '../components/category/List'),
      meta: {
        title: 'Categories',
      },
    },
    {
      path: '/categories/:id/edit',
      name: 'categories.edit',
      component: () => import(/* webpackChunkName: "category" */ '../components/category/Edit'),
      meta: {
        title: 'Edit Category',
      },
    },
    {
      path: '/products',
      name: 'products',
      component: () => import(/* webpackChunkName: "product" */ '../components/product/List'),
      meta: {
        title: 'Products',
      },
    },
    {
      path: '/products/:id/edit',
      name: 'products.edit',
      component: () => import(/* webpackChunkName: "product" */ '../components/product/Edit'),
      meta: {
        title: 'Edit Product',
      },
    },
  ],
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title

  next()
})

export default router