<template>
  <div>
    <div class="row">
      <div
        class="col-sm-12 offline-div text-center bg-danger text-light"
        style="padding: 16px"
      >
        <span class="lead"
          ><i class="fa fa-power-off"></i> Your are offline</span
        >
      </div>
    </div>
    <div class="content-wrapper mt-5">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="lead display-4">
              <i class="fa fa-plug"></i> You're not connected
            </h1>
            <p>
              And Larabrary just isn't the same without you. Let's get you back
              online!
            </p>
            <b class="ml-3">Try :</b>
            <ul class="mt-2">
              <li>Checking your network cables, modem, and routers</li>
              <li>Reconnecting to your wireless network</li>
              <li>
                <button
                  @click="reload"
                  style="padding: 0"
                  class="btn btn-link"
                >
                  Refresh Page
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    methods:{
        reload(){
            location.reload()
        }
    }
};
</script>
