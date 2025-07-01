<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

import UserInfoUpdateModal from "./UserInfoUpdateModal.vue";
import UpdatePasswordModal from "./UpdatePasswordModal.vue";

const form = ref({
    name: "",
    email: "",
});

const fetchUserProfile = async () => {
    try {
        const response = await axios.get("/get-user-profile");
        if (response.status === 200) {
            form.value.name = response.data.data.name;
            form.value.email = response.data.data.email;
        }
    } catch (error) {
        console.error("Error fetching user profile:", error);
    }
};

const showUpdateModal = ref(false);
const handleUpdateProfile = () => {
    showUpdateModal.value = true;
};

const showPasswordModal = ref(false);
const handleUpdatePassword = () => {
    showPasswordModal.value = true;
};

// Navigation functions
const projectPage = () => router.visit("/project");
const timeLogPage = () => router.visit("/timeLog");
const clientPage = () => router.visit("/client");
const reportPage = () => router.visit("/report");

onMounted(() => {
    fetchUserProfile();
});
</script>

<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="container mb-2 d-flex justify-content-center">
                    <div class="col-md-8">
                        <div
                            class="alert alert-secondary text-center shadow"
                            role="alert"
                        >
                            📢 <strong>Note:</strong> Use the buttons below to
                            manage your profile and navigate between sections.
                            You can also export PDF reports from the Reports
                            page.
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-lg-6">
                    <!-- Navigation buttons -->
                    <div class="mb-4">
                        <button
                            @click.prevent="clientPage()"
                            class="btn btn-primary shadow me-2 mb-2"
                        >
                            <i class="bi bi-people-fill"></i> Clients
                        </button>
                        <button
                            @click.prevent="projectPage()"
                            class="btn btn-success shadow me-2 mb-2"
                        >
                            <i class="bi bi-kanban"></i> Projects
                        </button>
                        <button
                            @click.prevent="timeLogPage()"
                            class="btn btn-warning shadow me-2 mb-2"
                        >
                            <i class="bi bi-clock"></i> Time Logs
                        </button>
                        <button
                            @click.prevent="reportPage()"
                            class="btn btn-info shadow me-2 mb-2"
                        >
                            <i class="bi bi-bar-chart-line"></i> Reports
                        </button>
                    </div>

                    <div class="card shadow bg-secondary-subtle">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-person-circle me-2"></i>
                                User Profile Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        id="name"
                                        class="form-control"
                                        v-model="form.name"
                                        readonly
                                    />
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label"
                                        >Email address</label
                                    >
                                    <input
                                        type="email"
                                        id="email"
                                        class="form-control"
                                        v-model="form.email"
                                        readonly
                                    />
                                </div>

                                <button
                                    @click.prevent="handleUpdateProfile()"
                                    type="button"
                                    class="btn btn-outline-secondary shadow me-2 mt-2"
                                >
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Update Profile
                                </button>
                                <button
                                    @click.prevent="handleUpdatePassword()"
                                    type="button"
                                    class="btn btn-light shadow mt-2"
                                >
                                    <i class="bi bi-key me-1"></i>
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <UserInfoUpdateModal
            :visible="showUpdateModal"
            @cancel="showUpdateModal = false"
            @updated="
                () => {
                    showUpdateModal = false;
                    fetchUserProfile();
                }
            "
        />

        <UpdatePasswordModal
            :visible="showPasswordModal"
            @cancel="showPasswordModal = false"
        />
    </div>
</template>

<style scoped>
/* Adjust spacing for layout clarity */
</style>
