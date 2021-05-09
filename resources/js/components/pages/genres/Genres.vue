<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Genres</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Genres</li>
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
              <h3 class="card-title">Genres Form</h3>

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
                  editMode
                    ? prepareUpdateGenre(genreObject)
                    : addGenre(genreObject)
                "
              >
                <div class="form-group">
                  <input
                    class="form-control"
                    v-model="genreObject.name"
                    placeholder="Enter Genre name"
                    type="text"
                    :class="{ 'is-invalid': genreObject.errors.has('name') }"
                  />
                  <has-error :form="genreObject" field="name"></has-error>
                </div>
                <div class="form-group">
                  <input
                    class="form-control"
                    v-model="genreObject.slug"
                    placeholder="Enter Genre slug"
                    type="text"
                    :class="{ 'is-invalid': genreObject.errors.has('slug') }"
                  />
                  <has-error :form="genreObject" field="slug"></has-error>
                </div>

                <div class="form-group" v-if="editMode">
                  <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-check"></i> Save Genre
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
                    <i class="fa fa-plus"></i> Add Genre
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Genres Data</h3>
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
              <table
                id="dataTable"
                class="table table-striped dataTable table-hover projects"
              >
                <thead class="schema-color text-white text-muted">
                  <tr>
                    <th style="width: 10%">Id</th>
                    <th style="width: 10%">Name</th>
                    <th style="width: 40%">Slug</th>
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
                  <tr v-else v-for="genre in allGenres" :key="genre.id">
                    <td>{{ genre.id }}</td>
                    <td>{{ genre.name }}</td>
                    <td>{{ genre.slug }}</td>
                    <td class="project-actions text-right">
                      <a
                        class="btn btn-danger btn-sm"
                        @click.prevent="deleteGenre(genre.id)"
                        href="#"
                      >
                        <i class="fa fa-trash"></i>
                      </a>
                      <a
                        class="btn btn-info btn-sm"
                        @click.prevent="editModeOn(genre)"
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
  name: "Genres",
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
    ...mapGetters("genres", ["allGenres", "genreObject"]),
  },

  methods: {
    editModeOn(genre) {
      this.editMode = true;
      this.genreObject.reset();
      this.genreObject.clear();
      this.genreObject.fill(genre);
    },
    editModeOff() {
      this.editMode = false;
      this.genreObject.reset();
      this.genreObject.clear();
    },
    prepareUpdateGenre(genreObject) {
      this.updateGenre(genreObject)
        .then((res) => {
          this.editModeOff();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    ...mapActions("genres", [
      "fetchGenres",
      "deleteGenre",
      "addGenre",
      "updateGenre",
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
    this.fetchGenres()
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
    this.genreObject.reset();
    this.genreObject.clear();
    next();
  },
};
</script>
<style scoped>
</style>
