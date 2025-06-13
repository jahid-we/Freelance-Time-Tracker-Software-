<script setup>
import { ref } from "vue";

import Navbar from "../../Components/DashBoardComp/Navbar.vue";
import Footer from "@/Components/Footer.vue";

import ALlClientComponent from "../../Components/Client/AllClientComponent.vue";
</script>

<template>
    <Navbar />
    <div class="min-vh-100">

    <ALlClientComponent/>

    </div>
    <Footer />
</template>

<style scoped></style>
