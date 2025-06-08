<script setup>
import { ref } from 'vue';
import { Link, router } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import axios from 'axios';

const email = ref('');

const sentEmail = async () => {
  try {
    const response = await axios.post('/api/reset-password-email', { email: email.value });
    if (response.status === 200) {
      alert('Reset link sent to your email.');
      setTimeout(() => router.visit('/loginPage'), 1000);
    }
  } catch (error) {
    console.error('Error sending reset link:', error);
    alert('Failed to send reset link. Please try again.');
  }
};
</script>

<template>
  <div class="d-flex flex-column min-vh-100">
    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
      <div class="col-md-6">
        <div class="card shadow w-100">
          <div class="card-header bg-dark text-white">Reset Password</div>

          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input v-model="email" type="email" class="form-control" placeholder="Enter Your Email" />
            </div>

            <button @click="sentEmail" type="button" class="btn btn-dark w-100">Send Reset Link</button>

            <div class="text-center mt-3">
              Remembered your password?
              <Link href="/loginPage">Login</Link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<style scoped>

</style>
