<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="float-right" :class="{ invisible: !bulkLoading }">
      <clip-loader color="blue"></clip-loader>
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Books</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">Home</router-link>
              </li>
              <li class="breadcrumb-item active">Books</li>
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
          <h3 class="card-title">Books Data</h3>

          <div class="card-tools">
            <button
              class="btn btn-danger bulk-btn"
              type="button"
              @click="prepareBulkDeleteBooks($event)"
            >
              <i class="fa fa-trash"></i> Bulk Delete
            </button>
            <router-link
              :to="{ name: 'books.create' }"
              type="button"
              class="btn btn-success"
            >
              <i class="fa fa-user-plus"></i> Add new Book
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
                <th width="1%">
                  <input
                    type="checkbox"
                    @click="selectAll"
                    v-model="allSelected"
                  />
                </th>
                <th style="width: 4%">Id</th>
                <th style="width: 15%">title</th>
                <th style="width: 15%">slug</th>
                <th style="width: 5%">price</th>
                <th style="width: 5%">Stock</th>
                <th style="width: 15%">Image</th>
                <th style="width: 15%">Author (User)</th>
                <th style="width: 10%">Genres</th>
                <th style="width: 15%" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="10">
                  <vcl-table
                    :speed="1"
                    :rtl="true"
                    primary="#6a737c"
                  ></vcl-table>
                </td>
              </tr>
              <tr v-else v-for="book in allBooks" :key="book.id">
                <td>
                  <input
                    type="checkbox"
                    v-model="selectedItems"
                    :value="book.id"
                  />
                </td>
                <td>{{ book.id }}</td>
                <td>{{ book.title }}</td>
                <td>{{ book.slug }}</td>

                <td>{{ book.price }}</td>
                <td>{{ book.stock }}</td>
                <td>
                  <img
                    v-if="book.images[0]"
                    :src="book.images[0].name"
                    class="img-fluid"
                    style="width: 100px; height: 100px"
                    alt
                  />
                  <img
                    v-if="!book.images[0]"
                    src="/storage/images/books/noimagebook.svg"
                    class="img-fluid"
                    style="width: 100px; height: 100px"
                    alt
                  />
                </td>
                <td>{{ book.user.name }}</td>
                <td>
                  <ul class="list-inline">
                    <li
                      class="list-inline-item"
                      :key="genre.id"
                      v-for="genre in book.genres"
                    >
                      <span class="badge badge-primary">{{ genre.name }}</span>
                    </li>
                  </ul>
                </td>

                <td class="project-actions text-right">
                  <a
                    :href="'/library/books/' + book.slug"
                    class="btn btn-success btn-sm"
                  >
                    <i class="fa fa-eye"></i>
                  </a>
                  <router-link
                    class="btn btn-info btn-sm"
                    :to="{
                      name: 'books.edit',
                      params: { id: book.id },
                    }"
                  >
                    <i class="fa fa-pencil"></i>
                  </router-link>
                  <a
                    class="btn btn-danger btn-sm"
                    @click.prevent="deleteBook(book.id)"
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
        <div class="card-footer">
          <!-- <pagination :data="allBooks"></pagination> -->
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
  name: "Books",
  components: {
    VclTable,
    VclInstagram,
  },
  data() {
    return {
      loading: true,
      bulkLoading: false,
      dtTable: null,
      selectedItems: [],
      allSelected: false,
    };
  },
  watch: {
    selectedItems() {
      this.allSelected =
        this.selectedItems.length == this.allBooks.length ? true : false;
    },
  },
  computed: {
    ...mapGetters("books", ["allBooks", "bookObject"]),
  },

  methods: {
     selectAll() {
      if (this.allSelected) {
        this.selectedItems = [];
      } else {

         this.allBooks.forEach((book) => {
          this.selectedItems.push(book.id);
        });
        this.allSelected = true;
      }
    },
    prepareBulkDeleteBooks() {
      this.bulkLoading = true
      this.bulkDeleteBooks(this.selectedItems)
        .then((res) => {
          this.selectedItems = [];
          this.bulkLoading = false
        })
        .catch((err) => {
          this.bulkLoading = false
          console.log(err);
        });
    },
    refreshDatatable() {
      $(document).ready(function () {
        $("#dataTable").DataTable({
          order: [[0, "desc"]],
        });
      });
    },
    ...mapActions("books", ["fetchBooks", "deleteBook", "bulkDeleteBooks"]),
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
    this.fetchBooks()
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
};
</script>
