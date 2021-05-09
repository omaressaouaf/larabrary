<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Roles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Roles</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
      <!-- Default box -->
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Roles Form</h3>

              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-tool"
                  data-card-widget="collapse"
                >
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <form
                @submit.prevent="
                  editMode ? prepareUpdateRole(roleObject) : addRole(roleObject)
                "
              >
                <div class="form-group">
                  <input
                    class="form-control"
                    v-model="roleObject.name"
                    placeholder="Enter Role name"
                    type="text"
                    :class="{ 'is-invalid': roleObject.errors.has('name') }"
                  />
                  <has-error :form="roleObject" field="name"></has-error>
                </div>
                <div class="form-group">
                  <textarea
                    class="form-control"
                    placeholder="Enter a Brief Role Description"
                    cols="10"
                    rows="3"
                    v-model="roleObject.description"
                    :class="{
                      'is-invalid': roleObject.errors.has('description'),
                    }"
                  ></textarea>
                  <has-error :form="roleObject" field="description"></has-error>
                </div>
                <div class="form-group" v-if="editMode">
                  <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-check"></i> Save Role
                  </button>
                  <button
                    type="button"
                    @click="editModeOff"
                    class="btn btn-warning btn-block"
                  >
                    <i class="fa fa-close"></i> Cancel
                  </button>
                </div>
                <div class="form-group" v-else>
                  <button
                    type="submit"
                    class="btn text-white schema-color btn-block"
                  >
                    <i class="fa fa-plus"></i> Add Role
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Roles Data</h3>
              <!-- SEARCH FORM -->

              <div class="card-tools">
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
              <!-- <search @searching="search"></search> -->
              <table
                id="dataTable"
                class="table table-striped dataTable table-hover projects"
              >
                <thead class="schema-color text-white text-muted">
                  <tr>
                    <th style="width: 10%">Id</th>
                    <th style="width: 10%">Name</th>
                    <th style="width: 40%">Description</th>
                    <th style="width: 40%" class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="loading">
                    <td colspan="4">
                      <vcl-table
                        :speed="1"
                        :rtl="true"
                        primary="#6a737c"
                      ></vcl-table>
                    </td>
                  </tr>
                  <tr v-else v-for="role in allRoles" :key="role.id">
                    <td>{{ role.id }}</td>
                    <td>{{ role.name }}</td>
                    <td>{{ role.description }}</td>
                    <td class="project-actions text-right">
                      <a
                        class="btn btn-danger btn-sm"
                        @click.prevent="deleteRole(role.id)"
                        href="#"
                      >
                        <i class="fa fa-trash"></i>
                      </a>
                      <a
                        class="btn btn-info btn-sm"
                        @click.prevent="editModeOn(role)"
                        href="#"
                      >
                        <i class="fa fa-edit"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- /.card-body -->
          </div>
        </div>
      </div>

      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
import { VclTable, VclInstagram } from "vue-content-loading";
import { mapGetters, mapActions } from "vuex";

export default {
  name: "Roles",
  components: {
    VclTable,
    VclInstagram,
  },
  data() {
    return {
      loading: true,
      editMode: false,
      dtTable: null,
    };
  },
  computed: {
    ...mapGetters("roles", ["allRoles", "roleObject"]),
  },

  methods: {
    search(query) {
      this.searchRoles(query);
    },
    editModeOn(role) {
      this.editMode = true;
      this.roleObject.reset();
      this.roleObject.clear();
      this.roleObject.fill(role);
    },
    editModeOff() {
      this.editMode = false;
      this.roleObject.reset();
      this.roleObject.clear();
    },
    prepareUpdateRole(roleObject) {
      this.updateRole(roleObject)
        .then((res) => {
          this.editModeOff();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    ...mapActions("roles", [
      "fetchRoles",
      "deleteRole",
      "addRole",
      "updateRole",
      "searchRoles",
    ]),
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
    this.fetchRoles()
      .then((res) => {
        this.loading = false;
        this.$Progress.finish();
      })
      .catch((err) => {
        this.loading = false;
        this.$Progress.fail();
        this.$helpers.handleHttpErrors(err);
      });
  },
  beforeRouteLeave(to, from, next) {
    this.editMode = false;
    this.roleObject.reset();
    this.roleObject.clear();
    next();
  },
};
</script>
<style scoped>
</style>
