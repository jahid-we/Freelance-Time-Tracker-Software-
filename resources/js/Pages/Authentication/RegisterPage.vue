<script setup>
import { ref } from 'vue';
import { Link, router } from "@inertiajs/vue3";
import axios  from "axios";
import Footer from "@/Components/Footer.vue";

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');

const handleRegister = async () => {
    if( name.value === '' || email.value === '' || password.value === '' || confirmPassword.value === '') {
        alert('Please fill in all fields.');
        return;
    }
    if (password.value !== confirmPassword.value) {
        alert('Passwords do not match.');
        return;
    }
    if (password.value.length < 6) {
        alert('Password must be at least 6 characters long.');
        return;
    }
    try {
        const response = await axios.post('/api/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: confirmPassword.value
        });

        if (response.status === 201) {
            setTimeout(() => router.visit('/loginPage'), 1000);
            alert('Registration successful.');
        }
    } catch (error) {
        console.error('Error during registration:', error);
        alert('Registration failed. Please try again.');
    }
}
</script>

<template>
  <div class="d-flex flex-column min-vh-100"> <!-- Full height container -->
    <div class="container d-flex justify-content-center align-items-center  flex-grow-1"> <!-- Main content container that takes available space -->
        <div class="col-md-6">
          <div class="card shadow">
            <div class="card-header bg-dark text-white">Register</div>

            <div class="card-body">
              <form>
                <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" v-model="name" class="form-control" placeholder="Name" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" v-model="email" class="form-control" placeholder="Email"/>
                </div>

                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" v-model="password" class="form-control" placeholder="Password"/>
                </div>

                <div class="mb-3">
                  <label class="form-label">Confirm Password</label>
                  <input type="password" v-model="confirmPassword" class="form-control" placeholder="Confirm Password" />
                </div>

                <button  @click.prevent="handleRegister()" class="btn btn-dark w-100">Register</button>

                <div class="text-center mt-3">
                  Already have an account?
                  <Link href="/loginPage">Login</Link>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<style scoped>
/* Optional styling */
</style>
