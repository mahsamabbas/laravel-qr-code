<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Home Component</div>

          <div class="card-body">
            Welcome to Homepage
            <br />
            <router-link to="/qr">Go to User</router-link>
          </div>
        </div>
      </div>
    </div>
    <router-view />
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted Example.");
  },
};
</script>
