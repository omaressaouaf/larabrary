<template>
  <div
    class="modal fade"
    id="orderDetailsModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="orderDetailsModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header schema-color text-white">
          <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card card-1">
            <div class="card-header schema-color text-white">
              <div
                class="media flex-sm-row flex-column-reverse justify-content-between"
              >
                <div class="col my-auto">
                  <h4 class="float-left">Order Id : {{ order.id }}</h4>
                </div>
                <div class="col-auto text-center my-auto pl-0 pt-sm-4">
                  <img
                    class="img-fluid my-auto align-items-center mb-0 pt-3"
                    src="/storage/images/design/logos/mylogo.png"
                    width="115"
                    height="115"
                  />
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row justify-content-between mb-3">
                <label for="" class="lead text-info">Edit Order Staus</label>
                <select
                  class="form-control"
                  v-model="orderObject.status"
                  @change="updateOrder(orderObject)"
                  id=""
                  :class="{
                    'is-invalid': orderObject.errors.has('status'),
                  }"
                >
                  <option value disabled selected>Select Status</option>
                  <option value="shipped">
                    <span class="badge">shipped</span>
                  </option>
                  <option value="processing">
                    <span class="badge">processing</span>
                  </option>
                  <option value="delivered">
                    <span class="badge">delivered</span>
                  </option>
                </select>
                <has-error :form="orderObject" field="status"></has-error>
              </div>
              <div class="row justify-content-between mb-3">
                <div class="col-auto">
                  <h6 class="color-1 mb-0 change-color">
                    Total Books in order is {{ allOrderDetails.length }}
                  </h6>
                </div>
                <div class="col-auto">
                  <small>Receipt Voucher : 1KAU9-84UIL</small>
                </div>
              </div>

              <div
                class="row mb-3"
                v-for="book in allOrderDetails"
                :key="book.id"
              >
                <div class="col">
                  <div class="card card-2">
                    <div class="card-body">
                      <div class="media">
                        <div class="sq align-self-center">
                          <img
                            :src="
                              book.images[0]
                                ? book.images[0].name
                                : '/storage/images/books/noimagebook.svg'
                            "
                            class="img-fluid my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                            width="135"
                            height="135"
                          />
                        </div>
                        <div class="media-body my-auto text-right">
                          <div class="row my-auto flex-column flex-md-row">
                            <div class="col my-auto">
                              <h6 class="mb-0">{{ book.title }}</h6>
                            </div>
                            <div></div>
                            <div class="col-auto my-auto">
                              <small>by {{ book.user.name }} </small>
                            </div>

                            <div class="col my-auto">
                              <small>Qty : {{ book.pivot.quantity }}</small>
                            </div>
                            <div class="col my-auto">
                              <h6 class="mb-0">
                                ${{ book.pivot.book_subtotal }}
                              </h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="my-3" />
                      <div class="row">
                        <div class="col-md-3 mb-3">
                          <small>
                            Track Order
                            <span
                              ><i
                                class="ml-2 fa fa-refresh"
                                aria-hidden="true"
                              ></i></span
                          ></small>
                        </div>
                        <div class="col mt-auto">
                          <div class="progress my-auto">
                            <div
                              class="progress-bar progress-bar rounded"
                              style="width: 62%"
                              role="progressbar"
                              aria-valuenow="25"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-md-7">
                  <p class="mb-1 text-success"><b>Order Details </b></p>
                  <p class="mb-1">
                    <b> Billing Email </b>: {{ order.billing_email }}
                  </p>
                  <p class="mb-1">
                    <b> Billing Full name </b>: {{ order.billing_full_name }}
                  </p>
                  <p class="mb-1">
                    <b> Billing Phone Number </b>: {{ order.billing_phone }}
                  </p>
                  <p class="mb-1">
                    <b> Billing Address </b>: {{ order.billing_country }} ,{{
                      order.billing_state
                    }},{{ order.billing_city }} <br />{{
                      order.billing_address
                    }}
                    , ZIP : {{ order.billing_zip }}
                  </p>
                </div>

                <div class="col md-5">
                  <div class="row justify-content-between">
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1 text-success"><b>Payment</b></p>
                    </div>
                  </div>
                  <div class="row justify-content-between">
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1"><b>Total</b></p>
                    </div>
                    <div class="flex-sm-col col-auto">
                      <p class="mb-1">${{ order.billing_total }}</p>
                    </div>
                  </div>
                  <div class="row justify-content-between">
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1"><b>Discount</b></p>
                    </div>
                    <div class="flex-sm-col col-auto">
                      <p class="mb-1">${{ order.billing_discount }}</p>
                    </div>
                  </div>
                  <div class="row justify-content-between">
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1"><b>GST 38%</b></p>
                    </div>
                    <div class="flex-sm-col col-auto">
                      <p class="mb-1">${{ order.billing_tax }}</p>
                    </div>
                  </div>
                  <div class="row justify-content-between">
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1"><b>Delivery Charges</b></p>
                    </div>
                    <div class="flex-sm-col col-auto">
                      <p class="mb-1">Free</p>
                    </div>
                  </div>
                  <div class="row justify-content-between">
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1"><b>Payment Method</b></p>
                    </div>
                    <div class="flex-sm-col col-auto">
                      <p class="mb-1">
                        {{
                          order.payment_mode == "cash"
                            ? "Cash on delivery"
                            : "Credit / Debit Card"
                        }}
                      </p>
                    </div>
                  </div>

                  <div
                    v-if="order.payment_mode == 'stripe'"
                    class="row justify-content-between"
                  >
                    <div class="flex-sm-col text-right col">
                      <p class="mb-1"><b>Card Holder Name</b></p>
                    </div>
                    <div class="flex-sm-col col-auto">
                      <p class="mb-1">{{ order.billing_card_holder_name }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer schema-color text-white">
              <div class="jumbotron-fluid">
                <div class="row justify-content-between">
                  <div class="col-sm-auto col-auto my-auto">
                    <img
                      class="img-fluid my-auto align-self-center"
                      src="/storage/images/design/logos/mylogo.png"
                      width="115"
                      height="115"
                    />
                  </div>
                  <div class="col-auto my-auto">
                    <h2 class="mb-0 font-weight-bold text-success">
                      TOTAL PAID
                    </h2>
                  </div>
                  <div class="col-auto my-auto ml-auto">
                    <h1 class="display-3">${{ order.billing_total }}</h1>
                  </div>
                </div>

                <div class="row mb-3 mt-3 mt-md-0">
                  <div class="col-auto border-line">
                    <small class="text-white">PAN:AA02hDW7E</small>
                  </div>
                  <div class="col-auto border-line">
                    <small class="text-white">CIN:UMMC20PTC </small>
                  </div>
                  <div class="col-auto">
                    <small class="text-white">GSTN:268FD07EXX </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "OrderDetails",
  props: ["order"],
  data() {
    return {};
  },
  computed: {
    ...mapGetters("orders", ["allOrderDetails", "orderObject"]),
  },
  methods: {
    ...mapActions("orders", ["fetchOrderDetails", "updateOrder"]),
  },
};
</script>

<style scoped>
p {
  font-size: 14px !important;
  margin-bottom: 7px !important;
}

.small {
  letter-spacing: 0.5px !important;
}

.card-1 {
  transition: 0.19s;
}

.card-1:hover {
  box-shadow: 2px 2px 15px 0px #01060c !important;
}

hr {
  background-color: rgba(248, 248, 248, 0.667) !important;
}

.bold {
  font-weight: 500 !important;
}

.change-color {
  color: #042d57 !important;
}

.card-2 {
  box-shadow: 1px 1px 3px 0px rgb(112, 115, 139) !important;
}

.fa-circle.active {
  font-size: 8px !important;
  color: #042d57 !important;
}

.fa-circle {
  font-size: 8px !important;
  color: #aaa !important;
}

.rounded {
  border-radius: 2.25rem !important;
}

.progress-bar {
  background-color: #042d57 !important;
}

.progress {
  height: 5px !important;
  margin-bottom: 0 !important;
}

.invoice {
  position: relative !important;
  top: -108px;
}

.Glasses {
  position: relative !important;
  top: -12px !important;
}

h4 {
  font-family: sans-serif !important;
  font-weight: 20 !important;
}

.display-3 {
  font-weight: 500 !important;
}

@media (max-width: 479px) {
  .invoice {
    position: relative;
    top: 7px;
  }

  .border-line {
    border-right: 0px solid rgb(226, 206, 226) !important;
  }
}

@media (max-width: 700px) {
  h2 {
    color: rgb(124, 7, 145) !important;
    font-size: 17px !important;
  }

  .display-3 {
    font-size: 28px !important;
    font-weight: 500 !important;
  }
}

.card-footer small {
  letter-spacing: 7px !important;
  font-size: 12px;
}

.border-line {
  border-right: 1px solid rgb(226, 206, 226);
}
</style>
