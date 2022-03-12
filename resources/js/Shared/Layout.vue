<template>
    <section class="p-6 bg-gray-400">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">{{ $page.props.appName }}</h1>
            <Navbar class="ml-7"/>
        </div>
    </section>

    <section class="p-6">
        <div class="max-w-4xl mx-auto">
            <slot/>
        </div>
    </section>

</template>

<script setup>
import Navbar from "./Navbar";
</script>

<style scoped>

</style>
