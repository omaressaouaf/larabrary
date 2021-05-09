
<template>
  <div>
    <navbar></navbar>
    <sidebar :csrf="this.csrf"></sidebar>
    <router-view v-if="$online"></router-view>
    <Offline v-else></Offline>
    <vue-progress-bar></vue-progress-bar>
  </div>
</template>


<script>
export default {
  name: "app",
  props: ["csrf"],
  data() {
    return {};
  },
  computed: {},

  methods: {

  },

  created() {
    this.$Progress.start();
    if (!navigator.onLine) {
      this.$Progress.fail();
    }
  },
};
</script>

