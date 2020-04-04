import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    homeCategoryPush: null,
  },
  getters: {
    homeCategoryPush: state => {
      return state.homeCategoryPush
    },
  },
  mutations: {
    homeCategoryPush(state, id) {
      state.homeCategoryPush = id
    },
  },
})