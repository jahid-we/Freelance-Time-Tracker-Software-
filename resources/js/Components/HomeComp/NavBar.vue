<script setup>
const props = defineProps({
    loggedIn: Boolean,
    user: Object,
});
import { Link } from "@inertiajs/vue3";
</script>

<template>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <a class="navbar-brand" href="/">
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
                        >Hi, {{ user?.name ?? "Freelancer" }}👋</span
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
</template>

<style scoped>

</style>
