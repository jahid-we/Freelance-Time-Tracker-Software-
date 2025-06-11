<script setup>
const props = defineProps({
  auth: Object
})
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import Footer from "@/Components/Footer.vue";

const handleLogout= async ()=>{
    try {
        const response = await axios.get('/logout');
        if (response.status === 200) {
        alert("Logged out successfully.");
        setTimeout(() => router.visit("/login"), 1000);
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
      <span class="navbar-text me-3">Hi, {{ auth.user?.name ?? 'Freelancer'}}</span>
      <button class="btn btn-outline-light btn-sm" @click.prevent="handleLogout()"><i class="bi bi-box-arrow-right"></i> Logout</button>
    </div>
  </nav>

  <div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-house-door me-2"></i>Dashboard</h2>

    <div class="row g-4">
      <!-- Clients -->
      <div class="col-md-4">
        <div class="card border-primary h-100">
          <div class="card-body text-center">
            <i class="bi bi-people-fill fs-1 text-primary"></i>
            <h5 class="card-title mt-3">Clients</h5>
            <p class="card-text">Manage your clients list.</p>
            <Link href="/clients" class="btn btn-primary btn-sm">View Clients</Link>
          </div>
        </div>
      </div>

      <!-- Projects -->
      <div class="col-md-4">
        <div class="card border-success h-100">
          <div class="card-body text-center">
            <i class="bi bi-kanban fs-1 text-success"></i>
            <h5 class="card-title mt-3">Projects</h5>
            <p class="card-text">Track client projects and statuses.</p>
            <Link href="/projects" class="btn btn-success btn-sm">View Projects</Link>
          </div>
        </div>
      </div>

      <!-- Time Logs -->
      <div class="col-md-4">
        <div class="card border-warning h-100">
          <div class="card-body text-center">
            <i class="bi bi-clock fs-1 text-warning"></i>
            <h5 class="card-title mt-3">Time Logs</h5>
            <p class="card-text">Start/end sessions or add manual logs.</p>
            <Link href="/timelogs" class="btn btn-warning btn-sm">View Time Logs</Link>
          </div>
        </div>
      </div>

      <!-- Reports -->
      <div class="col-md-4">
        <div class="card border-info h-100">
          <div class="card-body text-center">
            <i class="bi bi-bar-chart-line fs-1 text-info"></i>
            <h5 class="card-title mt-3">Reports</h5>
            <p class="card-text">See summaries by project, client, or day.</p>
            <Link href="/reports" class="btn btn-info btn-sm">View Reports</Link>
          </div>
        </div>
      </div>

      <!-- Profile -->
      <div class="col-md-4">
        <div class="card border-secondary h-100">
          <div class="card-body text-center">
            <i class="bi bi-person-circle fs-1 text-secondary"></i>
            <h5 class="card-title mt-3">Profile</h5>
            <p class="card-text">Manage your account and password.</p>
            <Link href="/profile" class="btn btn-secondary btn-sm">Go to Profile</Link>
          </div>
        </div>
      </div>

    </div>
  </div>
    <Footer />
</template>

<style scoped>

</style>
