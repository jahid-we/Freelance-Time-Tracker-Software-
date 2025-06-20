<script setup>
import Navbar from "../../Components/DashBoardComp/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import AllProjectComponent from "../../Components/Project/AllProjectComponent.vue";
</script>

<template>
    <Navbar />
    <div class="min-vh-100">
        <AllProjectComponent />
    </div>
    <Footer />
</template>

<style scoped></style>
