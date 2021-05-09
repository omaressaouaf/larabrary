<template>
  <div>
    <div class="dropdown-divider"></div>
    <div class="dropdown-item">
      <i class="fa fa-user-plus mr-2"></i> {{ unread.data.email }} has
      registered
      <p class="float-right text-muted text-sm">
        {{ unread.created_at | timeAgo }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "NotificationItem",

  data() {
    return {};
  },
  props: {
    unread: Object,
  },
  methods: {},
  created() {
    
  },
};
</script>
