<template>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#">
          <i class="fa fa-bars"></i>
        </a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <router-link :to="{ name: 'dashboard' }" class="nav-link"
          >Home</router-link
        >
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input
          class="form-control form-control-navbar"
          type="search"
          placeholder="Search"
          aria-label="Search"
        />
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">

            <div class="media">
              <img
                src="/storage/images/users/noavataruser.jpg"
                alt="User Avatar"
                class="img-size-50 img-circle mr-3"
              />
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted">
                    <i class="fa fa-star"></i>
                  </span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted">
                  <i class="fa fa-clock mr-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>

          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">

            <div class="media">
              <img
                src="/storage/images/users/noavataruser.jpg"
                alt="User Avatar"
                class="img-size-50 img-circle mr-3"
              />
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning">
                    <i class="fa fa-star"></i>
                  </span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted">
                  <i class="fa fa-clock mr-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>

          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> -->
      <!-- Notifications Component-->
      <notifications></notifications>
    </ul>
  </nav>
  <!-- /.navbar -->
</template>

<script>
export default {
  mounted() {},
};
</script>
