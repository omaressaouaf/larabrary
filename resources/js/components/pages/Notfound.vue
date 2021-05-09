<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-sm-12 text-center">
        <h1 class="display-3 mb-4">Not Found</h1>
        <img src="/storage/images/design/random/404.svg" alt />
        <router-link :to="{name : 'dashboard'}" class="btn btn-dark btn-block btn-lg mb-4">Go to Dashboard</router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Notfound",
  data() {
    return {};
  },
  methods: {},
  mounted() {
    this.$Progress.fail();
  },
};
</script>
