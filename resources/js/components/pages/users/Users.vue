<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content">
      <!-- Default box -->

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Users Data</h3>

          <div class="card-tools">
            <router-link
              :to="{ name: 'users.create' }"
              type="button"
              class="btn btn-success"
            >
              <i class="fa fa-user-plus"></i> Add new user
            </router-link>
            <button
              type="button"
              class="btn btn-tool"
              data-card-widget="collapse"
            >
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body table-responsive">
          <table
            id="dataTable"
            class="table table-striped table-hover projects"
          >
            <thead class="schema-color text-white text-muted">
              <tr>
                <th style="width: 1%">Id</th>
                <th style="width: 15%">Name</th>
                <th style="width: 20%">Email</th>
                <th style="width: 20%">Roles</th>
                <th style="width: 15%">Avatar</th>
                <th style="width: 15%">Registered At</th>
                <th style="width: 35%" class="text-right">Action</th>
              </tr>
            </thead>

            <tbody>
              <tr v-if="loading">
                <td colspan="7"><vcl-table :speed="1" :rtl="true" primary="#6a737c"></vcl-table></td>


              </tr>

              <tr v-for="user in users" v-else :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <ul class="list-inline">
                    <li
                      class="list-inline-item"
                      :key="role.id"
                      v-for="role in user.roles"
                    >
                      <span
                        v-bind:class="
                          role.name == 'admin'
                            ? 'badge-primary'
                            : 'badge-warning'
                        "
                        class="badge"
                        >{{ role.name }}</span
                      >
                    </li>
                  </ul>
                </td>

                <td>
                  <img
                    class="img-responsive img-circle"
                    width="50"
                    height="50"
                    v-bind:src="user.avatar"
                    alt="Avatar"
                  />
                </td>
                <td>{{ user.created_at | formatDate }}</td>

                <td class="project-actions text-right">
                  <router-link
                    class="btn btn-info btn-sm"
                    :to="{
                      name: 'users.edit',
                      params: { id: user.id },
                    }"
                  >
                    <i class="fa fa-pencil"></i>
                  </router-link>
                  <a
                    class="btn btn-danger btn-sm"
                    @click.prevent="deleteUser(user.id)"
                    href="#"
                  >
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- /.card-body -->
      </div>

      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
import { VclTable, VclInstagram } from "vue-content-loading";
export default {
  name: "Users",
  components: {
    VclTable,
    VclInstagram,
  },
  data() {
    return {
      users: [],
      loading: true,
      dtTable: null,
    };
  },

  methods: {
    loadUsers() {
      axios
        .get("/api/users")
        .then((res) => {
          this.users = res.data;
          this.loading = false;
          this.$Progress.finish();
        })

        .catch((err) => {
          this.$Progress.fail();
          this.$helpers.handleHttpErrors(err);
        });
    },
    deleteUser(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((confirm) => {
          if (confirm.isConfirmed) {
            this.$Progress.start();
            axios
              .delete("/api/users/" + id)
              .then((res) => {
                this.users = this.users.filter((user) => user.id !== id);
                this.$Progress.finish();
                toast.fire({
                  icon: "success",
                  title: "User Deleted successfully",
                });
              })
              .catch((err) => {
                this.$Progress.fail();
                this.$helpers.handleHttpErrors(err);
                if (err.response.status == 404) {
                  this.$router.push("*");
                }
              });
          }
        });
    },
  },
  beforeUpdate() {
    if (this.dtTable) {
      this.dtTable.destroy();
    }
  },
  updated() {
    this.dtTable = $("#dataTable").DataTable({
      order: [[0, "desc"]],
    });
  },
  created() {
    this.loadUsers();
  },
};
</script>
