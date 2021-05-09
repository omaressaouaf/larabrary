<template>
  <div class="content-wrapper" >


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="display-1">Admin Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div>
        </div>
      </div>

      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <clip-loader color="white" v-if="countLoading"></clip-loader>
              <h3 v-else>{{ ordersCount }}</h3>

              <p>Sales</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-bag"></i>
            </div>
            <router-link :to="{ name: 'orders' }" class="small-box-footer">
              More info
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <clip-loader color="white" v-if="countLoading"></clip-loader>
              <h3 v-else>{{ booksCount }}</h3>
              <p>Books</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <router-link :to="{ name: 'books' }" class="small-box-footer">
              More info
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <clip-loader color="white" v-if="countLoading"></clip-loader>
              <h3 v-else>{{ usersCount }}</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <router-link :to="{ name: 'users' }" class="small-box-footer">
              More info
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <clip-loader color="white" v-if="countLoading"></clip-loader>

              <h3 v-else>{{ genresCount }}</h3>

              <p>Genres</p>
            </div>
            <div class="icon">
              <i class="fa fa-bars"></i>
            </div>
            <router-link :to="{ name: 'genres' }" class="small-box-footer">
              More info
              <i class="fa fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <div class="row" >
        <div class="col-xl-6 col-lg-6">
          <div class="card mb-4">
            <div class="card-header schema-color text-light">
              <i class="fa fa-bar-chart"></i> Columns Chart
            </div>
            <div class="card-body text-center">
              <div v-if="chartLoading">
                <scale-loader color="grey"></scale-loader>
                <span class="text-dark lead">Loading ...</span>
              </div>

              <GChart
                :class="{ invisible: chartLoading }"
                :events="chartEvents"
                type="ColumnChart"
                :data="chartColumnsData"
                :options="chartColumnsOptions"
              />
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="card mb-4">
            <div class="card-header schema-color text-light">
              <i class="fa fa-area-chart"></i> Area Chart
            </div>

            <div class="card-body text-center">
              <div v-if="chartLoading">
                <scale-loader color="grey"></scale-loader>
                <span class="text-dark lead">Loading ...</span>
              </div>

              <GChart
                :class="{ invisible: chartLoading }"
                :events="chartEvents"
                type="AreaChart"
                :data="chartAreaData"
                :options="chartAreaOptions"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import moment from "moment";
export default {
  data() {
    return {
      countLoading: true,
      chartLoading: true,
      ordersCount: 0,
      booksCount: 0,
      usersCount: 0,
      genresCount: 0,
      chartAreaData: [["Month", "Sales"]],
      chartAreaOptions: {
        chart: {
          title: "Company Performance",
          subtitle: "Sales, Expenses, and Profit: 2014-2017",
        },
        sliceVisibilityThreshold: 0.0,
        pieHole: 0.3,
        pieSliceText: "label",
        height: 300,
        width: "100%",
        is3D: true,
        animation: {
          duration: 1000,
          easing: "out",
          startup: true,
        },
      },

      chartColumnsData: [
        [
          "Element",
          "Total",
          {
            role: "style",
          },
        ],
      ],
      chartColumnsOptions: {
        chart: {
          title: "Company Data Total",
        },
        sliceVisibilityThreshold: 0.0,
        pieHole: 0.3,
        pieSliceText: "label",
        height: 300,
        width: "100%",
        is3D: true,
        animation: {
          duration: 1000,
          easing: "out",
          startup: true,
        },
      },
      chartEvents: {
        ready: () => {
          this.chartLoading = false;
          this.$Progress.finish();
        },
      },
    };
  },
  computed: {},

  methods: {
    getCount() {
      axios
        .get("/api/dashboard/count")
        .then((res) => {
          this.ordersCount = res.data.ordersCount;
          this.booksCount = res.data.booksCount;
          this.usersCount = res.data.usersCount;
          this.genresCount = res.data.genresCount;
          this.countLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getCharts() {
      axios
        .get("/api/dashboard/charts")
        .then((res) => {
          this.chartColumnsData.push(
            ["Low Stock", res.data.lowStockCount, "red"],
            ["High Stock", res.data.highStockCount, "green"],
            ["Shipped", res.data.shippedCount, "red"],
            ["Processing", res.data.processingCount, "blue"],
            ["Delivered", res.data.deliveredCount, "green"],
            ["Clients", res.data.clientsCount, "blue"],
            ["Authors", res.data.authorsCount, "orange"],
            ["Admins", res.data.adminsCount, "grey"]
          );
          if (res.data.ordersByMonth.length) {
            res.data.ordersByMonth.forEach((element) => {
              this.chartAreaData.push([element.month, element.total]);
            });
          } else {
            const myDate = new Date();
            const shortMonthName = moment(myDate).format("MMM");
            this.chartAreaData.push([shortMonthName, 0.0]);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },

  created() {
    this.getCount();
    this.getCharts();

  },
};
</script>
<style lang="css">


</style>
