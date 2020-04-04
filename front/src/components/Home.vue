<template>
  <div class="container">

    <div class="columns">

      <div class="column is-one-quarter">

        <aside class="menu">

          <p class="menu-label">
            Categories
          </p>

          <ul class="menu-list">

            <tree-menu
                v-for="category in categories"
                :id="category.id"
                :title="category.title"
                :children="category.children"
                :key="category.id"
            />

          </ul>

        </aside>

      </div>

      <div class="column">

        <article class="media" v-for="product in products" :key="product.id">
          <figure class="media-left">
            <p class="image is-64x64">
              <img
                  :src="product.image ? product.image : 'https://bulma.io/images/placeholders/64x64.png'"
                  :alt="product.title"
              >
            </p>
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong>
                  <router-link
                      :to="{ name: 'products.edit', params: { id: product.id} }"
                  >
                    {{ product.title }}
                  </router-link>
                </strong>
                <br>
                {{ product.content }}
              </p>
            </div>
          </div>
        </article>

      </div>

    </div>

  </div>
</template>

<script>

  import axios from '../plugins/axios'
  import TreeMenu from './_common/TreeMenu'

  export default {

    beforeRouteEnter(to, from, next) {
      axios.get('/home')
        .then(resp => next(vm => vm.initialize(resp.data)))
    },

    mounted() {
      this.$store.subscribe(mutation => {

        if (mutation.type === 'homeCategoryPush') {

          this.$http
            .get(`home/${mutation.payload}/products`)
            .then(resp => this.products = resp.data)
        }
      })
    },

    components: {
      TreeMenu,
    },

    data: () => ({
      categories: [],
      products: [],
    }),

    methods: {
      initialize(items) {
        this.categories = items
      },
    },
  }
</script>