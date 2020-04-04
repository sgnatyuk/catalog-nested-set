<template>
  <div class="container">

    <h1 class="title">Products</h1>

    <nav class="level">

      <div class="level-left">
        <div class="level-item">
          <div class="field has-addons">
            <p class="control">
              <input
                  v-model="search"
                  class="input"
                  type="text"
                  placeholder="Find by title"
              >
            </p>
            <p class="control">
              <button class="button" @click="doSearch">Search</button>
            </p>
          </div>
        </div>
      </div>

      <div class="level-right">
        <p class="level-item">
          <button class="button is-success" @click="openModal">Create</button>
        </p>
      </div>
    </nav>

    <div class="table-container">
      <table class="table is-fullwidth">
        <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
          <th>Created At</th>
          <th class="has-text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item of items" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.categoryTitle }}</td>
          <td>{{ item.createdAt }}</td>
          <td>
            <div class="buttons is-pulled-right">
              <router-link :to="{ name: 'products.edit', params: { id: item.id }}"
                           class="button is-link is-light">Edit
              </router-link>
              <button class="button is-danger is-light" @click="destroy(item.id)">Delete</button>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <modal v-model="isOpenModal" title="New product" @save="saveModalForm">

      <div class="container">

        <div class="field">
          <label class="label" for="modal-title">Title</label>
          <div class="control">
            <input
                type="text"
                id="modal-title"
                :class="['input', { 'is-danger': errors.has('title') }]"
                v-model="modalForm.title"
            >
          </div>
          <p class="help is-danger" v-if="errors.has('title')">{{ errors.get('title') }}</p>
        </div>

        <div class="field">
          <label class="label" for="modal-content">Content</label>
          <div class="control">
                    <textarea
                        id="modal-content"
                        :class="['textarea', { 'is-danger': errors.has('content') }]"
                        v-model="modalForm.content">
                    </textarea>
          </div>
          <p class="help is-danger" v-if="errors.has('content')">{{ errors.get('content') }}</p>
        </div>

      </div>

    </modal>

  </div>
</template>

<script>

  import axios from '../../plugins/axios'
  import Errors from '../../utils/Errors'
  import Modal from '../_common/Modal'

  const objToUrl = obj => Object.entries(obj)
    .map(([key, val]) => val ? (`${key}=${val}`) : '')
    .join('&')

  export default {

    beforeRouteEnter(to, from, next) {

      axios.get(`/products?${objToUrl(to.query)}`)
        .then(resp => next(vm => vm.initialize(resp.data)))
    },
    beforeRouteUpdate(to, from, next) {

      axios.get(`/products?${objToUrl(to.query)}`)
        .then(resp => {
          this.initialize(resp.data)
          next()
        })
    },

    created() {
      this.search = this.$route.query.search
    },

    components: {
      Modal,
    },

    data: () => ({
      items: [],
      isOpenModal: false,
      modalForm: {
        title: '',
        content: '',
      },
      search: '',
      errors: new Errors,
    }),

    methods: {
      initialize(resp) {
        this.items = resp.data
      },
      openModal() {
        this.modalForm = { title: '', content: '' }
        this.errors.clear()
        this.isOpenModal = true
      },
      saveModalForm() {
        this.$http
          .post('products', this.modalForm)
          .then(resp => this.$router
            .push({ name: 'products.edit', params: { id: resp.headers['x-created-resource-id'] } }))
          .catch(err => this.errors.record(err.response.data.errors))
      },
      destroy(id) {
        if (window.confirm('Delete it?')) {
          this.$http
            .post(`products/${id}`, { _method: 'DELETE' })
            .then(() => this.items = this.items.filter(item => item.id !== id))
        }
      },
      doSearch() {

        let query = this.search ? { search: this.search } : null

        this.$router.replace({ name: this.$route.name, query })
      },
    },
  }
</script>