<script setup>
import NavBar from "@/components/layouts/Navbar.vue";
import SiteFooter from "@/components/layouts/SiteFooter.vue";
</script>

<template>
    <header>
        <NavBar />
    </header>

    <RouterView />

    <SiteFooter />
</template>

<style lang="scss">
@import "@/assets/base.css";
@import 'sweetalert2/src/sweetalert2.scss';
@import '@vuepic/vue-datepicker/dist/main.css';
</style>
