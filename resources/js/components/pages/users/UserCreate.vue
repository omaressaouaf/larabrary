<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="display-1">Manage Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{name : 'dashboard'}">Home</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="{name : 'users'}">Users</router-link>
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
              <h3 class="mb-0">Create account</h3>
            </div>
            <div class="col-4 text-right">
              <router-link :to="{name : 'users'}" class="btn btn-sm btn-warning">
                <i class="fa fa-arrow-left"></i> Discard changes
              </router-link>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form @submit.prevent="createUser">
            <h6 class="heading-small text-muted mb-4">User information</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="input-username">Full name</label>
                    <input
                      type="text"
                      id="input-username"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('name')}"
                      placeholder="Full name"
                      v-model="form.name"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label" for="input-email">Email address</label>
                    <input
                      type="email"
                      id="input-email"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('email')}"
                      placeholder="Email address"
                      v-model="form.email"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label" for="input-password">Password</label>
                    <input
                      type="password"
                      id="input-password"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('password')}"
                      placeholder="Password"
                      v-model="form.password"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="password"></has-error>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4" />
            <!-- Address -->
            <h6 class="heading-small text-muted mb-4">Contact information</h6>
            <div class="pl-lg-4">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group focused">
                    <label class="form-control-label" for="input-phone">Phone</label>
                    <input
                      id="input-phone"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('phone')}"
                      placeholder="Phone number"
                      v-model="form.phone"
                      type="text"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="phone"></has-error>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group focused">
                    <label class="form-control-label" for="input-address">Address</label>
                    <input
                      id="input-address"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('address')}"
                      placeholder="Address "
                      v-model="form.address"
                      type="text"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="address"></has-error>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3">
                  <div class="form-group focused">
                    <label class="form-control-label" for="input-city">City</label>
                    <input
                      type="text"
                      id="input-city"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('city')}"
                      placeholder="City "
                      v-model="form.city"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="city"></has-error>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group focused">
                    <label class="form-control-label" for="input-state">State</label>
                    <input
                      type="text"
                      id="input-state"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('state')}"
                      placeholder="State "
                      v-model="form.state"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="state"></has-error>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group focused">
                    <label class="form-control-label" for="input-country">Country</label>
                    <input
                      type="text"
                      id="input-country"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('country')}"
                      placeholder="Country "
                      v-model="form.country"
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="country"></has-error>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="form-control-label" for="input-country">Postal code</label>
                    <input
                      type="number"
                      id="input-postal-code"
                      v-model="form.zip"
                      class="form-control form-control-alternative"
                      :class="{'is-invalid':form.errors.has('zip')}"
                      placeholder="Postal code "
                      @change="setUnsaved"
                    />
                    <has-error :form="form" field="zip"></has-error>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4" />
            <!-- roles -->
            <h6 class="heading-small text-muted mb-4">User Roles</h6>
            <div class="pl-lg-4">
              <div>
                <label class="typo__label">user Roles</label>
                <has-error :form="form" field="roles"></has-error>
                <multiselect
                  v-model="form.roles"
                  :options="allRoles"
                  :multiple="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :preserve-search="true"
                  placeholder="Pick some Roles"
                  label="name"
                  track-by="name"
                  @change="setUnsaved"
                ></multiselect>
              </div>
              <div v-if="form.roles.length" class="form-group focused mt-2">
                <span
                  :key="role.id"
                  v-for="role in form.roles"
                  class="badge badge-primary ml-2 mr-2"
                >{{role.name}}</span>
              </div>
              <div
                v-if="form.errors.has('roles') && form.roles.length ==0"
                class="alert alert-danger mt-3"
              >
                <span class>
                  <i class="fa fa-exclamation-triangle"></i> No Roles Assigned ! Pick at least one
                </span>
              </div>
            </div>
            <h6 class="heading-small text-muted mb-4 mt-3">User Avatar</h6>
            <div class="pl-lg-4 mb-5">
              <div class="input-group mb-3 mt-2">
                <div class="input-group-prepend" id="inputGroupFileAddon01" style="display: none;">
                  <button type="button" class="input-group-text btn btn-info" @click="cancelAvatar">
                    <i class="fa fa-close mr-2"></i> Cancel
                  </button>
                </div>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control mr-3 @error('avatar')is-invalid @enderror"
                    name="avatar"
                    id="avatar"
                    aria-describedby="inputGroupFileAddon01"
                    onchange="$('#upload-file-info').html(this.files[0].name) ; $('#inputGroupFileAddon01').css('display','block')"
                    @change="onFileChange"
                    :class="{'is-invalid':form.errors.has('avatar')}"
                  />
                  <label
                    class="custom-file-label"
                    style="overflow: hidden;"
                    id="upload-file-info"
                    for="image"
                  >
                    Choose
                    new Avatar
                  </label>
                </div>
              </div>
              <div v-if="form.errors.has('avatar') " class="alert alert-danger mt-3">
                <span class>
                  <i class="fa fa-exclamation-triangle"></i> The avatar should be image (jpg , png) and it should not exceed 9mb
                </span>
              </div>
            </div>
            <!-- Bio -->
            <h6 class="heading-small text-muted mb-4 mt-3">User Bio</h6>
            <div class="pl-lg-4">
              <div class="form-group focused mb-">
                <label>User bio</label>
                <textarea
                  rows="4"
                  class="form-control form-control-alternative"
                  :class="{'is-invalid':form.errors.has('bio')}"
                  v-model="form.bio"
                  placeholder="A few words about The User ..."
                  @change="setUnsaved"
                ></textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>
            </div>
            
            <div class="pl-lg-4">
              <div class="form-group focused">
                <button type="submit" class="btn btn-primary btn-block">
                  <i class="fa fa-plus-circle"></i> Create Account
                </button>
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

export default {
  name: "UserCreate",
  components: {
    VclCode,
  },
  data() {
    return {
      unsavedChanges: false,
      form: new Form({
        id: "",
        name: "",
        email: "",
        phone: "",
        address: "",
        country: "",
        state: "",
        city: "",
        zip: "",
        bio: "",
        roles: [],
        avatar: "",
      }),
      allRoles: [],
    };
  },

  methods: {
    cancelAvatar() {
      $("#avatar").val("");
      $("#upload-file-info").html("Choose new Avatar");
      $("#inputGroupFileAddon01").css("display", "none");
      this.form.avatar = "";
    },
    onFileChange(e) {
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);
      fileReader.onload = (e) => {
        this.form.avatar = e.target.result;
        // console.log(this.form.avatar);
      };
    },
    getAllRoles() {
      axios
        .get("/api/roles")
        .then((res) => {
          this.allRoles = res.data;
        })
        .catch((err) => {
          this.$helpers.handleHttpErrors(err);
        });
    },
    createUser() {
      this.unsavedChanges = false;
      this.$Progress.start();

      this.form
        .post("/api/users")
        .then((res) => {
          this.$Progress.finish();
          toast.fire({
            icon: "success",
            title: "User Created successfully",
          });
          this.$router.push("/admin/users");
        })
        .catch((err) => {
          this.$helpers.handleHttpErrors(err);
          this.$Progress.fail();
        });
    },
    setUnsaved() {
      this.unsavedChanges = true;
    },
  },
  mounted() {
    this.getAllRoles();
    this.$Progress.finish();
  },

  beforeRouteLeave(to, from, next) {
    if (this.unsavedChanges) {
      const answer = window.confirm(
        "Do you really want to leave? you have unsaved changes!"
      );
      if (answer) {
        next();
      } else {
        next(false);
      }
    } else {
      next();
    }
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>