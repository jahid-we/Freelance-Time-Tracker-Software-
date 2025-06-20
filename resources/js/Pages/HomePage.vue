<script setup>
const props = defineProps({
    loggedIn: Boolean,
    user: Object,
});
import { Link } from "@inertiajs/vue3";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <div class="min-vh-100">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <a class="navbar-brand" href="#">
                <i class="bi bi-clock-history me-2"></i>Freelance Time Tracker
            </a>
            <div class="ms-auto d-flex gap-2">
                <Link
                    v-if="!loggedIn"
                    href="/login"
                    class="btn btn-outline-light"
                >
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </Link>
                <div class="ms-auto d-flex">
                    <span v-if="loggedIn" class="navbar-text me-3"
                        >Hi, {{ user?.name ?? "Freelancer" }}</span
                    >
                    <Link
                        v-if="loggedIn"
                        href="/dashboard"
                        class="btn btn-outline-light"
                    >
                        <i class="bi bi-speedometer2 me-1"></i> DashBoard
                    </Link>
                </div>
                <Link
                    v-if="!loggedIn"
                    href="/registerPage"
                    class="btn btn-outline-light"
                >
                    <i class="bi bi-person-plus me-1"></i> Register
                </Link>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-secondary-subtle text-center py-5">
            <div class="container">
                <h1 class="display-5 mb-3">Track Your Freelance Time Easily</h1>
                <p class="lead">
                    Manage clients, log work hours, monitor projects, and
                    generate reports — all in one place.
                </p>
                <Link href="/login" class="btn btn-secondary btn-lg mt-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Get Started
                </Link>
            </div>
        </section>

        <!-- Features Section -->
        <section class="container py-5">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                    <h5 class="mt-3">Manage Clients</h5>
                    <p>Add and update your freelance clients with ease.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="bi bi-kanban fs-1 text-success"></i>
                    <h5 class="mt-3">Track Projects</h5>
                    <p>Organize and monitor work per client and deadline.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="bi bi-clock fs-1 text-warning"></i>
                    <h5 class="mt-3">Log Time</h5>
                    <p>
                        Start/end logs or manually add hours with descriptions.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<style scoped></style>
