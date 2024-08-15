<script setup>
import Footer from "@/components/app/Footer.vue";
import Header from "@/components/app/Header.vue";
</script>

<template>
    <Header/>
    <main class="container my-4">
        <router-view></router-view>
    </main>
    <Footer/>
</template>
