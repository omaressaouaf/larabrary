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
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content" >
      <!-- Default box -->

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Orders Data</h3>

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
            class="table table-striped table-hover projects"
          >
            <thead class="schema-color text-white text-muted">
              <tr>
                <th style="width: 1%">Id</th>
                <th style="width: 15%">User Id</th>
                <th style="width: 20%">Status</th>
                <th style="width: 15%">On</th>
                <th style="width: 35%" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="5">
                  <vcl-table
                    :speed="1"
                    :rtl="true"
                    primary="#6a737c"
                  ></vcl-table>
                </td>
              </tr>
              <tr v-else v-for="order in allOrders" :key="order.id">
                <td>{{ order.id }}</td>
                <td>{{ order.user_id }} ({{ order.user.email }})</td>
                <td>
                  <span class="badge" :class="bindStatusClass(order)">{{
                    order.status
                  }}</span>
                </td>
                <td>{{ order.created_at | formatDate }}</td>

                <td class="project-actions text-right">
                  <router-link
                    class="btn btn-success btn-sm"
                    :to="{
                      name: 'orders.invoice',
                      params: { id: order.id },
                    }"
                  >
                    Invoice
                  </router-link>
                  <button
                    class="btn btn-info btn-sm"
                    @click.prevent="openDetailsModal($event, order)"
                  >
                    Details
                  </button>
                  <a
                    class="btn btn-danger btn-sm"
                    @click.prevent="deleteOrder(order.id)"
                    href="#"
                  >
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <order-details :order="selectedOrder"></order-details>
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
import OrderDetails from "./OrderDetails.vue";
export default {
  name: "Orders",
  components: {
    VclTable,
    VclInstagram,
    OrderDetails,
  },
  data() {
    return {
      loading: true,
      dtTable: null,
      selectedOrder: "",
    };
  },
  computed: {
    ...mapGetters("orders", ["allOrders"]),
  },

  methods: {
    openDetailsModal(event, order) {
      event.target.disabled = true;
      event.target.innerHTML = "<i class='fa fa-spinner  fa-spin'></i> Loading";
      this.selectedOrder = order;
      this.fetchOrderDetails(order.id)
        .then((res) => {
          this.fetchOrderFromTableForStatus(this.selectedOrder);
          $("#orderDetailsModal").modal("show");

          event.target.disabled = false;
          event.target.innerHTML = "Details";
        })
        .catch((err) => {

          event.target.disabled = false;
          event.target.innerHTML = "Details";
          this.$helpers.handleHttpErrors(err);
        });
    },
    bindStatusClass(order) {
      if (order.status == "processing") {
        return "badge-danger";
      } else if (order.status == "shipped") {
        return "badge-warning";
      } else {
        return "badge-success";
      }
    },
    refreshDatatable() {
      $(document).ready(function () {
        $("#dataTable").DataTable({
          order: [[0, "desc"]],
        });
      });
    },
    ...mapActions("orders", [
      "fetchOrders",
      "deleteOrder",
      "fetchOrderDetails",
      "fetchOrderFromTableForStatus",
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
    this.fetchOrders()
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
