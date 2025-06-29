<script setup>
import Navbar from "../../Components/DashBoardComp/Navbar.vue";
import Footer from "@/Components/Footer.vue";
import AllTimeLogComponent from "../../Components/TimeLog/AllTimeLogComponent.vue";
import FilterTimLog from "../../Components/TimeLog/FilterTimLog.vue";

</script>

<template>
    <Navbar />
    <div class="min-vh-100">
       <AllTimeLogComponent />
         <FilterTimLog />
    </div>
    <Footer />
</template>

<style scoped></style>
