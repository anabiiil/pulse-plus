<template>
    <v-app>
        <!-- Header/Navbar -->
        <v-app-bar app color="primary" dark elevation="2">
            <v-toolbar-title>
                <router-link to="/" class="text-white text-decoration-none">
                    Pulse
                </router-link>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <!-- Desktop Menu -->
            <v-btn :to="{ name: 'home' }" text class="d-none d-md-flex">Home</v-btn>
            <v-btn :to="{ name: 'about' }" text class="d-none d-md-flex">About</v-btn>
            <v-btn :to="{ name: 'services' }" text class="d-none d-md-flex">Services</v-btn>
            <v-btn :to="{ name: 'products' }" text class="d-none d-md-flex">Products</v-btn>
            <v-btn :to="{ name: 'contact' }" text class="d-none d-md-flex">Contact</v-btn>

            <!-- Auth Links - Desktop -->
            <template v-if="isAuthenticated">
                <v-btn :to="{ name: 'profile' }" text class="d-none d-md-flex">
                    <v-icon left>mdi-account</v-icon>
                    Profile
                </v-btn>
            </template>
            <template v-else>
                <v-btn :to="{ name: 'login' }" text class="d-none d-md-flex">Login</v-btn>
                <v-btn :to="{ name: 'register' }" text class="d-none d-md-flex" color="secondary">Register</v-btn>
            </template>

            <!-- Mobile Menu -->
            <v-app-bar-nav-icon @click="drawer = !drawer" class="d-md-none"></v-app-bar-nav-icon>
        </v-app-bar>

        <!-- Mobile Navigation Drawer -->
        <v-navigation-drawer v-model="drawer" app temporary>
            <v-list>
                <v-list-item :to="{ name: 'home' }" @click="drawer = false">
                    <v-list-item-title>Home</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{ name: 'about' }" @click="drawer = false">
                    <v-list-item-title>About</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{ name: 'services' }" @click="drawer = false">
                    <v-list-item-title>Services</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{ name: 'products' }" @click="drawer = false">
                    <v-list-item-title>Products</v-list-item-title>
                </v-list-item>
                <v-list-item :to="{ name: 'contact' }" @click="drawer = false">
                    <v-list-item-title>Contact</v-list-item-title>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <!-- Mobile Auth Links -->
                <template v-if="isAuthenticated">
                    <v-list-item :to="{ name: 'profile' }" @click="drawer = false">
                        <v-list-item-title>
                            <v-icon left>mdi-account</v-icon>
                            Profile
                        </v-list-item-title>
                    </v-list-item>
                </template>
                <template v-else>
                    <v-list-item :to="{ name: 'login' }" @click="drawer = false">
                        <v-list-item-title>Login</v-list-item-title>
                    </v-list-item>
                    <v-list-item :to="{ name: 'register' }" @click="drawer = false">
                        <v-list-item-title>Register</v-list-item-title>
                    </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>

        <!-- Main Content -->
        <v-main>
            <router-view></router-view>
        </v-main>

        <!-- Footer -->
        <v-footer app color="grey-darken-3" dark>
            <v-container>
                <v-row>
                    <v-col cols="12" md="4">
                        <h3 class="mb-2">Pulse</h3>
                        <p>Your trusted healthcare partner</p>
                    </v-col>
                    <v-col cols="12" md="4">
                        <h4 class="mb-2">Quick Links</h4>
                        <div class="d-flex flex-column">
                            <router-link to="/" class="text-white mb-1">Home</router-link>
                            <router-link :to="{ name: 'about' }" class="text-white mb-1">About</router-link>
                            <router-link :to="{ name: 'services' }" class="text-white mb-1">Services</router-link>
                            <router-link :to="{ name: 'products' }" class="text-white mb-1">Products</router-link>
                        </div>
                    </v-col>
                    <v-col cols="12" md="4">
                        <h4 class="mb-2">Contact Info</h4>
                        <p class="mb-1">Email: info@pulse.com</p>
                        <p class="mb-1">Phone: +1 (555) 123-4567</p>
                    </v-col>
                </v-row>
                <v-divider class="my-4"></v-divider>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <p class="mb-0">&copy; {{ new Date().getFullYear() }} Pulse. All rights reserved.</p>
                    </v-col>
                </v-row>
            </v-container>
        </v-footer>
    </v-app>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '../../stores/authStore';

const drawer = ref(false);
const authStore = useAuthStore();

// Check if user is authenticated using Pinia store
const isAuthenticated = authStore.isAuthenticated;
</script>

<style scoped>
.website-layout {
    min-height: 100vh;
}
</style>
