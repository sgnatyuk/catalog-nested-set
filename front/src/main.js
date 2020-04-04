import Vue from 'vue'
import App from './App.vue'

import store from './plugins/store'
import router from './plugins/router'
import axios from './plugins/axios'

import 'bulma'

Vue.config.productionTip = false
Vue.prototype.$http = axios

new Vue({
  store,
  router,
  render: h => h(App),
}).$mount('#app')
