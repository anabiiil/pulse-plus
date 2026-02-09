<template>
    <div class="home-page">
        <section class="hero-section">
            <v-container>
                <v-row align="center" justify="center" class="min-h-screen">
                    <v-col cols="12" md="8" class="text-center">
                        <h1 class="text-h2 font-weight-bold mb-4">Welcome to Pulse</h1>
                        <p class="text-h5 mb-6">Your Health, Our Priority</p>
                        <v-btn color="primary" size="large" :to="{ name: 'services' }">
                            Explore Services
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <!-- Services Section -->
        <section class="services-section py-16">
            <v-container>
                <h2 class="text-h3 text-center mb-8">Our Services</h2>
                <v-row v-if="!loading">
                    <v-col
                        v-for="service in services"
                        :key="service.id"
                        cols="12"
                        md="4"
                    >
                        <v-card class="h-100" elevation="2">
                            <v-img
                                :src="service.image_url"
                                height="200"
                                cover
                            ></v-img>
                            <v-card-title>{{ service.name }}</v-card-title>
                            <v-card-text>{{ service.description }}</v-card-text>
                            <v-card-actions>
                                <v-btn
                                    color="primary"
                                    :to="{ name: 'service.detail', params: { id: service.id } }"
                                >
                                    Learn More
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row v-else>
                    <v-col cols="12" class="text-center">
                        <v-progress-circular indeterminate color="primary"></v-progress-circular>
                    </v-col>
                </v-row>
            </v-container>
        </section>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import axios from 'axios';

useHead({
    title: 'Home',
});

const services = ref([]);
const loading = ref(true);

const fetchServices = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/api/website/services', {
            params: {
                limit: 3
            }
        });
        services.value = response.data.data || response.data;
    } catch (error) {
        console.error('Error fetching services:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchServices();
});
</script>

<style scoped>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    min-height: 100vh;
}

.services-section {
    background-color: #f5f5f5;
}

.h-100 {
    height: 100%;
}
</style>
