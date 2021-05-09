<template>
  <li class="nav-item dropdown">
    <a
      class="nav-link"
      @click="getUnreadNotifications"
      data-toggle="dropdown"
      href="#"
    >

      <span class="lead">Notifications</span> |
      <i class="fa fa-bell"></i>
      <span class="badge badge-warning navbar-badge">{{
        unreadNotificationsCount
      }}</span>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <clip-loader color="blue" v-if="loading"></clip-loader>
      <div v-else>
        <div v-if="unreadNotifications.length">
          <span class="dropdown-item dropdown-header"
            >{{ unreadNotifications.length }} Unread Notifications</span
          >
          <notification-item
            v-for="unread in unreadNotifications"
            :key="unread.id"
            :unread="unread"
          ></notification-item>
        </div>
        <div v-else class="alert alert-primary">
          <span class="lead"
            ><i class="fa fa-exclamation-circle"></i> No unread
            notifications</span
          >
        </div>
      </div>
    </div>
  </li>
</template>

<script>
import NotificationItem from "./NotificationItem";
export default {
  name: "Notifications",
  components: { NotificationItem },
  data() {
    return {
      loading: true,
      unreadNotificationsCount: 0,
      unreadNotifications: [],
    };
  },
  methods: {
    getUnreadNotificationsCount() {
      axios
        .get("/api/notifications/getUnreadNotificationsCount")
        .then((res) => {
          this.unreadNotificationsCount = res.data;
        })
        .catch((err) => {
          this.$helpers.handleHttpErrors(err);
        });
    },
    getUnreadNotifications() {
      if (this.unreadNotificationsCount > 0) {
        axios
          .get("/api/notifications/getUnreadNotifications")
          .then((res) => {
            this.unreadNotifications = res.data;
            this.loading = false;
            this.unreadNotificationsCount -= this.unreadNotifications.length;
          })
          .catch((err) => {
            this.$helpers.handleHttpErrors(err);
          });
      } else {
        this.unreadNotifications = [];
        this.loading = false;
      }
    },
  },
  created() {

      Echo.private("App.User." + this.$store.state.auth.user.id).notification(
        (notification) => {
          this.unreadNotificationsCount += 1;
          this.loading = true;
          toast.fire({
            icon: "success",
            title: "New Registration",
            position: "top",
          });
        }
      );


    this.getUnreadNotificationsCount();
  },
};
</script>
