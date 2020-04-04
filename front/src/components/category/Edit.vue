<template>
  <div class="container">

    <h1 class="title">Edit category</h1>

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
            v-model="category.title"
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
                    v-model="category.content">
                </textarea>
      </div>
      <p class="help is-danger" v-if="errors.has('content')">{{ errors.get('content') }}</p>
    </div>

    <div class="field">
      <label class="label" for="parentId">Parent Category</label>
      <div class="control is-expanded">
        <div class="select is-fullwidth">
          <select id="parentId" v-model="category.parentId">

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

    <div class="field is-grouped">
      <div class="control">
        <button class="button is-link" @click="save">Save</button>
      </div>
      <div class="control">
        <router-link :to="{ name: 'categories' }" class="button is-link is-light">Back</router-link>
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
        category: null,
        categories: null,
      }

      await axios.get(`/categories/${to.params.id}`)
        .then(resp => data.category = resp.data.data)

      await axios.get(`/categories`)
        .then(resp => data.categories = resp.data.data)

      next(vm => vm.initialize(data))
    }),

    data: () => ({
      category: {
        id: null,
        parentId: null,
        title: '',
        content: '',
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
        this.category = resp.category
        this.categories = resp.categories
      },
      save() {
        this.$http
          .post(`/categories/${this.category.id}`, { _method: 'PUT', ...this.category })
          .then(() => this.alert = {
            active: true,
            message: 'Saved',
            state: 'is-success',
          })
          .catch(err => this.errors.record(err.response.data.errors))
      },
    },
  }
</script>