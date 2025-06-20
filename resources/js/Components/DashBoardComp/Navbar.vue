<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
const page = usePage();
const user = page.props.auth.user;
import axios from "axios";

const handleLogout= async ()=>{
    try {
        const response = await axios.get('/logout');
        if (response.status === 200) {
        alert("Logged out successfully.");
        setTimeout(() => router.visit("/"), 1000);
        }
    } catch (error) {
        console.error("Logout error:", error);
        alert("Failed to log out. Please try again.");
    }
}
</script>

<template>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <Link class="navbar-brand" href="/">
      <i class="bi bi-clock-history me-2"></i>Time Tracker
    </Link>
    <div class="ms-auto d-flex">
      <span class="navbar-text me-3">Hi, {{ user?.name ?? 'Freelancer'}}</span>
      <button class="btn btn-outline-light btn-sm" @click.prevent="handleLogout()"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </div>
  </nav>
</template>

<style scoped>

</style>
