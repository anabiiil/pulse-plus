<template>
    <v-container class="py-16">
        <v-row>
            <v-col cols="12" class="text-center">
                <h1 class="text-h2 mb-4">404</h1>
                <h2 class="text-h4 mb-6">Page Not Found</h2>
                <p class="text-body-1 mb-8">
                    Sorry, the page you are looking for doesn't exist or has been moved.
                </p>
                <v-btn color="primary" size="large" :to="{ name: 'home' }">
                    Go Home
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { useHead } from '@vueuse/head';

useHead({
    title: 'Page Not Found',
});
</script>
