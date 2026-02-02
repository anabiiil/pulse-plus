<template>
    <v-container class="py-16">
        <v-row>
            <v-col cols="12" md="6">
                <h1 class="text-h3 mb-8">Contact Us</h1>
                <v-card elevation="2" class="pa-6">
                    <v-form @submit.prevent="submitForm">
                        <v-text-field
                            v-model="formData.name"
                            label="Name"
                            variant="outlined"
                            :error-messages="errors.name"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="formData.email"
                            label="Email"
                            type="email"
                            variant="outlined"
                            :error-messages="errors.email"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="formData.phone"
                            label="Phone"
                            variant="outlined"
                            :error-messages="errors.phone"
                        ></v-text-field>

                        <v-textarea
                            v-model="formData.message"
                            label="Message"
                            variant="outlined"
                            rows="5"
                            :error-messages="errors.message"
                            required
                        ></v-textarea>

                        <v-btn
                            type="submit"
                            color="primary"
                            size="large"
                            :loading="loading"
                            block
                        >
                            Send Message
                        </v-btn>
                    </v-form>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <h2 class="text-h5 mb-4">Get in Touch</h2>
                <v-card elevation="2" class="pa-6">
                    <div class="mb-4">
                        <h3 class="text-h6 mb-2">Address</h3>
                        <p>123 Healthcare Street<br>Medical District<br>City, State 12345</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-h6 mb-2">Phone</h3>
                        <p>+1 (555) 123-4567</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-h6 mb-2">Email</h3>
                        <p>info@pulse.com</p>
                    </div>
                    <div>
                        <h3 class="text-h6 mb-2">Hours</h3>
                        <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useHead } from '@vueuse/head';
import axios from 'axios';

useHead({
    title: 'Contact Us',
});

const loading = ref(false);
const formData = reactive({
    name: '',
    email: '',
    phone: '',
    message: '',
});

const errors = reactive({
    name: '',
    email: '',
    phone: '',
    message: '',
});

const resetErrors = () => {
    errors.name = '';
    errors.email = '';
    errors.phone = '';
    errors.message = '';
};

const submitForm = async () => {
    resetErrors();
    loading.value = true;

    try {
        const response = await axios.post('/api/contact', formData);
        window.showSuccessToast?.('Message sent successfully!');

        // Reset form
        formData.name = '';
        formData.email = '';
        formData.phone = '';
        formData.message = '';
    } catch (error: any) {
        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                errors[key] = error.response.data.errors[key][0];
            });
        } else {
            window.showErrorToast?.('Failed to send message. Please try again.');
        }
    } finally {
        loading.value = false;
    }
};
</script>
