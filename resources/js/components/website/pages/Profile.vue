<template>
    <v-container class="py-16">
        <v-row>
            <v-col cols="12">
                <h1 class="text-h3 mb-8">My Profile</h1>
            </v-col>
        </v-row>

        <v-row v-if="user">
            <v-col cols="12" md="4">
                <v-card elevation="2">
                    <v-card-text class="text-center py-8">
                        <v-avatar size="120" color="primary" class="mb-4">
                            <span class="text-h2 text-white">
                                {{ user.name?.charAt(0).toUpperCase() }}
                            </span>
                        </v-avatar>
                        <h2 class="text-h5 mb-2">{{ user.name }}</h2>
                        <p class="text-body-1 text-grey">{{ user.email }}</p>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions class="justify-center py-4">
                        <v-btn color="error" @click="handleLogout" :loading="loggingOut">
                            <v-icon left>mdi-logout</v-icon>
                            Logout
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>

            <v-col cols="12" md="8">
                <v-card elevation="2">
                    <v-card-title class="text-h5">Profile Information</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form @submit.prevent="handleUpdate">
                            <v-text-field
                                v-model="formData.name"
                                label="Full Name"
                                variant="outlined"
                                :error-messages="errors.name"
                                class="mb-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="formData.email"
                                label="Email"
                                type="email"
                                variant="outlined"
                                :error-messages="errors.email"
                                class="mb-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="formData.phone"
                                label="Phone"
                                variant="outlined"
                                :error-messages="errors.phone"
                                class="mb-4"
                            ></v-text-field>

                            <v-btn
                                type="submit"
                                color="primary"
                                :loading="updating"
                                class="mr-2"
                            >
                                Update Profile
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>

                <!-- Change Password Section -->
                <v-card elevation="2" class="mt-4">
                    <v-card-title class="text-h5">Change Password</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-form @submit.prevent="handlePasswordChange">
                            <v-text-field
                                v-model="passwordData.current_password"
                                label="Current Password"
                                type="password"
                                variant="outlined"
                                :error-messages="passwordErrors.current_password"
                                class="mb-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="passwordData.password"
                                label="New Password"
                                type="password"
                                variant="outlined"
                                :error-messages="passwordErrors.password"
                                class="mb-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="passwordData.password_confirmation"
                                label="Confirm New Password"
                                type="password"
                                variant="outlined"
                                :error-messages="passwordErrors.password_confirmation"
                                class="mb-4"
                            ></v-text-field>

                            <v-btn
                                type="submit"
                                color="primary"
                                :loading="changingPassword"
                            >
                                Change Password
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import axios from 'axios';

useHead({
    title: 'My Profile',
});

interface User {
    id: number;
    name: string;
    email: string;
    phone?: string;
}

const user = ref<User | null>(null);
const updating = ref(false);
const loggingOut = ref(false);
const changingPassword = ref(false);

const formData = reactive({
    name: '',
    email: '',
    phone: '',
});

const passwordData = reactive({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const errors = reactive<Record<string, string>>({
    name: '',
    email: '',
    phone: '',
});

const passwordErrors = reactive<Record<string, string>>({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const resetErrors = () => {
    errors.name = '';
    errors.email = '';
    errors.phone = '';
};

const resetPasswordErrors = () => {
    passwordErrors.current_password = '';
    passwordErrors.password = '';
    passwordErrors.password_confirmation = '';
};

const loadUser = async () => {
    try {
        const response = await axios.get('/user/profile');
        user.value = response.data.data || response.data;
        if (user.value) {
            formData.name = user.value.name;
            formData.email = user.value.email;
            formData.phone = user.value.phone || '';
        }
    } catch (error) {
        console.error('Error loading user:', error);
        window.showErrorToast?.('Failed to load profile');
    }
};

const handleUpdate = async () => {
    resetErrors();
    updating.value = true;

    try {
        const response = await axios.put('/user/profile', formData);
        user.value = response.data.data || response.data;
        window.showSuccessToast?.('Profile updated successfully!');
    } catch (error: any) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                if (key in errors) {
                    errors[key] = Array.isArray(error.response.data.errors[key])
                        ? error.response.data.errors[key][0]
                        : error.response.data.errors[key];
                }
            });
        } else {
            window.showErrorToast?.('Failed to update profile');
        }
    } finally {
        updating.value = false;
    }
};

const handlePasswordChange = async () => {
    resetPasswordErrors();
    changingPassword.value = true;

    try {
        await axios.post('/user/change-password', passwordData);
        window.showSuccessToast?.('Password changed successfully!');
        passwordData.current_password = '';
        passwordData.password = '';
        passwordData.password_confirmation = '';
    } catch (error: any) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                if (key in passwordErrors) {
                    passwordErrors[key] = Array.isArray(error.response.data.errors[key])
                        ? error.response.data.errors[key][0]
                        : error.response.data.errors[key];
                }
            });
        } else {
            window.showErrorToast?.('Failed to change password');
        }
    } finally {
        changingPassword.value = false;
    }
};

const handleLogout = async () => {
    loggingOut.value = true;

    try {
        await axios.post('/user/logout');
        window.showSuccessToast?.('Logged out successfully!');
        window.location.href = '/';
    } catch (error) {
        console.error('Error logging out:', error);
        window.showErrorToast?.('Failed to logout');
    } finally {
        loggingOut.value = false;
    }
};

onMounted(() => {
    loadUser();
});
</script>
