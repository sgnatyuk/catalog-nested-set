<template>
  <div class="container">

    <h1 class="title">Categories</h1>

    <nav class="level">

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
          <th>Products count</th>
          <th>Created At</th>
          <th class="has-text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item of items" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.productsCount }}</td>
          <td>{{ item.createdAt }}</td>
          <td>
            <div class="buttons is-pulled-right">
              <router-link :to="{ name: 'categories.edit', params: { id: item.id }}"
                           class="button is-link is-light">Edit
              </router-link>
              <button class="button is-danger is-light" @click="destroy(item.id)">Delete</button>
            </div>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <modal v-model="isOpenModal" title="New category" @save="saveModalForm">

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

  export default {

    beforeRouteEnter(to, from, next) {
      axios.get('/categories')
        .then(resp => next(vm => vm.initialize(resp.data.data)))
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
      errors: new Errors,
    }),

    methods: {
      initialize(items) {
        this.items = items
      },
      openModal() {
        this.modalForm = { title: '', content: '' }
        this.errors.clear()
        this.isOpenModal = true
      },
      saveModalForm() {
        this.$http
          .post('categories', this.modalForm)
          .then(resp => this.$router
            .push({ name: 'categories.edit', params: { id: resp.headers['x-created-resource-id'] } }))
          .catch(err => this.errors.record(err.response.data.errors))
      },
      destroy(id) {
        if (window.confirm('Delete it?')) {
          this.$http
            .post(`categories/${id}`, { _method: 'DELETE' })
            .then(() => this.items = this.items.filter(item => item.id !== id))
        }
      },
    },
  }
</script>