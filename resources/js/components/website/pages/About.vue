<template>
    <v-container class="py-16">
        <v-row>
            <v-col cols="12">
                <h1 class="text-h3 mb-8">About Pulse</h1>
                <v-card elevation="2" class="pa-6">
                    <p class="text-body-1 mb-4">
                        Welcome to Pulse - Your trusted healthcare partner. We are committed to providing
                        exceptional medical services and products to improve your health and well-being.
                    </p>
                    <p class="text-body-1 mb-4">
                        Our team of experienced professionals is dedicated to delivering personalized care
                        that meets your unique needs. With state-of-the-art facilities and cutting-edge
                        technology, we ensure you receive the best possible healthcare experience.
                    </p>
                    <p class="text-body-1">
                        At Pulse, we believe in a holistic approach to health, combining medical expertise
                        with compassionate care to help you achieve optimal wellness.
                    </p>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { useHead } from '@vueuse/head';

useHead({
    title: 'About Us',
});
</script>
