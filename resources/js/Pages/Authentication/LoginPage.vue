<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";

import NavBar from "../../Components/HomeComp/NavBar.vue";
import Footer from "@/Components/Footer.vue";

const email = ref("");
const password = ref("");
const remember = ref(false);

const emailError = ref("");
const passwordError = ref("");

const handleLogin = async () => {
    if (!email.value || !password.value) {
        alert("Please fill in all fields.");
        return;
    }
    try {
        const response = await axios.post("/login", {
            email: email.value,
            password: password.value,
            remember: remember.value,
        },{withCredentials: true});
        if (response.status === 200) {
            emailError.value = "";
            passwordError.value = "";
            setTimeout(() => {
                router.visit("/dashboard");
            }, 1000);
            alert("Login successful!");
        } else {
            alert("Login failed. Please check your credentials.");
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const errors = error.response.data?.data;

            emailError.value = errors.email ? errors.email[0] : "";
            passwordError.value = errors.password ? errors.password[0] : "";

            const firstError = Object.values(errors)[0][0];
            alert(firstError);
        } else if (error.response && error.response.status === 401) {
            alert("Invalid credentials. Please try again.");
        } else {
            console.error("Login error:", error);
            alert("Login failed. Please try again.");
        }
    }
};
// Navigation handlers
const goBack = () => window.history.back();
</script>

<template>
    <div class="d-flex flex-column min-vh-100">
        <!-- Full height container -->
        <NavBar />
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
                    <div class="card-header bg-dark text-white">Login</div>

                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    v-model="email"
                                    class="form-control"
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
                                />
                                <div
                                    v-if="passwordError"
                                    class="text-danger mt-1"
                                >
                                    {{ passwordError }}
                                </div>
                            </div>

                            <div
                                class="d-flex justify-content-between align-items-center mb-3"
                            >
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        v-model="remember"
                                        class="form-check-input"
                                        value="true"
                                        id="remember"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="remember"
                                        >Remember Me</label
                                    >
                                </div>
                                <Link href="/reset-link" class="small px-2"
                                    >Forgot Password?</Link
                                >
                            </div>

                            <button
                                type="submit"
                                @click.prevent="handleLogin()"
                                class="btn btn-dark w-100"
                            >
                                Login
                            </button>

                            <div class="text-center mt-3">
                                Don't have an account?
                                <Link href="/registerPage">Register</Link>
                                <br />
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
