<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import Footer from "@/Components/Footer.vue";

const props = defineProps({
    token: String,
});

const token = ref(props.token);

const newPassword = ref("");
const confirmPassword = ref("");

const updatePassword = async () => {
    if (newPassword.value !== confirmPassword.value) {
        alert("Passwords do not match.");
        return;
    }

    try {
        const response = await axios.post("/api/reset-password", {
            token: token.value,
            password: newPassword.value,
            password_confirmation: confirmPassword.value,
        });

        if (response.status === 200) {
            alert("Password updated successfully.");
            setTimeout(() => router.visit("/login"), 1000);
        }
    } catch (error) {
        console.error("Error updating password:", error);
        alert("Failed to update password. Please try again.");
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
                            <input
                                type="text"
                                v-model="token"
                                hidden
                                class="form-control"
                            />
                            <label class="form-label">New Password</label>
                            <input
                                type="password"
                                v-model="newPassword"
                                class="form-control mb-4"
                                placeholder="New Password"
                            />
                            <label class="form-label">Confirm Password</label>
                            <input
                                type="password"
                                v-model="confirmPassword"
                                class="form-control mb-4"
                                placeholder="Confirm Password"
                            />
                        </div>

                        <button
                            @click.prevent="updatePassword()"
                            class="btn btn-dark w-100"
                        >
                            Update Password
                        </button>

                        <div class="text-center mt-4 mb-3">
                            Remembered your password?
                            <Link href="/login">Login</Link> <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<style scoped></style>
