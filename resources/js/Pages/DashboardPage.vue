<script setup>
import { Link } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
import Navbar from "../Components/DashBoardComp/Navbar.vue";
</script>

<template>
    <!-- Navbar -->
    <Navbar />

    <div class="container py-4">
        <h2 class="mb-4"><i class="bi bi-house-door me-2"></i>Dashboard</h2>

        <div class="row g-4">
            <!-- Profile -->
            <div class="col-md-4">
                <div
                    class="card bg-secondary-subtle border-secondary h-100 hover-effect"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-person-circle fs-1 text-secondary"></i>
                        <h5 class="card-title mt-3">Profile</h5>
                        <p class="card-text">
                            Manage your account and password.
                        </p>
                        <Link
                            href="/profile"
                            class="btn hover-effect btn-secondary btn-sm"
                            >Go to Profile</Link
                        >
                    </div>
                </div>
            </div>
            <!-- Clients -->
            <div class="col-md-4">
                <div
                    class="card bg-primary-subtle border-primary h-100 hover-effect"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-people-fill fs-1 text-primary"></i>
                        <h5 class="card-title mt-3">Clients</h5>
                        <p class="card-text">Manage your clients list.</p>
                        <Link
                            href="/client"
                            class="btn hover-effect btn-primary btn-sm"
                            >View Clients</Link
                        >
                    </div>
                </div>
            </div>

            <!-- Projects -->
            <div class="col-md-4">
                <div
                    class="card bg-success-subtle border-success h-100 hover-effect"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-kanban fs-1 text-success"></i>
                        <h5 class="card-title mt-3">Projects</h5>
                        <p class="card-text">
                            Track client projects and statuses.
                        </p>
                        <Link
                            href="/project"
                            class="btn hover-effect btn-success btn-sm"
                            >View Projects</Link
                        >
                    </div>
                </div>
            </div>

            <!-- Time Logs -->
            <div class="col-md-4">
                <div
                    class="card bg-warning-subtle border-warning h-100 hover-effect"
                >
                    <div class="card-body text-center">
                        <i class="bi bi-clock fs-1 text-warning"></i>
                        <h5 class="card-title mt-3">Time Logs</h5>
                        <p class="card-text">
                            Start/end sessions or add manual logs.
                        </p>
                        <Link
                            href="/timeLog"
                            class="btn hover-effect btn-warning btn-sm"
                            >View Time Logs</Link
                        >
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="col-md-4">
                <div class="card bg-info-subtle border-info h-100 hover-effect">
                    <div class="card-body text-center">
                        <i class="bi bi-bar-chart-line fs-1 text-info"></i>
                        <h5 class="card-title mt-3">Reports</h5>
                        <p class="card-text">
                            See summaries by project, client, or day.
                        </p>
                        <Link
                            href="/report"
                            class="btn hover-effect btn-info btn-sm"
                            >View Reports</Link
                        >
                    </div>
                </div>
            </div>

        </div>
    </div>
    <Footer />
</template>

<style scoped>
.hover-effect {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}
</style>
