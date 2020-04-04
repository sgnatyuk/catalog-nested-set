<template>
  <div class="container">

    <h1 class="title">Edit product</h1>

    <div :class="['notification is-light', alert.state]" v-if="alert.active">
      <button class="delete" @click="alert.active = false"></button>
      {{ alert.message }}
    </div>

    <div class="field">
      <label class="label" for="title">Title</label>
      <div class="control">
        <input
            type="text"
            id="title"
            :class="['input', { 'is-danger': errors.has('title') }]"
            v-model="product.title"
        >
      </div>
      <p class="help is-danger" v-if="errors.has('title')">{{ errors.get('title') }}</p>
    </div>

    <div class="field">
      <label class="label" for="content">Content</label>
      <div class="control">
                <textarea
                    id="content"
                    :class="['textarea', { 'is-danger': errors.has('content') }]"
                    v-model="product.content">
                </textarea>
      </div>
      <p class="help is-danger" v-if="errors.has('content')">{{ errors.get('content') }}</p>
    </div>

    <div class="field">
      <label class="label" for="categoryId">Category</label>
      <div class="control is-expanded">
        <div class="select is-fullwidth">
          <select id="categoryId" v-model="product.categoryId">

            <option :value="null">Not selected</option>

            <option
                v-for="category in categories"
                :value="category.id"
                :key="category.id"
            >
              {{ category.title }}
            </option>

          </select>
        </div>
      </div>
    </div>

    <div class="field">

      <p class="label">Image</p>

      <div class="control">

        <div class="file has-name">

          <label class="file-label" for="image">

            <input
                type="file"
                id="image"
                class="file-input"
                @change="uploadImage">

            <span class="file-cta">
              <span class="file-icon"><i class="fas fa-upload"></i></span>
              <span class="file-label">Choose a image</span>
            </span>
          </label>

        </div>

      </div>

    </div>

    <div class="field">
      <div class="control">
        <figure class="image is-128x128">
          <img
              :src="product.image ? product.image : 'https://bulma.io/images/placeholders/128x128.png'"
              :alt="product.title"
          >
        </figure>
      </div>
    </div>

    <div class="field is-grouped">
      <div class="control">
        <button class="button is-link" @click="save">Save</button>
      </div>
      <div class="control">
        <router-link :to="{ name: 'products' }" class="button is-link is-light">Back</router-link>
      </div>
    </div>

  </div>
</template>

<script>

  import axios from '../../plugins/axios'
  import Errors from '../../utils/Errors'

  export default {

    beforeRouteEnter: (async (to, from, next) => {

      const data = {
        product: null,
        categories: null,
      }

      await axios.get(`/products/${to.params.id}`)
        .then(resp => data.product = resp.data.data)

      await axios.get(`/categories`)
        .then(resp => data.categories = resp.data.data)

      next(vm => vm.initialize(data))
    }),

    data: () => ({
      product: {
        id: null,
        categoryId: null,
        imageId: null,
        title: '',
        content: '',
        image: null,
      },
      categories: [],
      errors: new Errors,
      alert: {
        active: false,
        message: '',
        state: '',
      },
    }),

    methods: {
      initialize(resp) {
        this.product = resp.product
        this.categories = resp.categories
      },
      save() {
        this.$http
          .post(`/products/${this.product.id}`, { _method: 'PUT', ...this.product })
          .then(() => this.alert = {
            active: true,
            message: 'Saved',
            state: 'is-success',
          })
          .catch(err => this.errors.record(err.response.data.errors))
      },
      uploadImage(event) {

        let files = event.target.files || event.dataTransfer.files

        let mime = [
          'image/jpeg',
          'image/png',
          'image/svg+xml',
        ]

        if (!files.length || !mime.includes(files[0].type)) {
          return null
        }

        let fd = new FormData

        fd.append('image', files[0])

        this.$http
          .post('product_images', fd)
          .then(resp => {
            this.product.image = resp.data.image
            this.product.imageId = resp.headers['x-created-resource-id']
          })
      },
    },
  }
</script>