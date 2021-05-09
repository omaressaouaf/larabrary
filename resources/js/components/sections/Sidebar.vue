<template>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img
        src="/storage/images/design/logos/mylogo.png"
        alt="Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">Larabrary Home</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            :src="this.currentUser.avatar"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <a href="#" class="d-block text-capitalize">{{
            this.currentUser.name
          }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-header ml-2">OVERVIEW</li>

          <li class="nav-item">
            <router-link :to="{ name: 'dashboard' }" class="nav-link">
              <i class="nav-icon fa fa-tachometer text-info"></i>
              <p>Dashboard</p>
            </router-link>
          </li>

          <li class="nav-header">MANAGEMENT</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-users text-success"></i>
              <p>
                Users
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'users' }" class="nav-link">
                  <!-- <i class="fa fa-circle nav-icon"></i> -->
                  <p class="ml-4">
                    <i class="fa fa-circle text-muted"></i> Consult Users
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-tasks text-warning"></i>
              <p>
                Roles
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'roles' }" class="nav-link">
                  <!-- <i class="fa fa-circle nav-icon"></i> -->
                  <p class="ml-4">
                    <i class="fa fa-circle text-muted"></i> Consult Roles
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-book text-white"></i>
              <p>
                Books
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'books' }" class="nav-link">
                  <p class="ml-4">
                    <i class="fa fa-circle text-muted"></i> Consult Books
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-list-alt text-danger"></i>
              <p>
                Genres
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'genres' }" class="nav-link">
                  <!-- <i class="fa fa-circle nav-icon"></i> -->
                  <p class="ml-4">
                    <i class="fa fa-circle text-muted"></i> Consult Genres
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-shopping-bag text-info"></i>
              <p>
                Orders
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{ name: 'orders' }" class="nav-link">
                  <!-- <i class="fa fa-circle nav-icon"></i> -->
                  <p class="ml-4">
                    <i class="fa fa-circle text-muted"></i> Consult Orders
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-header">ACCOUNT</li>
          <li class="nav-item">
            <a
              style="cursor: pointer"
              class="nav-link"
              onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"
            >
              <i class="nav-icon fa fa-power-off text-danger"></i>
              <p>Log out</p>
            </a>

            <form
              id="logout-form"
              action="/logout"
              method="POST"
              style="display: none"
            >
              <input type="hidden" name="_token" v-bind:value="csrf" />
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>
<script>
export default {
  props: ["csrf"],
  data() {
    return {
      currentUser: this.$store.state.auth.user,
    };
  },
  created() {},
};
</script>
