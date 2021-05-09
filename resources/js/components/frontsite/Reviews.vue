<template>
  <div class="tab-pane fade show" id="nav-review" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="mb-4 mt-1">
      <button
        v-if="!currentUserReview"
        type="button"
        class="btn btn-primary float-right"
        data-toggle="modal"
        data-target="#exampleModal"
        @click="openModal()"
      >
        <i class="fa fa-star"></i> Rate This Book
      </button>

      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header schema-color text-light">
              <h5 class="modal-title" id="exampleModalLabel">Book Rating</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form
                @submit.prevent="(currentUserReview == null ) ? addReview()   : updateReview(review)"
              >
                <input type="hidden" name="book_id" v-model="book.id" />
                <div class="form-group">
                  <label for>Rating</label>
                  <star-rating :star-size="30" v-model="review.rating"></star-rating>
                </div>
                <div class="form-group">
                  <label for>Headline</label>
                  <input
                    type="text"
                    placeholder="Write A headline"
                    class="form-control"
                    v-model="review.headline"
                    value
                  />
                </div>
                <div class="form-group">
                  <label for>Description</label>
                  <textarea
                    placeholder="Tell us More about what you think ..."
                    v-model="review.description"
                    class="form-control"
                    id
                    cols="20"
                    rows="5"
                  ></textarea>
                </div>

                <button
                  v-if="(currentUserReview == null )"
                  class="btn btn-primary-schema btnForm"
                  type="submit"
                >
                  <span class="fa fa-plus"></span>
                  Submit
                </button>

                <button v-else class="btn btn-primary-schema btnForm" type="submit">
                  <span class="fa fa-check"></span>
                  Save
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="currentUserReview" class="chat-body no-padding profile-message">
      <h6 class="text-center lead">Your review</h6>

      <ul style=" word-break: break-all;">
        <li class="message mb-5">
          <span class="message-text">
            <div class="row">
              <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 mt-4">
                <img :src="currentUserReview.user.avatar" class="online" />
              </div>
              <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 mt-4">
                <div class="row">
                  <b>{{currentUserReview.headline}}</b>
                </div>
                <div class="row">{{currentUserReview.description}}</div>
                <div class="row">
                  <a href="#" @click.prevent="editReview" class="mr-2">Edit</a>
                  <a href="#" @click.prevent="deleteReview(currentUserReview.id)">Delete</a>
                </div>
              </div>
              <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <star-rating
                  :show-rating="false"
                  :star-size="14"
                  :read-only="true"
                  :rating="currentUserReview.rating"
                ></star-rating>
              </div>
            </div>
          </span>
          <ul class="list-inline font-xs">
            <li class="pull-right">
              <small class="text-muted pull-right ultra-light mt-2">
                Posted {{currentUserReview.created_at | formatDate}}
                ago By You
              </small>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="chat-body no-padding profile-message">
      <h6 class="text-center lead">what other people think</h6>
      <hr class="mt-4" />
      <ul v-if="reviews.length" style=" word-break: break-all;">
        <li class="message mb-5" :key="review.id" v-for="review in reviews ">
          <span class="message-text">
            <div class="row">
              <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 mt-4">
                <img :src="review.user.avatar" class="online" />
              </div>
              <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 mt-4">
                <div class="row">
                  <b>{{review.headline}}</b>
                </div>
                <div class="row">{{review.description}}</div>
              </div>
              <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <star-rating
                  :show-rating="false"
                  :star-size="14"
                  :read-only="true"
                  :rating="review.rating"
                ></star-rating>
              </div>
            </div>
          </span>
          <ul class="list-inline font-xs">
            <li class="pull-right">
              <small class="text-muted pull-right ultra-light mt-2">
                Posted {{review.created_at | formatDate}}
                ago By {{review.user.name}}
              </small>
            </li>
          </ul>
        </li>
      </ul>
      <div class="container mt-5" v-else>
        <div class="alert alert-info" role="alert">No reviews From other's for this book yet</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    book: Object,
  },
  data() {
    return {
      review: {
        id: "",
        book_id: this.book.id,
        rating: 1,
        headline: "",
        description: "",
      },
      reviews: [],
      currentUserReview: null,
    };
  },
  methods: {
    updateReview(review) {
      $(".btnForm").attr("disabled", "disabled");
      axios
        .put("/review/" + review.id, review)
        .then((res) => {
          this.currentUserReview = Object.assign({}, this.review);
          $("#exampleModal").modal("hide");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    editReview() {
      $(".btnForm").removeAttr("disabled");
      this.review = Object.assign({}, this.currentUserReview);
      $("#exampleModal").modal("show");
    },
    openModal() {
      $(".btnForm").removeAttr("disabled");
      $("#exampleModal").modal("show");
    },
    deleteReview(id) {
      axios
        .delete("/review/" + id)
        .then((res) => {
          this.review = {
            id: "",
            book_id: this.book.id,
            rating: 1,
            headline: "",
            description: "",
          };
          this.currentUserReview = null;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    addReview() {
      $(".btnForm").attr("disabled", "disabled");
      axios
        .post("/review", this.review)
        .then((res) => {
          this.getReviews();
          $("#exampleModal").modal("hide");
        })
        .catch((err) => {
          console.log(err);
          if (err.response.status == 401) {
               toastr["error"]('<h6>Please Login First</h6>');
          }
        });
    },
    getReviews() {
      axios
        .get("/review/book/" + this.book.id)
        .then((res) => {
          this.reviews = res.data.reviews;
          this.currentUserReview = res.data.currentUserReview;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {
    this.getReviews();
  },
};
</script>
<style scoped>
</style>
