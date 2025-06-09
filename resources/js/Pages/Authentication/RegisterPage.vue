<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import Footer from "@/Components/Footer.vue";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const nameError = ref("");
const emailError = ref("");
const passwordError = ref("");

const handleRegister = async () => {
    if (
        name.value === "" ||
        email.value === "" ||
        password.value === "" ||
        confirmPassword.value === ""
    ) {
        alert("Please fill in all fields.");
        return;
    }
    if (password.value !== confirmPassword.value) {
        alert("Passwords do not match.");
        return;
    }
    if (password.value.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
    }
    try {
        const response = await axios.post("/api/register", {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: confirmPassword.value,
        });

        if (response.status === 201) {
            nameError.value = "";
            emailError.value = "";
            passwordError.value = "";
            setTimeout(() => router.visit("/loginPage"), 1000);
            alert("Registration successful.");
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const errors = error.response.data?.data;

            nameError.value = errors.name ? errors.name[0] : "";
            emailError.value = errors.email ? errors.email[0] : "";
            passwordError.value = errors.password ? errors.password[0] : "";

            const firstError = Object.values(errors)[0][0]; // first message
            alert(firstError);
        } else {
            console.error("Error during registration:", error);
            alert("Registration failed. Please try again.");
        }
    }
};
// Navigation handlers
const goBack = () => window.history.back();
</script>

<template>
    <div class="d-flex flex-column min-vh-100">
        <!-- Full height container -->
        <div
            class="container d-flex justify-content-center align-items-center flex-grow-1"
        >
            <!-- Main content container that takes available space -->
            <div class="col-md-6">
                <button
                    @click.prevent="goBack"
                    class="btn btn-outline-dark shadow mb-3"
                >
                    <i class="bi bi-arrow-left"></i> Back
                </button>
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">Register</div>

                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input
                                    type="text"
                                    v-model="name"
                                    class="form-control"
                                    placeholder="Name"
                                />
                                <div v-if="nameError" class="text-danger mt-1">
                                    {{ nameError }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    v-model="email"
                                    class="form-control"
                                    placeholder="Email"
                                />
                                <div v-if="emailError" class="text-danger mt-1">
                                    {{ emailError }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    v-model="password"
                                    class="form-control"
                                    placeholder="Password"
                                />
                                <div
                                    v-if="passwordError"
                                    class="text-danger mt-1"
                                >
                                    {{ passwordError }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"
                                    >Confirm Password</label
                                >
                                <input
                                    type="password"
                                    v-model="confirmPassword"
                                    class="form-control"
                                    placeholder="Confirm Password"
                                />
                            </div>

                            <button
                                @click.prevent="handleRegister()"
                                class="btn btn-dark w-100"
                            >
                                Register
                            </button>

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
