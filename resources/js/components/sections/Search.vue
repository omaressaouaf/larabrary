<template>
  
    <div class="input-group input-group-sm col-md-4 ml-auto">
      <input
        class="form-control ml-2"
        id="search"
        v-model="query"
        placeholder="Search"
        @keyup.enter="typing"
      />
    </div>
  
</template>

<script>
export default {
  name: "Search",
  data() {
    return {
      query: "",
    };
  },
  methods: {
    typing() {
      this.$emit("searching", this.query);
    },
  },
};
</script>
