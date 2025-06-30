<script setup>
import Navbar from "../../Components/DashBoardComp/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import UserProfileComponent from "../../Components/UserProfile/UserProfileComponent.vue";
</script>

<template>
    <Navbar />
    <div class="min-vh-100">
       <UserProfileComponent />
    </div>
    <Footer />
</template>

<style scoped></style>
