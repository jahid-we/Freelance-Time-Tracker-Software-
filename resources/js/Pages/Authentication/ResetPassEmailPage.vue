<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import axios from "axios";

const email = ref("");
const emailError = ref("");

const sentEmail = async () => {
    try {
        const response = await axios.post("reset-password-email", {
            email: email.value,
        });

        if (response.status === 200) {
            emailError.value = "";
            alert("Reset link sent to your email.");
            setTimeout(() => router.visit("/login"), 1000);
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            const validationErrors = error.response.data?.data;
            const firstError = Object.values(validationErrors)[0][0]; // get first validation message
            emailError.value = firstError;
            alert(firstError);
        } else {
            console.error("Error sending reset link:", error);
            alert("Failed to send reset link. Please try again.");
        }
    }
};
// Navigation handlers
const goBack = () => window.history.back();
</script>

<template>
    <div class="d-flex flex-column min-vh-100">
        <div
            class="container d-flex justify-content-center align-items-center flex-grow-1"
        >
            <div class="col-md-6">
                <button
                    @click.prevent="goBack"
                    class="btn btn-outline-dark shadow mb-3"
                >
                    <i class="bi bi-arrow-left"></i> Back
                </button>
                <div class="card shadow w-100">
                    <div class="card-header bg-dark text-white">
                        Reset Password
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                v-model="email"
                                type="email"
                                class="form-control"
                                placeholder="Enter Your Email"
                            />
                            <div v-if="emailError" class="text-danger mt-1">
                                {{ emailError }}
                            </div>
                        </div>

                        <button
                            @click="sentEmail"
                            type="button"
                            class="btn btn-dark w-100"
                        >
                            Send Reset Link
                        </button>

                        <div class="text-center mt-3">
                            Remembered your password?
                            <Link href="/login">Login</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
    </div>
</template>

<style scoped></style>
