<template>
    <v-container class="py-16">
        <v-row justify="center">
            <v-col cols="12" md="6" lg="5">
                <v-card elevation="4" class="pa-6">
                    <v-card-title class="text-h4 text-center mb-4">
                        Login
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="handleLogin">
                            <v-text-field
                                v-model="formData.email"
                                label="Email"
                                type="email"
                                variant="outlined"
                                prepend-inner-icon="mdi-email"
                                :error-messages="errors.email"
                                required
                                class="mb-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="formData.password"
                                label="Password"
                                :type="showPassword ? 'text' : 'password'"
                                variant="outlined"
                                prepend-inner-icon="mdi-lock"
                                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append-inner="showPassword = !showPassword"
                                :error-messages="errors.password"
                                required
                                class="mb-2"
                            ></v-text-field>

                            <v-checkbox
                                v-model="formData.remember"
                                label="Remember me"
                                color="primary"
                            ></v-checkbox>

                            <v-btn
                                type="submit"
                                color="primary"
                                size="large"
                                :loading="loading"
                                block
                                class="mb-4"
                            >
                                Login
                            </v-btn>

                            <div class="text-center">
                                <p class="mb-2">
                                    Don't have an account?
                                    <router-link :to="{ name: 'register' }" class="text-primary">
                                        Register here
                                    </router-link>
                                </p>
                            </div>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useHead } from '@vueuse/head';
import { useRouter } from 'vue-router';
import axios from 'axios';

useHead({
    title: 'Login',
});

const router = useRouter();
const loading = ref(false);
const showPassword = ref(false);

const formData = reactive({
    email: '',
    password: '',
    remember: false,
});

const errors = reactive({
    email: '',
    password: '',
});

const resetErrors = () => {
    errors.email = '';
    errors.password = '';
};

const handleLogin = async () => {
    resetErrors();
    loading.value = true;

    try {
        const response = await axios.post('/user/login', formData);
        window.showSuccessToast?.('Login successful!');

        // Redirect to profile or intended page
        const redirectTo = response.data.data?.redirect || '/profile';
        window.location.href = redirectTo;
    } catch (error: any) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                errors[key] = Array.isArray(error.response.data.errors[key])
                    ? error.response.data.errors[key][0]
                    : error.response.data.errors[key];
            });
        } else {
            window.showErrorToast?.('Login failed. Please check your credentials.');
        }
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.text-primary {
    color: rgb(var(--v-theme-primary));
    text-decoration: none;
}

.text-primary:hover {
    text-decoration: underline;
}
</style>
