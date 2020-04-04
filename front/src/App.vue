<template>

  <main id="app">

    <nav class="navbar" role="navigation" aria-label="main navigation">

      <div class="container">

        <div class="navbar-brand">

          <router-link
              :to="{ name: 'home' }"
              class="navbar-item">
            <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28" alt="Logo">
          </router-link>

          <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
             data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
          </a>
        </div>

        <div class="navbar-menu">
          <div class="navbar-start">

            <router-link
                :to="{ name: 'home' }"
                class="navbar-item">Home
            </router-link>

            <router-link
                :to="{ name: 'categories' }"
                class="navbar-item">Categories
            </router-link>

            <router-link
                :to="{ name: 'products' }"
                class="navbar-item">Products
            </router-link>

          </div>

        </div>

      </div>
    </nav>

    <section class="section">
      <router-view></router-view>
    </section>

  </main>

</template>

<script>

</script>

<style lang="scss" scoped>
  .router-link-exact-active {
    color: #3273dc;
  }
</style>
