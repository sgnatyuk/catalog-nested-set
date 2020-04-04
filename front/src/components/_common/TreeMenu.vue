<template>
  <li>
    <a @click="push(id)">{{ title }}</a>

    <ul>
      <tree-menu
          v-for="item in children"
          :id="item.id"
          :title="item.title"
          :children="item.children"
          :key="item.id"
      />
    </ul>
  </li>
</template>

<script>

  export default {
    name: 'TreeMenu',
    props: {
      id: Number,
      title: String,
      children: Array,
    },
    methods: {
      push(id) {
        this.$store.commit('homeCategoryPush', id)
      },
    },
  }
</script>