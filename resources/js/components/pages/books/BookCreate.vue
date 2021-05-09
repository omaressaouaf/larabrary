<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="display-1">Manage Books</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">Home</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'books' }">Books</router-link>
              </li>
              <li class="breadcrumb-item active">Create</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content">
      <!-- Default box -->
      <div class="card shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Create Book</h3>
            </div>
            <div class="col-4 text-right">
              <router-link
                :to="{ name: 'books' }"
                class="btn btn-sm btn-warning"
              >
                <i class="fa fa-arrow-left"></i> Discard changes
              </router-link>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form @submit.prevent="addBook(bookObject)">
            <h6 class="heading-small text-muted mb-4">Book information</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="input-title">Title</label>
                    <input
                      type="text"
                      id="input-title"
                      class="form-control form-control-alternative"
                      :class="{ 'is-invalid': bookObject.errors.has('title') }"
                      placeholder="Book Title"
                      v-model="bookObject.title"
                    />
                    <has-error :form="bookObject" field="title"></has-error>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="input-slug">Slug</label>
                    <input
                      type="text"
                      id="input-slug"
                      class="form-control form-control-alternative"
                      :class="{ 'is-invalid': bookObject.errors.has('slug') }"
                      placeholder="Book Slug"
                      v-model="bookObject.slug"
                    />
                    <has-error :form="bookObject" field="slug"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="input-price">Price</label>
                    <input
                      type="number"
                      step="0.01"
                      id="input-price"
                      class="form-control form-control-alternative"
                      :class="{ 'is-invalid': bookObject.errors.has('price') }"
                      placeholder="Book Price"
                      v-model="bookObject.price"
                    />
                    <has-error :form="bookObject" field="price"></has-error>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="input-stock">Stock</label>
                    <input
                      type="number"
                      id="input-stock"
                      class="form-control form-control-alternative"
                      :class="{ 'is-invalid': bookObject.errors.has('stock') }"
                      placeholder="Book Stock"
                      v-model="bookObject.stock"
                    />
                    <has-error :form="bookObject" field="stock"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <div>
                      <label class="typo__label">Book Genres</label>

                      <multiselect
                        v-model="bookObject.genres"
                        :options="allGenres"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        placeholder="Pick some Genres"
                        label="name"
                        track-by="name"
                      ></multiselect>
                    </div>
                    <div
                      v-if="bookObject.genres.length"
                      class="form-group focused mt-2"
                    >
                      <span
                        :key="genre.id"
                        v-for="genre in bookObject.genres"
                        class="badge badge-primary ml-2 mr-2"
                        >{{ genre.name }}</span
                      >
                    </div>
                    <div
                      v-if="
                        bookObject.errors.has('genres') &&
                        bookObject.genres.length == 0
                      "
                      class="alert alert-danger mt-3"
                    >
                      <span class>
                        <i class="fa fa-exclamation-triangle"></i> No Genres
                        Assigned ! Pick at least one
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="typo__label">Book Author</label>
                    <select
                      :class="{
                        'is-invalid': bookObject.errors.has('user_id'),
                      }"
                      class="form-control"
                      v-model="bookObject.user_id"
                      id
                    >
                      <option value disabled selected>Select An Author</option>
                      <option
                        v-for="author in allAuthors"
                        :key="author.id"
                        :value="author.id"
                      >
                        {{ author.name }}
                      </option>
                    </select>
                    <has-error :form="bookObject" field="user_id"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="typo__label">Book Images</label>
                    <div class="custom-file">
                      <input
                        type="file"
                        id="file"
                        class="custom-file-input form-control mr-3"
                        aria-describedby="inputGroupFileAddon01"
                        @change="onFileChange"
                        :class="{ 'is-invalid': newImagesHaveErrors }"
                        multiple
                      />
                      <label
                        class="custom-file-label"
                        style="overflow: hidden"
                        id="upload-file-info"
                        for="image"
                      >
                        Choose Multipe Images
                      </label>
                    </div>
                    <div
                      v-if="newImagesHaveErrors"
                      class="alert alert-danger mt-3"
                    >
                      <span class>
                        <i class="fa fa-exclamation-triangle"></i> Selected
                        Files should be images (jpg ,jpeg , png ) and they
                        should not exceed 9mb
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <span v-for="(image, index) in urls" :key="index">
                      <img
                        class="img-fluid"
                        :src="image"
                        width="80"
                        height="80"
                        alt="no Image"
                      />
                      <button
                        type="button"
                        @click="removeNewFile(index)"
                        class="btn btn-danger mr-1"
                      >
                        <i class="fa fa-times-circle"></i>
                      </button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Book Description</label>
                    <textarea
                      rows="4"
                      class="form-control form-control-alternative"
                      :class="{
                        'is-invalid': bookObject.errors.has('description'),
                      }"
                      v-model="bookObject.description"
                      placeholder="A small description about The Book ..."
                    ></textarea>
                    <has-error
                      :form="bookObject"
                      field="description"
                    ></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-12">
                  <button
                    type="submit"
                    class="btn btn-primary btn-block submitBook"
                  >
                    <i class="fa fa-plus-circle"></i> Add Book
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
import { VclCode } from "vue-content-loading";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "BookCreate",
  components: {
    VclCode,
  },
  data() {
    return {
      urls: [],
    };
  },
  computed: {
    newImagesHaveErrors() {
      for (let i = 0; i < 5; i++) {
        if (this.bookObject.errors.has("newImages" + "." + i)) {
          return true;
        }
      }
      return false;
    },
    ...mapGetters("books", ["bookObject", "allGenres", "allAuthors"]),
  },

  methods: {
    removeNewFile(index) {
      this.$delete(this.bookObject.newImages, index);
      this.$delete(this.urls, index);
      $("#file").val("");
    },
    onFileChange(e) {
      let selectedFiles = e.target.files;
      if (!selectedFiles.length) {
        return false;
      }

      for (let i = 0; i < selectedFiles.length; i++) {
        var fileReader = new FileReader();
        fileReader.readAsDataURL(selectedFiles[i]);
        this.urls.push(URL.createObjectURL(selectedFiles[i]));
        fileReader.onload = (e) => {
          this.bookObject.newImages.push(e.target.result);
        };
      }
      $("#file").val("");
    },
    ...mapActions("books", ["addBook", "fetchGenres", "fetchAuthors"]),
  },
  created() {
    this.fetchGenres();
    this.fetchAuthors();
    this.$Progress.finish();
  },
  beforeRouteLeave(to, from, next) {
    this.bookObject.reset();
    this.bookObject.clear();
    next();
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>