<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">Home</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'orders' }">Orders</router-link>
              </li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <vcl-table v-if="loading"></vcl-table>

    <section v-else class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <!-- Main content -->
            <div class="invoice p-3" ref="invoice" id="invoice">
              <!-- title row -->
              <div class="row mb-3">
                <div class="col-12">
                  <h4 class="text-info">
                    <i class="fa fa-book"></i> Larabrary.com
                    <small class="float-right"
                      >Date: {{ date | formatDate }}</small
                    >
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br />
                    795 Folsom Ave, Suite 600<br />
                    San Francisco, CA 94107<br />
                    Phone: (804) 123-5432<br />
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>{{ orderObject.billing_full_name }}</strong
                    ><br />
                    {{ orderObject.billing_address }}<br />
                    {{ orderObject.billing_country }} /
                    {{ orderObject.billing_state }} /
                    {{ orderObject.billing_city }} , {{ orderObject.billing_zip
                    }}<br />
                    Phone: {{ orderObject.billing_phone }}<br />
                    Email: {{ orderObject.billing_email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Order Number:</b> {{ orderObject.id }}<br />
                  <b>Payment Due:</b> {{ orderObject.created_at | formatDate
                  }}<br />
                  <b>Account Id:</b> {{ orderObject.user_id }} <br />

                  <h4>
                    Status :
                    <span class="badge" :class="bindStatusClass(orderObject)">{{
                      orderObject.status
                    }}</span>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Qty</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="book in allOrderDetails" :key="book.id">
                        <td>{{ book.pivot.quantity }}</td>
                        <td>{{ book.title }}</td>
                        <td>
                          {{ book.description }}
                        </td>
                        <td>${{ book.pivot.book_subtotal }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6 mt-3">
                  <div class="flex-sm-col col-auto">
                    <p class="lead text-info">Payment Method:</p>
                    <p class="mb-1">
                      <i class="fa fa-circle text-muted"></i>
                      {{
                        orderObject.payment_mode == "cash"
                          ? "Cash on delivery"
                          : "Credit / Debit Card"
                      }}
                    </p>
                  </div>
                  <div
                    class="flex-sm-col col-auto mt-3"
                    v-if="orderObject.payment_mode == 'stripe'"
                  >
                    <p class="lead text-info">Card Holder Name :</p>
                    <p class="mb-1">
                      <i class="fa fa-circle text-muted"></i>
                      {{ orderObject.billing_card_holder_name }}
                    </p>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width: 50%">Discount:</th>
                        <td class="text-success">
                          -${{ orderObject.billing_discount }}
                        </td>
                      </tr>

                      <tr>
                        <th style="width: 50%">Subtotal:</th>
                        <td>${{ orderObject.billing_subtotal }}</td>
                      </tr>
                      <tr>
                        <th>Tax (38%)</th>
                        <td class="text-danger">
                          ${{ orderObject.billing_tax }}
                        </td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td class="text-success">Free</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td class="lead text-bold">
                          ${{ orderObject.billing_total }}
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
            </div>
            <!-- /.invoice -->
            <div class="row no-print mt-3 mb-2">
              <div class="col-12">
                <button

                  target="_blank"
                  class="btn btn-primary"
                  @click="print"
                  ><i class="fa fa-print"></i> Print</button
                >

                <button
                  type="button"
                  class="btn btn-danger float-right"
                  style="margin-right: 5px"
                  @click="download($event)"
                >
                  <i class="fa fa-download"></i> Generate PDF
                </button>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
// import html2canvas from "html2canvas";
import { VclTable, VclInstagram } from "vue-content-loading";
import { mapGetters, mapActions } from "vuex";

export default {
  name: "OrderInvoice",
  components: {
    VclTable,

  },
  data() {
    return {
      loading: true,
      date: new Date(),
    };
  },
  computed: {
    ...mapGetters("orders", ["orderObject", "allOrderDetails"]),
  },

  methods: {
    bindStatusClass(order) {
      if (order.status == "processing") {
        return "badge-danger";
      } else if (order.status == "shipped") {
        return "badge-warning";
      } else {
        return "badge-success";
      }
    },
    print() {
      window.print();
    },
    download(event) {
      //   // using jsPDF and html2canvas combined
      //   html2canvas(document.getElementById("invoice"), {
      //     imageTimeout: 5000,
      //     useCORS: true,
      //   }).then((canvas) => {
      //     document.getElementById("pdf").appendChild(canvas);
      //     let img = canvas.toDataURL("image/png");
      //     let pdf = new jsPDF("portrait", "mm", "a4");
      //     pdf.addImage(img, "JPEG", 5, 5, 200, 287);
      //     pdf.save("test.pdf");
      //     document.getElementById("pdf").innerHTML = "";
      //   });
      //   using html2pdf library
      event.target.disabled = true;
      event.target.innerHTML =
        "<i class='fa fa-spinner  fa-spin'></i> Generating PDF ";

      var element = document.getElementById("invoice");
      var opt = {
        margin: 0,
        filename: 'Order '+ this.orderObject.id + ' Invoice.pdf'  ,
        image: { type: "jpeg", quality: 1 },
        html2canvas: { scale: 2 },
        jsPDF: {
          unit: "mm",
          orientation: "landscape",
          pagesplit: true,
        },
      };
      html2pdf(element, opt);
      event.target.disabled = false;
      event.target.innerHTML = "<i class='fa fa-download'></i> Generate PDF";
    },
    ...mapActions("orders", ["fetchOrderDetails"]),
  },
  mounted() {
    this.fetchOrderDetails(this.$route.params.id)
      .then((res) => {
        this.$Progress.finish();
        this.loading = false;
      })
      .catch((err) => {
        this.$helpers.handleHttpErrors(err);
      });
  },
};
</script>

<style>
</style>
