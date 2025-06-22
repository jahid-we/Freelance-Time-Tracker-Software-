<script setup>
import Navbar from "../../Components/DashBoardComp/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import AllTimeLogComponent from "../../Components/TimeLog/AllTimeLogComponent.vue";

</script>

<template>
    <Navbar />
    <div class="min-vh-100">
       <AllTimeLogComponent />
    </div>
    <Footer />
</template>

<style scoped></style>
